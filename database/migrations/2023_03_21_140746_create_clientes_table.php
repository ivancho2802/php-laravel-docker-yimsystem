<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('clientes')) {
            Schema::create('clientes', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('ced_cliente');
                $table->string('nom_cliente');
                $table->string('contri_cliente');
                $table->string('email_cliente');
                $table->string('tel_cliente');
                $table->string('dir_cliente');
                $table->timestamp('fech_i_cliente')->useCurrent();
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
        //Schema::dropIfExists('clientes');
    }
}
