<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades';

    protected $fillable = [
        'user_id',
        'action',
        'subject_type',
        'subject_id',
        'subject_label',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'subject_id' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function actionLabel(): string
    {
        return match ($this->action) {
            'create' => 'Creó',
            'update' => 'Actualizó',
            'delete' => 'Eliminó',
            default => ucfirst($this->action),
        };
    }

    public function actionBadgeVariant(): string
    {
        return match ($this->action) {
            'create' => 'success',
            'update' => 'info',
            'delete' => 'danger',
            default => 'neutral',
        };
    }

    public function subjectTypeLabel(): string
    {
        $type = class_basename($this->subject_type);
        return match ($type) {
            'Cliente' => 'cliente',
            'Proyecto' => 'proyecto',
            'Tarea' => 'tarea',
            default => strtolower($type),
        };
    }

    public function fullDescription(): string
    {
        $action = $this->actionLabel();
        $type = $this->subjectTypeLabel();
        return "{$action} {$type} «{$this->subject_label}»";
    }
}
