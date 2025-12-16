<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwal_users', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('jadwal_id');
            $table->unsignedBigInteger('user_id');

            // foreign keys
            $table->foreign('jadwal_id')
                  ->references('jadwal_id')->on('jadwal_ronda')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('user_id')->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_users');
    }
};