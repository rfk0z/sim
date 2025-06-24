<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;
    protected $table = 'bimbingan';

    protected $primaryKey = 'id_bimbingan';

    protected $fillable = [
        'nim',
        'nidn',
        'tanggal',
        'topik',
        'catatan',
        'status_validasi',
        'dokumen_url',
    ];
    public $timestamps = false;

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'id_nim');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'id_nidn');
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'id_bimbingan', 'id_bimbingan');
    }
}
