<?php
	if( isset($_POST['id']) ){
			$fechaInvIni = $_POST['id'];
			//CONSULTA DE TODAS FACTURAS de COMPRA CON PARA COMPARAR LA FECHA CON LA DEL INVENTARIO
			include_once("../conexion.php");	
			$consulDocu = mysqli_query($conexion,sprintf("SELECT * FROM fact_compra WHERE fecha_fact_compra > '%s'", $fechaInvIni) );
			$resconsulDocu = $consulDocu->fetch_assoc();
			$total_consulDocu = mysqli_num_rows($consulDocu);//$resconsulDocu->num_rows
	
			if($resconsulDocu)
				echo 1;//la fecha compra > fecha inventario ASI ESTA BIEN
			else
				echo 0;//la fecha compra < fecha inventario ASI NO ESTA BIEN Y VALIDO
	}
?>