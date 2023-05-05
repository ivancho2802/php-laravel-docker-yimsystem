<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class InsertInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::table('inventarios')->insert([
            array(
                'id' => 278,
                'nombre_i' => 'PAÃ‘ALES PEQUEÃ‘IN',
                'descripcion' => '',
                'cant_min' => 0,
                'cant_max' => 0,
                'stock' => 400,
                'valor_unitario' => 16805.012531328,
                'pmpvj_actual' => 20748.000,
                'fecha' => '2017-05-28'
            ),
            array(
                'id' => 281,
                'nombre_i' => 'CAFE CONCAFE',
                'descripcion' => '',
                'cant_min' => 0,
                'cant_max' => 0,
                'stock' => 299,
                'valor_unitario' => 7600,
                'pmpvj_actual' => 10108,
                'fecha' => '2017-05-28'
            ),
            array(
                'id' => 697,
                'nombre_i' => 'LECHE EN POLVO LA CAMPIÃ‘A',
                'descripcion' => '',
                'cant_min' => 0,
                'cant_max' => 0,
                'stock' => 299,
                'valor_unitario' => 5600,
                'pmpvj_actual' => 7448,
                'fecha' => '2017-05-28'
            ),
            array(
                'id' => 712,
                'nombre_i' => 'CREMA SAPOLIN',
                'descripcion' => '',
                'cant_min' => 0,
                'cant_max' => 0,
                'stock' => 30,
                'valor_unitario' => 6500,
                'pmpvj_actual' => 0,
                'fecha' => '2017-06-28'
            ),
            array(
                'id' => 985,
                'nombre_i' => 'harina pan',
                'descripcion' => '',
                'cant_min' => 1,
                'cant_max' => 150,
                'stock' => 301,
                'valor_unitario' => 474500,
                'pmpvj_actual' => 631085,
                'fecha' => '2017-03-28'
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
