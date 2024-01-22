<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadScheduleFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:csv', 'size:1024']
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'O envio do arquivo é obrigatório',
            'file.file' => 'Arquivo não reconhecido',
            'mimes' => 'O arquivo deve ser um CSV',
            'size' => 'O arquivo deve ter o tamanho máximo de 1MB'
        ];
    }
}
