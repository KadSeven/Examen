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
        Schema::create('detalles_facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factura_id')->constrained();
            $table->foreignId('producto_id')->constrained();
            $table->integer('cantidad'); 
            $table->decimal('subtotal', 10, 2); 
            $table->string('registrado_por'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_facturas');
    }
};
