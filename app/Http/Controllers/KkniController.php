<?php

namespace App\Http\Controllers;

use App\Models\Kkni;
use Illuminate\Http\Request;

class KkniController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required',
            'image' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048']
        ]);
        $kkni_data = [
            'file' =>$request->file,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $safeName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $new_image = time() . '_' . $safeName;
            $image->move('uploads/kkni/', $new_image);
            $kkni_data['image'] = 'uploads/kkni/'.$new_image;
        }

        Kkni::create($kkni_data);
        return back()->with('success','File anda berhasil di Upload');
    }


    public function destroy($id)
    {
        $file = Kkni::findorfail($id);
        $file->delete();
        return back()->with('success', 'File Berhasil dihapus');
    }


    public function kkni_detail($id)
    {
        $file = Kkni::findorfail($id);
        return view('admin/file/show', compact('file'));
    }
}
