<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Metodo_pago extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'metodo_pagos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'tipo',
        'estado',
        'registrado_por',
    ];

    public function pagos()
    {
    return $this->hasMany(Pago::class, 'metodo_pago_id');
    }

    
}
