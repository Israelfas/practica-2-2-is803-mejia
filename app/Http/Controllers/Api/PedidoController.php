<?php

namespace App\Http\Controllers\Api;

use App\DTOs\CrearPedidoDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Resources\PedidoResource;
use App\Models\Pedido;
use App\Services\PedidoService;
use Illuminate\Http\JsonResponse;

class PedidoController extends Controller
{
    public function __construct(private readonly PedidoService $servicio) {}

    // POST /api/v1/pedidos
    public function store(StorePedidoRequest $request): JsonResponse
    {
        // Deserialización: JSON -> array validado -> DTO tipado
        $dto = CrearPedidoDTO::fromArray($request->validated());

        $pedido = $this->servicio->registrar($dto);

        // Serialización: modelo -> PedidoResource -> JSON
        return (new PedidoResource($pedido))
            ->additional(['mensaje' => 'Pedido registrado correctamente'])
            ->response()
            ->setStatusCode(201);
    }

    // GET /api/v1/pedidos/{pedido}
    public function show(Pedido $pedido): PedidoResource
    {
        return new PedidoResource($pedido->load('producto'));
    }
}
