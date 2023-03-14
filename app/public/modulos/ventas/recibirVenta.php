<?php
	include_once('../../includes_SISTEM/include_head.php');
	include_once('../../includes_SISTEM/include_login.php');
//asignacion de 			NEGATIVOS O NO
if($_POST['tipo_fact_venta'] == "NC-DEVO" || $_POST['tipo_fact_venta'] == "NC-DESC"){
	$negativo = -1;
	$mtot_iva_venta = $_POST['mtot_iva_venta']*$negativo; 
	$tot_iva = $_POST['tot_iva']*$negativo;
	$msubt_exento_venta = $_POST['msubt_exento_venta']*$negativo;
	$msubt_tot_bi_venta = $_POST['msubt_tot_bi_venta']*$negativo;
	$msubt_bi_iva_12 = $_POST['msubt_bi_iva_12']*$negativo;
	$msubt_bi_iva_8 = $_POST['msubt_bi_iva_8']*$negativo;
	$msubt_bi_iva_27 = $_POST['msubt_bi_iva_27']*$negativo;
}else{
	$mtot_iva_venta = $_POST['mtot_iva_venta']; 
	$tot_iva = $_POST['tot_iva']; 
	$msubt_exento_venta = $_POST['msubt_exento_venta'];
	$msubt_tot_bi_venta = $_POST['msubt_tot_bi_venta'];
	$msubt_bi_iva_12 = $_POST['msubt_bi_iva_12'];
	$msubt_bi_iva_8 = $_POST['msubt_bi_iva_8'];
	$msubt_bi_iva_27 = $_POST['msubt_bi_iva_27'];
}
//insertar en FACT_
$sql=sprintf("INSERT INTO fact_venta (id_fact_venta, serie_fact_venta, num_fact_venta, num_ctrl_factventa, fecha_fact_venta, tipo_trans, nfact_afectada, tipo_fact_venta, tipo_pago, dias_venc, monto_paga, fk_cliente, tipo_contri, fk_usuariosV, empre_cod_empre, nplanilla_export, nexpe_export, naduana_export, fechaduana_export,  mtot_iva_venta, tot_iva, msubt_exento_venta, msubt_tot_bi_venta, msubt_bi_iva_12, msubt_bi_iva_8, msubt_bi_iva_27, reg_maq_fis, num_repo_z) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
                       $_POST['id_fact_venta'],//auto lleno v
					   
					   $_POST['serie_fact_venta'],//v
                       $_POST['num_fact_venta'],//v
					   $_POST['num_ctrl_factventa'],//v
					   $_POST['fecha_fact_venta'],//v
					   $_POST['tipo_trans'],//v
					   
					   $_POST['nfact_afectada'],//v
					   $_POST['tipo_fact_venta'],//v tipo del documento
					   $_POST['tipo_pago'],//v tipo o froma de pago
					   $_POST['dias_venc'],// 	dias para pafar el credito
					   $_POST['monto_paga'],// 	 
					   
					   $_POST['fk_cliente'],//v
					   $_POST['tipo_contri'],//v
                       $_POST['fk_usuariosV'],//v
                       $_POST['empre_cod_empre'],//v
                       
                       $_POST['nplanilla_export'],//v
                       $_POST['nexpe_export'],//v
                       $_POST['naduana_export'],//v
                       $_POST['fechaduana_export'],//v
                       //$_POST['num_compro_reten'],$_POST['fecha_compro_reten'],//num_compro_reten, fecha_compro_reten,//, %s, %s
                       
					   $mtot_iva_venta,//v
						$tot_iva, //v
						$msubt_exento_venta,//v
						$msubt_tot_bi_venta,//v
						$msubt_bi_iva_12,//v
						$msubt_bi_iva_8,//v
						$msubt_bi_iva_27,//v
					   
					   $_POST['reg_maq_fis'],
					   $_POST['num_repo_z']);//v
					   //ndebito_factventa, ncredito_factventa,// , %s, %s// $_POST['ndebito_factventa'],$_POST['ncredito_factventa'],	 	 
