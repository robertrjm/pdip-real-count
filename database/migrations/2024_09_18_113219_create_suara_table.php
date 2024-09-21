<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuaraTable extends Migration
{
    public function up()
    {
        Schema::create('suara', function (Blueprint $table) {
            $table->uuid('suara_id')->primary();
            $table->uuid('kelurahan_id');
            $table->uuid('tps_id');
            $table->uuid('calon_id');
            $table->integer('jumlah_suara');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('suara');
    }
}
