<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArchivoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'archivo' => [
                'required',
                'file',
                'max:10240',
                'mimes:pdf,png,jpg,jpeg,gif,webp,doc,docx,xls,xlsx,zip,rar,txt,csv',
            ],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'archivo.required' => 'Debes seleccionar un archivo.',
            'archivo.file' => 'El archivo no es válido.',
            'archivo.max' => 'El archivo no puede superar los 10 MB.',
            'archivo.mimes' => 'Tipo de archivo no permitido. Usa PDF, imágenes, documentos Office, ZIP o TXT.',
            'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',
        ];
    }
}
