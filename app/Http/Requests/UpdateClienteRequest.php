<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clienteId = $this->route('cliente');

        return [
            'nombre' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('clientes', 'email')->ignore($clienteId),
            ],
            'telefono' => ['nullable', 'string', 'max:50'],
            'empresa' => ['nullable', 'string', 'max:255'],
            'notas' => ['nullable', 'string', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de :max caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe tener un formato válido.',
            'email.unique' => 'Este email ya está registrado para otro cliente.',
            'telefono.max' => 'El teléfono no puede tener más de :max caracteres.',
            'empresa.max' => 'La empresa no puede tener más de :max caracteres.',
            'notas.max' => 'Las notas no pueden tener más de :max caracteres.',
        ];
    }
}
