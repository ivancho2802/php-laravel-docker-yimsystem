<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ventas')) {
            Schema::create('ventas', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->string('serial')->nullable();
                $table->string('tipoVenta');
                $table->decimal('costo', 20, 4);
                $table->decimal('precio_venta', 20, 4);
                $table->integer('cantidad');
                
                $table->unsignedBigInteger('fk_inventario');
                $table->foreign('fk_inventario')
                    ->references('id')->on('inventarios');
                
                $table->unsignedBigInteger('fk_fact_venta');
                $table->foreign('fk_fact_venta')
                    ->references('id')->on('fact_ventas');
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
        Schema::dropIfExists('ventas');
    }
}
