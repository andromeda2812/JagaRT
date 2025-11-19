<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('statistik_siskamling', function (Blueprint $table) {
            $table->id('statistik_id');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->integer('total_ronda')->default(0);
            $table->integer('total_laporan')->default(0);
            $table->integer('total_hadir')->default(0);
            $table->integer('total_tidak_hadir')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistik_siskamling');
    }
};
