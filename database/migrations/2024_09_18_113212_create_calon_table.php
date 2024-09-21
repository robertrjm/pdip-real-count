<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalonTable extends Migration
{
    public function up()
    {
        Schema::create('calon', function (Blueprint $table) {
            $table->uuid('calon_id')->primary();
            $table->string('nama');
            $table->string('no_urut')->nullable();
            $table->string('partai')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('calon');
    }
}
