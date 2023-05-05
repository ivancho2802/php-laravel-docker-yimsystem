<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'tipoCompra',
        'cantidad',
        'costo',
        'fk_inventario',
        'fk_fact_compra',
        'created_at',
        'updated_at'
    ];

    public function scopeAcum($query, $type)
    {
        return $query->where('tipoCompra', $type);
    }

    public function inventario() {
        return $this->hasOne(Inventario::class, 'id', 'fk_inventario');
    }

    public function factCompra() {
        return $this->hasOne(FactCompra::class, 'id', 'fk_fact_compra');
    }
}
