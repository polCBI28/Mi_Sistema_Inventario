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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('rol')->default('usuario'); 
            $table->boolean('estado')->default(true);  
            $table->timestamp('ultimo_acceso')->nullable();
            $table->timestamps(); 
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
