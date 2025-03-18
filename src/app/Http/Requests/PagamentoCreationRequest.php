<?php

namespace App\Http\Requests;

use App\Http\Enums\MetodoPagamento;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PagamentoCreationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'descricao' => ['required', 'string'],
            'valor' => ['required', 'numeric', 'min:1'],
            'data' => ['required', 'date'],
            'categoria_id' => [
                'required',
                'exists:categoria,id',
            ],
            'metodo_pagamento' => [
                'required',
                Rule::enum(MetodoPagamento::class),
            ],
            'pago' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'descricao.required' => 'A descrição é obrigatória.',
            'valor.required' => 'O valor é obrigatório.',
            'data.required' => 'A data é obrigatória.',
            'categoria_id.required' => 'A categoria é obrigatória.',
            'metodo_pagamento.required' => 'O método de pagamento é obrigatório.',
            'pago.required' => 'O status é obrigatorio.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
