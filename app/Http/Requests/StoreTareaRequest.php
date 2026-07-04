<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTareaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $proyectoId = $this->route('proyecto');

        return [
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:5000'],
            'fecha_limite' => ['nullable', 'date'],
            'prioridad' => ['required', Rule::in(['baja', 'media', 'alta'])],
            'proyecto_id' => [
                'required', 'integer',
                Rule::exists('proyectos', 'id')->where('user_id', auth()->id()),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la tarea es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de :max caracteres.',
            'descripcion.max' => 'La descripción no puede tener más de :max caracteres.',
            'fecha_limite.date' => 'La fecha límite no tiene un formato válido.',
            'prioridad.required' => 'La prioridad es obligatoria.',
            'prioridad.in' => 'La prioridad seleccionada no es válida.',
            'proyecto_id.required' => 'El proyecto es obligatorio.',
            'proyecto_id.exists' => 'El proyecto seleccionado no existe o no te pertenece.',
        ];
    }
}
