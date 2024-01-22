<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeNotificationRequest extends FormRequest
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
            'scheduled_at' => ['required', 'present', 'date', 'after_or_equal:now'],
        ];
    }

    public function messages(): array
    {
        return [
            'scheduled_at.present' => 'Data deve ser informada',
            'scheduled_at.required' => 'Data é obrigatório',
            'scheduled_at.after_or_equal' => 'A data deve ser igual ou maior que hoje'
        ];
    }
}
