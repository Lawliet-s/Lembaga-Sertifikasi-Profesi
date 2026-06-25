<?php

namespace App\Http\Controllers;

use App\Models\F_profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class F_profilController extends Controller
{
    public function index()
    {
        $profil = F_profil::all();
        return view('admin/f_profil/index', compact('profil'));
    }

    public function create()
    {
        return view('admin/f_profil/create');
    }

    public function store(Request $request)
    {
        $profil_data = [
            'profil' => \App\Helpers\HtmlSanitizer::sanitize($request->profil),
            'isi' => \App\Helpers\HtmlSanitizer::sanitize($request->isi),
            'visi' => \App\Helpers\HtmlSanitizer::sanitize($request->visi),
            'misi' => \App\Helpers\HtmlSanitizer::sanitize($request->misi),
            'motto' => \App\Helpers\HtmlSanitizer::sanitize($request->motto),
        ];

        F_profil::create($profil_data);
        return redirect()->route('f_profil.index')->with('success','Profil LSP berhasil dibuat');
    }

    public function edit($id)
    {
        $decryptID = Crypt::decryptString($id);
        $profil = F_profil::findorfail($decryptID);
        return view('admin/f_profil/edit', compact('profil'));
    }

    public function update(Request $request, $id)
    {
        $profil = F_profil::findorfail($id);
        $profil_data = [
            'profil' => \App\Helpers\HtmlSanitizer::sanitize($request->profil),
            'visi' => \App\Helpers\HtmlSanitizer::sanitize($request->visi),
            'isi' => \App\Helpers\HtmlSanitizer::sanitize($request->isi),
            'misi' => \App\Helpers\HtmlSanitizer::sanitize($request->misi),
            'motto' => \App\Helpers\HtmlSanitizer::sanitize($request->motto),
        ];

        $profil->update($profil_data);
        return redirect()->route('f_profil.index')->with('success','Data Profil Web berhasil di Update');
    }
}
