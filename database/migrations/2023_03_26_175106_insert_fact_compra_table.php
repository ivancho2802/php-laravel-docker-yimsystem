<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertFactCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Insert some stuff
        DB::table('fact_compras')->insert([
            array(
                'id' => 1,
                'num_fact_compra' => '0111',
                'tipo_fact_compra' => 'NC-DEVO',
                'empre_cod_empre' => 'E814176951',
                'serie_fact_compra' => '1',
                'num_ctrl_factcompra' => 1,
                'fecha_fact_compra' => '2023-02-04',
                'fecha_fact_compra_reg' => '2023-02-04',
                'hora_fact_compra' => '09:54:15',
                'tipo_trans' => '2023-07-04',
                'nplanilla_import' => '',
                'nexpe_import' => '03-reg',
                'naduana_import' => '',
                'num_compro_reten' => '',
                'fecha_compro_reten' => '2000-01-01',
                'nfact_afectada' => '',
                'mtot_iva_compra' => 0.000,
                'tot_iva' => 0.000,
                'msubt_exento_compra' => -6272.000,
                'msubt_tot_bi_compra' => -672.000,
                'msubt_bi_iva_12' => 0.000,
                'msubt_bi_iva_8' => -5600.000,
                'msubt_bi_iva_27' => -5600.000,
                'm_iva_reten' => 0.000,
                'mes_apli_reten' => '',
                'fk_proveedor' => 1,
                'fk_usuariosc' => 1,
            ),
            array(
                'id' => 2,
                'num_fact_compra' => '0333',
                'tipo_fact_compra' => 'NC-DEVO',
                'empre_cod_empre' => 'J2558888',
                'serie_fact_compra' => '1',
                'num_ctrl_factcompra' => 1,
                'fecha_fact_compra' => '2023-02-04',
                'fecha_fact_compra_reg' => '2023-02-04',
                'hora_fact_compra' => '14:44:46',
                'tipo_trans' => '2023-07-04',
                'nplanilla_import' => '',
                'nexpe_import' => '03-reg',
                'naduana_import' => '',
                'num_compro_reten' => '',
                'fecha_compro_reten' => '2000-01-01',
                'nfact_afectada' => '',
                'mtot_iva_compra' => 0.000,
                'tot_iva' => 0.000,
                'msubt_exento_compra' => -531440.000,
                'msubt_tot_bi_compra' => -56940.000,
                'msubt_bi_iva_12' => 0.000,
                'msubt_bi_iva_8' => -474500.000,
                'msubt_bi_iva_27' => -474500.000,
                'm_iva_reten' => 0.000,
                'mes_apli_reten' => '',
                'fk_proveedor' => 1,
                'fk_usuariosc' => 1,
            ),
            array(
                'id' => 3,
                'num_fact_compra' => '111',
                'tipo_fact_compra' => 'F',
                'empre_cod_empre' => 'E814176951',
                'serie_fact_compra' => '1',
                'num_ctrl_factcompra' => 1,
                'fecha_fact_compra' => '2023-02-04',
                'fecha_fact_compra_reg' => '2023-02-28',
                'hora_fact_compra' => '11:26:40',
                'tipo_trans' => '2023-06-28',
                'nplanilla_import' => '',
                'nexpe_import' => '01-reg',
                'naduana_import' => '',
                'num_compro_reten' => '',
                'fecha_compro_reten' => '2000-01-01',
                'nfact_afectada' => '',
                'mtot_iva_compra' => 0.000,
                'tot_iva' => 0.000,
                'msubt_exento_compra' => 169108800.000,
                'msubt_tot_bi_compra' => 18118800.000,
                'msubt_bi_iva_12' => 0.000,
                'msubt_bi_iva_8' => 150990000.000,
                'msubt_bi_iva_27' => 150990000.000,
                'm_iva_reten' => 0.000,
                'mes_apli_reten' => '',
                'fk_proveedor' => 1,
                'fk_usuariosc' => 1,
            ),
            array(
                'id' => 4,
                'num_fact_compra' => '222',
                'tipo_fact_compra' => 'F',
                'empre_cod_empre' => 'E814176951',
                'serie_fact_compra' => '1',
                'num_ctrl_factcompra' => 1,
                'fecha_fact_compra' => '2023-02-04',
                'fecha_fact_compra_reg' => '2023-02-28',
                'hora_fact_compra' => '18:07:38',
                'tipo_trans' => '2023-07-03',
                'nplanilla_import' => '',
                'nexpe_import' => '01-reg',
                'naduana_import' => '',
                'num_compro_reten' => '',
                'fecha_compro_reten' => '2000-01-01',
                'nfact_afectada' => '',
                'mtot_iva_compra' => 0.000,
                'tot_iva' => 0.000,
                'msubt_exento_compra' => 2799664.000,
                'msubt_tot_bi_compra' => 299964.000,
                'msubt_bi_iva_12' => 0.000,
                'msubt_bi_iva_8' => 2499700.000,
                'msubt_bi_iva_27' => 2499700.000,
                'm_iva_reten' => 0.000,
                'mes_apli_reten' => '',
                'fk_proveedor' => 1,
                'fk_usuariosc' => 1,
            ),
            array(
                'id' => 5,
                'num_fact_compra' => '333',
                'tipo_fact_compra' => 'F',
                'empre_cod_empre' => 'E814176951',
                'serie_fact_compra' => '1',
                'num_ctrl_factcompra' => 1,
                'fecha_fact_compra' => '2023-02-04',
                'fecha_fact_compra_reg' => '2023-02-04',
                'hora_fact_compra' => '14:31:12',
                'tipo_trans' => '2023-07-04',
                'nplanilla_import' => '',
                'nexpe_import' => '01-reg',
                'naduana_import' => '',
                'num_compro_reten' => '',
                'fecha_compro_reten' => '2000-01-01',
                'nfact_afectada' => '',
                'mtot_iva_compra' => 0.000,
                'tot_iva' => 0.000,
                'msubt_exento_compra' => 531440.000,
                'msubt_tot_bi_compra' => 56940.000,
                'msubt_bi_iva_12' => 0.000,
                'msubt_bi_iva_8' => 474500.000,
                'msubt_bi_iva_27' => 42705.000,
                'm_iva_reten' => 0.000,
                'mes_apli_reten' => '2023-07',
                'fk_proveedor' => 1,
                'fk_usuariosc' => 1,
            ),

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
