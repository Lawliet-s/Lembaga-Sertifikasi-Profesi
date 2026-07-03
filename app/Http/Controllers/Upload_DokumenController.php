<?php

namespace App\Http\Controllers;

use App\Models\Upload_file;
use Illuminate\Http\Request;

class Upload_DokumenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kode' => ['required', 'unique:upload_files,kode'],
            'kode_dokumen' => ['required', 'unique:upload_files,kode_dokumen'],
            'name' =>['required', 'array'],
            'name.*' => ['required', 'string', 'max:255'],
            'data_register_id' => ['nullable', 'array'],
            'status' => ['nullable', 'array'],
            'status.*' => ['nullable', 'string', 'max:500'],
            'y' => ['nullable', 'array'],
            'n' => ['nullable', 'array'],
            'z' => ['nullable', 'array'],
        ],[
            'kode.unique' => 'Data sudah diambil',
        ]);
        foreach($request->name as $item => $value) {
                    Upload_file::create([
                        'name' => strip_tags($request->name[$item]),
                        'data_register_id' => $request->data_register_id[$item] ?? null,
                        'user_id' => auth()->id(),
                        'status' => strip_tags($request->status[$item] ?? ''),
                        'kode' => $request->kode[$item] ?? '',
                        'y' => $request->y[$item] ?? '',
                        'n' => $request->n[$item] ?? '',
                        'z' => $request->z[$item] ?? '',
                        'kode_dokumen' => $request->kode_dokumen[$item] ?? '',
                    ]);
                }
        return back()->with('success', 'Formulir APL-01 Berhasil Diambil');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => ['required', 'file', 'mimes:png,pdf,jpg,jpeg', 'max:2000'],
            'status' => ['nullable', 'string', 'max:500'],
            'koreksi' => ['nullable', 'string', 'max:2000'],
        ]);
        $data = [
            'status' => strip_tags($request->status),
            'koreksi' => strip_tags($request->koreksi),
            'y' => strip_tags($request->y),
            'n' => strip_tags($request->n),
            'z' => strip_tags($request->z),
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $safeName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $new_image = time() . '_' . $safeName;
            $image->move('uploads/uploads_file_register/', $new_image);
            $data['image'] = 'uploads/uploads_file_register/' . $new_image;
        }

    Upload_file::where('id', $id)->where('user_id', auth()->id())->update($data);
    return back()->with('success', 'Dokumen Berhasil Diupload');
    }

}
