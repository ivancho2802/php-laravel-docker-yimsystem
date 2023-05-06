<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRegInventarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::table('reg_inventarios')->insert([
            array(
                'id' => 105,
                'fecha_reg_inv' => '2023-06-28',
                'fecha_registro' => '2023-06-28',
                'hora_registro' => '11:26:40',
                'costo_reg_inv' => '15600.000',
                'cantidad_reg_inv' => 300,
                'pmpvj' => '20748.000',
                'tipo' => 'compra',
                'fk_inventario' => 278,
                'fk_fact_cv' => 2
            ),
            array(


                'id' => 106,
                'fecha_reg_inv' => '2023-06-28',
                'fecha_registro' => '2023-06-28',
                'hora_registro' => '11:26:40',
                'costo_reg_inv' => '7600.000',
                'cantidad_reg_inv' => 300,
                'pmpvj' => '10108.000',
                'tipo' => 'compra',
                'fk_inventario' => 281,
                'fk_fact_cv' => 2

            ),

            array(
                'id' => 107,
                'fecha_reg_inv' => '2023-06-28',
                'fecha_registro' => '2023-06-28',
                'hora_registro' => '11:26:40',
                'costo_reg_inv' => '5600.000',
                'cantidad_reg_inv' => 300,
                'pmpvj' => '7448.000',
                'tipo' => 'compra',
                'fk_inventario' => 697,
                'fk_fact_cv' => 2
            ),
            array(
                'id' => 108,
                'fecha_reg_inv' => '2023-06-28',
                'fecha_registro' => '2023-06-28',
                'hora_registro' => '11:26:40',
                'costo_reg_inv' => '474500.000',
                'cantidad_reg_inv' => 300,
                'pmpvj' => '631085.000',
                'tipo' => 'compra',
                'fk_inventario' => 985,
                'fk_fact_cv' => 2
            ),
            array(
                'id' => 110,
                'fecha_reg_inv' => '2023-06-29',
                'fecha_registro' => '2023-06-28',
                'hora_registro' => '11:30:51',
                'costo_reg_inv' => '15889.100',
                'cantidad_reg_inv' => 400,
                'pmpvj' => '22244.000',
                'tipo' => 'venta',
                'fk_inventario' => 278,
                'fk_fact_cv' => 1
            ),
            array(
                'id' => 111,
                'fecha_reg_inv' => '2023-06-29',
                'fecha_registro' => '2023-06-30',
                'hora_registro' => '18:40:00',
                'costo_reg_inv' => '7600.000',
                'cantidad_reg_inv' => 299,
                'pmpvj' => '0.000',
                'tipo' => 'retiro',
                'fk_inventario' => 281,
                'fk_fact_cv' => 1
            ),
            array(
                'id' => 116,
                'fecha_reg_inv' => '2023-06-28',
                'fecha_registro' => '2023-07-03',
                'hora_registro' => '18:07:39',
                'costo_reg_inv' => '16805.013',
                'cantidad_reg_inv' => 422,
                'pmpvj' => '20748.000',
                'tipo' => 'compra',
                'fk_inventario' => 278,
                'fk_fact_cv' => 3
            ),
            array(
                'id' => 117,
                'fecha_reg_inv' => '2023-06-28',
                'fecha_registro' => '2023-07-03',
                'hora_registro' => '18:07:39',
                'costo_reg_inv' => '474500.000',
                'cantidad_reg_inv' => 301,
                'pmpvj' => '631085.000',
                'tipo' => 'compra',
                'fk_inventario' => 985,
                'fk_fact_cv' => 3
            ),
            array(
                'id' => 119,
                'fecha_reg_inv' => '2023-07-04',
                'fecha_registro' => '2023-07-04',
                'hora_registro' => '09:54:15',
                'costo_reg_inv' => '5600.000',
                'cantidad_reg_inv' => 299,
                'pmpvj' => '7448.000',
                'tipo' => 'compra',
                'fk_inventario' => 697,
                'fk_fact_cv' => 1
            ),
            array(
                'id' => 121,
                'fecha_reg_inv' => '2023-07-04',
                'fecha_registro' => '2023-07-04',
                'hora_registro' => '14:31:13',
                'costo_reg_inv' => '474500.000',
                'cantidad_reg_inv' => 302,
                'pmpvj' => '631085.000',
                'tipo' => 'compra',
                'fk_inventario' => 985,
                'fk_fact_cv' => 4
            ),
            array(
                'id' => 122,
                'fecha_reg_inv' => '2023-07-04',
                'fecha_registro' => '2023-07-04',
                'hora_registro' => '14:44:46',
                'costo_reg_inv' => '474500.000',
                'cantidad_reg_inv' => 301,
                'pmpvj' => '631085.000',
                'tipo' => 'compra',
                'fk_inventario' => 985,
                'fk_fact_cv' => 2
            ),
            array(
                'id' => 123,
                'fecha_reg_inv' => '2023-06-28',
                'fecha_registro' => '2023-07-06',
                'hora_registro' => '18:25:02',
                'costo_reg_inv' => '6500.000',
                'cantidad_reg_inv' => 30,
                'pmpvj' => '8645.000',
                'tipo' => 'inv_ini',
                'fk_inventario' => 712,
                'fk_fact_cv' => 1
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
