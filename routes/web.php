<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClienteController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::get('/clientes/{id}', [ClienteController::class, 'detalhes'])->name('clientes.detalhes');
