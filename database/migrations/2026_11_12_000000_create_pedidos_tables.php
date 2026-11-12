<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos_danados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('nivel_danio'); // leve | moderado | severo
            $table->decimal('precio', 10, 2);
            $table->unsignedInteger('stock');
            $table->timestamps();
        });

        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('users');
            $table->foreignId('producto_id')->constrained('productos_danados');
            $table->unsignedInteger('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('metodo_pago');
            $table->string('tipo_entrega');
            $table->string('direccion_entrega')->nullable();
            $table->string('observacion', 500)->nullable();
            $table->string('estado')->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
        Schema::dropIfExists('productos_danados');
    }
};
