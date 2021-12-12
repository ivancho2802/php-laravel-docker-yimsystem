<?php
class usuario
{	
	function iniciar_sesion($conexion,$usuario,$clave){
		$clave=md5($clave);
		$sql = pg_prepare($conexion, "login___", 'select * from usuarios, data_system 
		where usuario=$1 and password=$2 and edo_ds=1');
		//$sql=sprintf("select * from usuarios, data_system 
		//where usuario='%s' and password='%s' and edo_ds=1", $usuario, $clave);
		$ok=pg_execute($conexion, 'login___', array($usuario, $clave));//mysql_query($sql);
		//$ok=pg_query($conexion,$sql);//mysql_query($sql);
		// $ok=mysqli_query($conexion,$sql);//mysql_query($sql);
		// var_dump($ok); 
		
		// if($resultado = $ok->fetch_array())
		// echo($resultado = pg_fetch_row($ok));
		if($resultado = pg_fetch_assoc($ok))
		{
			$resultado["mensaje"] = "";
			$resultado["acceso"] = 1;
			return $resultado;
		} else{
			$resultado["mensaje"] = "Usuario &oacute; Contrase&ntilde;a Inv&aacute;lidos";
			$resultado["acceso"] = 0;
			return $resultado;
		}
	}
}
?>