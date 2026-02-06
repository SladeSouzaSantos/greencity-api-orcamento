<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\OrcamentoController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/gerar-orcamento', [OrcamentoController::class, 'store']);
