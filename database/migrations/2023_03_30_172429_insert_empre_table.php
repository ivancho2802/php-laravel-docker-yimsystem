<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertEmpreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        
        DB::table('empres')->insert([
            array(
                'cod_empre'=> 1,
                'rif_empre'=>'E814176951',
                'titular_rif_empre'=>'IVAN ORLANDO DIAZ CACERES',
                'nom_empre'=>'Sistemas Informaticos NN',
                'contri_empre'=>'Especial',
                'dir_empre'=>'san antonio del tachira centro civicco calle jum',
                'est_empre'=>1,
                'fk_usuarios'=>1,
                'retenIVA'=>'SI',
                'tel_empre'=>'0276-5554444',
                'url_report'=>'C:\\Users\\ivancho2802\\Desktop\\ReportesSistemaYIMI'
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
