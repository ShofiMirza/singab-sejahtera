<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('keluarga', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('nama_kk', 100);
            $table->string('alamat', 200);
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->enum('kategori', ['Sangat Miskin', 'Miskin', 'Rentan Miskin']);
            $table->enum('kondisi_rumah', ['Rusak Berat', 'Sedang', 'Baik']);
            $table->enum('status_bantuan', ['Belum Dibantu', 'Sedang Diproses', 'Sudah Dibantu'])->default('Belum Dibantu');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('keluarga');
    }
}; 