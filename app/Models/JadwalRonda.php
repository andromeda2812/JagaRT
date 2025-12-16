<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalRonda extends Model
{
    use HasFactory;

    protected $table = 'jadwal_ronda';
    protected $primaryKey = 'jadwal_id';
    public $timestamps = false;

    protected $fillable = [
        'tanggal_ronda',
        'lokasi',
        'keterangan',
        'dibuat_oleh',
        'created_at',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'jadwal_users', 'jadwal_id', 'user_id');
    }

    public function absensi()
    {
        return $this->hasMany(AbsensiRonda::class, 'jadwal_id', 'jadwal_id');
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh', 'user_id');
    }
}