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
        $registrations = Data_register::where('user_id', auth()->user()->id)
            ->where(function ($q) {
                $q->where('status', 'LIKE', '%Pendaftaran Divalidasi%')
                  ->orWhere('status', 'LIKE', '%Sertifikasi Selesai%');
            })
            ->get();

        return view('asesi.frak04.index', compact('registrations'));
    }

    public function create($id)
    {
        $registration = Data_register::where('user_id', auth()->id())->findOrFail($id);
        $frAk04 = FrAk04::where('data_register_id', $id)->first();

        return view('asesi.frak04.create', compact('registration', 'frAk04'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_register_id' => 'required|exists:data_registers,id',
            'alasan' => 'required|string',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $registration = Data_register::where('user_id', auth()->id())
            ->findOrFail($request->data_register_id);

        $filePath = null;
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/frak04/', $filename);
            $filePath = 'uploads/frak04/' . $filename;
        }

        FrAk04::updateOrCreate(
            [
                'data_register_id' => $request->data_register_id,
                'user_id' => auth()->id(),
            ],
            [
                'alasan' => $request->alasan,
                'file_path' => $filePath,
                'status' => 'diajukan',
                'diajukan_at' => now(),
            ]
        );

        return redirect()->route('frak04.show', $request->data_register_id)
            ->with('success', 'FR.AK.04 — Keberatan/Klaim berhasil diajukan.');
    }

    public function show($id)
    {
        $registration = Data_register::where('user_id', auth()->id())->findOrFail($id);
        $frAk04 = FrAk04::where('data_register_id', $id)->first();

        return view('asesi.frak04.show', compact('registration', 'frAk04'));
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
