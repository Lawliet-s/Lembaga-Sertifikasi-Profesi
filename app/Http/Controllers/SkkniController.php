<?php

namespace App\Http\Controllers;

use App\Models\Skkni;
use Illuminate\Http\Request;

class SkkniController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required'],
            'skema_id' => ['required'],
            'image' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048']
        ],[
            'file.required' => 'Nama File Perlu diisi',
            'image.required' => 'Gambarnya Mana?',
            'image.max' => 'Batas Ukuran Gambar 5 mb',
        ]);
        $skkni_data = [
            'file' =>$request->file,
            'skema_id' =>$request->skema_id,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $safeName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $new_image = time() . '_' . $safeName;
            $image->move('uploads/skkni/', $new_image);
            $skkni_data['image'] = 'uploads/skkni/'.$new_image;
        }

        Skkni::create($skkni_data);
        return back()->with('success','File anda berhasil di Upload');
    }


    public function destroy($id)
    {
        $file = Skkni::findorfail($id);
        $file->delete();
        return back()->with('success', 'File Berhasil dihapus');
    }


    public function skkni_detail($id)
    {
        $file = Skkni::findorfail($id);
        return view('admin/file/show', compact('file'));
    }
}
