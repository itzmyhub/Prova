<?php

use App\Http\Controllers\PagamentoController;
use Illuminate\Support\Facades\Route;

Route::post('/pagamentos', [PagamentoController::class, 'store'])->name('pagamentos.store');;
Route::get('/', [PagamentoController::class, 'index'])->name('pagamentos.index');
Route::put('/pagamento/{id}', [PagamentoController::class, 'update'])->name('pagamento.update');
