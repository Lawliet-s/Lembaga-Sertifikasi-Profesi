<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Filelain;
use App\Models\Kkni;
use App\Models\Skema;
use App\Models\Skkni;
use Illuminate\Http\Request;

class FileController extends Controller
{

    public function index()
    {
        $file = File::all();
        $filelain = Filelain::all();
        $skkni = Skkni::all();
        $kkni = Kkni::all();
        $skema = Skema::all();
        return view('admin/file/index', compact('file', 'filelain', 'skkni', 'skema', 'kkni'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'file' => 'required',
            'image' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048']
        ]);
        $file_data = [
            'file' =>$request->file,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $safeName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $new_image = time() . '_' . $safeName;
            $image->move('uploads/file/', $new_image);
            $file_data['image'] = 'uploads/file/'.$new_image;
        }

        File::create($file_data);
        return back()->with('success','File anda berhasil di Upload');
    }


    public function show($id)
    {
        $file = File::findorfail($id);
        return view('admin/file/show', compact('file'));
    }


    public function destroy($id)
    {
        $file = File::findorfail($id);
        $file->delete();
        return back()->with('success', 'File Berhasil dihapus');
    }
}
