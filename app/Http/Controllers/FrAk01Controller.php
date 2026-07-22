<?php

namespace App\Http\Controllers;

use App\Models\Data_register;
use App\Models\FrAk01;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrAk01Controller extends Controller
{
    public function index()
    {
        $registrations = Data_register::where('user_id', auth()->user()->id)
            ->where(function ($q) {
                $q->where('status', 'LIKE', '%Pendaftaran Divalidasi%')
                  ->orWhere('status', 'LIKE', '%Sertifikasi Selesai%');
            })
            ->get();

        return view('asesi.frak01.index', compact('registrations'));
    }

    public function create($id)
    {
        $registration = Data_register::where('user_id', auth()->id())->findOrFail($id);
        $frAk01 = FrAk01::where('data_register_id', $id)->first();

        return view('asesi.frak01.create', compact('registration', 'frAk01'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_register_id' => 'required|exists:data_registers,id',
            'ttd' => 'nullable|string',
        ]);

        $registration = Data_register::where('user_id', auth()->id())
            ->findOrFail($request->data_register_id);

        $ttdData = null;
        if ($request->has('ttd') && !empty($request->ttd)) {
            $ttdData = $request->ttd;
            if (strpos($ttdData, 'data:') === false) {
                $ttdData = 'data:image/png;base64,' . $ttdData;
            }
        }

        FrAk01::updateOrCreate(
            [
                'data_register_id' => $request->data_register_id,
                'user_id' => auth()->id(),
            ],
            [
                'ttd' => $ttdData,
                'status' => 'signed',
                'agreed_at' => now(),
            ]
        );

        return redirect()->route('frak01.show', $request->data_register_id)
            ->with('success', 'FR.AK.01 — Pernyataan Kesediaan berhasil disimpan.');
    }

    public function show($id)
    {
        $registration = Data_register::where('user_id', auth()->id())->findOrFail($id);
        $frAk01 = FrAk01::where('data_register_id', $id)->first();

        return view('asesi.frak01.show', compact('registration', 'frAk01'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
