<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProyectoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:255'],
            'cliente_id' => [
                'required', 'integer',
                Rule::exists('clientes', 'id')->where('user_id', auth()->id()),
            ],
            'descripcion' => ['nullable', 'string', 'max:5000'],
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_entrega' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'estado' => ['required', Rule::in(['pendiente', 'en_progreso', 'completado', 'cancelado'])],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título es obligatorio.',
            'titulo.max' => 'El título no puede tener más de :max caracteres.',
            'cliente_id.required' => 'Debes asignar el proyecto a un cliente.',
            'cliente_id.exists' => 'El cliente seleccionado no existe o no te pertenece.',
            'descripcion.max' => 'La descripción no puede tener más de :max caracteres.',
            'fecha_inicio.date' => 'La fecha de inicio no tiene un formato válido.',
            'fecha_entrega.date' => 'La fecha de entrega no tiene un formato válido.',
            'fecha_entrega.after_or_equal' => 'La fecha de entrega debe ser igual o posterior a la fecha de inicio.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',
        ];
    }
}
