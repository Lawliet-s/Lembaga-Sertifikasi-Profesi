<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{

    public function index()
    {
        $note = Note::orderBy('created_at', 'desc')->get();
        return view('admin/note/index', compact('note'));
    }


    public function create()
    {
        return view('admin/note/create');
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'judul' => ['required'],
            'isi' => ['required']
        ]);

        $note = Note::create([
            'judul' => \App\Helpers\HtmlSanitizer::plain($request->judul),
            'isi' => \App\Helpers\HtmlSanitizer::sanitize($request->isi)
        ]);
        return redirect()->route('note.index')->with('success', 'Catatan anda berhasil disimpan');
    }


    public function show($id)
    {
        $note = Note::findorfail($id);        
        return view('admin/note/show', compact('note'));
    }


    public function edit($id)
    {
        $note = Note::findorfail($id);
        return view('admin/note/edit', compact('note'));
    }


    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'judul' => ['required'],
            'isi' => ['required']
        ]);

        $note_data = [
            'judul' => \App\Helpers\HtmlSanitizer::plain($request->judul),
            'isi' => \App\Helpers\HtmlSanitizer::sanitize($request->isi)
        ];
        Note::whereId($id)->update($note_data);
        return back()->with('success', 'Catatan anda berhasil di ubah');
    }


    public function destroy($id)
    {
        $note = Note::findorfail($id);
        $note->delete();
        return back()->with('success', 'Catatan Berhasil Dihapus');
    }
}
