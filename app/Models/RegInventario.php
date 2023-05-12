<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegInventario extends Model
{
    //use HasFactory;

    protected $fillable = [
        'id',

        'created_at',
        'updated_at',
        'fecha_reg_inv',
        'fecha_registro',
        'hora_registro',
        'costo_reg_inv',
        'cantidad_reg_inv',
        'pmpvj',
        'tipo',
        'fk_inventario',
        'fk_fact_cv'
    ];
}
