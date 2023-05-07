<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('data_systems')) {
            Schema::create('data_systems', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->string('nom_ds');
                $table->string('alias_ds');
                $table->string('version_ds');
                $table->integer('edo_ds');
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
        //Schema::dropIfExists('data_systems');
    }
}
