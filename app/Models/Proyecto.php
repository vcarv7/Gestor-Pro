<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyecto extends Model
{
    use HasFactory;

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

    public function tareasPendientes(): HasMany
    {
        return $this->hasMany(Tarea::class)->where('completada', false);
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
}
