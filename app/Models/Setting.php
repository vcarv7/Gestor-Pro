<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    protected $fillable = [
        'user_id',
        'dark_mode',
        'notify_password_change',
        'notify_cliente_delete',
        'notify_proyecto_delete',
        'notify_tarea_bulk_delete',
    ];

    protected function casts(): array
    {
        return [
            'dark_mode' => 'boolean',
            'notify_password_change' => 'boolean',
            'notify_cliente_delete' => 'boolean',
            'notify_proyecto_delete' => 'boolean',
            'notify_tarea_bulk_delete' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
