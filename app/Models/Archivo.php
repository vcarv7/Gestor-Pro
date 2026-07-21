<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Archivo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'archivos';

    protected $fillable = [
        'proyecto_id',
        'user_id',
        'nombre_original',
        'nombre_storage',
        'mime_type',
        'tamano',
        'descripcion',
    ];

    protected function casts(): array
    {
        return [
            'tamano' => 'integer',
        ];
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTamanoHumanoAttribute(): string
    {
        $bytes = $this->tamano;
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . ' MB';
        }
        if ($bytes >= 1024) {
            return round($bytes / 1024, 1) . ' KB';
        }
        return $bytes . ' B';
    }

    protected static function booted()
    {
        if (! Auth::id()) {
            return;
        }

        $clearCache = fn () => Cache::forget('dashboard_stats_' . Auth::id());

        static::created(fn ($m) => $clearCache());
        static::deleted(fn ($m) => $clearCache());
    }

    public function getIconoAttribute(): string
    {
        $mime = $this->mime_type;

        return match (true) {
            str_starts_with($mime, 'image/') => 'image',
            $mime === 'application/pdf' => 'picture_as_pdf',
            str_contains($mime, 'word') || str_contains($mime, 'document') => 'description',
            str_contains($mime, 'sheet') || str_contains($mime, 'excel') => 'table_chart',
            str_contains($mime, 'zip') || str_contains($mime, 'rar') || str_contains($mime, 'compressed') => 'folder_zip',
            str_starts_with($mime, 'text/') => 'article',
            default => 'insert_drive_file',
        };
    }
}
