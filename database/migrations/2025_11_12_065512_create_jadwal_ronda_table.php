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
        Schema::create('jadwal_ronda', function (Blueprint $table) {
            $table->id('jadwal_id');
            $table->date('tanggal_ronda');
            $table->string('lokasi', 100);
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('dibuat_oleh'); // FK ke users
            $table->timestamps();

            $table->foreign('dibuat_oleh')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal_ronda');
    }
};
