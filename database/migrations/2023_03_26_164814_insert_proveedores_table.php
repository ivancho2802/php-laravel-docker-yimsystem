<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::table('proveedors')->insert([
            array(
                'rif' => 'E814176951',
                'nombre' => 'GUSTAVO ADOLFO SALAS RIAÃ‘O',
                'telefono' => '',
                'direccion' => '',
            ),
            array(
                'rif' => 'INV_INI',
                'nombre' => 'INV_INI',
                'telefono' => 'INV_INI',
                'direccion' => 'INV_INI',
            ),
            array(
                'rif' => 'J2333555',
                'nombre' => 'Pasteurizadora TÃ¡chira',
                'telefono' => '3445522',
                'direccion' => 'SC',
            ),
            array(
                'rif' => 'J2558888',
                'nombre' => 'Comercial GonzÃ¡lez',
                'telefono' => '2147483647',
                'direccion' => 'Caracas',
            ),
            array(
                'rif' => 'J274653536',
                'nombre' => 'FARMACIA MAUZAGO C.A (FARMACIA',
                'telefono' => '',
                'direccion' => '',
            ),
            array(
                'rif' => 'J294905439',
                'nombre' => 'HIERROMAX C.A.',
                'telefono' => '02712218661',
                'direccion' => 'av principal local nro 00 urb jose feliz rivas sector plata ii valera edo trujil',
            ),
            array(
                'rif' => 'J315583305',
                'nombre' => 'DISTRIBUIDORA BORRERO MEDINA C',
                'telefono' => '02762913553',
                'direccion' => 'ctra panamericana con calle 9 ',
            ),
            array(
                'rif' => 'J407512625',
                'nombre' => 'KATABOOM C.A.',
                'telefono' => '04268094821',
                'direccion' => 'SAN ANTONIO',
            ),
            array(
                'rif' => 'V012223331',
                'nombre' => 's',
                'telefono' => '',
                'direccion' => '',
            ),
            array(
                'rif' => 'V043194930',
                'nombre' => 'REINA COROMOTO QUINTERO DE VEN',
                'telefono' => '',
                'direccion' => '',
            ),
            array(
                'rif' => 'V053283523',
                'nombre' => 'IVAN FUENTES GONZALEZ',
                'telefono' => '',
                'direccion' => '',
            ),
            array(
                'rif' => 'V11022089',
                'nombre' => 'DIOCELINA  CACERES CASTILLO',
                'telefono' => '04168700911',
                'direccion' => 'LLANO DE JORGE',
            ),
            array(
                'rif' => 'V111655029',
                'nombre' => 'CRISTIAN CARLOS URIBE ROJAS',
                'telefono' => '',
                'direccion' => '',
            ),
            array(
                'rif' => 'V127601654',
                'nombre' => 'YTALA YANETH OMAÃ‘A MONTAÃ‘EZ',
                'telefono' => '04164973215',
                'direccion' => 'AV 1RO DE MAYO CON CALLES 10 Y 11 OFICINA 2-14 CENTRO CIVICO SAN ANTONIO',
            ),
            array(
                'rif' => 'V157733790',
                'nombre' => 'LARRY ANTONIO ALVAREZ SUENCUN',
                'telefono' => '04164973215',
                'direccion' => 'CALLE 4 ENTRE CARRERA 13 Y 14 CASA NRO 13.50 BARRIO MIRANDA',
            ),
            array(
                'rif' => 'V18353562',
                'nombre' => 'Norky Garcia',
                'telefono' => '2147483647',
                'direccion' => 'Capacho',
            ),
            array(
                'rif' => 'V183547638',
                'nombre' => 'RAMON EDUARDO VIVAS PASTRAN',
                'telefono' => '04147540437',
                'direccion' => 'CALLE 6 CASA N 6 49 BARRIO LAGUNITAS',
            ),
            array(
                'rif' => 'V200613780',
                'nombre' => 'ANGY STEFANIA CRUZ FUENTES',
                'telefono' => '',
                'direccion' => '',
            ),
            array(
                'rif' => 'V241501411',
                'nombre' => 'N',
                'telefono' => '',
                'direccion' => '',
            ),

            array(
                'rif' => 'V241501449',
                'nombre' => 'IVAN DIAZ',
                'telefono' => '04161234567',
                'direccion' => 'AAA',
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
