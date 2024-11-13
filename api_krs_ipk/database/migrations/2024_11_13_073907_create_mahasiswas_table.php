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
        Schema::create('tb_mhs', function (Blueprint $table) {
            $table->string('nim')->primary();
            $table->string('nama');
            $table->float('ips')->nullable();
            $table->float('ipk')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_mhs');
    }
};
