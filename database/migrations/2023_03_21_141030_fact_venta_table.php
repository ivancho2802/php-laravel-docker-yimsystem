<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FactVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasTable('fact_ventas')) {

            Schema::create('fact_ventas', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('empre_cod_empre');
                $table->string('tipo_fact_venta');
                $table->string('tipo_pago');
                $table->string('tipo_contri');
                $table->integer('dias_venc')->nullable();
                $table->timestamp('fecha_fact_venta')->useCurrent();
                $table->string('num_fact_venta');
                $table->string('serie_fact_venta');
                $table->string('num_ctrl_factventa');
                $table->string('reg_maq_fis')->nullable();
                $table->string('num_repo_z')->nullable();
                $table->string('tipo_trans');

                $table->string('nplanilla_export')->nullable();
                $table->string('nexpe_export')->nullable();
                $table->string('naduana_export')->nullable();
                $table->timestamp('fechaduana_export')->nullable()->useCurrent();
                $table->string('num_compro_reten')->nullable();
                $table->timestamp('fecha_compro_reten')->nullable()->useCurrent();
                $table->decimal('m_iva_reten', 20, 4)->nullable();
                $table->string('mes_apli_reten')->nullable();
                $table->string('nfact_afectada')->nullable();

                $table->decimal('tot_iva', 20, 4);
                $table->decimal('msubt_exento_venta', 20, 4);
                $table->decimal('msubt_tot_bi_venta', 20, 4);
                $table->decimal('msubt_bi_iva_12', 20, 4);
                $table->decimal('msubt_bi_iva_8', 20, 4);
                $table->decimal('msubt_bi_iva_27', 20, 4);
                $table->decimal('mtot_iva_venta', 20, 4);
                $table->decimal('monto_paga', 20, 4)->nullable();
                
                $table->timestamps();

                $table->unsignedBigInteger('fk_cliente');
                $table->foreign('fk_cliente')
                    ->references('id')->on('clientes');

                $table->unsignedBigInteger('fk_usuariosV');
                $table->foreign('fk_usuariosV')
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
        Schema::dropIfExists('fact_ventas');
        //
    }
}
