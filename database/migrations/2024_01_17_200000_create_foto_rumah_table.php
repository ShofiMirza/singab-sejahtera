<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('foto_rumah', function (Blueprint $table) {
            $table->id();
            $table->string('keluarga_id', 20);
            $table->string('foto_depan', 200)->nullable();
            $table->string('foto_samping', 200)->nullable();
            $table->string('foto_dalam', 200)->nullable();
            $table->timestamps();

            $table->foreign('keluarga_id')
                  ->references('id')
                  ->on('keluarga')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('foto_rumah');
    }
}; 