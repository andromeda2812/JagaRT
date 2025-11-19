<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id'; 
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_lengkap',
        'username',
        'password',
        'role',
        'no_hp',
        'email',
        'alamat',
        'status',
        'foto',
    ];

    protected $hidden = ['password', 'remember_token', 'pivot'];

    public function jadwalDibuat() {
    return $this->hasMany(JadwalRonda::class, 'dibuat_oleh');
    }
    public function absensi() {
        return $this->hasMany(AbsensiRonda::class, 'user_id');
    }
    public function laporan() {
        return $this->hasMany(LaporanKejadian::class, 'user_id');
    }
}
