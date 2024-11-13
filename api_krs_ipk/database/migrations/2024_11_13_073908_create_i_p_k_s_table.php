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
        Schema::create('tb_ipk', function (Blueprint $table) {
            $table->increments('id_ipk');
            $table->string('nim');
            $table->integer('semester');
            $table->year('tahun');
            $table->float('ips');
            $table->float('ipk');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('nim')->references('nim')->on('tb_mhs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_ipk');
    }
};
