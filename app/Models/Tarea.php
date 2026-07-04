<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tarea extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'proyecto_id',
        'nombre',
        'descripcion',
        'fecha_limite',
        'prioridad',
        'completada',
    ];

    protected function casts(): array
    {
        return [
            'fecha_limite' => 'date',
            'completada' => 'boolean',
            'user_id' => 'integer',
            'proyecto_id' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function prioridadLabel(): string
    {
        return match ($this->prioridad) {
            'baja' => 'Baja',
            'media' => 'Media',
            'alta' => 'Alta',
            default => ucfirst($this->prioridad),
        };
    }

    public function prioridadBadgeVariant(): string
    {
        return match ($this->prioridad) {
            'baja' => 'neutral',
            'media' => 'info',
            'alta' => 'danger',
            default => 'neutral',
        };
    }

    public function fechaHumana(): string
    {
        if (!$this->fecha_limite) return 'Sin fecha';
        $fecha = $this->fecha_limite;
        if ($fecha->isToday()) return 'Hoy, ' . $fecha->format('H:i');
        if ($fecha->isTomorrow()) return 'Mañana, ' . $fecha->format('H:i');
        if ($fecha->isYesterday()) return 'Ayer';
        return $fecha->format('d M Y');
    }
}
