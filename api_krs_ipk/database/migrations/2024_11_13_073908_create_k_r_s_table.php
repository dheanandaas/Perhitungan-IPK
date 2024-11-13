<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tb_krs', function (Blueprint $table) {
            $table->increments('id_krs');
            $table->year('tahun');
            $table->integer('semester');
            $table->string('nim');
            $table->unsignedInteger('id_mk');
            $table->string('nilai');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('nim')->references('nim')->on('tb_mhs')->onDelete('cascade');
            $table->foreign('id_mk')->references('id_mk')->on('tb_mk')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_krs');
    }
};