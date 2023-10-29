<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plancuenta extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_plancuenta',
        'nom_plancuenta',
        'tsc',
        'natu',
        'aux',
        'rel_empre'
    ];

    public function empreplancuenta() {
        return $this->hasOne(EmprePlancuenta::class, 'rel_plancuenta', 'id');

    }
    
}

