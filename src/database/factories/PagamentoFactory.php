<?php

namespace Database\Factories;

use App\Http\Enums\MetodoPagamento;
use App\Models\Pagamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagamentoFactory extends Factory
{
    protected $model = Pagamento::class;

    public function definition(): array
    {
        return [
            'descricao' => $this->faker->sentence(),
            'valor' => $this->faker->randomFloat(2, 10.00, 1000.00),
            'data' => $this->faker->date(),
            'categoria_id' => $this->faker->randomDigit(),
            'metodo_pagamento' => MetodoPagamento::cases()[0]->value, //pix
        ];
    }

    public function naoPago(): static
    {
        return $this->state(fn (array $attributes) => [
            'pago' => 0,
        ]);
    }
}
