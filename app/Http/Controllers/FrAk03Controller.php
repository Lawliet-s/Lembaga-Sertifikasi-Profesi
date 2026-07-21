<?php

namespace App\Http\Controllers;

use App\Models\Data_register;
use App\Models\FrAk03;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrAk03Controller extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $registrations = Data_register::where('user_id', $userId)
            ->with('frAk03')
            ->get();

        return view('asesi.frak03.index', compact('registrations'));
    }

    public function show($id)
    {
        $registration = Data_register::with('frAk03')
            ->findOrFail($id);

        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        $frAk03 = $registration->frAk03;

        return view('asesi.frak03.show', compact('registration', 'frAk03'));
    }

    public function store(Request $request, $id)
    {
        $registration = Data_register::findOrFail($id);

        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:2000',
            'catatan' => 'nullable|string|max:2000',
            'saran' => 'nullable|string|max:2000',
        ]);

        FrAk03::updateOrCreate(
            ['data_register_id' => $registration->id],
            [
                'user_id' => Auth::id(),
                'rating' => $request->rating,
                'feedback' => $request->feedback,
                'catatan' => $request->catatan,
                'saran' => $request->saran,
            ]
        );

        return redirect()->route('frak03.show', $registration->id)
            ->with('success', 'FR.AK.03 — Umpan Balik dan Catatan Asesmen berhasil disimpan.');
    }
}
