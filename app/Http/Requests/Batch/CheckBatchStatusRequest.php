<?php

namespace App\Http\Requests\Batch;

use Illuminate\Foundation\Http\FormRequest;

class CheckBatchStatusRequest extends FormRequest
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
            'batch_id' => 'required|string|max:255|exists:batchs,id',
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
            'batch_id.required' => 'O campo batch_id é obrigatório.',
            'batch_id.string' => 'O campo batch_id deve ser uma string.',
            'batch_id.max' => 'O campo batch_id não pode ter mais de 255 caracteres.',
            'batch_id.exists' => 'O batch_id fornecido não existe no sistema.',
        ];
    }
}
