<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nombre de la tabla asociada al modelo.
     */
    protected $table = 'productos';

    /**
     * Atributos que pueden ser asignados masivamente.
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'inventario',
        'activo'
    ];

    /**
     * Conversiones de tipos para los atributos.
     */
    protected $casts = [
        'precio' => 'decimal:2',  // Precio con 2 decimales
        'activo' => 'boolean'     // Estado como booleano
    ];

    /**
     * Fechas que deben ser tratadas como instancias de Carbon.
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'  // Para el borrado suave
    ];
}