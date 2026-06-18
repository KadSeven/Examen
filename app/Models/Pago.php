<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pago extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pagos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'factura_id',
        'fecha_pago',
        'monto',
        'metodo_pago_id',
        'registrado_por',
    ];

    public function factura()
{
    return $this->belongsTo(Factura::class, 'factura_id')->withTrashed();
}

    public function metodoPago()
    {
    return $this->belongsTo(Metodo_pago::class, 'metodo_pago_id');
    }
    public function getClienteAttribute()
{
    // Añadimos withTrashed() para que encuentre al cliente aunque esté en la papelera
    return $this->factura ? $this->factura->cliente : null;
}
}
