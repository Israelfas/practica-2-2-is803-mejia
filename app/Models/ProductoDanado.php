<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoDanado extends Model
{
    protected $table = 'productos_danados';

    protected $fillable = ['nombre', 'nivel_danio', 'precio', 'stock'];

    protected $casts = [
        'precio' => 'float',
        'stock'  => 'integer',
    ];
}
