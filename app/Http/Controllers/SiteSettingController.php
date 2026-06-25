<?php

namespace App\Http\Controllers;

use App\Helpers\MapsHelper;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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
        $data = $request->only(['title', 'maps_embed', 'address', 'phone', 'instagram', 'facebook', 'twitter', 'email', 'primary_color', 'secondary_color']);
        $data['footer_text'] = \App\Helpers\HtmlSanitizer::sanitize($request->footer_text ?? '');
        foreach (['title', 'address', 'phone', 'instagram', 'facebook', 'twitter', 'email'] as $field) {
            if (isset($data[$field])) {
                $data[$field] = \App\Helpers\HtmlSanitizer::plain($data[$field]);
            }
        }
        $data['maps_embed'] = MapsHelper::convertToEmbed($data['maps_embed'] ?? '');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_logo.' . $logo->getClientOriginalExtension();
            $logo->move('uploads/site_settings/', $logoName);
            $data['logo'] = 'uploads/site_settings/' . $logoName;
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

        $data = $request->only(['title', 'maps_embed', 'address', 'phone', 'instagram', 'facebook', 'twitter', 'email', 'primary_color', 'secondary_color']);
        $data['footer_text'] = \App\Helpers\HtmlSanitizer::sanitize($request->footer_text ?? '');
        foreach (['title', 'address', 'phone', 'instagram', 'facebook', 'twitter', 'email'] as $field) {
            if (isset($data[$field])) {
                $data[$field] = \App\Helpers\HtmlSanitizer::plain($data[$field]);
            }
        }
        $data['maps_embed'] = MapsHelper::convertToEmbed($data['maps_embed'] ?? '');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_logo.' . $logo->getClientOriginalExtension();
            $logo->move('uploads/site_settings/', $logoName);
            $data['logo'] = 'uploads/site_settings/' . $logoName;
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

        $setting->update($data);

        return redirect()->route('site_setting.index')->with('success', 'Pengaturan situs berhasil diupdate');
    }
}
