<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('empleados')) {

            Schema::create('empleados', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->string('ci');
                $table->string('nombre');
                $table->decimal('sueldo', 20, 4);
                $table->string('cargo');
                $table->string('telefono');
                $table->string('direccion');
                $table->string('codigo_empleado');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}
