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
        DB::table('empre_plancuentas')->insert([
            array("id" => 2, "rel_empre" => 1, "rel_plancuenta" => 1110101, "cant_plancuenta" => 1000, "c_natu" => 'Debe', "status" => true),
            array("id" => 3, "rel_empre" => 1, "rel_plancuenta" => 1110101, "cant_plancuenta" => 1000, "c_natu" => 'Debe', "status" => true),
            array("id" => 4, "rel_empre" => 1, "rel_plancuenta" => 3110101, "cant_plancuenta" => 500, "c_natu" => 'Haber', "status" => true),
            array("id" => 5, "rel_empre" => 1, "rel_plancuenta" => 4110102, "cant_plancuenta" => 9999, "c_natu" => 'Haber', "status" => true)
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
