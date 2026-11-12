<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Contrato de SOLICITUD: POST /api/v1/pedidos
 * Valida el JSON recibido antes de que llegue al controlador.
 */
class StorePedidoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente_id'        => ['required', 'integer', 'exists:users,id'],
            'producto_id'       => ['required', 'integer', 'exists:productos_danados,id'],
            'cantidad'          => ['required', 'integer', 'min:1', 'max:10'],
            'metodo_pago'       => ['required', 'string', Rule::in(['efectivo', 'transferencia', 'tarjeta'])],
            'tipo_entrega'      => ['required', 'string', Rule::in(['retiro_agencia', 'domicilio'])],
            'direccion_entrega' => ['nullable', 'string', 'max:255', 'required_if:tipo_entrega,domicilio'],
            'observacion'       => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'required'                      => 'El campo :attribute es obligatorio.',
            'integer'                       => 'El campo :attribute debe ser un número entero.',
            'string'                        => 'El campo :attribute debe ser texto.',
            'exists'                        => 'El :attribute indicado no existe.',
            'in'                            => 'El valor de :attribute no es válido.',
            'cantidad.min'                  => 'La cantidad mínima es 1.',
            'cantidad.max'                  => 'La cantidad máxima por pedido es 10.',
            'direccion_entrega.required_if' => 'La dirección es obligatoria cuando la entrega es a domicilio.',
        ];
    }
}
