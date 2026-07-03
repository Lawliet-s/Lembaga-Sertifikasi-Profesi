<?php

namespace App\Http\Controllers;

use App\Models\Strorg;
use Illuminate\Http\Request;

class StrorgController extends Controller
{

    public function index()
    {
        $strorg = Strorg::all();
        return view('admin/strorg/index', compact('strorg'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ],[
            'image.required' => 'Gambarnya mana?',
            'image.max' => 'Gambarnya Kegedean?',
        ]);
        $strorg_data = [
            'keterangan' =>$request->keterangan,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $safeName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $new_image = time() . '_' . $safeName;
            $image->move('uploads/strorg/', $new_image);
            $strorg_data['image'] = 'uploads/strorg/'.$new_image;
        }

        Strorg::create($strorg_data);
        return redirect()->route('strorg.index')->with('success','Gambar anda berhasil di Posting');
    }


    public function update(Request $request, $id)
    {
        $strorg = Strorg::findorfail($id);
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            ],[
                'image.required' => 'Gambarnya mana?',
                'image.max' => 'Gambarnya Kegedean.., ukuran gambar maksimal 1 mb',
            ]);
            $image = $request->file('image');
            $safeName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $new_image = time() . '_' . $safeName;
            $image->move('uploads/strorg/', $new_image);
            $strorg_data = [
                'keterangan' =>$request->keterangan,
                'image' => 'uploads/strorg/'.$new_image,
            ];
        }
        else{
            $strorg_data = [
                'keterangan' =>$request->keterangan,
            ];
        }
        Strorg::whereId($id)->update($strorg_data);
        return redirect()->route('strorg.index')->with('success','Gambar Struktur Organisasi berhasil di Update');
    }
}
