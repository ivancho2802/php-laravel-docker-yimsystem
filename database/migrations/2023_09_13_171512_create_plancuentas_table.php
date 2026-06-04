<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlancuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plancuentas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_plancuenta');
            $table->string('nom_plancuenta');
            $table->string('tsc');
            $table->string('natu');
            $table->string('aux');
            
            $table->unsignedBigInteger('rel_empre');
            $table->foreign('rel_empre')
                ->references('id')->on('empres');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plancuentas');
    }
}
