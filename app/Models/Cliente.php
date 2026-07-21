<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nombre',
        'email',
        'telefono',
        'empresa',
        'notas',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class);
    }

    public function getActividadLabel(): string
    {
        return $this->nombre ?? "Cliente #{$this->id}";
    }

    protected static function booted()
    {
        // No loguear si no hay user autenticado (ej: seeders en tinker)
        if (! Auth::id()) {
            return;
        }

        $log = function ($model, $action) {
            Actividad::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'subject_type' => get_class($model),
                'subject_id' => $model->id,
                'subject_label' => $model->getActividadLabel(),
                'description' => null,
            ]);
        };

        $clearCache = fn () => Cache::forget('dashboard_stats_' . Auth::id());

        static::created(function ($m) use ($log, $clearCache) { $log($m, 'create'); $clearCache(); });
        static::updated(function ($m) use ($log, $clearCache) { $log($m, 'update'); $clearCache(); });
        static::deleted(function ($m) use ($log, $clearCache) { $log($m, 'delete'); $clearCache(); });
    }
}
