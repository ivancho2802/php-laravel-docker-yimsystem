<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('proveedors')) {
            Schema::create('proveedors', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('rif');
                $table->string('nombre');
                $table->string('telefono');
                $table->string('direccion');
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
        Schema::dropIfExists('proveedors');
    }
}
