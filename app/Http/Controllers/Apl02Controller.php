<?php

namespace App\Http\Controllers;

use App\Models\Asesmen;
use App\Models\Data_register;
use App\Models\Skema;
use App\Models\Unikom;
use App\Models\Xnxx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Apl02Controller extends Controller
{
    public function index()
    {
        $registrations = Data_register::where('user_id', auth()->user()->id)
            ->where(function ($q) {
                $q->where('status', 'LIKE', '%Pendaftaran Divalidasi%')
                  ->orWhere('status', 'LIKE', '%Sertifikasi Selesai%');
            })
            ->get();

        return view('asesi.apl02.index', compact('registrations'));
    }

    public function create($id)
    {
        $registration = Data_register::where('user_id', auth()->id())->findOrFail($id);
        $skema = Skema::findOrFail($registration->skema_id);

        $unikoms = Unikom::where('skema_id', $skema->id)
            ->with('asesmens')
            ->get();

        $existing = Xnxx::where('data_register_id', $registration->id)
            ->where('user_id', auth()->user()->id)
            ->get();

        return view('asesi.apl02.create', compact('registration', 'skema', 'unikoms', 'existing'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_register_id' => 'required|exists:data_registers,id',
            'elemen_id' => 'required|array',
            'elemen_id.*' => 'exists:elemen,id',
            'status' => 'required|array',
            'status.*' => 'in:kompeten,tidak_kompeten',
            'image' => 'nullable|array',
            'image.*' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:2048',
        ]);

        $dataRegisterId = $request->data_register_id;
        $registration = Data_register::where('user_id', auth()->id())->findOrFail($dataRegisterId);

        foreach ($request->elemen_id as $i => $elemenId) {
            $elemen = Asesmen::with('unikom')->findOrFail($elemenId);
            $kode = $i + 1 . auth()->user()->id;
            $kodeElemen = $i + 1 . auth()->user()->id . $dataRegisterId;

            $imagePath = null;
            if ($request->hasFile('image.' . $i)) {
                $file = $request->file('image.' . $i);
                $safeName = \Illuminate\Support\Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $filename = time() . '_' . $safeName;
                $file->move('uploads/formulir_apl2/', $filename);
                $imagePath = 'uploads/formulir_apl2/' . $filename;
            }

            $statusValue = $request->status[$i] === 'kompeten' ? 'kompeten' : 'tidak_kompeten';

            Xnxx::updateOrCreate(
                [
                    'data_register_id' => $dataRegisterId,
                    'kode_elemen' => $kodeElemen,
                ],
                [
                    'user_id' => auth()->user()->id,
                    'unikom_id' => $elemen->unikom_id,
                    'unikom_name' => $elemen->unikom->unikom ?? '',
                    'unikom_kode' => $elemen->unikom->kode_unikom ?? '',
                    'asesmen_name' => $elemen->asesmen,
                    'kriteria' => $elemen->kriteria,
                    'skema_id' => $registration->skema_id,
                    'skema_name' => $registration->skema_name,
                    'kode' => $kode,
                    'status' => $statusValue,
                    'image' => $imagePath,
                    'koreksi' => 'Belum Dikoreksi',
                ]
            );
        }

        return redirect()->route('apl02.show', $dataRegisterId)
            ->with('success', 'FR.APL.02 — Asesmen Mandiri berhasil disimpan.');
    }

    public function show($id)
    {
        $registration = Data_register::where('user_id', auth()->id())->findOrFail($id);
        $xnxxes = Xnxx::where('data_register_id', $registration->id)
            ->where('user_id', auth()->user()->id)
            ->get()
            ->groupBy('unikom_name');

        return view('asesi.apl02.show', compact('registration', 'xnxxes'));
    }
}
