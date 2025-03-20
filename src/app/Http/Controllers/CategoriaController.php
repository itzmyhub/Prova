<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController
{
    public function store(Request $request) {
        $request->validate([
           'nome' => 'required|unique:categoria',
        ]);
        Categoria::create($request->all());
        return redirect()->route('categoria.show')->with('success', 'Categoria cadastrada com sucesso!');
    }

    public function show() {
        $categorias = Categoria::all();
        return view('criar_categoria', ['categorias' => $categorias]);
    }

}
