<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'productos';
    protected $primaryKey = 'id';
    

    protected $fillable = [
        'nombre',
        'precio_venta',
        'descripcion',
        'stock',
        'stock_minimo',
        'imagen',
        'estado',
        'registradopor'
    ];

    public function detallefacturas()
    {
    return $this->hasMany(Detalle_factura::class, 'producto_id');
    }

}
