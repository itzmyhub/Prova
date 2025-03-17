<?php

namespace App\Http\Controllers;

use App\Http\Requests\PagamentoCreationRequest;
use App\Models\Categoria;
use App\Models\Pagamento;
use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    public function index()
    {
        $pagamentos = Pagamento::with('categoria')->get();
        $categorias = Categoria::all();
        return view('welcome', compact('pagamentos', 'categorias'));
    }

    public function store(PagamentoCreationRequest $request)
    {
        $validated = $request->validated();

        Pagamento::create($validated);

        return redirect('/')->with('success', 'Pagamento criado com sucesso!');

    }

    public function update(Request $request, $id)
    {
        $pagamento = Pagamento::findOrFail($id);

        $validated = $request->validate([
            'metodo_pagamento' => 'required',
            'categoria_id' => ['required', 'exists:App\Models\Categoria,id'],
        ]);

        if($validated) {
            $pagamento->pago = $request->pago ?? 0;
            $pagamento->metodo_pagamento = $request->metodo_pagamento;
            $pagamento->categoria_id = $request->categoria_id;
            $pagamento->save();
        }

        return redirect()->back()->with('success', 'Pagamento atualizado com sucesso!');
    }
}
