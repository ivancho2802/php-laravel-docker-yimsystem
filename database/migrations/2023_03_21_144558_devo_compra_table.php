<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DevoCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasTable('devo_compras')) {

            Schema::create('devo_compras', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('motivo_devolucion');
                $table->timestamp('fecha_devolucion')->useCurrent();
                $table->decimal('cantidad_devuelta', 20, 4);
                $table->decimal('monto_bs', 20, 4);
                $table->unsignedBigInteger('fk_compra');

                $table->foreign('fk_compra')
                    ->references('id')->on('compras');
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
        Schema::dropIfExists('devo_compras');
        //
    }
}
