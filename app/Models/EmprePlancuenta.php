<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmprePlancuenta extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'cant_plancuenta',
        'rel_empre',
        'status',
        'rel_plancuenta',
        'c_natu'
    ];

    public function plancuenta() {
        return $this->belongsTo(Plancuenta::class, 'rel_plancuenta', 'id');
    }

    /**
     * scopes
     */
    public function scopeActive($query)
    {
        $query->where('status', true);
    }
}
