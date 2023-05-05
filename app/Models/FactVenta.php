<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactVenta extends Model
{
    use HasFactory;

    /**
     * PATH AGREGAR FACTURA DE VENTA
     */
    const FVENTAADD = 'book-sales-add';

    /**
     * PATH EDITAR FACTURA DE VENTA
     */
    const FVENTAEDIT = 'book-sale-edit';

    /**
     * PATH AGREGAR FACTURA DE VENTA RETENCION
     */
    const FVENTARETENADD = 'book-sale-reten-add';

    /**\App\Models\FactVenta::TYPEVENTA;
     * CONTANTES DE TIPO DE VENTA
     */

    //Create array of options to be added&prime; Exoneradas&prime; No Sujetas&prime; Sin derecho a Credito Fiscal&prime;
    const TYPEVENTA = [
        "Nacionales" => [
            "NA_EX" => "Nacionales Exentas",
            "NA_EXO" => "Nacionales Exoneradas",
            "NA_NS" => "Nacionales No Sujetas",
            "NA_SDCF" => "Nacionales Sin derecho a Credito Fiscal",
            "NA_BI_12" => "Nacionales Base Imponible al 12%",
            "NA_BI_8" => "Nacionales Base Imponible al 8%",
            "NA_BI_27" => "Nacionales Base Imponible al 27%",
        ],
        "Exportaciones" => [
            "EX_EX" => "Exportaciones Exentas"
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',

        'empre_cod_empre',
        'tipo_fact_venta',
        'tipo_pago',
        'tipo_contri',
        'dias_venc',
        'fecha_fact_venta',
        'num_fact_venta',
        'serie_fact_venta',
        'num_ctrl_factventa',
        'reg_maq_fis',
        'num_repo_z',
        'tipo_trans',
        'nplanilla_export',
        'nexpe_export',
        'naduana_export',
        'fechaduana_export',
        'num_compro_reten',
        'fecha_compro_reten',
        'nfact_afectada',
        'tot_iva',
        'msubt_exento_venta',
        'msubt_tot_bi_venta',
        'msubt_bi_iva_12',
        'msubt_bi_iva_8',
        'msubt_bi_iva_27',
        'mtot_iva_venta',
        'monto_paga',
        'm_iva_reten',
        'mes_apli_reten',

        'fk_cliente',
        'fk_usuariosV',
        'updated_at',
        'created_at'
    ];

    public function notascdventas()
    {
        return $this->hasMany(NotasCdVenta::class, 'id_fact_venta', 'id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'fk_cliente', 'id');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'fk_fact_venta', 'id');
    }

    public function empre()
    {
        return $this->hasOne(Empre::class, 'rif_empre', 'empre_cod_empre');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'fk_usuariosV', 'id');
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
     * public function getWithoutIvaAttribute() without_iva
     */
    public function getWithoutIvaAttribute()
    {

        $totalAmountINSDCF = 0;
        $totalAmountINEX = 0;
        $totalAmountINEXO = 0;
        $totalAmountINNS = 0;

        $ventas = [];

        if ($this->whereOr([
            ['nplanilla_export', ''],
            ['nplanilla_export', NULL],
        ])) {
            $ventas = $this->ventas();
        }

        foreach ($ventas as $venta) {

            if ($venta->tipoVenta == "IN_SDCF") {
                $totalAmountINSDCF += $venta->costo * $venta->cantidad;
            } elseif ($venta->tipoVenta == "IN_EX") {
                $totalAmountINEX += $venta->costo * $venta->cantidad;
            } elseif ($venta->tipoVenta == "IN_EXO") {
                $totalAmountINEXO += $venta->costo * $venta->cantidad;
            } elseif ($venta->tipoVenta == "IN_NS") {
                $totalAmountINNS += $venta->costo * $venta->cantidad;
            }
        }

        return [
            'SDCF' => $totalAmountINSDCF,
            'EX' => $totalAmountINEX,
            'EXO' => $totalAmountINEXO,
            'NS' => $totalAmountINNS,
        ];
    }
}
