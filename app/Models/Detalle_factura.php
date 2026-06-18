<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle_factura extends Model
{
    use HasFactory;
    protected $table = 'detalles_facturas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'factura_id',
        'producto_id',
        'cantidad',
        'subtotal',
        'registrado_por',
    ];

    public function factura()
    {
    return $this->belongsTo(Factura::class);
    }

    public function producto()
    {
    return $this->belongsTo(Producto::class);
    }
}
