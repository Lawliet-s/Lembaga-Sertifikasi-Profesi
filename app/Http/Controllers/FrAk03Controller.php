<?php

namespace App\Http\Controllers;

use App\Models\Data_register;
use App\Models\FrAk03;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrAk03Controller extends Controller
{
    public function index()
    {
        $registrations = Data_register::where('user_id', auth()->user()->id)
            ->where(function ($q) {
                $q->where('status', 'LIKE', '%Pendaftaran Divalidasi%')
                  ->orWhere('status', 'LIKE', '%Sertifikasi Selesai%');
            })
            ->get();

        return view('asesi.frak03.index', compact('registrations'));
    }

    public function create($id)
    {
        $registration = Data_register::where('user_id', auth()->id())->findOrFail($id);
        $frAk03 = FrAk03::where('data_register_id', $id)->first();

        return view('asesi.frak03.create', compact('registration', 'frAk03'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_register_id' => 'required|exists:data_registers,id',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string',
            'catatan' => 'nullable|string',
            'saran' => 'nullable|string',
        ]);

        $registration = Data_register::where('user_id', auth()->id())
            ->findOrFail($request->data_register_id);

        FrAk03::updateOrCreate(
            [
                'data_register_id' => $request->data_register_id,
                'user_id' => auth()->id(),
            ],
            [
                'rating' => $request->rating,
                'feedback' => $request->feedback,
                'catatan' => $request->catatan,
                'saran' => $request->saran,
            ]
        );

        return redirect()->route('frak03.show', $request->data_register_id)
            ->with('success', 'FR.AK.03 — Evaluasi Kepuasan berhasil disimpan.');
    }

    public function show($id)
    {
        $registration = Data_register::where('user_id', auth()->id())->findOrFail($id);
        $frAk03 = FrAk03::where('data_register_id', $id)->first();

        return view('asesi.frak03.show', compact('registration', 'frAk03'));
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
