<?php

namespace App\Http\Controllers;

use App\Models\Galeri_foto;
use App\Models\Group_galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class GaleriController extends Controller
{

    public function index()
    {
        $galeri = Group_galeri::orderBy('created_at','desc')->get();
        return view('admin/galeri/list_galeri', compact('galeri'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'galeri' => ['required'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048']
        ],[
            'galeri.required' => 'Masukan Judul Album',
            'image.max' => 'Ukuran gambar maksimal 10 mb',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $safeName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $new_image = time() . '_' . $safeName;
            $image->move('uploads/group-galeri/', $new_image);
            $galeri = Group_galeri::create([
                'galeri' => $request->galeri,
                'image' => 'uploads/group-galeri/' . $new_image,
            ]);
        } else {
            $galeri = Group_galeri::create([
                'galeri' => $request->galeri,
            ]);
        }
        // $image->move('uploads/berita/', $new_image);
        return back()->with('success', 'Galeri Berhasil dibuat');
    }


    public function show($id)
    {
        $decryptID = Crypt::decryptString($id);
        $galeri = Group_galeri::findorfail($decryptID);
        return view('admin/galeri/show', compact('galeri'));
    }


    public function edit($id)
    {
        $galeri = Group_galeri::findorfail($id);
        return view('admin/galeri/edit', compact('galeri'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'galeri' => ['required'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048']
        ],[
            'galeri.required' => 'Masukan Judul Album',
            'image.max' => 'Ukuran gambar maksimal 10 mb',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $safeName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $new_image = time() . '_' . $safeName;
            $image->move('uploads/group-galeri/', $new_image);
            $galeri_data = [
                'galeri' => $request->galeri,
                'image' => 'uploads/group-galeri/' . $new_image,
            ];
        } else {
            $galeri_data = [
                'galeri' => $request->galeri,
            ];
        }
        Group_galeri::whereId($id)->update($galeri_data);
        return back()->with('success', 'Galeri Berhasil diubah');
    }


    public function destroy($id)
    {
        $galeri = Group_galeri::findorfail($id);
        $galeri->delete();
        return back()->with('success', 'Galeri Berhasil dihapus');
    }


    public function destroy3($id)
    {
        $foto = Galeri_foto::findorfail($id);
        $foto->delete();
        return back()->with('success', 'Galeri Berhasil dihapus');
    }


    public function foto_store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'array'],
            'image.*' => ['file', 'mimes:jpg,jpeg,png,pdf,webp', 'max:10240']
        ]);
        if ($request->hasFile('image')) {
            $images = $request->file('image');
            $successCount = 0;
            $errors = [];
            foreach ($images as $key => $image) {
                try {
                    $safeName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
                    $new_image = time() . '_' . $safeName;
                    $image->move('uploads/galeri/', $new_image);
                    Galeri_foto::create([
                        'group_galeri_id' => $request->group_galeri_id,
                        'image' => 'uploads/galeri/' . $new_image,
                    ]);
                    $successCount++;
                } catch (\Exception $e) {
                    $errors[] = "Gambar #" . ($key + 1) . " gagal diupload: " . $e->getMessage();
                }
            }
            if ($errors) {
                return back()->with('success', "{$successCount} gambar berhasil diupload. " . implode(', ', $errors));
            }
            return back()->with('success', "{$successCount} gambar berhasil diupload");
        }
        return back()->with('error', 'Tidak ada gambar yang dipilih');
    }
}
