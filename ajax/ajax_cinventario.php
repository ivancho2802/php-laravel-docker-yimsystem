<?php
	if( isset($_POST['id']) ){
			$fechaInvIni = $_POST['id'];
			//CONSULTA DE TODAS FACTURAS de COMPRA CON PARA COMPARAR LA FECHA CON LA DEL INVENTARIO
			include_once("../conexion.php");	
			$consulta = pg_query($conexion,sprintf("SELECT * FROM fact_compra WHERE fecha_fact_compra > '%s'", $fechaInvIni) );
			// $resconsulDocu = $consulDocu->fetch_assoc();
			$filas=pg_fetch_assoc($consulta);

			$total_consulDocu = pg_num_rows($filas);//$filas->num_rows
	
			if($filas)
				echo 1;//la fecha compra > fecha inventario ASI ESTA BIEN
			else
				echo 0;//la fecha compra < fecha inventario ASI NO ESTA BIEN Y VALIDO
	}
?>