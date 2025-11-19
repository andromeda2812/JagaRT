<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiRonda extends Model
{
    use HasFactory;

    protected $table = 'absensi_ronda';
    protected $primaryKey = 'absensi_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'jadwal_id',
        'waktu_absen',
        'bukti_foto',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalRonda::class, 'jadwal_id', 'jadwal_id');
    }
}