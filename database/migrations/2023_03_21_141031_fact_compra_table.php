<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FactCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasTable('fact_compras')) {

            Schema::create('fact_compras', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('num_fact_compra');
                $table->string('tipo_fact_compra');
                $table->string('empre_cod_empre');
                $table->string('serie_fact_compra');
                $table->string('num_ctrl_factcompra');
                $table->timestamp('fecha_fact_compra')->useCurrent();
                $table->timestamp('fecha_fact_compra_reg')->useCurrent();
                $table->time('hora_fact_compra');
                $table->string('tipo_trans');

                $table->string('nplanilla_import')->nullable();
                $table->string('nexpe_import')->nullable();
                $table->string('naduana_import')->nullable();
                $table->timestamp('fechaduana_import')->useCurrent()->nullable();
                $table->string('num_compro_reten')->nullable();
                $table->timestamp('fecha_compro_reten')->useCurrent()->nullable();
                $table->decimal('m_iva_reten', 20, 4)->nullable()->default(0);
                $table->string('mes_apli_reten')->nullable();
                $table->string('nfact_afectada')->nullable();

                $table->decimal('mtot_iva_compra', 20, 4)->default(0);
                $table->decimal('tot_iva', 20, 4)->default(0);
                $table->decimal('msubt_exento_compra', 20, 4)->default(0);
                $table->decimal('msubt_tot_bi_compra', 20, 4)->default(0);
                $table->decimal('msubt_bi_iva_12', 20, 4)->default(0);
                $table->decimal('msubt_bi_iva_8', 20, 4)->default(0);
                $table->decimal('msubt_bi_iva_27', 20, 4)->default(0);

                $table->timestamps();

                $table->unsignedBigInteger('fk_proveedor');
                $table->foreign('fk_proveedor')
                    ->references('id')->on('proveedors');

                $table->unsignedBigInteger('fk_usuariosc');
                $table->foreign('fk_usuariosc')
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
        //
        Schema::dropIfExists('fact_compras');
    }
}
