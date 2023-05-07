<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasCdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('notas_cds')) {
            Schema::create('notas_cds', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->string('id_notas_cd');
                $table->string('num_notas_cd');
                $table->string('tipo_notas_cd');

                $table->unsignedBigInteger('fact_compra_id');
                $table->foreign('fact_compra_id')
                    ->references('id')->on('fact_compras')
                    ->references('id')->on('fact_ventas');
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
        Schema::dropIfExists('notas_cds');
    }
}
