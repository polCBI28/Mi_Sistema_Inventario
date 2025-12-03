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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();

            $table->date('fecha');
            $table->decimal('total', 10, 2);
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('proveedor_id');

            $table->string('tipo_comprobante', 50);
            $table->string('numero_comprobante', 50);

            $table->decimal('igv', 10, 2);
            $table->decimal('subtotal', 10, 2);

            $table->string('estado', 20)->default('ACTIVO');
            $table->text('observaciones')->nullable();

            $table->timestamps();

            // Relaciones (las activaremos más adelante si quieres)
            // $table->foreign('usuario_id')->references('id')->on('users');
            // $table->foreign('proveedor_id')->references('id')->on('proveedores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
