<?php

namespace App\Http\Controllers;

use App\Models\Asesi;
use App\Models\Data_register;
use App\Models\Info;
use App\Models\Jurusan;
use App\Models\Semester;
use App\Models\Sex;
use App\Models\Skema;
use App\Models\Unikom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;


class AsesiController extends Controller
{


    public function index(){
        $semester = Semester::all();
        $jurusan = Jurusan::all();
        $asesi = Asesi::all();
        return view('asesi/index', compact('asesi', 'semester', 'jurusan'));
    }


    public function info_skema(){
        $skema = Skema::where('status_id', 'Aktif')->get();
        return view('asesi/info_skema', compact('skema'));
    }


    public function info_skema_show($id){
        $decryptID = Crypt::decryptString($id);
        $skema = Skema::findorfail($decryptID);
        return view('asesi/info_skema_show', compact('skema'));
    }


    public function sertifikat_show($id){
         $decryptID = Crypt::decryptString($id);
         $validasi = Data_register::where('user_id', auth()->id())->findOrFail($decryptID);
         return view('asesi/sertifikat_show', compact('validasi'));
     }


     public function koleksi_sertifikat(){
         $datareg = Data_register::where('user_id', auth()->user()->id)
             ->where('status', 'Sertifikasi Selesai')
             ->get();
         return view('asesi/koleksi', compact('datareg'));
     }


    public function instruksi_registrasi(){
        $info = Info::all();
        return view('asesi/instruksi', compact('info'));
    }


    public function edit(){
        $user = auth()->user();
        return view('asesi/edit', compact('user'));
    }


    public function update(Request $request){
        $user = auth()->user();

        $request->validate([
            'name'     => 'required|string|max:100',
            'nik'      => 'required|string|max:50',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|max:255|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name'  => $request->name,
            'nik'   => $request->nik,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $extension = strtolower($file->getClientOriginalExtension());
            $mime = $file->getMimeType();

            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $allowedMimes = ['image/jpeg', 'image/png'];

            if (!in_array($extension, $allowedExtensions) || !in_array($mime, $allowedMimes)) {
                return back()->with('error', 'Hanya file PNG dan JPG yang diizinkan.');
            }

            $imageInfo = @getimagesize($file->getPathname());
            if ($imageInfo === false) {
                return back()->with('error', 'File yang diupload bukan gambar yang valid.');
            }

            $content = file_get_contents($file->getPathname());
            if (preg_match('/<\?php/i', $content)) {
                return back()->with('error', 'File mengandung skrip berbahaya.');
            }

            if ($user->image && file_exists(public_path($user->image))) {
                @unlink(public_path($user->image));
            }

            $newImage = time() . '_' . uniqid() . '.' . $extension;
            $file->move(public_path('uploads/users'), $newImage);
            $data['image'] = 'uploads/users/' . $newImage;
        }

        User::whereId($user->id)->update($data);

        return redirect()->route('profil.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
