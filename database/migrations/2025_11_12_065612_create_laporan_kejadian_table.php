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
        Schema::create('laporan_kejadian', function (Blueprint $table) {
            $table->id('laporan_id');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('tanggal_kejadian')->nullable();
            $table->string('lokasi', 100)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('foto_bukti', 255)->nullable();
            $table->enum('status_laporan', ['baru', 'diproses', 'selesai'])->default('baru');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_kejadian');
    }
};
