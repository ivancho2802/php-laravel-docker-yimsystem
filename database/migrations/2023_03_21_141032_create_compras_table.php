<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('compras')) {
            Schema::create('compras', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('tipoCompra');
                $table->decimal('costo', 20, 4);
                $table->decimal('cantidad', 20, 4);
                
                $table->unsignedBigInteger('fk_inventario');
                $table->foreign('fk_inventario')
                    ->references('id')->on('inventarios');
                
                $table->unsignedBigInteger('fk_fact_compra');
                $table->foreign('fk_fact_compra')
                    ->references('id')->on('fact_compras');
                    //->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('compras');
    }
}
