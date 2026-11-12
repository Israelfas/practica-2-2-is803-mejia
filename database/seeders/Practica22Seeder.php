<?php

namespace Database\Seeders;

use App\Models\ProductoDanado;
use App\Models\User;
use Illuminate\Database\Seeder;

// Datos ficticios para las pruebas de la práctica.
class Practica22Seeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'cliente.demo@example.com'],
            ['name' => 'Cliente Demo', 'password' => bcrypt('demo12345')],
        );

        ProductoDanado::insert([
            ['nombre' => 'Licuadora Oster - caja golpeada', 'nivel_danio' => 'leve',     'precio' => 24.50, 'stock' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Audífonos Bluetooth - empaque roto', 'nivel_danio' => 'leve',  'precio' => 12.00, 'stock' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Monitor 24" - marco rayado',     'nivel_danio' => 'moderado', 'precio' => 79.99, 'stock' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
