<?php
	include_once('../../includes_SISTEM/include_head.php');
	include_once('../../includes_SISTEM/include_login.php');
	//consulta de los datos de la empreas PARA SABE LA ACTIVA 
	$consulta = pg_query($conexion,"SELECT * FROM empre WHERE empre.est_empre = '1'");

	// $filas = pg_fetch_assoc($consultaEmpre);
	$filas=pg_fetch_assoc($consulta);

	$total_consultaEmpre = pg_num_rows($consulta);
?>
<script>
	function validar_fecha(fechai, fechaf){
		if(fechai !== "" && fechaf !== ""){
			if(fechai > fechaf){
				alert('Atencion la Fecha Inicial debe ser Menor a la Fecha Final');
				document.forms['form_rang'].elements['fechai'].value = "";
				document.forms['form_rang'].elements['fechaf'].value = "";
				return 0;
			}else if(fechaf < fechai){
				alert('Atencion la Fecha Final debe ser Mayor a la Fecha Final');
				document.forms['form_rang'].elements['fechai'].value = "";
				document.forms['form_rang'].elements['fechaf'].value = "";
				return 0;
			}
		}
	}
</script>
<div id="movUnidades"  class="bs-example">
	<div class="">
    	<h1 class="bd-title">Movimiento de Unidades</h1>
    </div>
    <div class="row">
      <div class="col-xs-12 col-md-4 col-lg-4">
    	<div class="form-group">
          <form method="POST">
                <label class="control-label">Consulta Por Dia</label>
                <div class="input-group">
                  <input type="date" class="form-control" name="dia" value="<?php if(isset($_POST['dia']))echo $_POST['dia'];?>" required="required"/>
                
                  <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit" name="" value="">Buscar Movimiento!</button>
                  </span>
                </div>
		  </form>
		</div>
	  </div><!--col-->
      <div class="col-xs-12 col-md-4 col-lg-4">
      	<div class="form-group">
          <form method="POST">
                <label class="control-label">Consulta Por Mes</label>
                <div class="input-group">
                  <input type="month" class="form-control" name="mes" value="<?php if(isset($_POST['mes']))echo $_POST['mes'];?>" required="required"/>
                
                  <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit" name="" value="">Buscar Movimiento!</button>
                  </span>
                </div>
		  </form>
		</div>
      </div>
      <div class="col-xs-12 col-md-4 col-lg-4">
      	<div class="form-group">
          <form method="POST">
                <label class="control-label">Consulta Por A&ntilde;o</label>
                <div class="input-group">
                  <input type="number" class="form-control" min="1500" max="9999" name="ano" value="<?php if(isset($_POST['ano']))echo $_POST['ano'];?>" required="required"/>
                
                  <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit" name="" value="">Buscar Movimiento!</button>
                  </span>
                </div>
		  </form>
		</div>
      </div>
	</div><!--row-->
    <div class="row">
      <div class="col-xs-12 col-md-12 col-lg-12">
      	<div class="form-group">
          <form method="POST" name="form_rang">
                <label class="control-label">Consulta Por Rango</label>
                <div class="input-group">
                  <span class="input-group-addon">Fecha Inicio:</span>
                  <input type="date" class="form-control" name="fechai" onblur=" validar_fecha(this.value,document.forms['form_rang'].elements['fechaf'].value)" value="<?php if(isset($_POST['fechai']))echo $_POST['fechai'];?>" required="required"/>
                  <span class="input-group-addon">Fecha Final:</span>
                  <input type="date" class="form-control" name="fechaf" onblur="validar_fecha(document.forms['form_rang'].elements['fechai'].value, this.value)" value="<?php if(isset($_POST['fechaf']))echo $_POST['fechaf'];?>" required="required"/>
                  <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit" name="" value="">Buscar Movimiento!</button>
                  </span>
                </div>
		  </form>
		</div>
      </div>
    </div>
</div><!--movunidades-->
<hr id="res_movUnidades" class="featurette-divider"/>
<?php

	$consulta2=pg_query($conexion,sprintf("SELECT * FROM inventario WHERE 1=1 ORDER BY codigo;"));
	// $filas2=$sql_inventario->fetch_assoc();
	$filas2=pg_fetch_assoc($consulta2);

	$total_inventario = pg_num_rows($consulta2);
	
	if (isset($_POST['mes']) || isset($_POST['ano']) || (isset($_POST['fechai']) && isset($_POST['fechaf'])) || isset($_POST['dia']) ){
		//validando que la fecha o ano que se introduzca no sea menor al menor del sistema
			/*SELECT fact_compra.fecha_fact_compra AS fecha FROM fact_compra
			UNION
			SELECT fact_venta.fecha_fact_venta AS fecha FROM fact_venta
			UNION
			SELECT inventario_retiros.fecha_inv_retiros AS fecha FROM inventario_retiros
			UNION
			SELECT reg_inventario.fecha_reg_inv AS fecha FROM reg_inventario
			ORDER BY fecha ASC*/
			$consulta3=pg_query($conexion,sprintf("SELECT fact_compra.fecha_fact_compra AS fecha FROM fact_compra
			UNION
			SELECT fact_venta.fecha_fact_venta AS fecha FROM fact_venta
			UNION
			SELECT inventario_retiros.fecha_inv_retiros AS fecha FROM inventario_retiros
			UNION
			SELECT reg_inventario.fecha_reg_inv AS fecha FROM reg_inventario
			ORDER BY fecha ASC"));
			// $filas3 = $sql_fecha_menor->fetch_assoc();
			$filas3=pg_fetch_assoc($consulta3);
			$total_fecha_menor = pg_num_rows($consulta3);
			
			//completando con ano y/o mes la fecha
			if(isset($_POST['mes'])){
				$mes = $_POST['mes'];
				$fechai = $mes."-01";
				$fechaf = ($mes=='02')? $mes."-28":(((int) $mes%2==0) ? $mes."-31" : $mes."-30");
				
			}elseif(isset($_POST['ano'])){
				$ano = $_POST['ano'];
				if ($ano >= substr($filas3['fecha'],0,4))
					$fechai = $filas3['fecha'];
				else
					$fechai = "errorano";
				$fechaf = $ano."-12-31";
			}elseif(isset($_POST['fechai']) && isset($_POST['fechaf'])){
				$fechai = $_POST['fechai'];
				$fechaf = $_POST['fechaf'];
			}elseif(isset($_POST['dia']) ){
				$dia = $_POST['dia'];
				if ($dia >= $filas3['fecha']){
					$fechai = $_POST['dia'];
					$fechaf = $_POST['dia'];
				}else 
					$fechai = "errorano";
			}
			
			if($fechai == "errorano" || $fechai < $filas3['fecha'])//para AÑO o mes y 
			{
				echo "Error con la fecha debe ser mayor a mes de ".mesNum_Texto($filas3['fecha']);
			}else{
				// TABLA DE CONSULTA 
				
				include_once('movUnidadTab.php');?>
<?php 		}//de la consulta
		}//de la validacion de la fecha?>