<?php

namespace App\Http\Controllers;

use App\Models\Data_register;
use App\Models\FrAk01;
use App\Models\Skema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class FrAk01Controller extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $registrations = Data_register::where('user_id', $userId)
            ->where(function ($q) {
                $q->where('status', 'LIKE', '%Pendaftaran Divalidasi%')
                  ->orWhereHas('frAk01', function ($q2) {
                      $q2->where('status', 'signed');
                  });
            })
            ->with('asesor', 'tuk', 'frAk01')
            ->get();

        return view('asesi.frak01.index', compact('registrations'));
    }

    public function show($id)
    {
        $registration = Data_register::with('asesor', 'tuk', 'frAk01')
            ->findOrFail($id);

        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        $skema = Skema::find($registration->skema_id);
        $frAk01 = $registration->frAk01;

        return view('asesi.frak01.show', compact('registration', 'skema', 'frAk01'));
    }

    public function store(Request $request, $id)
    {
        $registration = Data_register::findOrFail($id);

        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'ttd' => 'required|string',
        ]);

        $ttdData = $request->ttd;
        $ttdPath = null;

        if ($ttdData && str_starts_with($ttdData, 'data:image/png;base64,')) {
            $ttdData = str_replace('data:image/png;base64,', '', $ttdData);
            $decoded = base64_decode($ttdData);
            $filename = 'frak01_ttd_' . time() . '_' . Auth::id() . '.png';
            Storage::disk('public')->put('ttd/' . $filename, $decoded);
            $ttdPath = 'ttd/' . $filename;
        } else {
            return back()->with('error', 'Gagal memproses tanda tangan.');
        }

        FrAk01::updateOrCreate(
            ['data_register_id' => $registration->id],
            [
                'user_id' => Auth::id(),
                'ttd' => $ttdData,
                'ttd_path' => $ttdPath,
                'agreed_at' => now(),
                'status' => 'signed',
            ]
        );

        return redirect()->route('frak01.show', $registration->id)
            ->with('success', 'FR.AK.01 — Persetujuan Asesmen dan Kerahasiaan berhasil ditandatangani.');
    }

    public function pdf($id)
    {
        $registration = Data_register::with('asesor', 'tuk', 'frAk01', 'user')
            ->findOrFail($id);

        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        $frAk01 = $registration->frAk01;
        $skema = Skema::find($registration->skema_id);

        if (!$frAk01 || $frAk01->status !== 'signed') {
            return redirect()->route('frak01.show', $registration->id)
                ->with('error', 'FR.AK.01 belum ditandatangani.');
        }

        $pdf = Pdf::loadView('asesi.frak01.pdf', compact('registration', 'skema', 'frAk01'));
        return $pdf->download('FR_AK_01_' . $registration->id . '.pdf');
    }
}
