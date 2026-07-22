<?php

namespace App\Http\Controllers;

use App\Helpers\MapsHelper;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function index()
    {
        $setting = SiteSetting::first(); // Asumsi hanya satu record
        return view('admin.site_setting.index', compact('setting'));
    }

    public function create()
    {
        return view('admin.site_setting.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'kepala_lsp_name' => 'nullable|string|max:255',
            'foto_signature' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'maps_embed', 'address', 'phone', 'instagram', 'facebook', 'twitter', 'email', 'primary_color', 'secondary_color', 'kepala_lsp_name']);
        $data['footer_text'] = \App\Helpers\HtmlSanitizer::sanitize($request->footer_text ?? '');
        foreach (['title', 'address', 'phone', 'instagram', 'facebook', 'twitter', 'email', 'kepala_lsp_name'] as $field) {
            if (isset($data[$field])) {
                $data[$field] = \App\Helpers\HtmlSanitizer::plain($data[$field]);
            }
        }
        $data['maps_embed'] = MapsHelper::convertToEmbed($data['maps_embed'] ?? '');

        if ($request->hasFile('foto_signature')) {
            $file = $request->file('foto_signature');
            $fileName = time() . '_foto_signature.' . $file->getClientOriginalExtension();
            $file->move('uploads/site_settings/', $fileName);
            $data['foto_signature'] = 'uploads/site_settings/' . $fileName;
        }

        foreach (['logo', 'logo2', 'logo3', 'logo4'] as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $fileName = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/site_settings/', $fileName);
                $data[$field] = 'uploads/site_settings/' . $fileName;
            }
        }

        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            $faviconName = time() . '_favicon.' . $favicon->getClientOriginalExtension();
            $favicon->move('uploads/site_settings/', $faviconName);
            $data['favicon'] = 'uploads/site_settings/' . $faviconName;
        }

        if ($request->hasFile('header_image')) {
            $headerImage = $request->file('header_image');
            $headerImageName = time() . '_header.' . $headerImage->getClientOriginalExtension();
            $headerImage->move('uploads/site_settings/', $headerImageName);
            $data['header_image'] = 'uploads/site_settings/' . $headerImageName;
        }

        if ($request->hasFile('background_image')) {
            $bgImage = $request->file('background_image');
            $bgImageName = time() . '_background.' . $bgImage->getClientOriginalExtension();
            $bgImage->move('uploads/site_settings/', $bgImageName);
            $data['background_image'] = 'uploads/site_settings/' . $bgImageName;
        }

        if ($request->hasFile('about_image')) {
            $aboutImage = $request->file('about_image');
            $aboutImageName = time() . '_about.' . $aboutImage->getClientOriginalExtension();
            $aboutImage->move('uploads/site_settings/', $aboutImageName);
            $data['about_image'] = 'uploads/site_settings/' . $aboutImageName;
        }

        SiteSetting::create($data);

        return redirect()->route('site_setting.index')->with('success', 'Pengaturan situs berhasil dibuat');
    }

    public function edit($id)
    {
        $decryptID = Crypt::decryptString($id);
        $setting = SiteSetting::findorfail($decryptID);
        return view('admin.site_setting.edit', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $setting = SiteSetting::findorfail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'kepala_lsp_name' => 'nullable|string|max:255',
            'foto_signature' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'maps_embed', 'address', 'phone', 'instagram', 'facebook', 'twitter', 'email', 'primary_color', 'secondary_color', 'kepala_lsp_name']);
        $data['footer_text'] = \App\Helpers\HtmlSanitizer::sanitize($request->footer_text ?? '');
        foreach (['title', 'address', 'phone', 'instagram', 'facebook', 'twitter', 'email', 'kepala_lsp_name'] as $field) {
            if (isset($data[$field])) {
                $data[$field] = \App\Helpers\HtmlSanitizer::plain($data[$field]);
            }
        }
        $data['maps_embed'] = MapsHelper::convertToEmbed($data['maps_embed'] ?? '');

        if ($request->hasFile('foto_signature')) {
            if ($setting->foto_signature && Storage::disk('public')->exists($setting->foto_signature)) {
                Storage::disk('public')->delete($setting->foto_signature);
            }
            $file = $request->file('foto_signature');
            $fileName = time() . '_foto_signature.' . $file->getClientOriginalExtension();
            $file->move('uploads/site_settings/', $fileName);
            $data['foto_signature'] = 'uploads/site_settings/' . $fileName;
        } elseif ($request->input('clear_foto_signature')) {
            if ($setting->foto_signature && Storage::disk('public')->exists($setting->foto_signature)) {
                Storage::disk('public')->delete($setting->foto_signature);
            }
            $data['foto_signature'] = null;
        }
        
        foreach (['logo', 'logo2', 'logo3', 'logo4'] as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $fileName = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/site_settings/', $fileName);
                $data[$field] = 'uploads/site_settings/' . $fileName;
            }
        }

        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            $faviconName = time() . '_favicon.' . $favicon->getClientOriginalExtension();
            $favicon->move('uploads/site_settings/', $faviconName);
            $data['favicon'] = 'uploads/site_settings/' . $faviconName;
        }

        if ($request->hasFile('header_image')) {
            $headerImage = $request->file('header_image');
            $headerImageName = time() . '_header.' . $headerImage->getClientOriginalExtension();
            $headerImage->move('uploads/site_settings/', $headerImageName);
            $data['header_image'] = 'uploads/site_settings/' . $headerImageName;
        }

        if ($request->hasFile('background_image')) {
            $bgImage = $request->file('background_image');
            $bgImageName = time() . '_background.' . $bgImage->getClientOriginalExtension();
            $bgImage->move('uploads/site_settings/', $bgImageName);
            $data['background_image'] = 'uploads/site_settings/' . $bgImageName;
        }

        if ($request->hasFile('about_image')) {
            $aboutImage = $request->file('about_image');
            $aboutImageName = time() . '_about.' . $aboutImage->getClientOriginalExtension();
            $aboutImage->move('uploads/site_settings/', $aboutImageName);
            $data['about_image'] = 'uploads/site_settings/' . $aboutImageName;
        }

        $setting->update($data);

        return redirect()->route('site_setting.index')->with('success', 'Pengaturan situs berhasil diupdate');
    }
}
