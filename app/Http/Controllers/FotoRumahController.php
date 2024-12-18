<?php

namespace App\Http\Controllers;

use App\Models\FotoRumah;
use App\Models\Keluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoRumahController extends Controller
{
    public function create(Keluarga $keluarga)
    {
        return view('foto_rumah.create', compact('keluarga'));
    }

    public function store(Request $request, Keluarga $keluarga)
    {
        $validated = $request->validate([
            'foto_depan' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_samping' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_dalam' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $foto_depan = $request->file('foto_depan')->store('foto_rumah', 'public');
        $foto_samping = $request->file('foto_samping')->store('foto_rumah', 'public');
        $foto_dalam = $request->file('foto_dalam')->store('foto_rumah', 'public');

        FotoRumah::create([
            'keluarga_id' => $keluarga->id,
            'foto_depan' => $foto_depan,
            'foto_samping' => $foto_samping,
            'foto_dalam' => $foto_dalam
        ]);

        return redirect()->route('keluarga.index')->with('success', 'Foto rumah berhasil ditambahkan');
    }

    public function edit(Keluarga $keluarga)
    {
        return view('foto_rumah.edit', compact('keluarga'));
    }

    public function update(Request $request, Keluarga $keluarga)
    {
        $validated = $request->validate([
            'foto_depan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_samping' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_dalam' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $foto_rumah = $keluarga->fotoRumah;

        if ($request->hasFile('foto_depan')) {
            Storage::disk('public')->delete($foto_rumah->foto_depan);
            $foto_depan = $request->file('foto_depan')->store('foto_rumah', 'public');
            $foto_rumah->foto_depan = $foto_depan;
        }

        if ($request->hasFile('foto_samping')) {
            Storage::disk('public')->delete($foto_rumah->foto_samping);
            $foto_samping = $request->file('foto_samping')->store('foto_rumah', 'public');
            $foto_rumah->foto_samping = $foto_samping;
        }

        if ($request->hasFile('foto_dalam')) {
            Storage::disk('public')->delete($foto_rumah->foto_dalam);
            $foto_dalam = $request->file('foto_dalam')->store('foto_rumah', 'public');
            $foto_rumah->foto_dalam = $foto_dalam;
        }

        $foto_rumah->save();

        return redirect()->route('keluarga.index')->with('success', 'Foto rumah berhasil diperbarui');
    }
}
