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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');          // Campo para el nombre de la categoría
            $table->text('descripcion')->nullable(); // Campo de descripción, puede ser opcional
            $table->string('estado')->default('activo'); // Campo para el estado (activo/inactivo)
            $table->timestamps();              // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
