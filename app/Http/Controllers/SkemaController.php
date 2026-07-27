<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use App\Models\CekPendaftaran;
use App\Models\Jurusan;
use App\Models\Skema;
use App\Models\Tuk;
use App\Models\Unikom;
use App\Models\VerifikasiSkema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;

class SkemaController extends Controller
{

    public function index(){
        $tuk = Tuk::all();
        $asesor = Asesor::all();
        $jurusan = Jurusan::all();
        $verifikasi_skemas = VerifikasiSkema::all();
        $skema = Skema::orderBy('created_at','desc')->get();
        return view('admin/skema/index', compact('skema', 'jurusan', 'asesor', 'tuk', 'verifikasi_skemas'));
    }


    public function store(Request $request){

        $request->validate([
            'kode_skema' => ['required'],
            'skema' => ['required'],
            'jurusan_id' => ['required'],
            'asesor_id' => ['required'],
            'tuk_id' => ['required'],
            'status_id' => ['required'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ],[
            'skema.required' => 'Skemanya mana?',
            'kode_skema.required' => 'Kode Skemanya mana?',
            'jurusan_id.required' => 'Pilih Jurusannya',
            'asesor_id.required' => 'Pilih Asesornya',
            'tuk_id.required' => 'Pilih TUKnya',
            'status_id.required' => 'Pilih Status Skema',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = [
            'kode_skema' => $request->kode_skema,
            'skema' => $request->skema,
            'jurusan_id' => $request->jurusan_id,
            'asesor_id' => $request->asesor_id,
            'tuk_id' => $request->tuk_id,
            'status_id' => $request->status_id,
            'verifikasi_skema_id' => $request->verifikasi_skema_id,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $safeName = \Illuminate\Support\Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/skemas/', $safeName);
            $data['image'] = 'uploads/skemas/' . $safeName;
        }

        Skema::create($data);
        return redirect()->route('skema.index')->with('success','Skema anda berhasil di Posting');
    }


    public function show($id) {
        $decryptID = Crypt::decryptString($id);
        $skema = Skema::findorfail($decryptID);
        return view('admin/skema/show')->with('skema', $skema);
    }


    public function edit($id) {
        $decryptID = Crypt::decryptString($id);
        $tuk = Tuk::all();
        $asesor = Asesor::all();
        $jurusan = Jurusan::all();
        $verifikasi_skemas = VerifikasiSkema::all();
        $skema = Skema::findorfail($decryptID);
        return view('admin/skema/edit', compact('skema', 'jurusan', 'asesor', 'tuk', 'verifikasi_skemas'));
    }


    public function update(Request $request, $id) {
        $request->validate([
            'skema' => ['required'],
            'jurusan_id' => ['required'],
            'asesor_id' => ['required'],
            'tuk_id' => ['required'],
            'status_id' => ['required'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ],[
            'skema.required' => 'Skemanya mana?',
            'kode_skema.required' => 'Kode Skemanya mana?',
            'jurusan_id.required' => 'Pilih Jurusannya',
            'asesor_id.required' => 'Pilih Asesornya',
            'tuk_id.required' => 'Pilih TUKnya',
            'status_id.required' => 'Pilih Status',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $skema = Skema::findorfail($id);

        $skema_data = [
            'kode_skema' => $request->kode_skema,
            'skema' => $request->skema,
            'jurusan_id' => $request->jurusan_id,
            'asesor_id' => $request->asesor_id,
            'tuk_id' => $request->tuk_id,
            'status_id' => $request->status_id,
            'verifikasi_skema_id' => $request->verifikasi_skema_id,
        ];

        if ($request->hasFile('image')) {
            if ($skema->image && File::exists(public_path($skema->image))) {
                File::delete(public_path($skema->image));
            }
            $image = $request->file('image');
            $safeName = \Illuminate\Support\Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/skemas/', $safeName);
            $skema_data['image'] = 'uploads/skemas/' . $safeName;
        }

        Skema::whereId($id)->update($skema_data);
        return redirect()->route('skema.index')->with('success','Skema Anda Berhasil di Ubah');
    }


    public function destroy($id){
        $skema = Skema::findorfail($id);
        if ($skema->image && File::exists(public_path($skema->image))) {
            File::delete(public_path($skema->image));
        }
        $skema->delete();
        return redirect()->back()->with('success','Skema Berhasil Dihapus');
    }


    public function show_asesmen($id){
        $decryptID = Crypt::decryptString($id);
        $unikom = Unikom::findorfail($decryptID);
        return view('admin/skema/show_asesmen')->with('unikom', $unikom);
    }


    public function detail($id){
        $decryptID = Crypt::decryptString($id);
        $skema = Skema::findorfail($decryptID);
        return view('admin/skema/detail', compact('skema'));
    }
}
