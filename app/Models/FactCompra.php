<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\HasConstants;

class FactCompra extends Model
{
    use HasFactory;

    //use HasConstants;

    /**
     * PATH AGREGAR FACTURA DE COMPRA
     */
    const FCOMPRAADD = 'book-shopping-add';
    
    /**
     * PATH EDITAR FACTURA DE COMPRA
     */
    const FCOMPRAEDIT = 'book-shopping-edit';

    /**
     * PATH AGREGAR FACTURA DE COMPRA RETENCION
     */
    const FCOMPRARETENADD = 'book-shopping-reten-add';

    /**\App\Models\FactCompra::TYPECOMPRA;
     * CONTANTES DE TIOOOPD E COMPRA
     */
    const TYPECOMPRA = [
        "Internas" => [
            "IN_EX" => "Internas Exentas",

            "IN_EXO" => "Internas Exoneradas",
            "IN_NS" => "Internas No Sujetas",
            "IN_SDCF" => "Internas Sin derecho a Credito Fiscal",
            "IN_BI_12" => "Internas Base Imponible al 12%",
            "IN_BI_8" => "Internas Base Imponible al 8%",
            "IN_BI_27" => "Internas Base Imponible al 27%"
        ],
        "Importaciones" => [
            "IM_EX" => "Importaciones Exentas",
            "IM_EXO" => "Importaciones Exoneradas",
            "IM_NS" => "Importaciones No Sujetas",
            "IM_SDCF" => "Importaciones Sin derecho a Credito Fiscal",
            "IM_BI_8" => "Importaciones Base Imponible al 8%",
            "IM_BI_27" => "Importaciones Base Imponible al 27%",
        ]
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'num_fact_compra',
        'tipo_fact_compra',
        'empre_cod_empre',
        'serie_fact_compra',
        'num_ctrl_factcompra',
        'fecha_fact_compra',
        'fecha_fact_compra_reg',
        'hora_fact_compra',
        
        'tipo_trans',
        'nplanilla_import',
        'nexpe_import',
        'naduana_import',
        'fechaduana_import',
        'num_compro_reten',
        'fecha_compro_reten',
        'nfact_afectada',
        'mtot_iva_compra',
        'tot_iva',
        'msubt_exento_compra',
        'msubt_tot_bi_compra',
        'msubt_bi_iva_12',
        'msubt_bi_iva_8',
        'msubt_bi_iva_27',
        'm_iva_reten',
        'mes_apli_reten',
        'fk_proveedor',
        'fk_usuariosc',

        'updated_at',
        'created_at'

    ];

    protected $appends = ['importations_without_iva'];

    /**
     * realtions
     */

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'fk_proveedor', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'fk_usuariosc', 'id');
    }

    public function empre()
    {
        return $this->hasOne(Empre::class, 'rif_empre', 'empre_cod_empre');
    }
    
    public function notacd()
    {
        return $this->hasMany(NotasCd::class);
    }
    
    public function compras()
    {
        return $this->hasMany(Compra::class, 'fk_fact_compra', 'id' );
    }

    public function notascds()
    {
        return $this->hasMany(NotasCd::class, 'fact_compra_id', 'id' );
    }
    
    /**
     * attributes
     */
    /**
     * IN_BI_12 -> TOTALES DE IMPORTACIONES EXENTAS O EXONERADAS
     * IN_EX -> TOTALES DE LAS BASES IMPONIBLES
     * IN_EXO -> TOTAL BI 12 IMPORT
     * IN_NS -> TOTAL BI 8 IMPORT
    * function  getRatingStoreShowAttribute() rating_store_show
    * public function getImportationsWithoutIvaAttribute() importations_without_iva
     */
    public function getImportationsWithoutIvaAttribute()
    {
        $totalAmountINSDCF = 0;
        $totalAmountINEX = 0;
        $totalAmountINEXO = 0;
        $totalAmountINNS = 0;
        $compras = $this->compras();

        foreach ($compras as $compra) {

            if ($compra->tipoCompra == "IN_SDCF") {
                $totalAmountINSDCF += $compra->costo * $compra->cantidad;
            } elseif ($compra->tipoCompra == "IN_EX") {
                $totalAmountINEX += $compra->costo * $compra->cantidad;
            } elseif ($compra->tipoCompra == "IN_EXO") {
                $totalAmountINEXO += $compra->costo * $compra->cantidad;
            } elseif ($compra->tipoCompra == "IN_NS") {
                $totalAmountINNS += $compra->costo * $compra->cantidad;
            }
        }

        return [
            'SDCF' => $totalAmountINSDCF,
            'EX' => $totalAmountINEX,
            'EXO' => $totalAmountINEXO,
            'NS' => $totalAmountINNS,
        ];
    }

    /**
     * scopes
     */


    /**
     * funciones o metodos
    */
    public function calculateTot() {
        $this->sum('mtot_iva_compra');
        return true;
    }


}
