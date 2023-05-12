<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    //use HasFactory;

    protected $fillable = [
        'rif',
        'nombre',
        'telefono',
        'direccion',
        'created_at',
        'updated_at'
    ];
}
