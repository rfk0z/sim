<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_nidn';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_nidn',
        'id_user',
        'nama',
        'jabatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'nidn', 'id_nidn');
    }
}
