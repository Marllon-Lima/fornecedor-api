<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FornecedorController;

Route::apiResource('fornecedores', FornecedorController::class);
Route::get('busca-cnpj/{cnpj}', [FornecedorController::class, 'buscaCnpj']);