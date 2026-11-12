<?php

namespace App\DTOs;

/**
 * DTO de entrada: representa el JSON ya deserializado y validado,
 * con tipos nativos de PHP. El servicio no conoce el Request HTTP.
 */
final readonly class CrearPedidoDTO
{
    public function __construct(
        public int $clienteId,
        public int $productoId,
        public int $cantidad,
        public string $metodoPago,
        public string $tipoEntrega,
        public ?string $direccionEntrega,
        public ?string $observacion,
    ) {}

    /** @param array<string, mixed> $datos Datos devueltos por $request->validated() */
    public static function fromArray(array $datos): self
    {
        return new self(
            clienteId: (int) $datos['cliente_id'],
            productoId: (int) $datos['producto_id'],
            cantidad: (int) $datos['cantidad'],
            metodoPago: $datos['metodo_pago'],
            tipoEntrega: $datos['tipo_entrega'],
            direccionEntrega: $datos['direccion_entrega'] ?? null,
            observacion: $datos['observacion'] ?? null,
        );
    }
}
