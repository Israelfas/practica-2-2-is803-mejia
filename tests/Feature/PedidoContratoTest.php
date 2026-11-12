<?php

namespace Tests\Feature;

use App\Models\ProductoDanado;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PedidoContratoTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $cambios = []): array
    {
        $cliente  = User::factory()->create();
        $producto = ProductoDanado::create([
            'nombre' => 'Licuadora Oster - caja golpeada', 'nivel_danio' => 'leve', 'precio' => 24.50, 'stock' => 5,
        ]);

        return array_merge([
            'cliente_id'        => $cliente->id,
            'producto_id'       => $producto->id,
            'cantidad'          => 2,
            'metodo_pago'       => 'transferencia',
            'tipo_entrega'      => 'domicilio',
            'direccion_entrega' => 'Av. 4 de Noviembre y Calle 115, Manta',
            'observacion'       => null,
        ], $cambios);
    }

    // P1: JSON válido -> 201 y respuesta según el contrato
    public function test_p1_json_valido_devuelve_201(): void
    {
        $this->postJson('/api/v1/pedidos', $this->payload())
            ->assertCreated()
            ->assertJsonStructure(['data' => [
                'pedido_id', 'codigo', 'estado', 'cliente_id',
                'producto' => ['id', 'nombre', 'nivel_danio'],
                'cantidad', 'precio_unitario', 'total', 'moneda', 'metodo_pago',
                'tipo_entrega', 'direccion_entrega', 'observacion', 'fecha_registro',
            ], 'mensaje'])
            ->assertJsonPath('data.total', 49.0)
            ->assertJsonPath('data.estado', 'pendiente');

        $this->assertDatabaseCount('pedidos', 1);
    }

    // P2: falta un campo obligatorio -> 422 con detalle
    public function test_p2_falta_campo_obligatorio_devuelve_422(): void
    {
        $payload = $this->payload();
        unset($payload['producto_id']);

        $this->postJson('/api/v1/pedidos', $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['producto_id']);

        $this->assertDatabaseCount('pedidos', 0);
    }

    // P3: tipo de dato incorrecto -> 422 y no se guarda nada
    public function test_p3_tipo_incorrecto_no_persiste(): void
    {
        $this->postJson('/api/v1/pedidos', $this->payload(['cantidad' => 'dos']))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['cantidad']);

        $this->assertDatabaseCount('pedidos', 0);
    }
}
