<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class LaporanSampahLiar extends Model
{
    use HasFactory;

    protected $table = 'laporan_sampah_liar';

    protected $fillable = [
        'warga_id',
        'komplek_id',
        'lat',
        'lng',
        'alamat_lokasi',
        'deskripsi',
        'foto_laporan_warga',
        'status',
        'alasan_penolakan',
        'alasan_ditunda',
        'koin_reward',
        'petugas_id',
        'foto_bukti_selesai_petugas',
    ];

    protected function casts(): array
    {
        return [
            'lat' => 'decimal:7',
            'lng' => 'decimal:7',
            'koin_reward' => 'integer',
        ];
    }

    /**
     * URL foto laporan warga (local & cloud compatible).
     */
    public function getFotoLaporanWargaUrlAttribute(): ?string
    {
        if (!$this->foto_laporan_warga) return null;
        return Storage::disk(config('filesystems.default') === 'local' ? 'public' : config('filesystems.default'))->url($this->foto_laporan_warga);
    }

    /**
     * URL foto bukti selesai petugas (local & cloud compatible).
     */
    public function getFotoBuktiSelesaiPetugasUrlAttribute(): ?string
    {
        if (!$this->foto_bukti_selesai_petugas) return null;
        return Storage::disk(config('filesystems.default') === 'local' ? 'public' : config('filesystems.default'))->url($this->foto_bukti_selesai_petugas);
    }

    public function warga(): BelongsTo
    {
        return $this->belongsTo(User::class, 'warga_id');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function komplek(): BelongsTo
    {
        return $this->belongsTo(Komplek::class);
    }
}
