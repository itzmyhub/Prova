<?php

namespace App\Http\Controllers;

use App\Http\Enums\MetodoPagamento;
use App\Http\Requests\PagamentoCreationRequest;
use App\Models\Categoria;
use App\Models\Pagamento;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PagamentoController extends Controller
{
    public function index()
    {
        $pagamentos = Pagamento::with('categoria')->get();
        $categorias = Categoria::all();
        return view('meus_pagamentos', compact('pagamentos', 'categorias'));
    }

    public function store(PagamentoCreationRequest $request)
    {
        Pagamento::create($request->toArray());

        return redirect(route('pagamentos.index'))->with('success', 'Pagamento criado com sucesso!');
    }

    public function update(Request $request, Pagamento $pagamento)
    {
        dump($request->all());

        $request->validate([
            'metodo_pagamento' => [
                'required',
                Rule::enum(MetodoPagamento::class),
            ],
            'categoria_id' => [
                'required',
                Rule::exists('categoria', 'id'),
            ],
        ]);

        $pagamento->update([
            'metodo_pagamento' => $request['metodo_pagamento'],
            'categoria_id' => $request['categoria_id'],
            'pago' => $request['pago'] ?? 0,
        ]);

        return redirect()->back()->with('success', 'Pagamento atualizado com sucesso!');
    }
}
