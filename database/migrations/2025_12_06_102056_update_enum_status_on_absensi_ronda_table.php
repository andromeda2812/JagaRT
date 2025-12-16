<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE absensi_ronda MODIFY status ENUM('belum', 'hadir', 'izin', 'alpa') DEFAULT 'belum'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE absensi_ronda MODIFY status ENUM('hadir', 'izin', 'alpa') DEFAULT 'hadir'");
    }
};