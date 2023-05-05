<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertFactVentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::table('fact_ventas')->insert([
            array(
                'fk_cliente' => 1,
                'fk_usuariosV' => 1,
                'empre_cod_empre' => '1',
                'tipo_fact_venta' => "F",

                'tipo_pago' => "E",

                'dias_venc' => 0,
                'tipo_contri' => 'NO_CONTRI',
                'fecha_fact_venta' => '2017-06-29',
                'num_fact_venta' => "1",


                'serie_fact_venta' => 'E',
                'num_ctrl_factventa' => '01',
                'reg_maq_fis' => "",
                'num_repo_z' => "",

                'tipo_trans' => '01-reg',


                'nplanilla_export' => '',
                'nexpe_export' => "",
                'naduana_export' => "",

                'fechaduana_export' => '2000-01-01',
                'num_compro_reten' => '',
                'fecha_compro_reten' => "2000-01-01",

                'nfact_afectada' => '',
                'tot_iva' => '58724.160',

                'msubt_exento_venta' => 0.000,
                'msubt_tot_bi_venta' => 489368.000,
                'msubt_bi_iva_12' => 0.000,
                'msubt_bi_iva_8' => 548092.160,

                'msubt_bi_iva_27' => 548092.160,
                'mtot_iva_venta' => 0.000,
                'monto_paga' => '20748.000',
                'm_iva_reten' => 0,
                'mes_apli_reten' => ''

            )
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
