<?php
	include_once('../../includes_SISTEM/include_head.php');

 if( !isset($_POST['report_pdf']) ){?>
<script>
	$( document ).ready(function() {
		//alert()
		hoverScrool('#btn-res_movUnidades');
	});
</script>
<?php }?>      
<div class="container">
  <?php if( !isset($_POST['report_pdf']) ){?>
  <div class="row">
      <div id="btn-res_movUnidades" class="col-xs-12 col-lg-12" align="center">
        <button type="button" class="btn btn-sm btn-primary col-xs-12 col-lg-12 glyphicon glyphicon-chevron-up" onclick="hoverScrool('#movUnidades')"></button>
      </div>
  </div>   <!--row-->  
  <?php }?>
    <div class="jumbotron">
        <div><?php echo $filas['titular_rif_empre']." - ". $filas['nom_empre'];?></div>
        <div>N.I.T./R.I.F.:<?php echo $filas["rif_empre"];?></div>
        <div>Direcci&oacute;n: &nbsp;<?php echo $filas['dir_empre'];?></div>
        <div>Contribuyente <?php echo $filas['contri_empre'];?></div>
        <div>Telefono <?php echo $filas["tel_empre"];?></div>
        <div>Clasificaci&oacute;n: .... &amp; Activo: Todos</div>
        <div>Fecha Desde:  <?php echo fechaInver( $fechai);?> &amp; Fecha Hasta:  <?php echo fechaInver( $fechaf);?></div>
         <!--funcion para convertir la fechaa mes en letras y ano-->
        <div>MOVIMIENTO DE UNIDADES </div>
        <div><i>Seg&uacute;n el art&iacute;culo N&deg; 177 Ley de Impuesto Sobre la Renta</i></div>
    </div>
    <br />
    <br />
    <br />
  <div class="table-desplazable" id="tabla_movunidad">
    <div class="table-responsive">
       <table class="tabla1 table table-bordered table-hover" cellpadding="0" cellspacing="0">
          <thead align="center">
            <tr>
              <td colspan="2"></td>
              <td colspan="3" align="center" class="titulo">Existencia Inicial</td>
              <td colspan="2" align="center" class="titulo">Entradas</td>
              <td colspan="2" align="center" class="titulo">Salidas</td>
              <td colspan="2" align="center" class="titulo">Autoconsumos</td>
              <td colspan="2" align="center" class="titulo">Devoluciones</td>
              <td colspan="2" align="center" class="titulo">Retiros</td>
              <td colspan="2" align="center" class="titulo">Existencia Actual</td>
               <?php if( !isset($_POST['report_pdf']) ){?>
              <td rowspan="2" colspan="3" align="center" class="titulo"><b>Acción</b></td>
              <?php }?>
            </tr>
            <tr class="titulo">
              <th>Codigo</th>
              <th>Nombre &oacute; Descripci&oacute;n</th>
              
              <th>Costo Unitario</th>
              <th>Cantidad</th>
              <th>Monto</th>
              <!--ETRADAS-->
              <th>Cantidad</th>
              <th>Monto</th>
              <!--SALIDAS-->
              <th>Cantidad</th>
              <th>Monto</th>
              <!--AUTOCUNSUMOS-->
              <th>Cantidad</th>
              <th>Monto</th>
              <!--DEVOLUCIONES-->
              <th>Cantidad</th>
              <th>Monto</th>
              <!--RETIROS-->
              <th>Cantidad</th>
              <th>Monto</th>
              <!--INVENTARIUO ACTUAL-->
              <th>Cantidad</th>
              <th>Monto</th>
              
            </tr>
          </thead>
          <tbody>    
            <?php
            $acum_miicu = 0;
            $acum_miic 	= 0;
            $acum_miim	= 0;
            $acum_mcc	= 0;
            $acum_mcm	= 0;
            $acum_mvc	= 0;
            $acum_mvm	= 0;
			$acum_mcdc	= 0;
            $acum_mcdm	= 0;
            $acum_mirc	= 0;
            $acum_mirm	= 0;
            $acum_mifc	= 0;
            $acum_mifm	= 0;
            
             
            do{	
                $inv_cod = $filas2["codigo"];////////FORMATO c_cv_inventario($codigoInv, $fechi, $fechaf, $accion);
                
                $acum_miicu = $acum_miicu 	+ c_cv_inventario($inv_cod, $fechai, $fechaf, "miicu");
                $acum_miic 	= $acum_miic 	+ c_cv_inventario($inv_cod, $fechai, $fechaf, "miic");
                $acum_miim	= $acum_miim	+ c_cv_inventario($inv_cod, $fechai, $fechaf, "miim");
                $acum_mcc	= $acum_mcc		+ c_cv_inventario($inv_cod, $fechai, $fechaf, "mcc");
                $acum_mcm	= $acum_mcm		+ c_cv_inventario($inv_cod, $fechai, $fechaf, "mcm");
                $acum_mvc	= $acum_mvc		+ c_cv_inventario($inv_cod, $fechai, $fechaf, "mvc");
                $acum_mvm	= $acum_mvm		+ c_cv_inventario($inv_cod, $fechai, $fechaf, "mvm");
				$acum_mcdc	= $acum_mcdc	+ c_cv_inventario($inv_cod, $fechai, $fechaf, "mcdc");
                $acum_mcdm	= $acum_mcdm	+ c_cv_inventario($inv_cod, $fechai, $fechaf, "mcdm");
                $acum_mirc	= $acum_mirc	+ c_cv_inventario($inv_cod, $fechai, $fechaf, "mirc");
                $acum_mirm	= $acum_mirm	+ c_cv_inventario($inv_cod, $fechai, $fechaf, "mirm");
                $acum_mifc	= $acum_mifc	+ c_cv_inventario($inv_cod, $fechai, $fechaf, "mifc");
                $acum_mifm	= $acum_mifm	+ c_cv_inventario($inv_cod, $fechai, $fechaf, "mifm");
                
                 
                // NO SE VAN A MOSTRAR PRODUCTOS QUE NO TENGAN CANTIDAD DE INVENTARIO INICIAL Y FINAL
                if((c_cv_inventario($inv_cod, $fechai, $fechaf, "miic") == 0 && c_cv_inventario($inv_cod, $fechai, $fechaf, "mifc") == 0)){
                    if(isset($_POST['report_pdf'])){//	ESTAMOS EN EL REPORTE PDF NO SE MOSTRARA NI ESTE AVISO
                        
                    }else{
            ?>
                        <td> <?php echo $inv_cod?> </td>
                        <td> <?php echo $filas2["nombre_i"]?></td>
                        <!--EXISTENCIA INICIAL-->
                        <td colspan="13"><font color="red">NO SE MOSTRARA EN EL REPORTE no posee movimientos ni existencia inicial</font></td>
            <?php
                    }
                }else{
            ?>
              <tr>
                <td> <?php echo $inv_cod?> </td>
                <td> <?php echo $filas2["nombre_i"]?></td>
                <!--EXISTENCIA INICIAL-->
                <td > <?php echo c_cv_inventario($inv_cod, $fechai, $fechaf, "miicu")?> </td>
                <td > <?php echo c_cv_inventario($inv_cod, $fechai, $fechaf, "miic")?></td>
                <td > <?php echo c_cv_inventario($inv_cod, $fechai, $fechaf, "miim")?></td>
                
                <td > <?php echo c_cv_inventario($inv_cod, $fechai, $fechaf, "mcc")?></td>
                <td > <?php echo c_cv_inventario($inv_cod, $fechai, $fechaf, "mcm")?></td>
                
                <td > <?php echo c_cv_inventario($inv_cod, $fechai, $fechaf, "mvc")?></td>
                <td > <?php echo c_cv_inventario($inv_cod, $fechai, $fechaf, "mvm")?></td>
                
                <td > 0</td>
                <td > 0</td>
                
                <td > <?php echo c_cv_inventario($inv_cod, $fechai, $fechaf, "mcdc")?></td>
                <td > <?php echo c_cv_inventario($inv_cod, $fechai, $fechaf, "mcdm")?></td>
                
                <td > <?php echo c_cv_inventario($inv_cod, $fechai, $fechaf, "mirc")?></td>
                <td > <?php echo c_cv_inventario($inv_cod, $fechai, $fechaf, "mirm")?></td>
                
                <td > <?php echo c_cv_inventario($inv_cod, $fechai, $fechaf, "mifc")?></td>
                <td > <?php echo c_cv_inventario($inv_cod, $fechai, $fechaf, "mifm")?></td>
                <?php if( !isset($_POST['report_pdf']) ){?>
                <td>
                    <a target="_blank" href="reporte_inventario.php?id= $inv_cod"> detalles </a>
                </td>
                <?php }?>
              </tr>
              <?php }//	IF SI ES 0 0
               }while($filas2 = pg_fetch_assoc($consulta2));
               // }while($filas_inventario = $sql_inventario->fetch_assoc());
               
              ?>
              <tr>
                <td colspan="2">&nbsp;</td>
                <td><b><?php echo $acum_miicu;?></b></td>
                <td><b><?php echo $acum_miic;?></b></td>
                <td><b><?php echo $acum_miim;?></b></td>
                <td><b><?php echo $acum_mcc;?></b></td>
                <td><b><?php echo $acum_mcm;?></b></td>
                <td><b><?php echo $acum_mvc;?></b></td>
                <td><b><?php echo $acum_mvm;?></b></td>
                <td><b><?php echo 0;?></b></td>
                <td><b><?php echo 0;?></b></td>
                <td><b><?php echo $acum_mcdc;?></b></td>
                <td><b><?php echo $acum_mcdm;?></b></td>
                <td><b><?php echo $acum_mirc;?></b></td>
                <td><b><?php echo $acum_mirm;?></b></td>
                <td><b><?php echo $acum_mifc;?></b></td>
                <td><b><?php echo $acum_mifm;?></b></td>
                
              </tr>
          </tbody>
        </table>
    </div>
  </div>
  <?php if( !isset($_POST['report_pdf']) ){?>
  <div class="row">
        <div class="col-xs-12 col-lg-12">
            <div class="input-group">
                <form target="_blank" name="form1" method="post" action="../reporte_pdf_mov_unidad.php">
					<?php if (isset($_POST['mes']) ){?>
                    <input type="hidden" name="mes" value="<?php echo $_POST['mes'];?>" />
                    <?php }elseif (isset($_POST['ano']) ){?>
                    <input type="hidden" name="ano" value="<?php echo $_POST['ano'];?>" />
                    <?php }elseif (isset($_POST['fechai']) && isset($_POST['fechaf'])){ ?>
                    <input type="hidden" name="fechai" value="<?php echo $_POST['fechai'];?>" />
                    <input type="hidden" name="fechaf" value="<?php echo $_POST['fechaf'];?>" />
                    <?php }elseif (isset($_POST['dia']) ){?>
                    <input type="hidden" name="dia" value="<?php echo $_POST['dia'];?>" />
                    <?php }?>
                    <button class="form-control btn btn-sm btn-danger" type="submit" name="report_pdf">
                        <span class="fa fa-file-pdf-o" title="pdf"></span>
                    </button>
                </form>
                <div class="input-group-addon">&amp;</div>
                <form target="_blank" name="form1" method="post" action="../res_reporte/reporte_excel_mov_unidad.php">
					<?php if (isset($_POST['mes']) ){?>
                    <input type="hidden" name="mes" value="<?php echo $_POST['mes'];?>" />
                    <?php }elseif (isset($_POST['ano']) ){?>
                    <input type="hidden" name="ano" value="<?php echo $_POST['ano'];?>" />
                    <?php }elseif (isset($_POST['fechai']) && isset($_POST['fechaf'])){ ?>
                    <input type="hidden" name="fechai" value="<?php echo $_POST['fechai'];?>" />
                    <input type="hidden" name="fechaf" value="<?php echo $_POST['fechaf'];?>" />
                    <?php }elseif (isset($_POST['dia']) ){?>
                    <input type="hidden" name="dia" value="<?php echo $_POST['dia'];?>" />
                    <?php }?>
                    <button class="form-control btn btn-sm btn-success" type="submit" name = "report_excel">
                        <span class="fa fa-file-excel-o" title="EXCEL"></span>
                    </button>
                </form>
            </div><!--input-group-->
        </div><!--col-->
    </div><!--row-->
    <?php }?>
</div><!--container-->

