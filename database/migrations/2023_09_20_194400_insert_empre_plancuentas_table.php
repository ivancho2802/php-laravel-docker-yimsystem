<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class InsertEmprePlancuentasTable extends Migration
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
            array("id" => 2, "rel_empre" => 1, "rel_plancuenta" => 1110101, "cant_plancuenta" => 1000.01, "c_natu" => 'Debe'),
            array("id" => 3, "rel_empre" => 1, "rel_plancuenta" => 1110101, "cant_plancuenta" => 1000.01, "c_natu" => 'Debe'),
            array("id" => 4, "rel_empre" => 1, "rel_plancuenta" => 3110101, "cant_plancuenta" => 500.00, "c_natu" => 'Haber'),
            array("id" => 4, "rel_empre" => 1, "rel_plancuenta" => 4110102, "cant_plancuenta" => 9999.00, "c_natu" => 'Haber')
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
