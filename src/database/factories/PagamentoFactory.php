<?php

namespace Database\Factories;

use App\Models\Pagamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagamentoFactory extends Factory
{
    protected $model = Pagamento::class;

    public function definition(): array
    {
        return [
            'descricao' => $this->faker->word(),
            'valor' => $this->faker->randomFloat(),
            'data' => $this->faker->date(),
            'categoria_id' => $this->faker->randomDigit(),
            'pago' => $this->faker->boolean(),
            'metodo_pagamento' => $this->faker->word(),
        ];
    }
}
