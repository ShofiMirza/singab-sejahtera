<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\FotoRumahController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DetailBantuanController;
use Illuminate\Support\Facades\Route;
use App\Models\Keluarga;
use App\Models\DetailBantuan;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $keluarga = Keluarga::all();
        $totalKeluarga = $keluarga->count();
        $belumDibantu = $keluarga->where('status_bantuan', 'Belum Dibantu')->count();
        $sedangDiproses = $keluarga->where('status_bantuan', 'Sedang Diproses')->count();
        $sudahDibantu = $keluarga->where('status_bantuan', 'Sudah Dibantu')->count();

        $recentActivities = DetailBantuan::with('keluarga')
            ->orderBy('tanggal_mulai', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'keluarga',
            'totalKeluarga',
            'belumDibantu',
            'sedangDiproses',
            'sudahDibantu',
            'recentActivities'
        ));
    })->name('dashboard');

    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('keluarga', KeluargaController::class);
        Route::resource('users', UserController::class);
        
        Route::get('/keluarga/{keluarga}/foto-rumah/create', [FotoRumahController::class, 'create'])->name('foto-rumah.create');
        Route::post('/keluarga/{keluarga}/foto-rumah', [FotoRumahController::class, 'store'])->name('foto-rumah.store');
        Route::get('/keluarga/{keluarga}/foto-rumah/edit', [FotoRumahController::class, 'edit'])->name('foto-rumah.edit');
        Route::put('/keluarga/{keluarga}/foto-rumah', [FotoRumahController::class, 'update'])->name('foto-rumah.update');

        Route::get('/keluarga/{keluarga}/bantuan', [DetailBantuanController::class, 'index'])->name('detail-bantuan.index');
        Route::get('/keluarga/{keluarga}/bantuan/create', [DetailBantuanController::class, 'create'])->name('detail-bantuan.create');
        Route::post('/keluarga/{keluarga}/bantuan', [DetailBantuanController::class, 'store'])->name('detail-bantuan.store');
        Route::put('/bantuan/{detailBantuan}/complete', [DetailBantuanController::class, 'complete'])->name('detail-bantuan.complete');
        Route::delete('/bantuan/{detailBantuan}', [DetailBantuanController::class, 'destroy'])->name('detail-bantuan.destroy');
        
        Route::get('/riwayat-pembangunan', [DetailBantuanController::class, 'history'])->name('detail-bantuan.history');
    });
});
