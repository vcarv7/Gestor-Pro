<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'notify_password_change' => ['boolean'],
            'notify_cliente_delete' => ['boolean'],
            'notify_proyecto_delete' => ['boolean'],
            'notify_tarea_bulk_delete' => ['boolean'],
        ];
    }
}
