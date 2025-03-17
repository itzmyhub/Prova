<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\PagamentoController;
use App\Models\Categoria;
use App\Models\Pagamento;

describe(PagamentoController::class, function () {
    test('deve conseguir renderizar a rota inicial', function () {
        $response = $this->get(route('pagamentos.index'));

        $response->assertStatus(200)
            ->assertViewIs('welcome');
    });

    test('deve conseguir criar um pagamento e retornar para a rota inicial', function () {

        $categorias = Categoria::create(['nome' => 'Categoria 1']);

        $this->assertNotNull($categorias->id);

        $novoPagamento = [
            'descricao' => "dragao branco de olhos azuis",
            'valor' => '1000.00',
            'data' => "2000-01-01",
            'categoria_id' => $categorias->id,
            'metodo_pagamento' => 'Pix',
            'pago' => 0,
        ];

        $this->post(route('pagamentos.store'), $novoPagamento)->assertRedirect(route('pagamentos.index'));

        $ultimoPagamento = Pagamento::latest('id')->first();

        expect($ultimoPagamento)
            ->descricao->toBe($novoPagamento['descricao'])
            ->valor->toBe($novoPagamento['valor'])
            ->metodo_pagamento->toBe($novoPagamento['metodo_pagamento']);
    });

    test('deve falhar na validação da criação de pagamento', function () {

        $novoPagamento = [
            'descricao' => "dragao branco de olhos azuis",
            'valor' => '1000.00',
            'data' => "2000-01-01",
            'categoria_id' => 1, //tenta criar um pagamento com uma categoria inexistente
            'metodo_pagamento' => 'Pix',
            'pago' => 0,
        ];

        $this->post(route('pagamentos.store'), $novoPagamento)->assertRedirect(route('pagamentos.index'));

        $ultimoPagamento = Pagamento::latest('id')->first();

        $this->assertNull($ultimoPagamento);

        expect($ultimoPagamento)
            ->descricao->not->toBe($novoPagamento['descricao'])
            ->valor->not->toBe($novoPagamento['valor'])
            ->metodo_pagamento->not->toBe($novoPagamento['metodo_pagamento']);
    });

    test('deve conseguir atualizar um cadastro de pagamento e então retornar para a rota inicial', function () {
        $primeiraCategoria = Categoria::create(['nome' => 'Categoria 1']);
        $segundaCategoria = Categoria::create(['nome' => 'Categoria 2']);
        $this->assertNotNull($primeiraCategoria->id);
        $this->assertNotNull($segundaCategoria->id);
        $pagamento = [
            'descricao' => "dragao branco de olhos azuis",
            'valor' => '1000.00',
            'data' => "2000-01-01",
            'categoria_id' => $primeiraCategoria->id,
            'metodo_pagamento' => 'Pix',
            'pago' => 0,
        ];

        $pagamento = Pagamento::create($pagamento);

        $request = [
            'metodo_pagamento' => 'Cartão Amazon',
            'categoria_id' => $segundaCategoria->id,
            'pago' => 1
        ];

        $this->put(route('pagamento.update', ['id' => $pagamento['id']]), $request)->assertRedirect(route('pagamentos.index'));

        $pagamentoAtualizado = Pagamento::latest('id')->first();

        expect($pagamentoAtualizado)
            ->metodo_pagamento->toBe($request['metodo_pagamento'])
            ->categoria_id->toBe($request['categoria_id'])
            ->pago->toBe($request['pago']);

    });

    test('deve falhar na validação e não realizar a atualização dos dados', function () {
        $primeiraCategoria = Categoria::create(['nome' => 'Categoria 1']);

        $this->assertNotNull($primeiraCategoria->id);
        $pagamento = [
            'descricao' => "dragao branco de olhos azuis",
            'valor' => '1000.00',
            'data' => "2000-01-01",
            'categoria_id' => $primeiraCategoria->id,
            'metodo_pagamento' => 'Pix',
            'pago' => '0',
        ];

        $pagamento = Pagamento::create($pagamento);

        $request = [
            'metodo_pagamento' => 'Cartão Amazon',
            'categoria_id' => 2, // tenta atualizar com uma categoria inexistente no banco de dados
            'pago' => 1
        ];

        $this->put(route('pagamento.update', ['id' => $pagamento['id']]), $request)->assertRedirect(route('pagamentos.index'));

        $pagamentoAtualizado = Pagamento::latest('id')->first();

        expect($pagamentoAtualizado)
            ->metodo_pagamento->not->toBe($request['metodo_pagamento'])
            ->categoria_id->not->toBe($request['categoria_id'])
            ->pago->not->toBe($request['pago']);
    });

});


