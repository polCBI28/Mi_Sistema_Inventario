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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            // Clave foránea: Categoría
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias')
                ->onDelete('cascade'); // Si se borra la categoría, ¡adiós productos! 🗑️

            // Clave foránea: Proveedor
            $table->unsignedBigInteger('proveedor_id');
            $table->foreign('proveedor_id')
                ->references('id')
                ->on('proveedores')
                ->onDelete('cascade'); // Igual con proveedores 🏭

            $table->string('nombre'); // Nombre del producto 📱
            $table->text('descripcion')->nullable(); // Descripción (opcional) ✍️
            $table->string('codigo_barra')->unique(); // Código único 📊
            $table->decimal('precio_venta', 10, 2); // Ej: 999.99 💰
            $table->decimal('precio_compra', 10, 2); // 💸
            $table->integer('stock'); // Cantidad disponible 📦
            $table->integer('stock_minimo'); // Alerta si baja de esto ⚠️
            $table->boolean('estado')->default(true); // Activo/Inactivo ✅
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
