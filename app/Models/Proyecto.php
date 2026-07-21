<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Proyecto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'cliente_id',
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_entrega',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_entrega' => 'date',
            'user_id' => 'integer',
            'cliente_id' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class);
    }

    public function archivos(): HasMany
    {
        return $this->hasMany(Archivo::class);
    }

    public function tareasPendientes(): HasMany
    {
        return $this->hasMany(Tarea::class)->where('completada', false);
    }

    public function getActividadLabel(): string
    {
        return $this->titulo ?? "Proyecto #{$this->id}";
    }

    public function estadoLabel(): string
    {
        return match ($this->estado) {
            'pendiente' => 'Pendiente',
            'en_progreso' => 'En Progreso',
            'completado' => 'Completado',
            'cancelado' => 'Cancelado',
            default => ucfirst($this->estado),
        };
    }

    public function estadoBadgeVariant(): string
    {
        return match ($this->estado) {
            'pendiente' => 'neutral',
            'en_progreso' => 'info',
            'completado' => 'success',
            'cancelado' => 'danger',
            default => 'neutral',
        };
    }

    protected static function booted()
    {
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
