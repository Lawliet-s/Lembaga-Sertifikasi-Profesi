<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use App\Models\Data_register;
use App\Models\Permohonan;
use App\Models\Skema;
use App\Models\Tuk;
use App\Models\Upload_file;
use App\Models\Xnxx;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Unique;

class ValidasiController extends Controller
{

    public function registrasi_baru(){
        $validasi = Data_register::where('status', 'Menunggu Validasi')->get();
        return view('admin/register/index', compact('validasi'));
    }


    public function list_valid(){
        $validasi = Data_register::where('status', 'Pendaftaran Divalidasi')->get();
        return view('admin/register/list_valid', compact('validasi'));
    }


    public function list_tolak(){
        $validasi = Data_register::where('status', 'Pendaftaran Ditolak')->get();
        return view('admin/register/list_tolak', compact('validasi'));
    }


    public function list_blacklist(){
        $validasi = Data_register::where('status', 'Pendaftaran Sementara Diblokir')->get();
        return view('admin/register/list_blacklist', compact('validasi'));
    }

    public function list_sertifikat(){
        $validasi = Data_register::where('status', 'Sertifikasi Selesai')->get();
        return view('admin/register/list_sertifikat', compact('validasi'));
    }



    public function show(Request $request, $id){
        $validasi = Data_register::with(['xnxxes', 'upload_files'])->findOrFail($id);
        $tuk = Tuk::all();
        $asesor = Asesor::all();
        $skema = Skema::with('unikoms')->find((int) $validasi->skema_id);
        return view('admin/register/show', compact('validasi', 'tuk', 'asesor', 'skema'));
    }


    public function proses_show(Request $request, $id){
        $validasi = Data_register::with(['xnxxes', 'upload_files'])->findOrFail($id);
        $tuk = Tuk::all();
        $asesor = Asesor::all();
        return view('admin/register/proses_show', compact('validasi', 'tuk', 'asesor'));
    }


    public function sertifikat_show(Request $request, $id){
        $validasi = Data_register::with(['xnxxes', 'upload_files'])->findOrFail($id);
        $tuk = Tuk::all();
        $asesor = Asesor::all();
        return view('admin/register/sertifikat_show', compact('validasi', 'tuk', 'asesor'));
    }


    public function blacklist_show(Request $request, $id){
        $validasi = Data_register::with(['xnxxes', 'upload_files'])->findOrFail($id);
        $tuk = Tuk::all();
        $asesor = Asesor::all();
        return view('admin/register/blacklist_show', compact('validasi', 'tuk', 'asesor'));
    }


    public function update(Request $request, $id){
        $request->validate([
            'date' => ['required'],
            'time' => ['required'],
            'asesor_id' => ['required'],
            'tuk_id' => ['required'],
        ],[
            'date.required' => 'Masukan tanggal sertifikasi',
            'time.required' => 'Masukan waktu sertifikasi',
            'asesor_id.required' => 'Pilih Penguji',
            'tuk_id.required' => 'Pilih Tempat Uji Kompetensi',
        ]);
        $validasi_data = [
            'status' => \App\Helpers\HtmlSanitizer::plain($request->status),
            'date' => $request->date,
            'time' => $request->time,
            'asesor_id' => $request->asesor_id,
            'tuk_id' => $request->tuk_id,
            'keterangan' => \App\Helpers\HtmlSanitizer::plain($request->keterangan ?? ''),
        ];
        Data_register::whereId($id)->update($validasi_data);
        return back()->with('success', 'Proses Update Data Registrasi Berhasil');
    }


    public function update2(Request $request, $id){
        $validasi_data = [
            'status' => \App\Helpers\HtmlSanitizer::plain($request->status),
            'id_skema' => $request->id_skema,
            'kode' => \App\Helpers\HtmlSanitizer::plain($request->kode ?? ''),
        ];
        Data_register::whereId($id)->update($validasi_data);
        return back()->with('success', 'Proses Validasi Data Registrasi Berhasil');
    }

