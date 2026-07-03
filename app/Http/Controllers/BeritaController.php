<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class BeritaController extends Controller
{

    public function index()
    {
        $berita = Berita::orderBy('created_at','desc')->get();
        return view('admin/berita/index', compact('berita'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => ['required'],
            'excerpt' => ['required'],
            'body' => ['required'],
            'status' => ['required'],
            'image' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048']
        ],[
            'title.required' => 'Masukan Judul Berita',
            'excerpt.required' => 'Masukan excerpt Berita',
            'body.required' => 'Masukan Isi Konten Berita',
            'status.required' => 'Pilih Status Postingan Berita',
            'image.required' => 'Masukan Gambar Berita',
            'image.max' => 'Ukuran gambar maksimal 1 mb',
        ]);
        $berita_data = [
            'title' => \App\Helpers\HtmlSanitizer::plain($request->title),
            'excerpt' => \App\Helpers\HtmlSanitizer::plain($request->excerpt),
            'body' => \App\Helpers\HtmlSanitizer::sanitize($request->body),
            'status' => \App\Helpers\HtmlSanitizer::plain($request->status),
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $safeName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $new_image = time() . '_' . $safeName;
            $image->move('uploads/berita/', $new_image);
            $berita_data['image'] = 'uploads/berita/' . $new_image;
        }

        Berita::create($berita_data);
        return back()->with('success', 'Artikel Berita Anda  berhasil di Posting');
    }


    public function show($id)
    {
        $decryptID = Crypt::decryptString($id);
        $berita = Berita::findorfail($decryptID);
        return view('admin/berita/show', compact('berita'));
    }


    public function edit($id)
    {
        $decryptID = Crypt::decryptString($id);
        $berita = Berita::findorfail($decryptID);
        return view('admin/berita/edit', compact('berita'));
    }


    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'title' => ['required'],
            'excerpt' => ['required'],
            'body' => ['required'],
            'status' => ['required'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ],[
            'title.required' => 'Masukan Judul Berita',
            'excerpt.required' => 'Masukan excerpt Berita',
            'body.required' => 'Masukan Isi Konten Berita',
            'status.required' => 'Pilih Status Postingan Berita',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $safeName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $new_image = time() . '_' . $safeName;
            $image->move('uploads/berita/', $new_image);
            $berita_data = [
                'title' => \App\Helpers\HtmlSanitizer::plain($request->title),
                'excerpt' => \App\Helpers\HtmlSanitizer::plain($request->excerpt),
                'body' => \App\Helpers\HtmlSanitizer::sanitize($request->body),
                'status' => \App\Helpers\HtmlSanitizer::plain($request->status),
                'image' => 'uploads/berita/' . $new_image,
            ];
        } else {
            $berita_data = [
                'title' => \App\Helpers\HtmlSanitizer::plain($request->title),
                'excerpt' => \App\Helpers\HtmlSanitizer::plain($request->excerpt),
                'body' => \App\Helpers\HtmlSanitizer::sanitize($request->body),
                'status' => \App\Helpers\HtmlSanitizer::plain($request->status),
            ];
        }

        Berita::whereId($id)->update($berita_data);
        return back()->with('success', 'Artikel Berita Anda  berhasil di Update');
    }


    public function destroy($id)
    {
        $berita = Berita::findorfail($id);
        $berita->delete();
        return back()->with('success', 'Artikel Berita Anda  berhasil di Hapus');
    }
}
