<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use App\Models\Skema;
use App\Models\Tuk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;


class AsesorController extends Controller
{
    public function index(){
        $asesor = Asesor::all();
        $skema = Skema::all();
        return view('admin/asesor/index', compact('skema','asesor'));
    }


    public function store(Request $request) {
        $request->validate([
            'no_registrasi' => ['required', 'max:19', 'unique:asesor,no_registrasi'],
            'nama' => ['required'],
            'password' => ['required', 'string', 'min:8', 'max:255', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ],[
            'no_registrasi.required' => 'No. Registrasi diperlukan',
            'no_registrasi.max' => 'No. Registrasi maksimal 19 karakter',
            'no_registrasi.unique' => 'No. Registrasi sudah digunakan',
            'nama.required' => 'Namanya Mana?',
            'password.required' => 'Password diperlukan',
            'password.min' => 'Password minimal 4 karakter',
            'image.max' => 'Maksimal ukuran  gambar 1 mb',
        ]);
 
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'asesor',
        ]);
        $user->syncRoles(['asesor']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $safeName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $new_image = time() . '_' . $safeName;
            $image->move('uploads/asesor/', $new_image);
            $asesor_data = Asesor::create([
                'no_registrasi' => $request->no_registrasi,
                'user_id' => $user->id,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'sex' => $request->sex,
                'email' => $request->email,
                'status' => $request->status,
                'skema' => $request->skema,
                'image' => 'uploads/asesor/'.$new_image,
            ]);
        }
        else{
            $asesor_data = Asesor::create( [
                'no_registrasi' => $request->no_registrasi,
                'user_id' => $user->id,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'sex' => $request->sex,
                'email' => $request->email,
                'status' => $request->status,
                'skema' => $request->skema,
            ]);
        }
        return redirect()->route('asesor.index')->with('success','Asesor Berhasil Ditambah');
    }


    public function edit($id) {
        $decryptID = Crypt::decryptString($id);
        $asesor = Asesor::findorfail($decryptID);
        $skema = Skema::all();
        return view('admin/asesor/edit', compact('asesor', 'skema'));
    }


    public function update(Request $request, $id) {
        $request->validate([
            'no_registrasi' => ['required', 'max:19', 'unique:asesor,no_registrasi,'.$id],
            'nama' => ['required'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ],[
            'no_registrasi.required' => 'No. Registrasi diperlukan',
            'no_registrasi.max' => 'No. Registrasi maksimal 19 karakter',
            'no_registrasi.unique' => 'No. Registrasi sudah digunakan',
            'nama.required' => 'Namanya Mana?',
            'image.max' => 'Maksimal ukuran  gambar 1 mb',
        ]);
        $asesor = Asesor::findorfail($id);

        if ($asesor->user_id && $request->filled('password')) {
            $user = User::find($asesor->user_id);
            if ($user) {
                $user->update(['password' => Hash::make($request->password)]);
            }
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $safeName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $new_image = time() . '_' . $safeName;
            $image->move('uploads/asesor/', $new_image);
            $asesor_data = [
                'no_registrasi' => $request->no_registrasi,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'sex' => $request->sex,
                'email' => $request->email,
                'status' => $request->status,
                'skema' => $request->skema,
                'image' => 'uploads/asesor/'.$new_image,
            ];
        }
        else{
            $asesor_data = [
                'no_registrasi' => $request->no_registrasi,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'sex' => $request->sex,
                'email' => $request->email,
                'status' => $request->status,
                'skema' => $request->skema,
            ];
        }
        $asesor->update($asesor_data);

        if ($asesor->user_id) {
            $user = User::find($asesor->user_id);
            if ($user) {
                $user->update([
                    'name' => $request->nama,
                    'email' => $request->email,
                ]);
            }
        }

        return back()->with('success','Data Asesor anda berhasil di Update');
    }


    public function destroy($id){
        $asesor = Asesor::findorfail($id);
        if ($asesor->user_id) {
            $user = User::find($asesor->user_id);
            if ($user) {
                $user->delete();
            }
        }
        $asesor->delete();
        return redirect()->back()->with('success','Asesor Berhasil Dihapus');
    }
}
