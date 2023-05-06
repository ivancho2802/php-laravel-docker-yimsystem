<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioRetirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('inventario_retiros')) {
            
            Schema::create('inventario_retiros', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->integer('cant_a');
                $table->decimal('costo_a', 20, 4);
                $table->timestamp('fecha_inv_retiros')->useCurrent();
                $table->integer('cant_inv_retiros');
                $table->string('orden_inv_retiros');
                $table->string('obs_inv_retiros');

                $table->unsignedBigInteger('fk_inventario');
                $table->foreign('fk_inventario')
                    ->references('id')->on('inventarios');
                    
                $table->unsignedBigInteger('fk_usuariosRI');
                $table->foreign('fk_usuariosRI')
                    ->references('id')->on('users');

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
        Schema::dropIfExists('inventario_retiros');
    }
}
