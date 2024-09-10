<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventUserRequest extends FormRequest
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
            'event_id' => 'required|uuid|exists:events,id',
            'user_id' => 'required|uuid|exists:users,id',
        ];
    }

    /**
     * Custom error messages (optional).
     *
     * @return array
     */
    public function messages()
    {
        return [
            'event_id.required' => 'O ID do evento é obrigatório.',
            'event_id.uuid' => 'O ID do evento deve ser um UUID válido.',
            'event_id.exists' => 'O evento especificado não foi encontrado.',
            'user_id.required' => 'O ID do usuário é obrigatório.',
            'user_id.uuid' => 'O ID do usuário deve ser um UUID válido.',
            'user_id.exists' => 'O usuário especificado não foi encontrado.',
        ];
    }
}