$res = pg_query($conexion,$sql)or die('Factura NO realizada con éxito'.pg_last_error());
if($res){
	$acumCamposN = "";
	for($i = 1;$i <= $_POST['numCampos']; $i++){
	  if(isset($_POST["id_venta$i"])	){//IF ESTE CAMPO SE ENVIA procedo
	  
	  	$costo_venta = $_POST["costo$i"];
		
		//CONSULTA de lo actual inventario
		$consulta = pg_query($conexion, sprintf("SELECT * FROM inventario WHERE inventario.codigo = '%s'",$_POST["fk_inventario$i"]) );
		// $filas = $sql_consul_inven->fetch_assoc();
		$filas=pg_fetch_assoc($consulta);
		
		
		
		//ACTUALIZA	RESTA DEL INVENTARIO//echo $stock_cantidad;
		//si es ND 
		if($_POST['tipo_fact_venta'] == "NC-DEVO")			//RESTO NORMAL
			$stock_cantidad = $filas['stock'] + $_POST["cantidad$i"];
		elseif($_POST['tipo_fact_venta'] == "NC-DESC" || $_POST['tipo_fact_venta'] == "ND")			//RESTO
			$stock_cantidad = $filas['stock'];
		else											//SUMO
			$stock_cantidad = $filas['stock'] - $_POST["cantidad$i"];
		
				
				
		$sqlUpdateInven = sprintf("UPDATE inventario SET stock = '%s', pmpvj_actual = '%s'  WHERE 
								codigo = '%s'",
								$stock_cantidad,
								$costo_venta, 
								$_POST["fk_inventario$i"]);
		$UpdateInven = pg_query($conexion,$sqlUpdateInven)or 
		die('Error al actualizar inventario'.pg_last_error());
		
		if($sqlUpdateInven){
			//INSERTAR PARA EL  REGISTRO DE INVENTARIO LO ACTUAL SEGUN LA FECHA PARA KARDEX
			$InsertRegInv = sprintf("INSERT INTO reg_inventario( fecha_reg_inv, costo_reg_inv, cantidad_reg_inv, pmpvj, tipo, fk_inventario, fk_fact_cv, hora_registro, fecha_registro) VALUES
									('%s','%s','%s','%s','%s','%s','%s','%s','%s')",
									$_POST['fecha_fact_venta'],
									$filas["valor_unitario"],//costo actual para esta fecha
									$stock_cantidad,//cantidad actual para esta fecha
									$costo_venta,
									"venta",
									$_POST["fk_inventario$i"],
									$_POST["id_fact_venta"],
									date('H:i:s'),
									date('Y/m/d'));
			$resInsertRegInv = pg_query($conexion,$InsertRegInv)or
			die('Registro inventario NO realizada con éxito'.pg_last_error());
		}
		if($resInsertRegInv){
		//INSERTAR venta
		$sql2 = sprintf("INSERT INTO venta (id_venta, tipoVenta, fk_inventario, costo, precio_venta, cantidad, fk_fact_venta) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')",
						$_POST["id_venta$i"], 
						$_POST["tipoVenta$i"],  
						$_POST["fk_inventario$i"], 
						$filas["valor_unitario"], 
						$_POST["costo$i"],
						$_POST["cantidad$i"], 
						$_POST["id_fact_venta"]);//
		
		/*creando la variable de insercion en productor ala venta del inventario tiene que existir en el inventarui sino
		$camposN = "('".."')";
		if($i == 1)
			$acumCamposN = $camposN;	
		else
			$acumCamposN = $acumCamposN .",". $camposN;
		*/
		
		$res2 = pg_query($conexion,$sql2)or die('Venta NO realizada con éxito'.pg_last_error());
		}
	  }//IF ESTE CAMPO SE ENVIA procedo
	}//for	
?>
<div align="center">
    <div class="page-header">
        <h1>Atencion en Ventas</h1>
    </div>
    <div class="container theme-showcase">
        <div class="alert alert-success fade in" role="alert">
            <strong>Excelente!</strong> Venta realizada con Exito.
            <span class="glyphicon glyphicon-ok text-success"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="close">×</button>
        </div>
        <div class="row">
        	<!--
        	<div class="col-xs-12 col-md-3 col-lg-3">
                <form target="_blank" name="form1" method="post" action="../reporte_pdf_fact_venta.php">
                	<input name="id_fact_venta" type="hidden" value="<?php echo $_POST['id_fact_venta']?>"/>
                    <button class="btn btn-danger" type="submit">
                        <span class="fa fa-file-pdf-o" style="font-size:40px;" title="PDF"></span>
                    </button>
                    <br>
                    <label>Imprimir Factura</label>
                </form>
            </div>
            
            <div class="col-xs-12 col-md-3 col-lg-3">
                <form name="form2" method="post" action="libroVenta.php">
                    <button class="btn btn-success glyphicon glyphicon-plus" title="NUEVO" type="submit">
                    
                    </button> 
                    <br>
                    <label>Libro de Venta</label>
                </form>
            </div>
            --> 
            <div class="col-xs-12 col-md-12 col-lg-12">
                <form name="form2" method="post" action="cargarVenta.php">
                    <button class="btn btn-success glyphicon glyphicon-plus" title="NUEVO" type="submit">
                    
                    </button> 
                    <br>
                    <label>Cargar Otra Venta</label>
                </form>
            </div>
            <!--
            <div class="col-xs-12 col-md-3 col-lg-3">
                <form name="form3" method="post" action="../home/status.php">
                    <button class="btn btn-success glyphicon glyphicon-home" title="HOME" type="submit">
                    </button> 
                    <br>
                    <label>Volver a Home</label>
                </form>	
            </div>
            -->
        </div>
    </div>
</div>
	<?php	  
	  }else{
		  echo 'Error al Agregar Factura Venta';
	  }
?>