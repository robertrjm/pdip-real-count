<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpsTable extends Migration
{
    public function up()
    {
        Schema::create('tps', function (Blueprint $table) {
            $table->uuid('tps_id')->primary(); // Primary key sebagai UUID
            $table->uuid('kelurahan_id'); // UUID untuk referensi ke tabel kelurahan
            $table->string('nama_tps'); // Nama TPS
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('tps'); // Menghapus tabel jika migrasi di-rollback
    }
}
