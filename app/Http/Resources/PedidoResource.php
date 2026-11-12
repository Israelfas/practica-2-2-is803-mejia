<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Contrato de RESPUESTA: serializa el modelo Pedido a JSON.
 * Web (React) y móvil (Flutter) reciben exactamente esta estructura.
 */
class PedidoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'pedido_id'  => $this->id,
            'codigo'     => 'PED-' . str_pad((string) $this->id, 6, '0', STR_PAD_LEFT),
            'estado'     => $this->estado,
            'cliente_id' => $this->cliente_id,
            'producto'   => [
                'id'          => $this->producto->id,
                'nombre'      => $this->producto->nombre,
                'nivel_danio' => $this->producto->nivel_danio,
            ],
            'cantidad'          => $this->cantidad,
            'precio_unitario'   => (float) $this->precio_unitario,
            'total'             => (float) $this->total,
            'moneda'            => 'USD',
            'metodo_pago'       => $this->metodo_pago,
            'tipo_entrega'      => $this->tipo_entrega,
            'direccion_entrega' => $this->direccion_entrega,
            'observacion'       => $this->observacion,
            'fecha_registro'    => $this->created_at->toIso8601String(),
        ];
    }

    /**
     * Conserva el ".0" de los decimales (49.0 y no 49) para que precio_unitario
     * y total viajen siempre como número decimal, como indica el contrato.
     */
    public function jsonOptions(): int
    {
        return JSON_PRESERVE_ZERO_FRACTION;
    }
}
