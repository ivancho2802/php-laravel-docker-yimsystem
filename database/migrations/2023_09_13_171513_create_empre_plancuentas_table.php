<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmprePlancuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empre_plancuentas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('cant_plancuenta');
            $table->string('c_natu');

            $table->unsignedBigInteger('rel_plancuenta');
            $table->foreign('rel_plancuenta')
                ->references('id')->on('plancuentas');

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
        Schema::dropIfExists('empre_plancuentas');
    }
}
