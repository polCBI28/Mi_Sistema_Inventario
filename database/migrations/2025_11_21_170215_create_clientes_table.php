<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();

            $table->string('tipo_documento', 20);
            $table->string('numero_documento', 20)->unique();
            $table->string('nombres', 120);
            $table->string('apellidos', 120);
            $table->string('email', 120)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->date('fecha_nacimiento')->nullable();

            $table->boolean('estado')->default(1);

            
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
