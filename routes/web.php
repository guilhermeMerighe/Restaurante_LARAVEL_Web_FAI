<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ItemPedidoController;

Route::get('/', function () {
    return view('welcome');
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

