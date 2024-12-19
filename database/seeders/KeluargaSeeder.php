<?php

namespace Database\Seeders;

use App\Models\Keluarga;
use App\Models\FotoRumah;
use App\Models\DetailBantuan;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class KeluargaSeeder extends Seeder
{
    public function run()
    {
        // 1. Keluarga yang belum dibantu
        $keluarga1 = Keluarga::create([
            'id' => 'KLG-001',
            'nama_kk' => 'Ahmad Santoso',
            'alamat' => 'Depan Musholla Al-Khoir',
            'rt' => '001',
            'rw' => '007',
            'latitude' => -6.654685,
            'longitude' => 110.690318,
            'kategori' => 'Sangat Miskin',
            'status_bantuan' => 'Belum Dibantu'
        ]);

        FotoRumah::create([
            'keluarga_id' => $keluarga1->id,
            'foto_depan' => 'foto-rumah/default-depan.jpg',
            'foto_samping' => 'foto-rumah/default-samping.jpg',
            'foto_dalam' => 'foto-rumah/default-dalam.jpg'
        ]);

        // 2. Keluarga yang sedang dibantu
        $keluarga2 = Keluarga::create([
            'id' => 'KLG-002',
            'nama_kk' => 'Budi Setiawan',
            'alamat' => 'Depan Indomaret',
            'rt' => '002',
            'rw' => '007',
            'latitude' => -6.655685,
            'longitude' => 110.691318,
            'kategori' => 'Miskin',
            'status_bantuan' => 'Sedang Diproses'
        ]);

        FotoRumah::create([
            'keluarga_id' => $keluarga2->id,
            'foto_depan' => 'foto-rumah/default-depan.jpg',
            'foto_samping' => 'foto-rumah/default-samping.jpg',
            'foto_dalam' => 'foto-rumah/default-dalam.jpg'
        ]);

        DetailBantuan::create([
            'keluarga_id' => $keluarga2->id,
            'tanggal_mulai' => Carbon::now()->subDays(15),
            'tanggal_selesai' => null,
            'catatan' => 'Pembangunan dalam proses, sudah mencapai 50%'
        ]);

        // 3. Keluarga yang sudah dibantu
        $keluarga3 = Keluarga::create([
            'id' => 'KLG-003',
            'nama_kk' => 'Candra Wijaya',
            'alamat' => 'Rumah Warna Hijau Setelah Perempatan Pertama',
            'rt' => '003',
            'rw' => '007',
            'latitude' => -6.656685,
            'longitude' => 110.692318,
            'kategori' => 'Rentan Miskin',
            'status_bantuan' => 'Sudah Dibantu'
        ]);

        FotoRumah::create([
            'keluarga_id' => $keluarga3->id,
            'foto_depan' => 'foto-rumah/default-depan.jpg',
            'foto_samping' => 'foto-rumah/default-samping.jpg',
            'foto_dalam' => 'foto-rumah/default-dalam.jpg'
        ]);

        DetailBantuan::create([
            'keluarga_id' => $keluarga3->id,
            'tanggal_mulai' => Carbon::now()->subMonths(2),
            'tanggal_selesai' => Carbon::now()->subMonths(1),
            'catatan' => 'Pembangunan selesai, rumah sudah layak huni'
        ]);
    }
} 