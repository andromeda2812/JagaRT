<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKejadian extends Model
{
    use HasFactory;

    protected $table = 'laporan_kejadian';
    protected $primaryKey = 'laporan_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'tanggal_kejadian',
        'lokasi',
        'deskripsi',
        'foto_bukti',
        'status_laporan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}