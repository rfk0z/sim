<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;
    protected $table = 'dokumen';

    protected $primaryKey = 'id_dokumen';

    protected $fillable = [
        'id_bimbingan',
        'nama_file',
        'file_path',
        'uploaded_at',
    ];
    public $timestamps = false;

    public function bimbingan()
    {
        return $this->belongsTo(Bimbingan::class, 'id_bimbingan', 'id_bimbingan');
    }
}
