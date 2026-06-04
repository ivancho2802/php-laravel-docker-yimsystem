<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('empres')) {
            Schema::create('empres', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('cod_empre');
                $table->string('rif_empre');
                $table->string('titular_rif_empre');
                $table->string('nom_empre');
                $table->string('contri_empre');
                $table->string('dir_empre');
                $table->string('tel_empre');
                $table->string('url_report');
                $table->string('retenIVA');
                $table->integer('est_empre');//'1 y 0',
    
                $table->unsignedBigInteger('fk_usuarios');
                $table->foreign('fk_usuarios')
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
        Schema::dropIfExists('empres');
    }
}
