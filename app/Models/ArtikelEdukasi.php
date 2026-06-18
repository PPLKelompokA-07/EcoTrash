<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class ArtikelEdukasi extends Model
{
    use HasFactory;

    protected $table = 'artikel_edukasi';

    protected $fillable = [
        'judul',
        'kategori',
        'gambar_thumbnail',
        'konten_html',
        'penulis_admin_id',
    ];

    /**
     * URL thumbnail kompatibel dengan local & cloud storage.
     * Mendukung path lama (public/edukasi/thumbnail/...) dan path baru (Storage).
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if (!$this->gambar_thumbnail) return null;
        if (str_starts_with($this->gambar_thumbnail, 'http://') || str_starts_with($this->gambar_thumbnail, 'https://')) {
            return $this->gambar_thumbnail;
        }
        if (str_starts_with($this->gambar_thumbnail, 'db/')) {
            return url('images/' . $this->gambar_thumbnail);
        }
        // Jika path lama (dimulai dengan 'edukasi/thumbnail'), gunakan asset()
        if (str_starts_with($this->gambar_thumbnail, 'edukasi/thumbnail/')) {
            return asset($this->gambar_thumbnail);
        }
        // Path baru dari Storage disk
        return Storage::disk(config('filesystems.default') === 'local' ? 'public' : config('filesystems.default'))->url($this->gambar_thumbnail);
    }

    public function penulisAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penulis_admin_id');
    }

    public function bookmarkUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmark_artikel', 'artikel_id', 'warga_id')
                    ->withPivot('created_at');
    }
}
