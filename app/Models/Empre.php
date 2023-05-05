<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empre extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',

        
        'cod_empre',
        'rif_empre',
        'titular_rif_empre',
        'nom_empre',
        'contri_empre',
        'dir_empre',
        'tel_empre',
        'url_report',
        'retenIVA',
        'est_empre',//'1 y 0',

        'fk_usuarios',

        'created_at',
        'updated_at'
    ];
    
    public function user() {
        return $this->belongsTo(User::class, 'fk_usuarios', 'id');
    }

    public function scopeActive($query) {
        return $query->where('est_empre', 1)->first();
    }
}
