<?php

namespace App\Http\Controllers;

use App\Models\Filelain;
use Illuminate\Http\Request;

class FilelainController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required',
            'image' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048']
        ]);
        $filelain_data = [
            'file' =>$request->file,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $safeName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $new_image = time() . '_' . $safeName;
            $image->move('uploads/file/', $new_image);
            $filelain_data['image'] = 'uploads/file/'.$new_image;
        }

        Filelain::create($filelain_data);
        return back()->with('success','File anda berhasil di Upload');
    }


    public function destroy($id)
    {
        $file = Filelain::findorfail($id);
        $file->delete();
        return back()->with('success', 'File Berhasil dihapus');
    }


    public function filelain_detail($id)
    {
        $file = Filelain::findorfail($id);
        return view('admin/file/show', compact('file'));
    }
}
