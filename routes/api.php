<?php

use App\Http\Controllers\Api\PedidoController;
use Illuminate\Support\Facades\Route;

// Práctica 2.2 - Marcelo Mejía
Route::prefix('v1')->group(function () {
    Route::post('pedidos', [PedidoController::class, 'store']);
    Route::get('pedidos/{pedido}', [PedidoController::class, 'show']);
});
