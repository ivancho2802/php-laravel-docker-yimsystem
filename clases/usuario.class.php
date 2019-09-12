<?php
class usuario
{	
	function iniciar_sesion($conexion,$usuario,$clave){
		$clave=md5($clave);
		$sql="select * from usuarios, data_system where usuario='$usuario' and password='$clave' and edo_ds=1";
		$ok=pg_query($conexion,$sql);//mysql_query($sql);
		// $ok=mysqli_query($conexion,$sql);//mysql_query($sql);
		var_dump($ok); 
		
		if($resultado = pg_fetch_row(fetch_array))
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