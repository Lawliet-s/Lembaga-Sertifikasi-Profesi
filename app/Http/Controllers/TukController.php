<?php

namespace App\Http\Controllers;

use App\Models\Tuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class TukController extends Controller
{

    public function index() {
        $tuk = Tuk::all();
        return view('admin/tuk/index', compact('tuk'));
    }


    public function show($id) {
        $decryptID = Crypt::decryptString($id);
        $tuk = Tuk::findorfail($decryptID);
        return view('admin/tuk/show', compact('tuk'));
    }


    public function store(Request $request){
        $request->validate([
            'tuk' => ['required'],
            'kode' => ['required'],
            'alamat' => ['required'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $safeName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $new_image = time() . '_' . $safeName;
            $image->move('uploads/tuk/', $new_image);
            $tuk = Tuk::create([
            'tuk' => $request->tuk,
            'kode' => $request->kode,
            'pengelola' => $request->pengelola,
            'alamat' => $request->alamat,
            'jenis_tuk' => $request->jenis_tuk,
            'image' => 'uploads/tuk/'.$new_image,
        ]);
        }
        else{
           $tuk = Tuk::create([
            'tuk' => $request->tuk,
            'kode' => $request->kode,
            'pengelola' => $request->pengelola,
            'alamat' => $request->alamat,
            'jenis_tuk' => $request->jenis_tuk,
        ]);
        }
        return redirect()->route('tuk.index')->with('success', 'TUK Berhasil Ditambahkan');
    }


    public function update(Request $request, $id)
    {
        $tuk = Tuk::findorfail($id);
        $request->validate([
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $safeName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $new_image = time() . '_' . $safeName;
            $image->move('uploads/tuk/', $new_image);
            $tuk_data = [
                'tuk' => $request->tuk,
                'kode' => $request->kode,
                'pengelola' => $request->pengelola,
                'alamat' => $request->alamat,
                'jenis_tuk' => $request->jenis_tuk,
                'image' => 'uploads/tuk/'.$new_image,
            ];
        }
        else{
            $tuk_data = [
                'tuk' => $request->tuk,
                'kode' => $request->kode,
                'pengelola' => $request->pengelola,
                'alamat' => $request->alamat,
                'jenis_tuk' => $request->jenis_tuk,
            ];
        }
        $tuk->update($tuk_data);
        return redirect()->back()->with('success','Data TUK Web anda berhasil di Update');
    }


    public function destroy($id)
    {
        $tuk = Tuk::findorfail($id);
        $tuk->delete();
        return redirect()->back()->with('success','TUK Berhasil Dihapus');
    }
}
