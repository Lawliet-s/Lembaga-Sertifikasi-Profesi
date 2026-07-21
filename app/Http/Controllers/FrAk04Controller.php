<?php

namespace App\Http\Controllers;

use App\Models\Data_register;
use App\Models\FrAk04;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrAk04Controller extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $registrations = Data_register::where('user_id', $userId)
            ->with('frAk04')
            ->get();

        return view('asesi.frak04.index', compact('registrations'));
    }

    public function show($id)
    {
        $registration = Data_register::with('frAk04')
            ->findOrFail($id);

        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        $frAk04 = $registration->frAk04;

        return view('asesi.frak04.show', compact('registration', 'frAk04'));
    }

    public function store(Request $request, $id)
    {
        $registration = Data_register::findOrFail($id);

        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        if ($registration->frAk04 && $registration->frAk04->status !== 'ditolak') {
            return back()->with('error', 'Banding sudah diajukan dan sedang diproses.');
        }

        $request->validate([
            'alasan' => 'required|string|max:5000',
            'file' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = 'banding_' . time() . '_' . Auth::id() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/banding/', $filename);
            $filePath = 'uploads/banding/' . $filename;
        }

        FrAk04::updateOrCreate(
            ['data_register_id' => $registration->id],
            [
                'user_id' => Auth::id(),
                'alasan' => $request->alasan,
                'file_path' => $filePath,
                'status' => 'diajukan',
                'catatan_admin' => null,
                'diajukan_at' => now(),
                'ditinjau_at' => null,
                'diputus_at' => null,
            ]
        );

        return redirect()->route('frak04.show', $registration->id)
            ->with('success', 'FR.AK.04 — Banding Asesmen berhasil diajukan.');
    }
}
