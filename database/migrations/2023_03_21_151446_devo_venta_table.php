<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DevoVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        
        if (!Schema::hasTable('devo_ventas')) {

            Schema::create('devo_ventas', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('id_devo_venta');
                $table->string('motivo_devo_venta');
                $table->string('text');
                $table->timestamp('fecha_devo_venta')->useCurrent();
                $table->decimal('cantidad_devo_venta', 20, 4);
                $table->decimal('mtot_devo_venta', 20, 4);
                $table->unsignedBigInteger('fk_venta');
                    
                $table->foreign('fk_venta')
                ->references('id')->on('ventas');
                //->onDelete('cascade')->onUpdate('cascade');

                $table->timestamps();
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
        Schema::dropIfExists('devo_ventas');
        //
    }
}
