<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use App\Models\CekPendaftaran;
use App\Models\Data_register;
use App\Models\Dokumen_Upload;
use App\Models\Jurusan;
use App\Models\Semester;
use App\Models\Sex;
use App\Models\Skema;
use App\Models\Tuk;
use App\Models\Unikom;
use App\Models\Upload_file;
use App\Models\User;
use App\Models\Xnxx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class RegistrasiController extends Controller
{

    public function index()
    {
        $dokumen_upload = Dokumen_Upload::all();
        $sex = Sex::all();
        $jurusan = Jurusan::all();
        $semester = Semester::all();
        $skema = Skema::all();
        $unikom =Unikom::all();
        return view('asesi/registrasi/pilihan_skema', compact('skema','dokumen_upload', 'unikom', 'semester','sex','jurusan'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:255',
            'skema_id' => 'required|exists:skemas,id',
            'kode_skema' => 'required|string|max:50',
            'nik' => 'required|string|max:50',
            'jurusan_id' => 'required|exists:jurusans,id',
            'id_skema' => 'required|string|max:255',
            'skema_name' => 'nullable|string|max:255',
            'tuk_id' => 'nullable|exists:t_u_k_s,id',
            'asesor_id' => 'nullable|exists:users,id',
            'email' => 'nullable|email|max:255',
            'sex_id' => 'nullable|exists:sexes,id',
            'tgl_lahir' => 'nullable|date',
            'tmpt_lahir' => 'nullable|string|max:100',
            'negara' => 'nullable|string|max:100',
            'alamat' => 'nullable|string|max:500',
            'no_hp' => 'nullable|string|max:20',
            'kode_post' => 'nullable|string|max:10',
            'surel' => 'nullable|string|max:255',
            'semester_id' => 'nullable|exists:semesters,id',
            'image' => 'nullable|string|max:255',
            'institusi' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'email3' => 'nullable|string|max:255',
            'fax' => 'nullable|string|max:50',
            'telp' => 'nullable|string|max:20',
            'postal' => 'nullable|string|max:10',
            'jenis' => 'nullable|string|max:50',
            'rmh' => 'nullable|string|max:255',
            'ktr' => 'nullable|string|max:255',
            'tmt' => 'nullable|string|max:255',
            'alamat_kantor' => 'nullable|string|max:500',
        ]);

            $data_register = Data_register::create([
                'id' => $request->id,
                'kode' => \App\Helpers\HtmlSanitizer::plain($request->kode),
                'nik' => \App\Helpers\HtmlSanitizer::plain($request->nik),
                'skema_name' => \App\Helpers\HtmlSanitizer::plain($request->skema_name ?? ''),
                'tuk_id' => $request->tuk_id,
                'kode_skema' => \App\Helpers\HtmlSanitizer::plain($request->kode_skema),
                'asesor_id' => $request->asesor_id,
                'status' => 'Lengkapi Data Anda',
                'skema_id' => $request->skema_id,
                'user_id' => auth()->id(),
                'id_skema' => \App\Helpers\HtmlSanitizer::plain($request->id_skema),
                'user_name' => \App\Helpers\HtmlSanitizer::plain(auth()->user()->name),
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
                'jurusan_id' => auth()->user()->jurusan_id,
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


    public function update(Request $request, $id)
    {
        $data = [
                'skema_id' => $request->skema_id,
                'status' => \App\Helpers\HtmlSanitizer::plain($request->status ?? ''),
            ];
            Data_register::where('id', $id)->where('user_id', auth()->id())->update($data);
        return redirect()->route('dashasesi.index')->with('success', ' Data Anda Berhasil di DiUpdate');
    }

    public function edit($id)
    {
        $xnxx = Xnxx::where('user_id', auth()->user()->id)
                ->where('kode', '>', 2)
                ->get();
        $dokumen_upload = Dokumen_Upload::all();
        $user = User::all();
        $identitas = Upload_file::where('user_id', auth()->user()->id)
                ->where('kode', '>', 2)
                ->get();
        $datareg = Data_register::where('user_id', auth()->user()->id)
            ->where('status', 'Lengkapi Data Anda')
            ->get();
        $sex = Sex::all();
        $semester = Semester::all();
        $jurusan = Jurusan::all();
        $skema = Skema::findorfail($id);
        return view('asesi/registrasi/mengambil_formulir', compact('semester', 'datareg', 'xnxx', 'dokumen_upload', 'jurusan','sex', 'identitas', 'user', 'skema'));
    }


    public function show($id)
    {
        $decryptID = Crypt::decryptString($id);
        $registrasi = Data_register::where('user_id', auth()->user()->id)->get();
        $xnxx = Xnxx::where('user_id', auth()->user()->id)
                    ->where('kode', '>', 3)
                    ->get();

        $datareg = Data_register::where('user_id', auth()->user()->id)
            ->where('status', 'Lengkapi Data Anda')
            ->get();
        $sex = Sex::all();
        $semester = Semester::all();
        $jurusan = Jurusan::all();
        $dokumen_upload = Dokumen_Upload::all();
        $data = Data_register::where('user_id', auth()->id())->findOrFail($decryptID);
        $identitas = Upload_file::where('user_id', auth()->user()->id)
                    ->where('kode', '>', 3)
                    ->get();
        return view('asesi/registrasi/formulirapl1', compact('data', 'datareg', 'sex', 'jurusan', 'semester', 'dokumen_upload', 'identitas', 'xnxx', 'registrasi'));
    }


    public function data_edit_tolak($id)
    {
        $registrasi = Data_register::where('user_id', auth()->user()->id)->get();
        $xnxx = Xnxx::where('user_id', auth()->user()->id)
                    ->where('kode', '>=', 1)
                    ->get();

        $datareg = Data_register::where('user_id', auth()->user()->id)
            ->where('status', 'Pendaftaran Ditolak')
            ->get();
        $sex = Sex::all();
        $semester = Semester::all();
        $jurusan = Jurusan::all();
        $dokumen_upload = Dokumen_Upload::all();
        $data = Data_register::where('user_id', auth()->id())->findOrFail($id);
        $identitas = Upload_file::where('user_id', auth()->user()->id)
                ->where('kode', '>', 1)
                ->get();
        return view('asesi/registrasi/formulirapl1_tolak', compact('data', 'datareg', 'sex', 'jurusan',
        'semester', 'dokumen_upload', 'identitas', 'registrasi', 'xnxx'));
    }


    public function destroy($id)
    {
        $data = Data_register::where('user_id', auth()->id())->findOrFail($id);
        $data->delete();
        return back()->with('success', 'Pendaftaran Asesi Berhasil dihapus');
    }


    public function rekap_pendaftaran($id)
    {
        $validasi = Data_register::where('user_id', auth()->id())->findOrFail($id);
        $xnxx = Xnxx::all();
        $identitas = Upload_file::all();
        $tuk = Tuk::all();
        $asesor = Asesor::all();
        return view('asesi/registrasi/rekap_pendaftaran', compact('validasi', 'tuk', 'asesor', 'identitas', 'xnxx'));
    }


    public function info_sertifikasi($id)
    {
        $validasi = Data_register::where('user_id', auth()->id())->findOrFail($id);
        $xnxx = Xnxx::all();
        $identitas = Upload_file::all();
        $tuk = Tuk::all();
        $asesor = Asesor::all();
        return view('asesi/registrasi/info_sertifikasi', compact('validasi', 'tuk', 'asesor', 'identitas', 'xnxx'));
    }


    public function daftar()
    {
        $skema = Skema::all();
        return view('asesi.registrasi.daftar_sertifikasi', compact('skema'));
    }


    public function skema_pendaftaran()
    {
        $skema = Skema::all();
        return view('asesi.registrasi.skema_pendaftaran', compact('skema'));
    }


}
