<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class InsertClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::table('clientes')->insert([
            array(
                'ced_cliente' => '11022089',
                'nom_cliente' => 'GREISY',
                'contri_cliente' => 'NO_CONTRI',
                'email_cliente' => 'greisypernia21@gmail.com',
                'tel_cliente' => '0416-1715880',
                'dir_cliente' => 'pregonero0',
                'fech_i_cliente' => '2015-04-03'
            ),
            array(
                'ced_cliente' => '24150144',
                'nom_cliente' => 'IVAN DIAZ',
                'contri_cliente' => 'NO_CONTRI',
                'email_cliente' => 'asd@gmail.com',
                'tel_cliente' => '0416-1715880',
                'dir_cliente' => 'pregonero0',
                'fech_i_cliente' => '2016-09-22'
            ),
            array(
                'ced_cliente' => 'V127601654',
                'nom_cliente' => 'YIM',
                'contri_cliente' => 'CONTRI_ORD',
                'email_cliente' => '123@gmail.com',
                'tel_cliente' => '0416-1231233',
                'dir_cliente' => 'okasmconaodn',
                'fech_i_cliente' => '2016-09-01'
            ),
            array(
                'ced_cliente' => 'V200613780',
                'nom_cliente' => 'ANGY STEFANIA CRUZ FUENTES',
                'contri_cliente' => 'CONTRI_ORD',
                'email_cliente' => '123@gmail.com',
                'tel_cliente' => '0416-1231233',
                'dir_cliente' => 'okasmconaodn',
                'fech_i_cliente' => '2016-09-23'
            ),
            array(
                'ced_cliente' => 'V241501449',
                'nom_cliente' => 'IVAN ORLANDO DIAZ CACERES',
                'contri_cliente' => 'CONTRI_ORD',
                'email_cliente' => '123@gmail.com',
                'tel_cliente' => '0416-1231233',
                'dir_cliente' => 'okasmconaodn',
                'fech_i_cliente' => '2016-09-01'
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
