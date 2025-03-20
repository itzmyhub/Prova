<?php

use App\Http\Controllers\PagamentoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;

Route::post('/pagamento', [PagamentoController::class, 'store'])->name('pagamento.store');;
Route::get('/', [PagamentoController::class, 'index'])->name('pagamentos.index');
Route::put('/pagamento/{pagamento}', [PagamentoController::class, 'update'])->name('pagamento.update');
Route::delete('/pagamento/{pagamento}', [PagamentoController::class, 'destroy'])->name('pagamento.destroy');

Route::post('/categoria', [CategoriaController::class, 'store'])->name('categoria.store');
Route::get('/categorias/criar', [CategoriaController::class, 'show'])->name('categoria.show');

