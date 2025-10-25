<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ItemPedidoController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\PratoController;

Route::get('/', function () {
    return view('index');
});



Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::get('/clientes/novo', [ClienteController::class, 'create'])->name('clientes.create');
Route::get('/clientes/{id}', [ClienteController::class, 'detalhes'])->name('clientes.detalhes');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');




Route::get('/pedidos', [PedidoController::class, 'index']);
Route::post('/pedidos/criar', [PedidoController::class, 'criar']);
Route::post('/pedidos/finalizar/{cod_pedido}', [PedidoController::class, 'finalizar']);

Route::get('/pedidos/{cod_pedido}/itens', [ItemPedidoController::class, 'listar']);
Route::post('/pedidos/{cod_pedido}/itens/adicionar', [ItemPedidoController::class, 'adicionar']);
Route::post('/pedidos/{cod_pedido}/itens/{cod_prato}/atualizar', [ItemPedidoController::class, 'atualizar']);
Route::post('/pedidos/{cod_pedido}/itens/{cod_prato}/excluir', [ItemPedidoController::class, 'excluir']);

Route::get('/ingredientes', [IngredienteController::class, 'index'])->name('ingredientes.index');
Route::get('/ingredientes/novo', [IngredienteController::class, 'create'])->name('ingredientes.create');
Route::post('/ingredientes', [IngredienteController::class, 'store'])->name('ingredientes.store');
Route::post('/ingredientes/{cod_ingrediente}/adicionar', [IngredienteController::class, 'adicionarEstoque'])->name('ingredientes.adicionar');
Route::post('/ingredientes/{cod_ingrediente}/excluir', [IngredienteController::class, 'destroy'])->name('ingredientes.destroy');

Route::get('/pratos', [PratoController::class, 'index']);
Route::get('/pratos/novo', [PratoController::class, 'create']);
Route::post('/pratos', [PratoController::class, 'store']);
Route::get('/pratos/editar/{id}', [PratoController::class, 'edit']);
Route::post('/pratos/{id}', [PratoController::class, 'update']);
Route::post('/pratos/deletar/{id}', [PratoController::class, 'destroy']);

