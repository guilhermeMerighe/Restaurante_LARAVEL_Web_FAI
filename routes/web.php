<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClienteController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::get('/clientes/novo', [ClienteController::class, 'create'])->name('clientes.create');
Route::get('/clientes/{id}', [ClienteController::class, 'detalhes'])->name('clientes.detalhes');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
