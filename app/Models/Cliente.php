<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'clientes';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre',
        'documento',
        'direccion',
        'telefono',
        'correo',
        'estado',
        'registrado_por',
    ];

    public function facturas()
    {

    return $this->hasMany(Factura::class, 'cliente_id');
    }
}
