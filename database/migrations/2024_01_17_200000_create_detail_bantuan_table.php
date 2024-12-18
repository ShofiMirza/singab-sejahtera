<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_bantuan', function (Blueprint $table) {
            $table->id();
            $table->string('keluarga_id', 20);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('keluarga_id')
                  ->references('id')
                  ->on('keluarga')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_bantuan');
    }
}; 