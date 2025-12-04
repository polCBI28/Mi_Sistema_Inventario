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
            $table->string('tipo_movimiento', 20);
            $table->unsignedBigInteger('producto_id');
            $table->integer('stock_anterior');
            $table->integer('cantidad');
            $table->string('motivo')
            ->nullable();
            $table->unsignedBigInteger('usuario_id')
            ->nullable();
            $table->integer('stock_actual');
            $table->unsignedBigInteger('referencia_id')
            ->nullable();
            $table->string('referencia_tabla')
            ->nullable();
            $table->timestamp('fecha_movimiento')
            ->useCurrent();
            $table->foreign('producto_id')->references('id')
            ->on('productos')
            ->onDelete('cascade');
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
