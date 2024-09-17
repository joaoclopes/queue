<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class CheckEventStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_id' => 'required|string|max:255|exists:events,id',
        ];
    }

    /**
     * Custom error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'event_id.required' => 'O campo event_id é obrigatório.',
            'event_id.string' => 'O campo event_id deve ser uma string.',
            'event_id.max' => 'O campo event_id não pode ter mais de 255 caracteres.',
            'event_id.exists' => 'O event_id fornecido não existe no sistema.',
        ];
    }
}
