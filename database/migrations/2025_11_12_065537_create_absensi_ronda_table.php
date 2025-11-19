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
        Schema::create('absensi_ronda', function (Blueprint $table) {
            $table->id('absensi_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('jadwal_id');
            $table->dateTime('waktu_absen')->nullable();
            $table->string('bukti_foto', 255)->nullable();
            $table->enum('status', ['hadir', 'izin', 'alpa'])->default('hadir');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('jadwal_id')->references('jadwal_id')->on('jadwal_ronda')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensi_ronda');
    }
};
