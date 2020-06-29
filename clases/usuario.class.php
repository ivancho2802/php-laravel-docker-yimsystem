<?php
class usuario
{	
	function iniciar_sesion($conexion,$usuario,$clave){
		$clave=md5($clave);
		$sql="SELECT * FROM usuarios, data_system WHERE usuario='$usuario' AND password='$clave' AND edo_ds=1";
		$ok=pg_query($conexion,$sql);//mysql_query($sql);
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