<?php

namespace App\Http\Controllers;

use App\Models\JadwalAsesmen;
use App\Models\Skema;
use App\Models\Tuk;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        JadwalAsesmen::where('status', 'aktif')->whereDate('tanggal', '<', today())->update(['status' => 'ditutup']);
        $jadwal = JadwalAsesmen::with('skema', 'tuk')->orderBy('tanggal')->get();
        $skema = Skema::orderBy('skema')->get();
        $tuk = Tuk::orderBy('tuk')->get();
        return view('admin.jadwal.index', compact('jadwal', 'skema', 'tuk'));
    }

    public function create()
    {
        $skema = Skema::orderBy('skema')->get();
        $tuk = Tuk::orderBy('tuk')->get();
        return view('admin.jadwal.create', compact('skema', 'tuk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'skema_id' => 'required|exists:skemas,id',
            'tuk_id' => 'required|exists:tuk,id',
            'tanggal' => 'required|date',
            'jam' => 'nullable|string|max:10',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|string|in:aktif,ditutup',
        ]);

        JadwalAsesmen::create($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal asesmen berhasil ditambahkan');
    }

    public function edit(JadwalAsesmen $jadwal)
    {
        $skema = Skema::orderBy('skema')->get();
        $tuk = Tuk::orderBy('tuk')->get();
        return view('admin.jadwal.edit', compact('jadwal', 'skema', 'tuk'));
    }

    public function update(Request $request, JadwalAsesmen $jadwal)
    {
        $request->validate([
            'skema_id' => 'required|exists:skemas,id',
            'tuk_id' => 'required|exists:tuk,id',
            'tanggal' => 'required|date',
            'jam' => 'nullable|string|max:10',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|string|in:aktif,ditutup',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal asesmen berhasil diperbarui');
    }

    public function destroy(JadwalAsesmen $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal asesmen berhasil dihapus');
    }
}
