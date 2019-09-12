<?php
class utilidades
{
////////////////////////////////////////////////////////////////////////////////
 function buscar_datos($conexion,$valor,$tabla,$campo,$campo_retorno)
 {
	 echo"INABILITADA";
	 /*
	 if($tabla == "proveedor")
	 {
		if($valor != "")
		{
		   $sql="select $campo_retorno from $tabla where $campo='$valor'";
		   //else
		   //$sql="select $campo_retorno from $tabla where nombre LIKE '%$valor%'";
		   
		   $ok=mysql_query($sql);
		   $datos=mysql_fetch_row($ok);
		   
		   if($datos[0] !== ""){//si el rif de los resultados de la consulta existe
			   echo 'R.I.F. / Cedula<br>
					 <span class="form-group has-error">
						 <input class="form-control" type="text" name="rif" id="rif" pattern="[JVEGP][0-9]{9}" onBlur="buscar_dato(2,this.value)" title="RIF existente" placeholder="RIF existente" onkeyup="javascript:this.value=this.value.toUpperCase();" lang="si-rif" required>
						 <span class="help-block">Formato: V012223334</span>
					 </span>
					 ';
		   }else{
			   echo 'R.I.F. / Cedula<br>
					
						<input class="form-control" type="text" name="rif" id="rif"  pattern="[JVEGP][0-9]{9}"  value="'.$valor.'" onBlur="buscar_dato(2,this.value);" onkeyup="javascript:this.value=this.value.toUpperCase();" lang="si-rif" required>
					<span class="form-group has-success">
						<span class="help-block">Formato: Disponible</span>
					</span>
					';
		   }
		}else{
			echo '
			R.I.F. / Cedula<br>
					<input type="text" class="form-control" name="rif" id="rif" pattern="[JVEGP][0-9]{9}" onBlur="buscar_dato(2,this.value);" onKeyUp="javascript:this.value=this.value.toUpperCase();" placeholder="Requerido" lang="si-rif" required>
					<span class="help-block">Formato: V012223334</span>
			';
		}
	 }elseif($tabla == "cliente")
	 {
		if($valor !== "")
		{
		   $sql="select $campo_retorno from $tabla where $campo='$valor'";
		   //else
		   //$sql="select $campo_retorno from $tabla where nombre LIKE '%$valor%'";
		   
		   $ok=pg_query($conexion,$sql);
		   $datos=mysql_fetch_row($ok);
		   
		   if($datos[0] !== ""){//si el rif de los resultados de la consulta existe
			   echo 'Documento del Cliente<br>
					 <span class="form-group has-error">
						 <input class="form-control" type="text" name="ced_cliente" id="ced_cliente" pattern="[JVEGP][0-9]{9}" onBlur="buscar_dato(3,this.value)" title="DOCUMENTO existente" placeholder="DOCUMENTO existente" onkeyup="autos_tipo_contri(this.value);javascript:this.value=this.value.toUpperCase();" lang="si-general" required>
						 <span class="help-block">Formato: V012223334</span>
					 </span>
					 ';
		   }else{
			   echo 'Documento del Cliente<br>
						<input class="form-control" type="text" name="ced_cliente" id="ced_cliente"  pattern="[JVEGP][0-9]{9}"  value="'.$valor.'" onBlur="buscar_dato(3,this.value);" onkeyup="autos_tipo_contri(this.value);javascript:this.value=this.value.toUpperCase();" lang="si-general" required>
					<span class="form-group has-success">
						<span class="help-block">Formato: Disponible</span>
					</span>
					';
		   }
		}else{
			echo '
			Documento del Cliente<br>
					<input type="text" class="form-control" name="ced_cliente" id="ced_cliente" pattern="[JVEGP][0-9]{9}" onBlur="buscar_dato(3,this.value);" onKeyUp="autos_tipo_contri(this.value);javascript:this.value=this.value.toUpperCase();" placeholder="Requerido" lang="si-general" required>
					<span class="help-block">Formato: V012223334</span>
			';
		}
	 }elseif($tabla == "inventario"){
		if($valor !== "")
		{
		   $sql="select $campo_retorno from $tabla where $campo='$valor'";
		   //else
		   //$sql="select $campo_retorno from $tabla where nombre LIKE '%$valor%'";
		   
		   $ok=pg_query($conexion,$sql);
		   $datos=mysql_fetch_row($ok);
		   
		   if($datos > 0){//si el rif de los resultados de la consulta existe
			   echo 'Codigo<br>
					 <span class="form-group has-error">
						 <input type="text" class="form-control" name="codigo" id="codigo" onBlur="buscar_dato(1,this.value);" title="Producto existente" placeholder="Producto existente" lang="si-general" required>
						 <span class="help-block">
						 	<button type="button" class="btn btn-sm btn-info" onclick="genCodRand(\'codigo\')">Generar Codigo</button>
						</span>
					 </span>
					 ';
		   }else{
			   echo 'Codigo<br>
			   		<span class="form-group has-success">
						<input type="text" class="form-control" name="codigo" id="codigo" onBlur="buscar_dato(1,this.value);" lang="si-general" required value="'.$valor.'">
						<span class="help-block"><button type="button" class="btn btn-sm btn-info" onclick="genCodRand(\'codigo\')">Generar Codigo</button></span>
					</span>
					';
		   }
		}else{
			echo 'Codigo<br>
					<input type="text" class="form-control" name="codigo" id="codigo" onBlur="buscar_dato(1,this.value); javascript:this.value=this.value.toUpperCase();" lang="si-general" required value="" placeholder="Requerido">
					<span class="help-block"><button type="button" class="btn btn-sm btn-info" onclick="genCodRand(\'codigo\')">Generar Codigo</button></span>
			';
		}
	 }
 }
////////////////////////////////////////////////////////////////////////////////

function validar_repetido($conexion,$valor,$tabla,$columna)
{
 $sql="select $columna from $tabla where $columna='$valor'";
 $ok=pg_query($conexion,$sql);
 $datos=mysql_fetch_row($ok);
 if($datos[0]==$valor)
 {
?>

<?php	 
   echo "<h4><font color='#FF0000'>¡¡¡El valor $valor ya está registrado en la Base de Datos Vuelva a Intentarlo!!!</font></h4>";	 
 }*/
}
////////////////////////////////////////////////////////////////////////////////

}
?>