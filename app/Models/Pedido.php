<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pedido extends Model
{
    protected $table = 'pedidos';

    protected $fillable = [
        'cliente_id', 'producto_id', 'cantidad', 'precio_unitario', 'total',
        'metodo_pago', 'tipo_entrega', 'direccion_entrega', 'observacion', 'estado',
    ];

    protected $casts = [
        'cantidad'        => 'integer',
        'precio_unitario' => 'float',
        'total'           => 'float',
    ];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(ProductoDanado::class, 'producto_id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }
}
