<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\PagamentoController;
use App\Models\Categoria;
use App\Models\Pagamento;

describe(PagamentoController::class, function () {
    test('deve conseguir renderizar a rota inicial', function () {
        $response = $this->get(route('pagamentos.index'));

        $response->assertStatus(200)
            ->assertViewIs('meus_pagamentos');
    });

    test('deve conseguir criar um pagamento e retornar para a rota inicial', function () {
        //Arrange
        $categoria = Categoria::factory()->create();
        $pagamento = Pagamento::factory()->naoPago()->make([
            'categoria_id' => $categoria->id,
        ]);

        //Act
        $response = $this->post(route('pagamentos.store'), $pagamento->toArray());

        //Assert
        $response->assertRedirect(route('pagamentos.index'));

        $this->assertDatabaseHas('pagamentos', [
            'descricao' => $pagamento->descricao,
            'valor' => $pagamento->valor,
            'metodo_pagamento' => $pagamento->metodo_pagamento,
            'categoria_id' => $pagamento->categoria_id,
            'pago' => $pagamento->pago,
        ]);

        $this->assertDatabaseCount('pagamentos', 1);
    });

    test('deve falhar na validação da criação de um novo pagamento', function () {
        //Arrange
        $pagamento = Pagamento::factory()->naoPago()->make([
            'categoria_id' => 88 ,
        ]);

        //Act
        $response = $this->post(route('pagamentos.store'), $pagamento->toArray());
        $response->assertRedirect(route('pagamentos.index'));

        //Assert
        $this->assertDatabaseMissing('pagamentos', [
            'descricao' => $pagamento->descricao,
            'valor' => $pagamento->valor,
            'metodo_pagamento' => $pagamento->metodo_pagamento,
            'categoria_id' => $pagamento->categoria_id,
            'pago' => $pagamento->pago,
        ]);

        $this->assertDatabaseCount('pagamentos', 0);
    });

    test('deve conseguir atualizar um cadastro de pagamento e então retornar para a rota inicial', function () {
        //Arrange
        $categorias = Categoria::factory(2)->create();
        $pagamento = Pagamento::factory()->naoPago()->create([
            'categoria_id' => $categorias[0]->id,
        ]);

        $request = [
            'metodo_pagamento' => 'Cartão Amazon',
            'categoria_id' => $categorias[1]->id,
            'pago' => 1
        ];

        //Act
        $response = $this->put(route('pagamento.update', $pagamento), $request);

        //Assert
        $response->assertRedirect(route('pagamentos.index'));

        $this->assertDatabaseHas('pagamentos', [
            'id' => $pagamento->id,
            'descricao' => $pagamento->descricao,
            'valor' => $pagamento->valor,
            'metodo_pagamento' => $request['metodo_pagamento'],
            'categoria_id' => $request['categoria_id'],
            'pago' => $request['pago'],
        ]);

        $this->assertDatabaseCount('pagamentos', 1);
    });

    test('deve falhar na validação e não realizar a atualização dos dados', function () {
        //Arrange
        $categoria = Categoria::factory()->create();
        $pagamento = Pagamento::factory()->naoPago()->create([
            'categoria_id' => $categoria->id,
        ]);

        $request = [
            'metodo_pagamento' => 'cartao nubank',
            'categoria_id' => $categoria->id,
            'pago' => 1
        ];

        //Act
        $response = $this->put(route('pagamento.update', $pagamento), $request);

        //Assert
        $response->assertRedirect(route('pagamentos.index'));
        $this->assertDatabaseMissing('pagamentos', [
            'id' => $pagamento->id,
            'descricao' => $pagamento->descricao,
            'valor' => $pagamento->valor,
            'metodo_pagamento' => $request['metodo_pagamento'],
            'categoria_id' => $request['categoria_id'],
            'pago' => $request['pago'],
        ]);

        $this->assertDatabaseCount('pagamentos', 1);
    });
});


