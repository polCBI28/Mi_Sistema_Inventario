<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias')
                ->onDelete('cascade'); 
            $table->unsignedBigInteger('proveedor_id');
            $table->foreign('proveedor_id')
                ->references('id')
                ->on('proveedores')
                ->onDelete('cascade'); 

            $table->string('nombre'); 
            $table->text('descripcion')->nullable(); 
            $table->string('codigo_barra')->unique(); 
            $table->decimal('precio_venta', 10, 2); 
            $table->decimal('precio_compra', 10, 2); 
            $table->integer('stock'); 
            $table->integer('stock_minimo');
            $table->boolean('estado')->default(true); 
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
