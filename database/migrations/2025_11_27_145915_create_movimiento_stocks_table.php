<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimientos_stock', function (Blueprint $table) {
            $table->id();

            // Producto
            $table->unsignedBigInteger('producto_id');

            // Tipo: entrada / salida
            $table->string('tipo_movimiento', 20);

            // Cantidades
            $table->integer('cantidad');
            $table->integer('stock_anterior');
            $table->integer('stock_actual');

            // Motivo
            $table->string('motivo')->nullable();

            // Usuario (nullable)
            $table->unsignedBigInteger('usuario_id')->nullable();

            // Polimórfico
            $table->unsignedBigInteger('referencia_id')->nullable();
            $table->string('referencia_tabla')->nullable();

            // Fecha
            $table->timestamp('fecha_movimiento')->useCurrent();

            // FK
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            // ESTA ES LA CORRECCIÓN
            $table->foreign('usuario_id')
                ->references('id')->on('users')
                ->onDelete('set null');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_stock');
    }
};
