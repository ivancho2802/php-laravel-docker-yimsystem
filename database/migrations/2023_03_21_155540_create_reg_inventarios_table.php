<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('reg_inventarios')) {

            Schema::create('reg_inventarios', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->timestamp('fecha_reg_inv')->useCurrent();
                $table->timestamp('fecha_registro')->useCurrent();
                $table->time('hora_registro');
                $table->decimal('costo_reg_inv', 20, 4);
                $table->integer('cantidad_reg_inv');
                $table->decimal('pmpvj', 20, 4);
                $table->string('tipo');

                $table->unsignedBigInteger('fk_inventario');
                $table->foreign('fk_inventario')
                    ->references('id')->on('inventarios');

                $table->unsignedBigInteger('fk_fact_cv')->nullable();
                $table->foreign('fk_fact_cv')
                    ->nullable()
                    ->constrained()
                    ->references('id')->on('fact_compras');

                $table->bigInteger('fk_fact_venta')->nullable();
                $table->foreign('fk_fact_venta')
                    ->nullable()
                    ->constrained()
                    ->references('id')->on('fact_ventas');

                /* $table->foreign('fk_fact_cv')
                ->references('id_fact_venta')->on('fk_fact_venta'); */

                /* $table->unsignedBigInteger('fk_fact_compra');
                $table->foreign('fk_fact_compra')
                    ->references('id_fact_compra')->on('fact_compra');
    
                $table->unsignedBigInteger('fk_fact_venta');
                $table->foreign('fk_fact_venta')
                    ->references('id_fact_venta')->on('fact_venta'); */
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
        Schema::dropIfExists('reg_inventarios');
    }
}
