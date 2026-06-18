<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Factura extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'facturas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fecha',
        'cliente_id',
        'metodo_pago_id',
        'saldopendiente',
        'total',
        'estado',
        'registrado_por',
    ];

    public function cliente()
{
    return $this->belongsTo(Cliente::class, 'cliente_id')->withTrashed();
}

    public function detallefacturas()
    {
    return $this->hasMany(Detalle_factura::class, 'factura_id');
    }
    public function metodo_pago()
{
    // Verifica que el nombre del modelo sea Metodo_pago o MetodoPago según tu archivo
    return $this->belongsTo(Metodo_pago::class, 'metodo_pago_id')->withTrashed();
}
public function usuario()
{
    // Relacionamos 'registrado_por' con la tabla de usuarios (User)
    return $this->belongsTo(User::class, 'registrado_por');
}
}
