<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotasCd extends Model
{
    //use HasFactory;

    protected $fillable = [
        'id',
        'fact_compra_id',
        'num_notas_cd',
        'tipo_notas_cd'
    ];
}
