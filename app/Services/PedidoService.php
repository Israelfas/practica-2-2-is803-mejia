<?php

namespace App\Services;

use App\DTOs\CrearPedidoDTO;
use App\Models\Pedido;
use App\Models\ProductoDanado;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class PedidoService
{
    public function registrar(CrearPedidoDTO $dto): Pedido
    {
        return DB::transaction(function () use ($dto) {
            $producto = ProductoDanado::lockForUpdate()->findOrFail($dto->productoId);

            if ($producto->stock < $dto->cantidad) {
                throw new ConflictHttpException('Stock insuficiente para el producto solicitado.');
            }

            $pedido = Pedido::create([
                'cliente_id'        => $dto->clienteId,
                'producto_id'       => $producto->id,
                'cantidad'          => $dto->cantidad,
                'precio_unitario'   => $producto->precio,
                'total'             => round($producto->precio * $dto->cantidad, 2),
                'metodo_pago'       => $dto->metodoPago,
                'tipo_entrega'      => $dto->tipoEntrega,
                'direccion_entrega' => $dto->direccionEntrega,
                'observacion'       => $dto->observacion,
                'estado'            => 'pendiente',
            ]);

            $producto->decrement('stock', $dto->cantidad);

            return $pedido->load('producto');
        });
    }
}
