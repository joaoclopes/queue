<?php

namespace App\Http\Requests\Batch;

use Illuminate\Foundation\Http\FormRequest;

class StoreBatchRequest extends FormRequest
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
            'event_id' => 'required|string|max:255|exists:events,id',
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
            'name.required' => 'O nome do lote é obrigatório.',
            'slots_available.required' => 'O número de vagas disponíveis é obrigatório.',
            'slots_available.integer' => 'As vagas disponíveis devem ser um número inteiro.',
            'slots_available.min' => 'O número de vagas disponíveis não pode ser negativo.',
            'slots.required' => 'O número total de vagas é obrigatório.',
            'slots.integer' => 'O número total de vagas deve ser um número inteiro.',
            'slots.min' => 'O número total de vagas deve ser no mínimo 1.',
            'event_id.required' => 'O campo event_id é obrigatório.',
            'event_id.string' => 'O campo event_id deve ser uma string.',
            'event_id.max' => 'O campo event_id não pode ter mais de 255 caracteres.',
            'event_id.exists' => 'O event_id fornecido não existe no sistema.',
        ];
    }
}
