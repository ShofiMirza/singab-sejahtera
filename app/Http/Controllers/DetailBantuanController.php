<?php

namespace App\Http\Controllers;

use App\Models\DetailBantuan;
use App\Models\Keluarga;
use Illuminate\Http\Request;

class DetailBantuanController extends Controller
{
    public function history()
    {
        $detailBantuan = DetailBantuan::with('keluarga')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();
        return view('detail_bantuan.history', compact('detailBantuan'));
    }

    public function index(Keluarga $keluarga)
    {
        return view('detail_bantuan.index', compact('keluarga'));
    }

    public function create(Keluarga $keluarga)
    {
        return view('detail_bantuan.create', compact('keluarga'));
    }

    public function store(Request $request, Keluarga $keluarga)
    {
        $validated = $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'catatan' => 'nullable|string'
        ]);

        $detailBantuan = new DetailBantuan($validated);
        $detailBantuan->keluarga_id = $keluarga->id;
        $detailBantuan->save();

        // Update status bantuan keluarga
        $keluarga->status_bantuan = $request->tanggal_selesai ? 'Sudah Dibantu' : 'Sedang Diproses';
        $keluarga->save();

        return redirect()->route('detail-bantuan.index', $keluarga->id)
            ->with('success', 'Data bantuan berhasil ditambahkan');
    }

    public function complete(Request $request, DetailBantuan $detailBantuan)
    {
        $validated = $request->validate([
            'tanggal_selesai' => 'required|date|after_or_equal:' . $detailBantuan->tanggal_mulai
        ]);

        $detailBantuan->tanggal_selesai = $validated['tanggal_selesai'];
        $detailBantuan->save();

        // Update status bantuan keluarga
        $keluarga = $detailBantuan->keluarga;
        $keluarga->status_bantuan = 'Sudah Dibantu';
        $keluarga->save();

        return redirect()->route('detail-bantuan.index', $keluarga->id)
            ->with('success', 'Bantuan berhasil diselesaikan');
    }

    public function destroy(DetailBantuan $detailBantuan)
    {
        $keluarga = $detailBantuan->keluarga;
        $detailBantuan->delete();

        // Update status bantuan keluarga if no active assistance
        if ($keluarga->detailBantuan()->whereNull('tanggal_selesai')->count() == 0) {
            if ($keluarga->detailBantuan()->whereNotNull('tanggal_selesai')->exists()) {
                $keluarga->status_bantuan = 'Sudah Dibantu';
            } else {
                $keluarga->status_bantuan = 'Belum Dibantu';
            }
            $keluarga->save();
        }

        return redirect()->route('detail-bantuan.index', $keluarga->id)
            ->with('success', 'Data bantuan berhasil dihapus');
    }
}