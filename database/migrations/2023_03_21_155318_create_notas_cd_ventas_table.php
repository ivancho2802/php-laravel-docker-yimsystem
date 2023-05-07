<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasCdVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('notas_cd_ventas')) {

            Schema::create('notas_cd_ventas', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->string('id_notas_cd_venta');
                $table->string('num_notas_cd_venta');
                $table->string('tipo_notas_cd_venta');

                $table->unsignedBigInteger('id_fact_venta');
                $table->foreign('id_fact_venta')
                    ->references('id')->on('fact_compras');
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
        Schema::dropIfExists('notas_cd_ventas');
    }
}
