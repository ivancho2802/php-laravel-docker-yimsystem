<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarioRetiro extends Model
{
    //use HasFactory;

    protected $fillable = [

        'id',
        'cant_a',
        'costo_a',
        'fecha_inv_retiros',
        'cant_inv_retiros',
        'orden_inv_retiros',
        'obs_inv_retiros',
        'fk_inventario',
        'fk_usuariosRI',
        'updated_at',
        'created_at'

    ];
}
