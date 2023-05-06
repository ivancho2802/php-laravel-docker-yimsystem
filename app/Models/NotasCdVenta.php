<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotasCdVenta extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_fact_venta',
        'num_notas_cd_venta',
        'tipo_notas_cd_venta'
    ];
}
