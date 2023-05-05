<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',

        'serial',
        'tipoVenta',
        'costo',
        'precio_venta',
        'cantidad',
        'fk_inventario',
        'fk_fact_venta',

        'created_at',
        'updated_at'
    ];

    public function inventario() {
        return $this->hasOne(Inventario::class, 'id', 'fk_inventario');
    }

    public function factVenta() {
        return $this->hasOne(FactVenta::class, 'id', 'fk_fact_venta');
    }
}
