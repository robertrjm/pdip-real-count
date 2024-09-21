<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelurahansTable extends Migration
{
    public function up()
    {
        Schema::create('kelurahans', function (Blueprint $table) {
            $table->uuid('kelurahan_id')->primary();
            $table->string('nama_kelurahan');
            $table->uuid('kecamatan_id'); // Ensure this matches the UUID type in kecamatans
            $table->timestamps();

            // Define foreign key constrain
        });
    }

    public function down()
    {
        Schema::dropIfExists('kelurahans');
    }
}