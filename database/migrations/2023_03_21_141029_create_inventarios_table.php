<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('inventarios')) {
            Schema::create('inventarios', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->string('codigo');
                $table->string('nombre_i');
                $table->string('descripcion');
                $table->integer('cant_min');
                $table->integer('cant_max');
                $table->integer('stock');
                $table->string('valor_unitario');
                $table->string('pmpvj_actual');
                $table->timestamp('fecha')->useCurrent();
                
                $table->unsignedBigInteger('fk_usuarios');
                $table->foreign('fk_usuarios')
                    ->references('id')->on('users')->nullable();
                
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
        Schema::dropIfExists('inventarios');
    }
}
