<?php
	include_once('../../includes_SISTEM/include_head.php');
	include_once('../../includes_SISTEM/include_login.php');
	/*
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'index.php';
	echo $host."<br />".$uri."<br />".$extra;
	*/
?>
<div id="libroCompra" class="">
    <div class="row">
        <form method="POST"  action="libroCompra.php">
          <div class="form-group">
            <div class="col-xs-6 col-md-6 col-lg-6">
            	<h1 class="bd-title">Libro de Compras</h1>
                <label class="control-label">Consulta Por Mes</label>
                <div class="input-group">  
                  <input type="month" class="form-control" name="mes" value="<?php if(isset($_POST['mes']))echo $_POST['mes'];?>" required="required"/>
                  <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit" name="" value="">Buscar Compra!</button>
                  </span>
                </div>
            </div>
            <div class="col-lg-4"></div>
          </div>
        </form>
    </div>
</div>

<hr id="" class="featurette-divider"/>

<?php
if (isset($_POST['mes'])){
$mes = $_POST['mes'];

	$mesi = $mes."-01";
    if ($mes=='02') {
        $mesf = $mes."-28";
    } elseif ($mes%2==0) {
        $mesf =  $mes."-31";
    } elseif ($mes%2!==0) {
        $mesf = $mes."-30";
    }

    //  si el numero es divisible entre cero es par sino es impar 
    // si es impar tiene 31 el resto 30 menos febrero
	
	
	//consulta de la factura con sus datos relacionados
	//NOTA IMPORTANTE MUSTRSO TODAS LAS COMPRAAS MENOS LO DEL INVENTARIO INICIAL fact_compra.tipo_fact_compra !== 'II'
	$consulta=pg_query($conexion,sprintf("SELECT * FROM empre, fact_compra, proveedor WHERE
									empre.est_empre = '1' AND
									fact_compra.fk_proveedor = proveedor.rif AND
									fact_compra.tipo_fact_compra != 'II' AND
									fact_compra.fecha_fact_compra BETWEEN '%s' AND '%s'",
								$mesi, $mesf))or die(pg_last_error());
																				
																			
	$filas=pg_fetch_assoc($consulta);
    // $filas=pg_fetch_assoc($consulta);
	$total_consulta = pg_num_rows($consulta);
	
	//consulta de los datos de la empreas PARA SABE LA ACTIVA 
	$consultaEmpre = pg_query($conexion,"SELECT * FROM empre WHERE empre.est_empre = '1'");
	// $filasEmpre = pg_fetch_assoc($consultaEmpre);
    $filasEmpre = pg_fetch_assoc($consultaEmpre);
	$total_consultaEmpre = pg_num_rows($consultaEmpre);
																					
?>
<script>
$( document ).ready(function() {
	document.getElementById('res_libroCompra').style = "opacity: 0";
	hoverScrool('#btn_res_libroCompra',"res_libroCompra");
	
});
</script>
<script type="text/javascript" src="../../js/jquery-1.6.4.min.js">
$( document ).ready(function() {
	alert()
	$( "div.table-responsive" ).scrollTop( 300 );
});
</script>
<div id="res_libroCompra">
    <div class="row">
      <div id="btn_res_libroCompra" class="col-xs-12 col-lg-12" align="center">
        <button type="button" class="btn btn-sm btn-primary col-xs-12 col-lg-12 glyphicon glyphicon-chevron-up" onclick="hoverScrool('#btn_res_libroCompra','res_libroCompra');"></button>
      </div>
    </div>
    <div class="jumbotron">
    	<div class="container">
            <div><?php echo $filasEmpre['titular_rif_empre']." - ". $filasEmpre['nom_empre'];?></div>
            <div><?php echo $filasEmpre['rif_empre'];?></div>
            <div>Direcci&oacute;n: &nbsp;<?php echo $filasEmpre['dir_empre'];?></div>
            <div>Contribuyente <?php echo $filasEmpre['contri_empre'];?></div>
            <?php //funcion para convertir la fechaa mes en letras y ano?>
            <div>LIBRO DE COMPRAS CORRESPONDIENTE AL MES DE <?php echo mesNum_Texto($mes);?></div>
        </div>
    </div>
  <div class="table-desplazable">
  	<div class="table-responsive" id="table-responsive">
	  <table class="table table-hover table-bordered">
 		<thead>
		  <tr>
            <td colspan="18"></td>
            <th colspan="6">IMPORTACIONES</th>
            <th colspan="9">INTERNAS</th>
            <td colspan="2"><b></b></td>
            <!--<th colspan="3" rowspan="2"><b>ACCIONES</b></th>-->
		  </tr>
          <tr class="titulo">
            <th class="content-verticalText"><div class="verticalText">Nro. Operaciones</div></th>
            <td><b>Fecha del Documento</b></td>
            
            <td><b>N° R.I.F. &oacute; de Identidad</b></td>
            <td><b>Nombre &oacute; Raz&oacute;n Social</b></td>
            <th class="content-verticalText"><div class="verticalText">Tipo de Proveedor</div></th>
            
            <th><div class="verticalText"><p>Nro. de Comprobante <br>de Retenci&oacute;n</p></div></th>
            <td><b>Fecha de Aplicaci&oacute;n de Retenci&oacute;n</b></td>
            
            <th><div class="verticalText">Nro. de Planilla<br> de Importaci&oacute;n</div></th>
            <th><div class="verticalText">Nro. del Expediente<br> de Importaci&oacute;n</div></th>
            <th><div class="verticalText">Nro. de Declaraci&oacute;n<br> de Aduana</div></th>
            <td><b>Fecha de Declaraci&oacute;n de Aduana</b></td>
            
            <th><div class="verticalText">Serie del Documento</div></th>
            <td><b>Nro. del Documento</b></td>
            <td><b>Nro. de Control</b></td>
            <td><b>Nro. de Nota de Debito</b></td>
            <td><b>Nro. de Nota de Credito</b></td>
            <th><div class="verticalText">Tipo de Transacci&oacute;n</div></th><!--tipo Compra-->
            
            <td><b>Nro. de Documento <br>afectado</b></td>
            <!--IMPORTACIONES-->
            <th><div class="verticalText">Total de Importaciones <br> incluyendo el IVA</div></th>
            <th><div class="verticalText">Importaciones<br> Exentas /Exoneradas</div></th>
            <th><div class="verticalText">Total Base Imponible</div></th>
            <th><div class="verticalText">Subtotal B.I. al 12%</div></th>
            <th><div class="verticalText">Subtotal B.I. al 8%</div></th>
            <th><div class="verticalText">Subtotal B.I. al 27%</div></th>
            <!--INTERNAS-->
            <th><div class="verticalText">Total de Compra <br> internas incluyendo IVA</div></th>
            <th><div class="verticalText">Compras sin derecho <br>a credito IVA</div></th>
            <th><div class="verticalText">Compras Exentas</div></th>
            <th><div class="verticalText">Compras Exoneradas</div></th>
            <th><div class="verticalText">Compras no Sujetas</div></th>
            <th><div class="verticalText">Base Imponible</div></th>
            <th><div class="verticalText">Subtotal B.I. al 12%</div></th>
            <th><div class="verticalText">Subtotal B.I. al 8%</div></th>
            <th><div class="verticalText">Subtotal B.I. al 27%</div></th>
            <th><div class="verticalText">Impuesto IVA</div></th>
            <th><div class="verticalText">I.V.A. Retenido</div></th>
            <!--ACCIONES-->
          </tr>
        </thead>
        <tbody>
			 <?php 
            //$consulta esta arriba
            //acumulador
            $acum_msubt_exento_compra = 0;
            
            $acum_msubt_bi_iva_12_inter = 0;
            $acum_msubt_bi_iva_8_inter = 0;
            $acum_msubt_bi_iva_27_inter = 0;
            
            $acum_msubt_bi_iva_12_import = 0;
            $acum_msubt_bi_iva_8_import = 0;
            $acum_msubt_bi_iva_27_import = 0;
            
            $acum_mtot_iva_compra_import = 0;
            $acum_msubt_exento_compra_import = 0;
            $acum_msubt_tot_bi_compra_import = 0;
            
            $acum_mtot_iva_compra_inter = 	0;
            
            $acum_IN_SDCF_compra_inter  =	0;
            $acum_IN_EX_compra_inter = 		0;
            $acum_IN_EXO_compra_inter  =	0;  
            $acum_IN_NS_compra_inter  = 	0;
            $acum_msubt_tot_bi_compra_inter = 	0;
            
            $acum_msubt_bi_iva_12_inter = 		0;
            $acum_msubt_bi_iva_8_inter = 		0;
            $acum_msubt_bi_iva_27_inter = 		0;
            
            $acum_m_iva_reten = 0;
            $acum_tot_iva = 0;
            //contador de filas
            $nop = 1;
            if(!is_null($filas['id_fact_compra']))
            do{
                //CONSULTAS RELACIONALES
                //consulta las notas si existen 
                $consultaNota = pg_query($conexion,sprintf("SELECT * FROM notas_cd, fact_compra WHERE 
								fact_compra.id_fact_compra = notas_cd.id_fact_compra AND
								notas_cd.id_fact_compra = '%s'",is_null($filas['id_fact_compra'])?'':$filas['id_fact_compra']));
                // $filasConsultaNota = $consultaNota->fetch_assoc();
                $filasConsultaNota = pg_fetch_assoc($consultaNota);
                $total_ConsultaNota = pg_num_rows($consultaNota);
                /////		FACTURA TOTALES IMPORTACIONES
                if(!is_null($filas['nplanilla_import'])){
                    $mtot_iva_compra_import = round($filas['mtot_iva_compra'],2);
                    $msubt_exento_compra_import = round($filas['msubt_exento_compra'],2);
                    $msubt_tot_bi_compra_import = round($filas['msubt_tot_bi_compra'],2);
                    $msubt_bi_iva_12_import = round($filas['msubt_bi_iva_12'],2);
                    $msubt_bi_iva_8_import = round($filas['msubt_bi_iva_8'],2);
                    $msubt_bi_iva_27_import = round($filas['msubt_bi_iva_27'],2);
                    /////////////////////////////////////////////7
                    $mtot_iva_compra_inter = 0;
                    $msubt_tot_bi_compra_inter = 0;
                    $msubt_bi_iva_12_inter = 0;
                    $msubt_bi_iva_8_inter = 0;
                    $msubt_bi_iva_27_inter = 0;
                    //ACUMULADORES
                    
                    $acum_mtot_iva_compra_import = $acum_mtot_iva_compra_import + $mtot_iva_compra_import;
                    $acum_msubt_exento_compra_import = $acum_msubt_exento_compra_import + $msubt_exento_compra_import;
                    $acum_msubt_tot_bi_compra_import = $acum_msubt_tot_bi_compra_import + $msubt_tot_bi_compra_import;
                    
                    $acum_msubt_bi_iva_12_import = $acum_msubt_bi_iva_12_import + $msubt_bi_iva_12_import;
                    $acum_msubt_bi_iva_8_import =  $acum_msubt_bi_iva_8_import + $msubt_bi_iva_8_import;
                    $acum_msubt_bi_iva_27_import = $acum_msubt_bi_iva_27_import + $msubt_bi_iva_27_import;
                /////		FACTURA TOTALES INTERNAS	
                }elseif($filas['nplanilla_import'] == ""){
                    $mtot_iva_compra_import = 0;
                    $msubt_exento_compra_import = 0;
                    $msubt_tot_bi_compra_import = 0;
                    $msubt_bi_iva_12_import = 0;
                    $msubt_bi_iva_8_import = 0;
                    $msubt_bi_iva_27_import = 0;
                    //////////////////////////////////////////7
                    $mtot_iva_compra_inter = round($filas['mtot_iva_compra'],2);
                        //las excentas ya estan hechas por una funcion ya que estas son desglozadas
                    $msubt_tot_bi_compra_inter = round($filas['msubt_tot_bi_compra'],2);
                    $msubt_bi_iva_12_inter = round($filas['msubt_bi_iva_12'],2);
                    $msubt_bi_iva_8_inter = round($filas['msubt_bi_iva_8'],2);
                    $msubt_bi_iva_27_inter = round($filas['msubt_bi_iva_27'],2);
                    //ACUMULADORES
                    $acum_mtot_iva_compra_inter = 	$acum_mtot_iva_compra_inter + $mtot_iva_compra_inter;
                    $acum_IN_SDCF_compra_inter  =	$acum_IN_SDCF_compra_inter + sumSinIVA($filas['id_fact_compra'], 'IN_SDCF');
                    $acum_IN_EX_compra_inter = 		$acum_IN_EX_compra_inter + sumSinIVA($filas['id_fact_compra'], 'IN_EX');
                    $acum_IN_EXO_compra_inter  =	$acum_IN_EXO_compra_inter + sumSinIVA($filas['id_fact_compra'], 'IN_EXO');  
                    $acum_IN_NS_compra_inter  = 	$acum_IN_NS_compra_inter + sumSinIVA($filas['id_fact_compra'], 'IN_NS');
                    $acum_msubt_tot_bi_compra_inter = 	$acum_msubt_tot_bi_compra_inter + $msubt_tot_bi_compra_inter;
                    
                    $acum_msubt_bi_iva_12_inter = 		$acum_msubt_bi_iva_12_inter + $msubt_bi_iva_12_inter;
                    $acum_msubt_bi_iva_8_inter = 		$acum_msubt_bi_iva_8_inter + $msubt_bi_iva_8_inter;
                    $acum_msubt_bi_iva_27_inter = 		$acum_msubt_bi_iva_27_inter + $msubt_bi_iva_27_inter;
                }
                $acum_msubt_exento_compra = $acum_msubt_exento_compra + round($filas['msubt_exento_compra']?$filas['msubt_exento_compra']:0,2);
                $acum_m_iva_reten = $acum_m_iva_reten + round($filas['m_iva_reten'],2);
                
                $acum_tot_iva = $acum_tot_iva + round($filas['tot_iva'],2);
            ?>
          <tr>
            <!--Numero de Operqciones-->
            <td><?php echo $nop++;?></td>
            <!--FACTURA-->
            <td><?php echo fechaInver($filas['fecha_fact_compra']) ?></td>
            <!--PROVEEDOR-->
            <td><?php echo $filas['rif'] ?></td>
            <td><?php echo $filas['nombre']; if($total_consulta <= 0)echo "*** Sin Actividad Comercial ***";?></td>
            <td><?php if($total_consulta > 0)echo condRif($filas['rif'])?></td><!--TIPO DE PROVEEDOR-->
            <!--FACTURA RETENCION-->
            <td><?php if($filas['num_compro_reten'] !="")echo $filas['num_compro_reten']; else echo "-"; ?></td>
            <td><?php echo fechaInver($filas['fecha_compro_reten'])?></td>
            <!--FACTURA IMPORTACION-->
            <td><?php echo $filas['nplanilla_import'] ?></td>
            <td><?php echo $filas['nexpe_import'] ?></td>
            <td><?php echo $filas['naduana_import'] ?></td>
            <td><?php echo fechaInver($filas['fechaduana_import']) ?></td>
            <!--FACTURA-->
            <td><?php echo $filas['serie_fact_compra'] ?></td>
            <td><?php echo $filas['num_fact_compra'] ?></td>
            <td><?php echo $filas['num_ctrl_factcompra']?></td>
            <!--FACTURA NOTA-->
            <td class="conter_table_nadatd">
                <table class="table_nada">
                <?php if($total_consulta > 0)
                        { 
                            do{
                                if($filasConsultaNota['tipo_notas_cd'] == 'NC')
                                echo "<tr><td>".$filasConsultaNota['num_notas_cd']."</td></tr>";
                            // }while($filasConsultaNota = $consultaNota->fetch_assoc());
                            }while($filasConsultaNota = pg_fetch_assoc($consultaNota));
                        }
                ?>
                </table>
            </td>
            <td>
                <table class="table_nada">
                <?php if($total_consulta > 0)
                        { 
                            do{
                                if($filasConsultaNota['tipo_notas_cd'] == 'ND')
                                echo "<tr><td>".$filasConsultaNota['num_notas_cd']."</td></tr>";
                            // }while($filasConsultaNota = $consultaNota->fetch_assoc());
                            }while($filasConsultaNota = pg_fetch_assoc($consultaNota));
                        }
                ?>
                </table>
            </td>
            <!--FACTURA RETENCION QUE Y A QUIEN-->
            <td><?php echo $filas['tipo_trans']?></td>
            <td><?php echo $filas['nfact_afectada']?></td>
            <!--FACTURA TOTALES IMPORTACIONES-->
            <td><?php echo $mtot_iva_compra_import;?></td>
            <td><?php echo $msubt_exento_compra_import;?></td>
            <td><?php echo $msubt_tot_bi_compra_import;?></td>
            <td><?php echo $msubt_bi_iva_12_import;?></td>
            <td><?php echo $msubt_bi_iva_8_import;?></td>
            <td><?php echo $msubt_bi_iva_27_import;?></td>
            <!--FACTURA TOTALES INTERNAS-->
            <td><?php echo $mtot_iva_compra_inter?></td>
            <td><?php echo sumSinIVA($filas['id_fact_compra'], 'IN_SDCF') ?></td>
            <td><?php echo sumSinIVA($filas['id_fact_compra'], 'IN_EX') ?></td>
            <td><?php echo sumSinIVA($filas['id_fact_compra'], 'IN_EXO') ?></td>
            <td><?php echo sumSinIVA($filas['id_fact_compra'], 'IN_NS')?></td>
            
            <td><?php echo $msubt_tot_bi_compra_inter;?></td>
            <td><?php echo $msubt_bi_iva_12_inter;?></td>
            <td><?php echo $msubt_bi_iva_8_inter;?></td>
            <td><?php echo $msubt_bi_iva_27_inter;?></td>
            <!--monto total de impuesto IVA-->
            <td><?php echo round($filas['tot_iva'],2)?></td>
            <!--FACTURA TOTALES DE RETENCIONES-->
            <td><?php echo round($filas['m_iva_reten'],2)?></td>
            <!--
            <td>
            <?php /*
            $id = $filas['id_fact_compra'];
            echo "<a href='modificarCompra.php?id=$id' target='principal'>Actualizar</a>";
            ?>
            </td>
            <td>
            <?php 
              echo "<a onclick='confirmDel();' href='borrarCompra.php?id=$id' target='principal'>Eliminar</a>";
            ?>
            </td>
            <td>
            <?php 
              echo "<a href='hacerDevolucion.php?id=$id' target='principal'>Devolver</a>";
            */?>
            </td>
            -->
          </tr>
          <?php
          ///	area de acumulaciones
                    
          // }while($filas=pg_fetch_assoc($consulta));
          }while($filas=pg_fetch_assoc($consulta));
          ?>
          <tr>
            <td colspan="18">Totales</td>
            <!-- IMPORTACIONES -->
            <td><?php echo $acum_mtot_iva_compra_import; ?></td><!-- TOTAL DE IMPORTACIONEES INCLUYENDO EL IVA-->
            <td><?php echo $acum_msubt_exento_compra_import; ?></td><!--TOTAL DE IMPORTACIONES EXENTAS O EXONERADAS	 -->
            <td><?php echo $acum_msubt_tot_bi_compra_import; ?></td><!--TOTALES DE LAS BASES IMPONIBLES -->
            <td><?php echo $acum_msubt_bi_iva_12_import; ?></td><!--TOTAL BI 12 IMPORT -->
            <td><?php echo $acum_msubt_bi_iva_8_import; ?></td><!--TOTAL BI 8 IMPORT -->
            <td><?php echo $acum_msubt_bi_iva_27_import; ?></td><!--TOTAL BI 27 IMPORT -->
            <!-- INTERNAS -->
            <td><?php echo $acum_mtot_iva_compra_inter; ?></td><!--total compras incluyendo el iva --> 
            <td><?php echo $acum_IN_SDCF_compra_inter; ?></td><!--TOTAL DE IMPORTACIONES EXENTAS O EXONERADAS	 -->
            <td><?php echo $acum_IN_EX_compra_inter; ?></td><!--TOTALES DE LAS BASES IMPONIBLES -->
            <td><?php echo $acum_IN_EXO_compra_inter; ?></td><!--TOTAL BI 12 IMPORT --> 
            <td><?php echo $acum_IN_NS_compra_inter; ?></td><!--TOTAL BI 8 IMPORT --> 
            <td><?php echo $acum_msubt_tot_bi_compra_inter; ?></td><!--TOTAL BI 27 IMPORT -->
            <td><?php echo $acum_msubt_bi_iva_12_inter; ?></td><!--TOTAL BI 27 IMPORT -->
            <td><?php echo $acum_msubt_bi_iva_8_inter; ?></td><!--TOTAL BI 27 IMPORT -->
            <td><?php echo $acum_msubt_bi_iva_27_inter; ?></td><!--TOTAL BI 27 IMPORT -->
            <td><?php echo $acum_tot_iva; ?></td><!--TOTAL BI 27 IMPORT -->
            <td><?php echo $acum_m_iva_reten; ?></td><!--TOTAL BI 27 IMPORT --> 
          </tr>
		</tbody>
	  </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <!--RESUMEN DE LA COMPRA-->
    <table class="table  table-hover">
      <thead align="center">
        <tr class="titulo">
            <td colspan="5">RESUMEN DE COMPRAS DEl MES DE <?php echo mesNum_Texto($mes);?></td>
        </tr>
        <tr class="titulo">
            <td rowspan="2">Descripci&oacute;n</td>
            <td colspan="2">Base Imponible</td>
            <td colspan="2">Credito Fiscal</td>
        </tr>
        <tr>
            <td>Item</td>
            <td>Monto</td>
            <td>Item</td>
            <td>Monto</td>
        </tr>
      </thead> 
      <tbody>
        <tr>
            <td>Compras no Gravadas y/o sin Derecho a Credito Fiscal</td>
            <td>30</td>
            <td><?php echo $acum_msubt_exento_compra; ?></td>
            <td>-</td>
            <td>-</td>
        </tr> 
        <tr>
            <td>Importaciones Gravadas por Alicuata General 12%</td>
            <td>31</td>
            <td><?php echo $acum_msubt_bi_iva_12_import;?>
            </td>
            <td>32</td>
            <td><?php echo $iva_12_import = $acum_msubt_bi_iva_12_import * 0.12;?></td>
        </tr> 
        <tr>
            <td>Importaciones Gravadas por Alicuata General mas Adicional 27%</td>
            <td>312</td>
            <td><?php echo $acum_msubt_bi_iva_27_import;?>
            </td>
            <td>322</td>
            <td><?php echo $iva_27_import = $acum_msubt_bi_iva_27_import * 0.27;?></td>
        </tr> 
        <tr>
            <td>Importaciones Gravadas por Alicuata Reducida 8%</td>
            <td>313</td>
            <td><?php echo $acum_msubt_bi_iva_8_import;?>
            </td>
            <td>323</td>
            <td><?php echo $iva_8_import = $acum_msubt_bi_iva_8_import * 0.08;?></td>
        </tr> 
        <tr>
            <td>Compras Internas Gravadas por Alicuota General 12%</td>
            <td>33</td>
            <td><?php echo $acum_msubt_bi_iva_12_inter;?>
            </td>
            <td>34</td>
            <td><?php echo $iva_12_inter = $acum_msubt_bi_iva_12_inter * 0.12;?></td>
        </tr> 
        <tr>
            <td>Compras Internas Gravadas por Alicuota General mas Alicuota Adicional 27%</td>
            <td>332</td>
            <td><?php echo $acum_msubt_bi_iva_27_inter;?></td>
            <td>342</td>
            <td><?php echo $iva_27_inter = $acum_msubt_bi_iva_27_inter * 0.27;?></td>
        </tr> 
        <tr>
            <td>Compras Internas Gravadas por Alicuota Reducida 8%</td>
            <td>333</td>
            <td><?php echo $acum_msubt_bi_iva_8_inter;?></td>
            <td>343</td>
            <td><?php echo $iva_8_inter = $acum_msubt_bi_iva_8_inter * 0.08;?></td>
        </tr> 
        <tr>
            <td><b>Total Compras y Creditos Fiscales del Periodo:</b></td>
            <td>38</td>
            <td><?php echo 	$acum_msubt_exento_compra + $acum_msubt_bi_iva_12_import + $acum_msubt_bi_iva_27_import + 
                            $acum_msubt_bi_iva_8_import + $acum_msubt_bi_iva_12_inter + $acum_msubt_bi_iva_27_inter + 
                            $acum_msubt_bi_iva_8_inter;?></td>
            <td>36</td>
            <td><?php echo $iva_12_import + $iva_27_import + $iva_8_import + $iva_12_inter + $iva_27_inter + $iva_8_inter;?></td>
        </tr>    
      </tbody>  
    </table>
    <div style="float:right">
    <br />
    <br /><br />
    <table class="table  table-hover" >
        <thead>
            <tr><td width="70px" class="titulo"><b style="text-align:center">I.V.A. Retenido por el Vendedor</b></td></tr>
        </thead>
        <tbody>
            <tr><td><?php echo $acum_m_iva_reten;?></td></tr>
        </tbody>
    </table>
    </div>  
  
</div><!--desplegable-->
<div class="row">
	<div class="col-xs-12 col-lg-12">
        <div class="input-group">
            <form class="" target="_blank" name="form1" method="post" action="../reporte_pdf_compra.php">
            <button class="form-control btn btn-sm btn-danger" type="submit" name = "mes" value="<?php echo $mes;?>">
                <span class="fa fa-file-pdf-o" title="pdf"></span>
            </button>
            </form>
            <div class="input-group-addon">&amp;</div>
            <form class="" target="_blank" name="form1" method="post" action="../res_reporte/reporte_excel_compra.php">
            <button class="form-control btn btn-sm btn-success" type="submit" name = "mes" value="<?php echo $mes;?>">
                <span class="fa fa-file-excel-o" title="EXCEL"></span>
            </button>
            </form>
        </div><!--input-group-->
	</div><!--col-->
</div><!--row-->
</div><!--responsive-->

</div><!--CONTAINER-->
<br />
<br />
<div class="container">
	
</div>
<?php }?>