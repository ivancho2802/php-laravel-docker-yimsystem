<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Insert some stuff
        DB::table('compras')->insert([
            [
                'tipoCompra' => 'IN_BI_12',
                'costo' => 15600.000,
                'cantidad' => 300,
                'fk_inventario' => 278,
                'fk_fact_compra' => 3
            ],
            [
                'tipoCompra' => 'IN_BI_12',
                'costo' => 7600.000,
                'cantidad' => 300,
                'fk_inventario' => 281,
                'fk_fact_compra' => 3
            ],
            [
                'tipoCompra' => 'IN_BI_12',
                'costo' => 5600.000,
                'cantidad' => 300,
                'fk_inventario' => 697,
                'fk_fact_compra' => 3
            ],
            [
                'tipoCompra' => 'IN_BI_12',
                'costo' => 474500.000,
                'cantidad' => 300,
                'fk_inventario' => 985,
                'fk_fact_compra' => 3
            ],
            [
                'tipoCompra' => 'IN_BI_12',
                'costo' => 16600.000,
                'cantidad' => 122,
                'fk_inventario' => 278,
                'fk_fact_compra' => 3
            ],
            [
                'tipoCompra' => 'IN_BI_12',
                'costo' => 474500.000,
                'cantidad' => 1,
                'fk_inventario' => 985,
                'fk_fact_compra' => 4
            ],
            [
                'tipoCompra' => 'IN_BI_12',
                'costo' => 5600.000,
                'cantidad' => 1,
                'fk_inventario' => 697,
                'fk_fact_compra' => 1
            ],
            [
                'tipoCompra' => 'IN_BI_12',
                'costo' => 474500.000,
                'cantidad' => 1,
                'fk_inventario' => '985',
                'fk_fact_compra' => 5
            ],
            [
                'tipoCompra' => 'IN_BI_12',
                'costo' => 474500.000,
                'cantidad' => 1,
                'fk_inventario' => 985,
                'fk_fact_compra' => 2
            ],
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
