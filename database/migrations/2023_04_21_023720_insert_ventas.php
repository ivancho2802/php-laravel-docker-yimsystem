<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertVentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::table('ventas')->insert([
            array(
                "tipoVenta" => 'NA_BI_12',
                "costo" => 15889.100,
                "precio_venta" => 22244.000,
                "cantidad" => 22,
                "fk_inventario" => 278,
                "fk_fact_venta" => 1
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
