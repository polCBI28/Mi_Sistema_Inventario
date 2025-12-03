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
        Schema::create('detalle_compras', function (Blueprint $table) {
            $table->id();

            // Claves foráneas
            $table->unsignedBigInteger('compra_id');
            $table->unsignedBigInteger('producto_id');

            // Datos del detalle
            $table->decimal('precio_unitario', 10, 2);
            $table->integer('cantidad');
            $table->decimal('subtotal', 10, 2);

            $table->timestamps();

            // Relaciones
            $table->foreign('compra_id')
                  ->references('id')->on('compras')
                  ->onDelete('cascade');

            $table->foreign('producto_id')
                  ->references('id')->on('productos')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_compras');
    }
};
