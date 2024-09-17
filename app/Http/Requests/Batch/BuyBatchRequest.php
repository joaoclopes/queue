<?php

namespace App\Http\Requests\Batch;

use Illuminate\Foundation\Http\FormRequest;

class BuyBatchRequest extends FormRequest
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
            'batch_id' => 'required|uuid|exists:batchs,id',
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
            'batch_id.required' => 'O ID do lote é obrigatório.',
            'batch_id.uuid' => 'O ID do lote deve ser um UUID válido.',
            'batch_id.exists' => 'O lote especificado não foi encontrado.',
            'user_id.required' => 'O ID do usuário é obrigatório.',
            'user_id.uuid' => 'O ID do usuário deve ser um UUID válido.',
            'user_id.exists' => 'O usuário especificado não foi encontrado.',
        ];
    }
}
