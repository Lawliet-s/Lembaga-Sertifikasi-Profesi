<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermohonanRequest;
use App\Models\DataPribadi;
use App\Models\Data_register;
use App\Models\Dokumen;
use App\Models\Pekerjaan;
use App\Models\Permohonan;
use App\Models\Sex;
use App\Models\Skema;
use App\Models\Unikom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PermohonanController extends Controller
{
    public function index()
    {
        return redirect()->route('permohonan.frapl01');
    }

    public function create()
    {
        $skemas = Skema::all();
        return view('asesi.permohonan.create', compact('skemas'));
    }

    public function store(StorePermohonanRequest $request)
    {
        $ttdData = $request->ttd;
        if ($ttdData && str_starts_with($ttdData, 'data:image/png;base64,')) {
            $ttdData = str_replace('data:image/png;base64,', '', $ttdData);
            $ttdData = base64_decode($ttdData);
            $filename = 'ttd_' . time() . '_' . auth()->id() . '.png';
            \Illuminate\Support\Facades\Storage::disk('public')->put('ttd/' . $filename, $ttdData);
            $ttdPath = 'ttd/' . $filename;
        } else {
            $ttdPath = null;
        }

        $permohonan = Permohonan::create([
            'user_id' => auth()->id(),
            'skema_id' => $request->skema_id,
            'tujuan_asesmen' => $request->tujuan_asesmen,
            'status' => 'pending',
            'ttd' => $ttdPath,
        ]);

        DataPribadi::create([
            'permohonan_id' => $permohonan->id,
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kebangsaan' => $request->kebangsaan,
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'pendidikan' => $request->pendidikan,
        ]);

        Pekerjaan::create([
            'permohonan_id' => $permohonan->id,
            'nama_perusahaan' => $request->nama_perusahaan,
            'jabatan' => $request->jabatan,
            'alamat_kantor' => $request->alamat_kantor,
            'kode_pos_kantor' => $request->kode_pos_kantor,
            'telepon_kantor' => $request->telepon_kantor,
            'email_kantor' => $request->email_kantor,
        ]);

        $dokumenFields = [
            'dokumen_raport' => 'raport',
            'dokumen_sertifikat_pkl' => 'sertifikat_pkl',
            'dokumen_kartu_keluarga' => 'kartu_keluarga',
            'dokumen_ktp' => 'ktp',
            'dokumen_foto' => 'foto_3x4',
        ];

        foreach ($dokumenFields as $field => $jenis) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = $file->store('dokumen', 'public');
                Dokumen::create([
                    'permohonan_id' => $permohonan->id,
                    'jenis_dokumen' => $jenis,
                    'nama_file' => \Illuminate\Support\Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension(),
                    'path_file' => $path,
                ]);
            }
        }

        $skema = Skema::find($request->skema_id);
        $sex = Sex::where('sex', $request->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan')->first();

        $lastId = Data_register::max('id') ?? 0;

        $dr = Data_register::create([
            'id' => $lastId + 1,
            'user_id' => (string) auth()->id(),
            'user_name' => \App\Helpers\HtmlSanitizer::plain(auth()->user()->name),
            'skema_id' => (string) $request->skema_id,
            'skema_name' => \App\Helpers\HtmlSanitizer::plain($skema->skema ?? ''),
            'kode_skema' => \App\Helpers\HtmlSanitizer::plain($skema->kode_skema ?? ''),
            'id_skema' => (string) $request->skema_id,
            'kode' => \App\Helpers\HtmlSanitizer::plain($request->tujuan_asesmen ?? ''),
            'status' => 'Menunggu Validasi',
            'nik' => \App\Helpers\HtmlSanitizer::plain($request->nik ?? ''),
            'tmpt_lahir' => \App\Helpers\HtmlSanitizer::plain($request->tempat_lahir ?? ''),
            'tgl_lahir' => $request->tanggal_lahir,
            'sex_id' => (string) ($sex->id ?? ''),
            'negara' => \App\Helpers\HtmlSanitizer::plain($request->kebangsaan ?? ''),
            'alamat' => \App\Helpers\HtmlSanitizer::plain($request->alamat ?? ''),
            'kode_post' => \App\Helpers\HtmlSanitizer::plain($request->kode_pos ?? ''),
            'no_hp' => \App\Helpers\HtmlSanitizer::plain($request->no_hp ?? ''),
            'surel' => \App\Helpers\HtmlSanitizer::plain($request->email ?? ''),
            'institusi' => \App\Helpers\HtmlSanitizer::plain($request->nama_perusahaan ?? ''),
            'jabatan' => \App\Helpers\HtmlSanitizer::plain($request->jabatan ?? ''),
            'alamat_kantor' => \App\Helpers\HtmlSanitizer::plain($request->alamat_kantor ?? ''),
            'postal' => \App\Helpers\HtmlSanitizer::plain($request->kode_pos_kantor ?? ''),
            'telp' => \App\Helpers\HtmlSanitizer::plain($request->telepon_kantor ?? ''),
            'email3' => \App\Helpers\HtmlSanitizer::plain($request->email_kantor ?? ''),
            'tmt' => \App\Helpers\HtmlSanitizer::plain($request->pendidikan ?? ''),
            'jenis' => 'Baru',
            'image' => optional($permohonan->dokumens->where('jenis_dokumen', 'foto_3x4')->first())->path_file,
        ]);

        $permohonan->update(['data_register_id' => $dr->id]);

        $dokumenMap = [
            'ktp' => 'KTP',
            'kartu_keluarga' => 'Kartu Keluarga',
            'raport' => 'Raport',
            'sertifikat_pkl' => 'Sertifikat PKL',
            'foto_3x4' => 'Pas Foto',
        ];
        foreach ($permohonan->dokumens as $dok) {
            $docLabel = $dokumenMap[$dok->jenis_dokumen] ?? $dok->jenis_dokumen;
            $dr->upload_files()->create([
                'name' => $dok->nama_file,
                'kode' => $request->skema_id,
                'kode_dokumen' => $docLabel,
                'image' => $dok->path_file,
                'user_id' => (string) auth()->id(),
                'status' => 'pending',
            ]);
        }

        return redirect()->route('permohonan.index')
            ->with('success', 'Permohonan sertifikasi berhasil dikirim. Status: Pending.');
    }

    public function show($id)
    {
        $permohonan = Permohonan::with([
            'user',
            'skema',
            'skema.unikoms',
            'dataPribadi',
            'pekerjaan',
            'dokumens',
        ])->findOrFail($id);

        if ($permohonan->user_id !== auth()->id() && !auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return view('asesi.permohonan.show', compact('permohonan'));
    }

    public function edit($id)
    {
        $permohonan = Permohonan::with(['dataPribadi', 'pekerjaan', 'dokumens', 'skema'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        if (!in_array($permohonan->status, ['pending', 'revisi'])) {
            return redirect()->route('permohonan.index')
                ->with('error', 'Permohonan tidak dapat diedit karena status: ' . $permohonan->status);
        }

        $skemas = Skema::all();
        return view('asesi.permohonan.edit', compact('permohonan', 'skemas'));
    }

    public function update(StorePermohonanRequest $request, $id)
    {
        $permohonan = Permohonan::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'revisi'])
            ->findOrFail($id);

        $ttdData = $request->ttd;
        $ttdPath = $permohonan->ttd;
        if ($ttdData && str_starts_with($ttdData, 'data:image/png;base64,')) {
            if ($permohonan->ttd) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($permohonan->ttd);
            }
            $ttdData = str_replace('data:image/png;base64,', '', $ttdData);
            $ttdData = base64_decode($ttdData);
            $filename = 'ttd_' . time() . '_' . auth()->id() . '.png';
            \Illuminate\Support\Facades\Storage::disk('public')->put('ttd/' . $filename, $ttdData);
            $ttdPath = 'ttd/' . $filename;
        }

        $permohonan->update([
            'skema_id' => $request->skema_id,
            'tujuan_asesmen' => $request->tujuan_asesmen,
            'status' => 'pending',
            'catatan' => null,
            'ttd' => $ttdPath,
        ]);

        $permohonan->dataPribadi->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kebangsaan' => $request->kebangsaan,
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'pendidikan' => $request->pendidikan,
        ]);

        $permohonan->pekerjaan->update([
            'nama_perusahaan' => $request->nama_perusahaan,
            'jabatan' => $request->jabatan,
            'alamat_kantor' => $request->alamat_kantor,
            'kode_pos_kantor' => $request->kode_pos_kantor,
            'telepon_kantor' => $request->telepon_kantor,
            'email_kantor' => $request->email_kantor,
        ]);

        $dokumenFields = [
            'dokumen_raport' => 'raport',
            'dokumen_sertifikat_pkl' => 'sertifikat_pkl',
            'dokumen_kartu_keluarga' => 'kartu_keluarga',
            'dokumen_ktp' => 'ktp',
            'dokumen_foto' => 'foto_3x4',
        ];

        foreach ($dokumenFields as $field => $jenis) {
            if ($request->hasFile($field)) {
                $oldDokumen = $permohonan->dokumens->where('jenis_dokumen', $jenis)->first();
                if ($oldDokumen) {
                    Storage::disk('public')->delete($oldDokumen->path_file);
                    $oldDokumen->delete();
                }

                $file = $request->file($field);
                $path = $file->store('dokumen', 'public');
                Dokumen::create([
                    'permohonan_id' => $permohonan->id,
                    'jenis_dokumen' => $jenis,
                    'nama_file' => \Illuminate\Support\Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension(),
                    'path_file' => $path,
                ]);
            }
        }

        $skema = Skema::find($request->skema_id);
        $sex = Sex::where('sex', $request->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan')->first();

        $dataRegister = Data_register::where('user_id', (string) auth()->id())
            ->where('id_skema', (string) $request->skema_id)
            ->latest()
            ->first();

        if ($dataRegister) {
            $dataRegister->update([
                'user_name' => \App\Helpers\HtmlSanitizer::plain(auth()->user()->name),
                'skema_id' => (string) $request->skema_id,
                'skema_name' => \App\Helpers\HtmlSanitizer::plain($skema->skema ?? ''),
                'kode_skema' => \App\Helpers\HtmlSanitizer::plain($skema->kode_skema ?? ''),
                'kode' => \App\Helpers\HtmlSanitizer::plain($request->tujuan_asesmen ?? ''),
                'status' => 'Menunggu Validasi',
                'nik' => \App\Helpers\HtmlSanitizer::plain($request->nik ?? ''),
                'tmpt_lahir' => \App\Helpers\HtmlSanitizer::plain($request->tempat_lahir ?? ''),
                'tgl_lahir' => $request->tanggal_lahir,
                'sex_id' => (string) ($sex->id ?? ''),
                'negara' => \App\Helpers\HtmlSanitizer::plain($request->kebangsaan ?? ''),
                'alamat' => \App\Helpers\HtmlSanitizer::plain($request->alamat ?? ''),
                'kode_post' => \App\Helpers\HtmlSanitizer::plain($request->kode_pos ?? ''),
                'no_hp' => \App\Helpers\HtmlSanitizer::plain($request->no_hp ?? ''),
                'surel' => \App\Helpers\HtmlSanitizer::plain($request->email ?? ''),
                'institusi' => \App\Helpers\HtmlSanitizer::plain($request->nama_perusahaan ?? ''),
                'jabatan' => \App\Helpers\HtmlSanitizer::plain($request->jabatan ?? ''),
                'alamat_kantor' => \App\Helpers\HtmlSanitizer::plain($request->alamat_kantor ?? ''),
                'postal' => \App\Helpers\HtmlSanitizer::plain($request->kode_pos_kantor ?? ''),
                'telp' => \App\Helpers\HtmlSanitizer::plain($request->telepon_kantor ?? ''),
                'email3' => \App\Helpers\HtmlSanitizer::plain($request->email_kantor ?? ''),
                'tmt' => \App\Helpers\HtmlSanitizer::plain($request->pendidikan ?? ''),
                'image' => optional($permohonan->dokumens->where('jenis_dokumen', 'foto_3x4')->first())->path_file ?? $dataRegister->image,
            ]);

            $dataRegister->upload_files()->delete();
            $dokumenMap = [
                'ktp' => 'KTP',
                'kartu_keluarga' => 'Kartu Keluarga',
                'raport' => 'Raport',
                'sertifikat_pkl' => 'Sertifikat PKL',
                'foto_3x4' => 'Pas Foto',
            ];
            foreach ($permohonan->dokumens as $dok) {
                $docLabel = $dokumenMap[$dok->jenis_dokumen] ?? $dok->jenis_dokumen;
                $dataRegister->upload_files()->create([
                    'name' => $dok->nama_file,
                    'kode' => $request->skema_id,
                    'kode_dokumen' => $docLabel,
                    'image' => $dok->path_file,
                    'user_id' => (string) auth()->id(),
                    'status' => 'pending',
                ]);
            }
        }

        return redirect()->route('permohonan.index')
            ->with('success', 'Permohonan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $permohonan = Permohonan::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->findOrFail($id);

        Data_register::where('user_id', (string) auth()->id())
            ->where('id_skema', (string) $permohonan->skema_id)
            ->delete();

        foreach ($permohonan->dokumens as $dok) {
            \Storage::disk('public')->delete($dok->path_file);
        }
        $permohonan->dokumens()->delete();
        $permohonan->dataPribadi()->delete();
        $permohonan->pekerjaan()->delete();
        $permohonan->delete();

        return redirect()->back()->with('success', 'Permohonan berhasil dibatalkan.');
    }

    public function frapl01()
    {
        $permohonans = Permohonan::with(['skema', 'dataPribadi'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        return view('asesi.permohonan.frapl01', compact('permohonans'));
    }

    public function showFrapl01($id)
    {
        $permohonan = Permohonan::with([
            'user',
            'skema',
            'skema.unikoms',
            'dataPribadi',
            'pekerjaan',
            'dokumens',
        ])->where('user_id', auth()->id())
            ->whereIn('status', ['diverifikasi', 'selesai'])
            ->findOrFail($id);

        return view('asesi.permohonan.frapl01_show', compact('permohonan'));
    }

    public function getUnitKompetensi($skemaId)
    {
        $unikoms = Unikom::where('skema_id', $skemaId)->get();
        return response()->json($unikoms);
    }

    public function adminIndex()
    {
        $permohonans = Permohonan::with(['user', 'skema', 'dataPribadi'])
            ->latest()
            ->paginate(15);
        return view('admin.permohonan.index', compact('permohonans'));
    }

    public function adminShow($id)
    {
        $permohonan = Permohonan::with([
            'user',
            'skema',
            'skema.unikoms',
            'dataPribadi',
            'pekerjaan',
            'dokumens',
        ])->findOrFail($id);
        return view('admin.permohonan.show', compact('permohonan'));
    }

    public function adminUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diverifikasi,revisi,ditolak,selesai',
            'catatan' => 'nullable|string',
        ]);

        $permohonan = Permohonan::findOrFail($id);
        $permohonan->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('admin.permohonan.show', $id)
            ->with('success', 'Status permohonan berhasil diperbarui menjadi ' . $request->status);
    }
}
