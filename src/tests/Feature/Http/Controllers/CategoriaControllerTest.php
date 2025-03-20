<?php

use App\Http\Controllers\CategoriaController;
use App\Models\Categoria;

describe(CategoriaController::class, function () {
    test('deve conseguir renderizar a rota criar categoria', function () {
        //Arrange
        //Act
        $response = $this->get(route('categoria.show'));
        //Assert
        $response->assertStatus(200)
            ->assertViewIs('criar_categoria');
    });

    test('deve conseguir criar uma nova categoria e retornar para a rota criar categoria', function () {
        //Arrange
        $categoria = Categoria::factory()->make();
        //Act
        $response = $this->post(route('categoria.store'), $categoria->toArray());
        //Assert
        $response->assertRedirect(route('categoria.show'));
        $this->assertDatabaseHas('categoria', [
            'nome' => $categoria->nome,
        ]);
        $this->assertDatabaseCount('categoria', 1);

    });
});