    public function finishstore(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:255',
            'skema_id' => 'required|exists:skemas,id',
            'skema_name' => 'required|string|max:255',
            'tuk_id' => 'nullable|exists:t_u_k_s,id',
            'tuk_name' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',
            'asesor_id' => 'nullable|exists:users,id',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'nullable|string|max:20',
            'nik' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:500',
            'tmp_lahir' => 'nullable|string|max:100',
            'tgl_lahir' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'pendidikan' => 'nullable|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'kewarganegaraan' => 'nullable|string|max:50',
            'nama_perusahaan' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'telephone' => 'nullable|string|max:20',
            'npwp' => 'nullable|string|max:50',
            'ktp' => 'nullable|string|max:255',
            'pasfoto' => 'nullable|string|max:255',
            'ijazah' => 'nullable|string|max:255',
            'cv' => 'nullable|string|max:255',
            'surat' => 'nullable|string|max:255',
            'status' => 'required|string|max:500',
            'keterangan' => 'nullable|string|max:2000',
        ]);

        Data_register::create([
            'kode' => \App\Helpers\HtmlSanitizer::plain($request->kode),
            'skema_id' => $request->skema_id,
            'skema_name' => \App\Helpers\HtmlSanitizer::plain($request->skema_name),
            'tuk_id' => $request->tuk_id,
            'tuk_name' => \App\Helpers\HtmlSanitizer::plain($request->tuk_name ?? ''),
            'user_id' => $request->user_id,
            'asesor_id' => $request->asesor_id,
            'nama' => \App\Helpers\HtmlSanitizer::plain($request->nama),
            'email' => \App\Helpers\HtmlSanitizer::plain($request->email),
            'no_hp' => \App\Helpers\HtmlSanitizer::plain($request->no_hp ?? ''),
            'nik' => \App\Helpers\HtmlSanitizer::plain($request->nik ?? ''),
            'alamat' => \App\Helpers\HtmlSanitizer::plain($request->alamat ?? ''),
            'tmp_lahir' => \App\Helpers\HtmlSanitizer::plain($request->tmp_lahir ?? ''),
            'tgl_lahir' => $request->tgl_lahir,
            'gender' => \App\Helpers\HtmlSanitizer::plain($request->gender ?? ''),
            'pendidikan' => \App\Helpers\HtmlSanitizer::plain($request->pendidikan ?? ''),
            'pekerjaan' => \App\Helpers\HtmlSanitizer::plain($request->pekerjaan ?? ''),
            'kewarganegaraan' => \App\Helpers\HtmlSanitizer::plain($request->kewarganegaraan ?? ''),
            'nama_perusahaan' => \App\Helpers\HtmlSanitizer::plain($request->nama_perusahaan ?? ''),
            'kode_pos' => \App\Helpers\HtmlSanitizer::plain($request->kode_pos ?? ''),
            'telephone' => \App\Helpers\HtmlSanitizer::plain($request->telephone ?? ''),
            'npwp' => \App\Helpers\HtmlSanitizer::plain($request->npwp ?? ''),
            'ktp' => \App\Helpers\HtmlSanitizer::plain($request->ktp ?? ''),
            'pasfoto' => \App\Helpers\HtmlSanitizer::plain($request->pasfoto ?? ''),
            'ijazah' => \App\Helpers\HtmlSanitizer::plain($request->ijazah ?? ''),
            'cv' => \App\Helpers\HtmlSanitizer::plain($request->cv ?? ''),
            'surat' => \App\Helpers\HtmlSanitizer::plain($request->surat ?? ''),
            'status' => \App\Helpers\HtmlSanitizer::plain($request->status),
            'keterangan' => \App\Helpers\HtmlSanitizer::plain($request->keterangan ?? ''),
            'jenis_sertifikasi' => \App\Helpers\HtmlSanitizer::plain($request->jenis_sertifikasi ?? ''),
            'skema_name_asal' => \App\Helpers\HtmlSanitizer::plain($request->skema_name_asal ?? ''),
            'tanggal_pelaksanaan_uji_kom' => $request->tanggal_pelaksanaan_uji_kom,
            'no_sertifikat' => \App\Helpers\HtmlSanitizer::plain($request->no_sertifikat ?? ''),
        ]);

        return redirect()->route('validasi.index')->with('success', 'Data Berhasil Disimpan');
    }


    public function update3(Request $request, $id)
    {
        $validasi_data = [
            'status' => \App\Helpers\HtmlSanitizer::plain($request->status),
            'date' => $request->date,
            'time' => $request->time,
            'asesor_id' => $request->asesor_id,
            'tuk_id' => $request->tuk_id,
            'keterangan' => \App\Helpers\HtmlSanitizer::plain($request->keterangan ?? ''),
        ];
        Data_register::whereId($id)->update($validasi_data);
        return back()->with('success', 'Proses Validasi Data Registrasi Berhasil');
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'in:pending,diverifikasi,ditolak,revisi'],
        ]);

        $statusMap = [
            'pending' => 'Menunggu Validasi',
            'diverifikasi' => 'Pendaftaran Divalidasi',
            'ditolak' => 'Pendaftaran Ditolak',
            'revisi' => 'Revisi Data',
        ];

        $data = [
            'status' => $statusMap[$request->status],
        ];

        if ($request->filled('keterangan')) {
            $data['keterangan'] = $request->keterangan;
        }

        Data_register::whereId($id)->update($data);

        // Also update related Permohonan record
        $dr = Data_register::find($id);
        if ($dr) {
            $permohonan = Permohonan::where('user_id', (int) $dr->user_id)
                ->where('skema_id', (int) $dr->skema_id)
                ->latest()
                ->first();
            if ($permohonan) {
                $permohonanStatusMap = [
                    'pending' => 'pending',
                    'diverifikasi' => 'diverifikasi',
                    'ditolak' => 'ditolak',
                    'revisi' => 'revisi',
                ];
                $permohonan->update([
                    'status' => $permohonanStatusMap[$request->status],
                    'catatan' => $request->filled('keterangan') ? $request->keterangan : $permohonan->catatan,
                ]);
            }
        }

        $label = ucfirst($request->status);
        return back()->with('success', "Status pendaftaran berhasil diubah menjadi: $label");
    }


    public function destroy($id){
        $validasi = Data_register::findorfail($id);
        $validasi->delete();
        return back()->with('success', 'Peserta Asesi Berhasil dihapus');
    }


    public function backup_store(Request $request)
    {
        $request->validate([
            'kode' => ['required', 'unique:data_registers,kode'],
            'skema_id' => ['required', 'unique:data_registers,skema_id'],
            'id' => ['required', 'unique:data_registers,id'],
            // 'sex_id' => ['required'],
            'kode_skema' => ['required'],
            'nik' => ['required'],
            // 'tmpt_lahir' => ['required'],
            // 'no_hp' => ['required'],
            // 'semester_id' => ['required'],
            // 'tgl_lahir' => ['required'],
            // 'surel' => ['required'],
            'jurusan_id' => ['required'],
            // 'alamat' => ['required'],
            // 'negara' => ['required'],
            'id_skema' => ['required'],
            // 'image' => ['required'],
            // 'kode_post' => ['required'],
            // 'provinsi' => ['required'],
            // 'kabupaten' => ['required'],
            // 'kecamatan' => ['required'],
            // 'kota' => ['required']
        ],[
            'kode.unique' => 'Pendaftaran Sertifikasi Ditolak',
            'skema_id.unique' => 'Harap periksa kembali status pendaftaran sertifikasi sebelumnya',
            'id.unique' => ' Kemungkinan anda sudah mendaftar dengan skema ini',
        ]);

            $data_register = Data_register::create([
                'id' => $request->id,
                'kode' => \App\Helpers\HtmlSanitizer::plain($request->kode ?? ''),
                'nik' => \App\Helpers\HtmlSanitizer::plain($request->nik ?? ''),
                'skema_name' => \App\Helpers\HtmlSanitizer::plain($request->skema_name ?? ''),
                'tuk_id' => $request->tuk_id,
                'kode_skema' => \App\Helpers\HtmlSanitizer::plain($request->kode_skema ?? ''),
                'asesor_id' => $request->asesor_id,
                'status' => \App\Helpers\HtmlSanitizer::plain($request->status ?? ''),
                'skema_id' => $request->skema_id,
                'user_id' => $request->user_id,
                'id_skema' => $request->id_skema,
                'user_name' => \App\Helpers\HtmlSanitizer::plain($request->user_name ?? ''),
                'email' => \App\Helpers\HtmlSanitizer::plain($request->email ?? ''),
                'sex_id' => $request->sex_id,
                'tgl_lahir' => $request->tgl_lahir,
                'tmpt_lahir' => \App\Helpers\HtmlSanitizer::plain($request->tmpt_lahir ?? ''),
                'negara' => \App\Helpers\HtmlSanitizer::plain($request->negara ?? ''),
                'alamat' => \App\Helpers\HtmlSanitizer::plain($request->alamat ?? ''),
                'no_hp' => \App\Helpers\HtmlSanitizer::plain($request->no_hp ?? ''),
                'kode_post' => \App\Helpers\HtmlSanitizer::plain($request->kode_post ?? ''),
                'surel' => \App\Helpers\HtmlSanitizer::plain($request->surel ?? ''),
                'semester_id' => $request->semester_id,
                'jurusan_id' => $request->jurusan_id,
                'image' => $request->image,
                'institusi' => \App\Helpers\HtmlSanitizer::plain($request->institusi ?? ''),
                'jabatan' => \App\Helpers\HtmlSanitizer::plain($request->jabatan ?? ''),
                'email3' => \App\Helpers\HtmlSanitizer::plain($request->email3 ?? ''),
                'fax' => \App\Helpers\HtmlSanitizer::plain($request->fax ?? ''),
                'telp' => \App\Helpers\HtmlSanitizer::plain($request->telp ?? ''),
                'postal' => \App\Helpers\HtmlSanitizer::plain($request->postal ?? ''),
                'jenis' => \App\Helpers\HtmlSanitizer::plain($request->jenis ?? ''),
                'rmh' => \App\Helpers\HtmlSanitizer::plain($request->rmh ?? ''),
                'ktr' => \App\Helpers\HtmlSanitizer::plain($request->ktr ?? ''),
                'tmt' => \App\Helpers\HtmlSanitizer::plain($request->tmt ?? ''),
                'alamat_kantor' => \App\Helpers\HtmlSanitizer::plain($request->alamat_kantor ?? ''),
            ]);
        return back()->with('success', ' Pendaftaran anda Berhasil, Selanjutnya Silahkan "Ambil Formulir Pendafatran"');
    }

}
