<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\FotoRumah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KeluargaController extends Controller
{
    public function index()
    {
        $keluarga = Keluarga::all();
        return view('keluarga.index', compact('keluarga'));
    }

    public function create()
    {
        return view('keluarga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string|max:20|unique:keluarga,id',
            'nama_kk' => 'required|string|max:100',
            'alamat' => 'required|string|max:200',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'kategori' => 'required|in:Sangat Miskin,Miskin,Rentan Miskin',
            'kondisi_rumah' => 'required|in:Rusak Berat,Sedang,Baik',
            'status_bantuan' => 'required|in:Belum Dibantu,Sedang Diproses,Sudah Dibantu',
            'foto_depan' => 'required|image|max:2048',
            'foto_samping' => 'required|image|max:2048',
            'foto_dalam' => 'required|image|max:2048',
        ]);

        $keluarga = Keluarga::create($validated);

        // Handle foto rumah
        if ($request->hasFile('foto_depan') || $request->hasFile('foto_samping') || $request->hasFile('foto_dalam')) {
            $fotoRumah = new FotoRumah();
            
            if ($request->hasFile('foto_depan')) {
                $fotoRumah->foto_depan = $request->file('foto_depan')->store('foto-rumah', 'public');
            }
            if ($request->hasFile('foto_samping')) {
                $fotoRumah->foto_samping = $request->file('foto_samping')->store('foto-rumah', 'public');
            }
            if ($request->hasFile('foto_dalam')) {
                $fotoRumah->foto_dalam = $request->file('foto_dalam')->store('foto-rumah', 'public');
            }

            $keluarga->fotoRumah()->save($fotoRumah);
        }

        return redirect()->route('keluarga.index')->with('success', 'Data keluarga berhasil ditambahkan');
    }

    public function edit(Keluarga $keluarga)
    {
        return view('keluarga.edit', compact('keluarga'));
    }

    public function update(Request $request, Keluarga $keluarga)
    {
        $validated = $request->validate([
            'nama_kk' => 'required|string|max:100',
            'alamat' => 'required|string|max:200',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'kategori' => 'required|in:Sangat Miskin,Miskin,Rentan Miskin',
            'kondisi_rumah' => 'required|in:Rusak Berat,Sedang,Baik',
            'status_bantuan' => 'required|in:Belum Dibantu,Sedang Diproses,Sudah Dibantu',
            'foto_depan' => 'nullable|image|max:2048',
            'foto_samping' => 'nullable|image|max:2048',
            'foto_dalam' => 'nullable|image|max:2048',
        ]);

        $keluarga->update($validated);

        // Handle foto rumah
        if ($request->hasFile('foto_depan') || $request->hasFile('foto_samping') || $request->hasFile('foto_dalam')) {
            // Get or create foto rumah record
            $fotoRumah = $keluarga->fotoRumah ?? new FotoRumah();
            $fotoRumah->keluarga_id = $keluarga->id;
            
            if ($request->hasFile('foto_depan')) {
                // Delete old photo if exists
                if ($fotoRumah->foto_depan) {
                    Storage::disk('public')->delete($fotoRumah->foto_depan);
                }
                $fotoRumah->foto_depan = $request->file('foto_depan')->store('foto-rumah', 'public');
            }
            
            if ($request->hasFile('foto_samping')) {
                // Delete old photo if exists
                if ($fotoRumah->foto_samping) {
                    Storage::disk('public')->delete($fotoRumah->foto_samping);
                }
                $fotoRumah->foto_samping = $request->file('foto_samping')->store('foto-rumah', 'public');
            }
            
            if ($request->hasFile('foto_dalam')) {
                // Delete old photo if exists
                if ($fotoRumah->foto_dalam) {
                    Storage::disk('public')->delete($fotoRumah->foto_dalam);
                }
                $fotoRumah->foto_dalam = $request->file('foto_dalam')->store('foto-rumah', 'public');
            }

            $fotoRumah->save();
        }

        return redirect()->route('keluarga.index')->with('success', 'Data keluarga berhasil diperbarui');
    }

    public function destroy(Keluarga $keluarga)
    {
        $keluarga->delete();
        return redirect()->route('keluarga.index')->with('success', 'Data keluarga berhasil dihapus');
    }
} 