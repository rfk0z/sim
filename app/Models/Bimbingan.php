<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    // Cast tanggal to date
    protected $casts = [
        'tanggal' => 'date',
    ];

    // Enable timestamps (created_at and updated_at)
    public $timestamps = false;

    /**
     * Relationship to Mahasiswa
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'id_nim');
    }

    /**
     * Relationship to Dosen
     */
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'id_nidn');
    }

    /**
     * Relationship to Dokumen
     */
    public function dokumen(): HasMany
    {
        return $this->hasMany(Dokumen::class, 'id_bimbingan', 'id_bimbingan');
    }

    /**
     * Relationship to KomentarBimbingan
     */
    public function komentar(): HasMany
    {
        return $this->hasMany(KomentarBimbingan::class, 'id_bimbingan', 'id_bimbingan')
            ->orderBy('waktu_kirim', 'desc');
    }

    /**
     * Scope for bimbingan yang valid
     */
    public function scopeValid($query)
    {
        return $query->where('status_validasi', 'Valid');
    }

    /**
     * Scope for bimbingan yang pending
     */
    public function scopePending($query)
    {
        return $query->where('status_validasi', 'Pending');
    }

    /**
     * Scope for bimbingan yang invalid
     */
    public function scopeInvalid($query)
    {
        return $query->where('status_validasi', 'Invalid');
    }
}
