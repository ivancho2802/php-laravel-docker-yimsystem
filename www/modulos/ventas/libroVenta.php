<?php
	include_once('../../includes_SISTEM/include_head.php');
	include_once('../../includes_SISTEM/include_login.php');
?>
<div id="libroVenta" class="">
    <div class="row">
        <form method="POST"  action="libroVenta.php">
          <div class="form-group">
            <div class="col-xs-6 col-md-6 col-lg-6">
            	<h1 class="bd-title">Libro de Ventas</h1>
                <label class="control-label">Consulta Por Mes</label>
                <div class="input-group">  
                  <input type="month" class="form-control" name="mes" value="<?php if(isset($_POST['mes']))echo $_POST['mes'];?>" required="required"/>
                  <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit" name="" value="">Buscar Venta!</button>
                  </span>
                </div>
            </div>
            <div class="col-lg-4"></div>
          </div>
        </form>
    </div>
</div><!--container-->
<hr id="res_libroVenta" class="featurette-divider"/>
<?php
if (isset($_POST['mes'])){
$mes = $_POST['mes'];

	$mesi = $mes."-01";
	$mesf = $mes=='02' ?
            $mes."-28":
          ($mes%2==0 ? $mes."-31" : $mes."-30");
	
	//consulta de los datos de la empreas PARA SABE LA ACTIVA 
	$consultaEmpre = pg_query($conexion,"SELECT * FROM empre WHERE empre.est_empre = '1'");
	$filasEmpre = pg_fetch_assoc($consultaEmpre);
	$total_consultaEmpre = pg_num_rows($consultaEmpre);
	
	//consulta de la factura con sus datos relacionados
	$consulta=pg_query($conexion,sprintf("SELECT * FROM empre, fact_venta, cliente WHERE
	  																			fact_venta.empre_cod_empre = empre.cod_empre AND
																				empre.cod_empre = '%s' AND
																				fact_venta.fk_cliente = cliente.ced_cliente AND
																				fact_venta.fecha_fact_venta BETWEEN '%s' AND '%s'",
																				$filasEmpre['cod_empre'], $mesi, $mesf));
	$filas=pg_fetch_assoc($consulta);
	$total_consulta = pg_num_rows($consulta);
	
	
																					
?>
<script>
	$( document ).ready(function() {
		hoverScrool('btn-res_libroVenta');
	});
</script>
<div class="">
    <div class="row">
      <div id="btn-res_libroVenta" class="col-xs-12 col-lg-12" align="center">
        <button type="button" class="btn btn-sm btn-primary col-xs-12 col-lg-12 glyphicon glyphicon-chevron-up" onclick="hoverScrool('#libroVenta')"></button>
      </div>
    </div>
    <div class="jumbotron">
      <div class="container">
		<div><?php echo $filasEmpre['titular_rif_empre']." - ". $filasEmpre['nom_empre'];?></div>
		<div><?php echo $filasEmpre['rif_empre'];?></div>
    	<div>Direcci&oacute;n: &nbsp;<?php echo $filasEmpre['dir_empre'];?></div>
        <div>Contribuyente <?php echo $filasEmpre['contri_empre'];?></div>
        <div>LIBRO DE VENTAS CORRESPONDIENTE AL MES DE <?php echo mesNum_Texto($mes);?></div><!--fechaa mes en letras y ano-->
      </div>
    </div>

    <div class="table-desplazable">
        <div class="table-responsive">
         <table class="table table-bordered table-hover">
         <thead  align="center">
          <tr>
            <td colspan="20" rowspan="2"></td>
            <th colspan="1" rowspan="2">EXPORTACIONES</th>
            <th colspan="11">NACIONALES</th>
            <td colspan="2" rowspan="2"><b></b></td>
            <th colspan="4" rowspan="2">ACCIONES</th>
            
          </tr>
          <tr class="titulo">
            <th colspan="5">&nbsp;</th>
            <th colspan="3" >Contribuyente</th>
            <th colspan="3">No Contribuyente</th>
          </tr>
          <tr class="titulo">
            <th class="content-verticalText"><div class="verticalText">Nro. Operaci&oacute;n</div></th>
            <td><b>Fecha del Documento</b></td>
            
            <td><b>N&deg; R.I.F. &oacute; de Identidad</b></td>
            <td><b>Nombre &oacute; Raz&oacute;n Social</b></td>
            <th><div class="verticalText">Tipo de Cliente</div></th>
            
            <th><div class="verticalText">Nro. de Planilla<br> de Exportaci&oacute;n</div></th>
            <th><div class="verticalText">Nro. del Expediente<br> de Exportaci&oacute;n</div></th>
            <th><div class="verticalText">Nro. de Declaraci&oacute;n<br> de Aduana</div></th>
            <td><b>Fecha de Declaraci&oacute;n de Aduana</b></td>
            
            <th><div class="verticalText">Serie del Documento</div></th>
            <td><b>Nro. del Documento</b></td>
            <td><b>Nro. de Control</b></td>
            <td><b>Registro de Maquina Fiscal</b></td>
            <td><b>Nro. de Reporte Z</b></td>
            <td><b>Nro. de Nota de Debito</b></td>
            <td><b>Nro. de Nota de Credito</b></td>
            <th><div class="verticalText">Tipo de<br /> Transacci&oacute;n</div></th><!--tipo Venta-->
            
            <th><div class="verticalText">Nro. de Comprobante <br>de Retenci&oacute;n</div></th>
            <td><b>Fecha de Aplicaci&oacute;n de Retenci&oacute;n</b></td>
            
            <td><b>Nro. de Documento <br>afectado</b></td>
            <!--EXPORTACIONES-->
            <th><div class="verticalText">Ventas Exportacion<br> Exentas /Exoneradas</div></th>
            <!--nacional-->
            <th><div class="verticalText">Total de Venta <br> Nacional incluyendo<br> el IVA</div></th>
            <th><div class="verticalText">Ventas sin derecho <br>a credito IVA</div></th>
            <th><div class="verticalText">Ventas Exentas</div></th>
            <th><div class="verticalText">Ventas Exoneradas</div></th>
            <th><div class="verticalText">Ventas no Sujetas</div></th>
            <th><div class="verticalText">Subtotal B.I. al 12%</div></th>
            <th><div class="verticalText">Subtotal B.I. al 8%</div></th>
            <th><div class="verticalText">Subtotal B.I. al 27%</div></th>
            
            <th><div class="verticalText">Subtotal B.I. al 12%</div></th>
            <th><div class="verticalText">Subtotal B.I. al 8%</div></th>
            <th><div class="verticalText">Subtotal B.I. al 27%</div></th>
            <th><div class="verticalText">Impuesto IVA</div></th>
            <th><div class="verticalText">IVA Retenido</div></th>
            
            <!--ACCIONES-->
            <th colspan="3"><div>&nbsp;</div></th>
            <th><div>Ver Factura</div></th>
          </tr>
        </thead>
        <tbody>
             <?php 
            //$consulta esta arriba
              //acumulador
            $acum_msubt_exento_venta = 0;
            
            $acum_msubt_bi_iva_12_n = 0;
            $acum_msubt_bi_iva_8_n = 0;
            $acum_msubt_bi_iva_27_n = 0;
            
            $acum_msubt_bi_iva_12_n_CONTRI = 0;
            $acum_msubt_bi_iva_8_n_CONTRI = 0;
            $acum_msubt_bi_iva_27_n_CONTRI = 0;
            
            $acum_msubt_bi_iva_12_n_NO_CONTRI = 0;
            $acum_msubt_bi_iva_8_n_NO_CONTRI = 0;
            $acum_msubt_bi_iva_27_n_NO_CONTRI = 0;
        
            $acum_mtot_iva_venta_n = 	0;
            $acum_IN_SDCF_venta_n  =	0;
            $acum_IN_EX_venta_n = 		0;
            $acum_IN_EXO_venta_n  =	0;  
            $acum_IN_NS_venta_n  = 	0;
            
            $acum_msubt_exento_venta_export = 0;
            
            $acum_m_iva_reten = 0;
            $acum_tot_iva = 0;
            //contador de filas
            $nop = 1;
            do{
                    //CONSULTAS RELACIONALES
                        //consulta las notas si existen 
                        $consulta2 = pg_query($conexion,sprintf("SELECT * FROM notas_cd_venta, fact_venta WHERE fact_venta.id_fact_venta = notas_cd_venta.id_fact_venta AND notas_cd_venta.id_fact_venta = '%s'",$filas['id_fact_venta']));
                        // $filasConsultaNota = $filas2=pg_fetch_assoc($consulta2);
                        $filas2=pg_fetch_assoc($consulta2);
                        $total_ConsultaNota = pg_num_rows($consulta2);
                        /////		FACTURA TOTALES EXPORTACIONES
                    if($filas['nplanilla_export'] !== ""){
                        $msubt_exento_venta_export = round($filas['mtot_iva_venta'],2);
                        /////////////////////////////////////////////
                        $mtot_iva_venta_n = 0;
                        $msubt_tot_bi_venta_n = 0;
                        $msubt_bi_iva_12_n = 0;
                        $msubt_bi_iva_8_n = 0;
                        $msubt_bi_iva_27_n = 0;
                        //ACUMULADORES
                        $acum_msubt_exento_venta_export = $acum_msubt_exento_venta_export + round($filas['msubt_exento_venta'],2);
                        $acum_msubt_bi_iva_12_n = 0;
                        $acum_msubt_bi_iva_8_n = 0;
                        $acum_msubt_bi_iva_27_n = 0;
                    /////		FACTURA TOTALES EXPORTACIONES	
                    }elseif($filas['nplanilla_export'] == ""){
                        $msubt_exento_venta_export = 0;
                        $acum_msubt_exento_venta_export = 0;
                        //////////////////////////////////////////7
                        $mtot_iva_venta_n = round($filas['mtot_iva_venta'],2);
                            //las excentas ya estan hechas por una funcion ya que estas son desglozadas
                        $msubt_tot_bi_venta_n = round($filas['msubt_tot_bi_venta'],2);
                        $msubt_bi_iva_12_n = round($filas['msubt_bi_iva_12'],2);
                        $msubt_bi_iva_8_n = round($filas['msubt_bi_iva_8'],2);
                        $msubt_bi_iva_27_n = round($filas['msubt_bi_iva_27'],2);
                        //ACUMULADORES
                        if($filas['tipo_contri'] !== "NO_CONTRI"){
                            $acum_msubt_bi_iva_12_n_NO_CONTRI = $acum_msubt_bi_iva_12_n + round($filas['msubt_bi_iva_12'],2);
                            $acum_msubt_bi_iva_8_n_NO_CONTRI = $acum_msubt_bi_iva_8_n + round($filas['msubt_bi_iva_8'],2);
                            $acum_msubt_bi_iva_27_n_NO_CONTRI = $acum_msubt_bi_iva_27_n + round($filas['msubt_bi_iva_27'],2);
                        }elseif($filas['tipo_contri'] == "NO_CONTRI"){
                            $acum_msubt_bi_iva_12_n_CONTRI = $acum_msubt_bi_iva_12_n + round($filas['msubt_bi_iva_12'],2);
                            $acum_msubt_bi_iva_8_n_CONTRI = $acum_msubt_bi_iva_8_n + round($filas['msubt_bi_iva_8'],2);
                            $acum_msubt_bi_iva_27_n_CONTRI = $acum_msubt_bi_iva_27_n + round($filas['msubt_bi_iva_27'],2);
                        }
                            $acum_msubt_bi_iva_12_n = $acum_msubt_bi_iva_12_n + round($filas['msubt_bi_iva_12'],2);
                            $acum_msubt_bi_iva_8_n = $acum_msubt_bi_iva_8_n + round($filas['msubt_bi_iva_8'],2);
                            $acum_msubt_bi_iva_27_n = $acum_msubt_bi_iva_27_n + round($filas['msubt_bi_iva_27'],2);
                        
                        $acum_msubt_exento_venta_export = $acum_msubt_exento_venta_export + round($filas['msubt_exento_venta'],2);
                        
                        $acum_mtot_iva_venta_n = 	$acum_mtot_iva_venta_n + round($filas['mtot_iva_venta'],2);
                        $acum_IN_SDCF_venta_n  =	$acum_IN_SDCF_venta_n + sumSinIVAventas($filas['id_fact_venta'], 'IN_SDCF');
                        $acum_IN_EX_venta_n = 		$acum_IN_EX_venta_n + sumSinIVAventas($filas['id_fact_venta'], 'IN_EX');
                        $acum_IN_EXO_venta_n  =	$acum_IN_EXO_venta_n +  sumSinIVAventas($filas['id_fact_venta'], 'IN_EXO');
                        $acum_IN_NS_venta_n  = 	$acum_IN_NS_venta_n + sumSinIVAventas($filas['id_fact_venta'], 'IN_NS');
                    }
                    $acum_msubt_exento_venta = $acum_msubt_exento_venta + round($filas['msubt_exento_venta'],2);
                    $acum_m_iva_reten = $acum_m_iva_reten + round($filas['m_iva_reten'],2);
                    $acum_tot_iva = $acum_tot_iva + round($filas['tot_iva'],2);
            ?>
          <tr>
            <!--Numero de Operqciones-->
            <td><?php echo $nop++;?></td>
            <!--FACTURA-->
            <td><?php echo fechaInver($filas['fecha_fact_venta']) ?></td>
            <!--cliente-->
            <td><?php echo $filas['ced_cliente'] ?></td>
            <td><?php echo $filas['nom_cliente']; if($total_consulta <= 0)echo "*** Sin Actividad Comercial ***";?></td>
            <td><?php if($total_consulta > 0)
                        echo condRif($filas['ced_cliente']);?></td><!--TIPO DE cliente-->
        
            <!--FACTURA EXPORTACIPONES-->
            <td><?php echo $filas['nplanilla_export'] ?></td>
            <td><?php echo $filas['nexpe_export'] ?></td>
            <td><?php echo $filas['naduana_export'] ?></td>
            <td><?php echo fechaInver($filas['fechaduana_export']) ?></td>
            <!--FACTURA-->
            <td><?php echo $filas['serie_fact_venta'] ?></td>
            <td><?php echo $filas['num_fact_venta'] ?></td>
            <td><?php echo $filas['num_ctrl_factventa']?></td>
            <!--registro z-->
            <td><?php echo $filas['reg_maq_fis']?></td>
            <td><?php echo $filas['num_repo_z']?></td>
            <!--FACTURA NOTA-->
            <td class="conter_table_nadatd">
                <table class="table_nada">
                <?php if($total_consulta > 0)
                        { 
                            do{
                                if($filas2['tipo_notas_cd_venta'] == 'NC')
                                echo "<tr><td>".$filas2['num_notas_cd_venta']."</td></tr>";
                            }while($filas2 = $filas2=pg_fetch_assoc($consulta2));
                        }
                ?>
                </table>
            </td>
            <td>
                <table class="table_nada">
                <?php if($total_consulta > 0)
                        { 
                            do{
                                if($filas2['tipo_notas_cd_venta'] == 'ND')
                                echo "<tr><td>".$filas2['num_notas_cd_venta']."</td></tr>";
                            }while($filas2 = $filas2=pg_fetch_assoc($consulta2));
                        }
                ?>
                </table>
            </td>
            <!---->
            <td><?php echo $filas['tipo_trans']?></td>
            <!--FACTURA RETENCION-->
            <td><?php if($filas['num_compro_reten'] !="")echo $filas['num_compro_reten']; else echo "-";?></td>
            <td><?php echo fechaInver($filas['fecha_compro_reten'])?></td>
            <!--NOTAS DEBEITO CREDITO-->
            <td><?php echo $filas['nfact_afectada']?></td>
            <!--FACTURA TOTALES Exportacion-->
            <td><?php echo $msubt_exento_venta_export;?></td>
            <!--FACTURA TOTALES nacional-->
            <td><?php echo $mtot_iva_venta_n;?></td>
            <td><?php echo sumSinIVAventas($filas['id_fact_venta'], 'IN_SDCF') ?></td>
            <td><?php echo sumSinIVAventas($filas['id_fact_venta'], 'IN_EX') ?></td>
            <td><?php echo sumSinIVAventas($filas['id_fact_venta'], 'IN_EXO') ?></td>
            <td><?php echo sumSinIVAventas($filas['id_fact_venta'], 'IN_NS')?></td>
            
            <td><?php if($filas['tipo_contri'] !== "NO_CONTRI")echo round($filas['msubt_bi_iva_12'],2); else echo 0;?></td>
            <td><?php if($filas['tipo_contri'] !== "NO_CONTRI")echo round($filas['msubt_bi_iva_8'],2); else echo 0;?></td>
            <td><?php if($filas['tipo_contri'] !== "NO_CONTRI")echo round($filas['msubt_bi_iva_27'],2); else echo 0;?></td>
            
            <td><?php if($filas['tipo_contri'] == "NO_CONTRI")echo round($filas['msubt_bi_iva_12'],2); else echo 0;?></td>
            <td><?php if($filas['tipo_contri'] == "NO_CONTRI")echo round($filas['msubt_bi_iva_8'],2); else echo 0;?></td>
            <td><?php if($filas['tipo_contri'] == "NO_CONTRI")echo round($filas['msubt_bi_iva_27'],2); else echo 0;?></td>
            <!--monto total de impuesto IVA-->
            <td><?php echo round($filas['tot_iva'],2)?></td>
            <!--FACTURA TOTALES DE RETENCIONES-->
            <td><?php echo round($filas['m_iva_reten'],2)?></td>
                
            <td width="32">
            <?php
            /*
            $id = $filas['id_fact_venta'];
            echo "<a href='modificarVenta.php?id=$id' target='principal'>Actualizar</a>";
            */
            ?>
            </td>
            <td width="34" >
            <?php /*
              echo "<a onclick='confirmDel();' href='borrarVenta.php?id=$id' target='principal'>  
             Eliminar</a>";
            */?>
            </td>
            <td width="34" >
            <?php /*
              echo "<a href='hacerDevolucion.php?id=$id' target='principal'>  
              Devolver</a>";
            */?>
            </td>
            <td>
                <form target="_blank" name="form1" method="post" action="../reporte_pdf_fact_venta.php">
                    <input name="id_fact_venta" type="hidden" value="<?php echo $filas['id_fact_venta']?>"/>
                    <button class="btn btn-danger" type="submit">
                        <span class="fa fa-file-pdf-o" style="font-size:40px;" title="PDF"></span>
                    </button>
                    <br>
                    <label></label>
                </form>
            </td>
          </tr>
          <?php }while($filas=pg_fetch_assoc($consulta)); ?>
          <tr>
            <td colspan="20">Totales</td>
            <td><?php echo $acum_msubt_exento_venta_export;?></td>
            <td><?php echo $acum_mtot_iva_venta_n;?></td>
            <td><?php echo $acum_IN_SDCF_venta_n;?></td>
            <td><?php echo $acum_IN_EX_venta_n;?></td>
            <td><?php echo $acum_IN_EXO_venta_n;?></td>
            <td><?php echo $acum_IN_NS_venta_n;?></td>
            <td><?php echo $acum_msubt_bi_iva_12_n_NO_CONTRI?></td>
            <td><?php echo $acum_msubt_bi_iva_8_n_NO_CONTRI?></td>
            <td><?php echo $acum_msubt_bi_iva_27_n_NO_CONTRI;?></td>
            
            <td><?php echo $acum_msubt_bi_iva_12_n_CONTRI;?></td>
            <td><?php echo $acum_msubt_bi_iva_8_n_CONTRI;?></td>
            <td><?php echo $acum_msubt_bi_iva_27_n_CONTRI;?></td>
            
            <td><?php echo $acum_tot_iva;?></td>
            <td><?php echo $acum_m_iva_reten;?></td>
            
          </tr>
         </tbody>
        </table>
        <br />
        <br />
        <br />
        <br />
        <br />
        <!--RESUMEN DE LA venta-->
        <table class="table table-bordered table-hover">
          <thead  align="center">
            <tr class="titulo">
                <td colspan="5">RESUMEN DE VENTAS DEl MES DE <?php echo mesNum_Texto($mes);?></td>
            </tr>
            <tr class="titulo">
                <td rowspan="2">Descripci&oacute;n</td>
                <td colspan="2">Base Imponible</td>
                <td colspan="2">Debito Fiscal</td>
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
                <td>Ventas Internas No Gravadas</td>
                <td>40</td>
                <td><?php echo $acum_msubt_exento_venta; ?></td>
                <td>-</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Ventas de Exportaci&oacute;n</td>
                <td>41</td>
                <td><?php echo $msubt_exento_venta_export;?></td>
                <td>-</td>
                <td>-</td>
            </tr>  
            <tr>
                <td>Ventas Internas o Nacionales Gravadas por Alicuota General 12%</td>
                <td>42</td>
                <td><?php echo $acum_msubt_bi_iva_12_n;?>
                </td>
                <td>43</td>
                <td><?php echo $msubt_iva_12 = $acum_msubt_bi_iva_12_n * 0.12;?></td>
            </tr> 
            <tr>
                <td>Ventas Internas o Nacionales Gravadas por Alicuota General mas Alicuota Adicional 27%</td>
                <td>442</td>
                <td><?php echo $acum_msubt_bi_iva_27_n;?>
                </td>
                <td>452</td>
                <td><?php echo $msubt_iva_27 = $acum_msubt_bi_iva_27_n * 0.27;?></td>
            </tr> 
            <tr>
                <td>Ventas Internas o Nacionales Gravadas por Alicuota Reducida 8%</td>
                <td>333</td>
                <td><?php echo $acum_msubt_bi_iva_8_n;?>
                </td>
                <td>343</td>
                <td><?php echo $msubt_iva_8 = $acum_msubt_bi_iva_8_n * 0.08;?></td>
            </tr> 
            <tr>
                <td><b>Total Ventas y Debitos Fiscales para Efectos de Determinacion:</b></td>
                <td>46</td>
                <td><?php echo $acum_msubt_exento_venta + $acum_msubt_bi_iva_12_n + $acum_msubt_bi_iva_27_n +  $acum_msubt_bi_iva_8_n;?></td>
                <td>47</td>
                <td><?php echo $msubt_iva_12 + $msubt_iva_27 + $msubt_iva_8;?></td>
            </tr>    
          </tbody>  
        </table>
        <div style="float:right">
            <br />
            <br /><br />
            <table class="table table-bordered table-hover" >
                <thead>
                    <tr><td width="70px" class="titulo"><b style="text-align:center">I.V.A. Retenido por el Comprador</b></td></tr>
                </thead>
                <tbody>
                    <tr><td><?php echo $acum_m_iva_reten;?></td></tr>
                </tbody>
            </table>
        </div>
	  </div><!--responsive-->
      <div class="row">
        <div class="col-xs-12 col-lg-12">
            <div class="input-group">
                <form class="" target="_blank" name="form1" method="post" action="../reporte_pdf_venta.php">
                <button class="form-control btn btn-sm btn-danger" type="submit" name = "mes" value="<?php echo $mes;?>">
                    <span class="fa fa-file-pdf-o" title="pdf"></span>
                </button>
                </form>
                <div class="input-group-addon">&amp;</div>
                <form class="" target="_blank" name="form1" method="post" action="../res_reporte/reporte_excel_venta.php">
                <button class="form-control btn btn-sm btn-success" type="submit" name = "mes" value="<?php echo $mes;?>">
                    <span class="fa fa-file-excel-o" title="EXCEL"></span>
                </button>
                </form>
            </div><!--input-group-->
        </div><!--col-->
    </div><!--row-->
    </div><!--desplazable-->
    
    
</div><!--container-->
<?php 
	//}else{
	//	echo "<div>No se encontraron resultados</div>";
	//	}
}?>