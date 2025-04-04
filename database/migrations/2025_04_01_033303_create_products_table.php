<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $tabla) {
            // Identificador único
            $tabla->id()->comment('ID único del producto');
            
            // Campos básicos
            $tabla->string('nombre', 100)->comment('Nombre del producto');
            $tabla->text('descripcion')->nullable()->comment('Descripción detallada');
            
            // Campos numéricos
            $tabla->decimal('precio', 10, 2)->comment('Precio unitario (10 dígitos totales, 2 decimales)');
            $tabla->unsignedInteger('inventario')->default(0)->comment('Cantidad disponible en stock');
            
            // Estado
            $tabla->boolean('activo')->default(true)->comment('¿Producto disponible?');
            
            // Marcas de tiempo
            $tabla->timestamps();
            
            // Borrado suave
            $tabla->softDeletes()->comment('Fecha de borrado (para borrado suave)');
            
            // Índices para mejor rendimiento
            $tabla->index('nombre')->comment('Índice para búsquedas por nombre');
            $tabla->index('precio')->comment('Índice para filtros por precio');
            $tabla->index('activo')->comment('Índice para productos activos');
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};