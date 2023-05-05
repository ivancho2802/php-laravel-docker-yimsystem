<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'ced_cliente',
        'nom_cliente',
        'contri_cliente',
        'email_cliente',
        'tel_cliente',
        'dir_cliente',
        'fech_i_cliente'
    ];
}
