<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    public function index()
    {
        $tutorials = Tutorial::orderBy('urutan')->get();
        return view('admin.tutorial.index', compact('tutorials'));
    }

    public function create()
    {
        return view('admin.tutorial.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'tautan' => 'nullable|url',
            'urutan' => 'nullable|integer',
        ]);

        Tutorial::create($request->all());

        return redirect()->route('tutorial.index')->with('success', 'Prosedur berhasil ditambahkan');
    }

    public function edit(Tutorial $tutorial)
    {
        return view('admin.tutorial.edit', compact('tutorial'));
    }

    public function update(Request $request, Tutorial $tutorial)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'tautan' => 'nullable|url',
            'urutan' => 'nullable|integer',
        ]);

        $tutorial->update($request->all());

        return redirect()->route('tutorial.index')->with('success', 'Prosedur berhasil diperbarui');
    }

    public function destroy(Tutorial $tutorial)
    {
        $tutorial->delete();

        return redirect()->route('tutorial.index')->with('success', 'Prosedur berhasil dihapus');
    }
}
