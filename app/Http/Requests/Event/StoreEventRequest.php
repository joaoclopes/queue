<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'slots_available' => 'required|integer|min:0',
            'slots' => 'required|integer|min:1',
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
            'name.required' => 'O nome do evento é obrigatório.',
            'slots_available.required' => 'O número de vagas disponíveis é obrigatório.',
            'slots_available.integer' => 'As vagas disponíveis devem ser um número inteiro.',
            'slots_available.min' => 'O número de vagas disponíveis não pode ser negativo.',
            'slots.required' => 'O número total de vagas é obrigatório.',
            'slots.integer' => 'O número total de vagas deve ser um número inteiro.',
            'slots.min' => 'O número total de vagas deve ser no mínimo 1.',
        ];
    }
}
