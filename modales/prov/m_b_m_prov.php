<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');

if(isset($_POST['rif_prov']))
{		
		//recibo la variable post
		$rif_prov = $_POST['rif_prov'];	
		//realizo el sql
		$consulta=pg_query($conexion,sprintf("SELECT * FROM proveedor WHERE
									proveedor.rif = '%s'",
									$rif_prov));
		// $filas=$c_mm_prov->fetch_assoc();
        $filas=pg_fetch_assoc($consulta);
		$t_mm_prov = pg_num_rows($consulta);
}
?>
<label>
    <div class="row">
        <!--para mostrar resultado de acciones de insercion y demas-->
        <label class="col-md-12 col-lg-12" id="txtEdomodRProv" data-dismiss="modal"></label>
    </div>
    <div class="row">
    
        <!--con el rif se manda a validar si existe con la funcino buscar_dato, y con cURLrif obtener el nombre-->
        <label class="col-md-6 col-lg-6" id="res_rif">
            <span id="cont_rif">
            R.I.F. / Cedula<br>
            <input type="text" class="form-control" name="rif_m_m_prov" id="rif_m_m_prov" pattern="[JVEGP][0-9]{8}" lang="si-rif" value="<?php echo $filas['rif']?>"/>
            <input type="hidden" id="rif_m_m_prov_vie" value="<?php echo $filas['rif']?>"/>
            <span class="help-block">Formato: V012223334</span>
            </span>
            <!--onBlur="javascript:this.value=this.value.toUpperCase();validar_repetidoM('proveedor', 'rif', this.value, 'rif');" -->
        </label>
        <label class="col-md-6 col-lg-6">
            Nombre o Raz&oacute;n Social:<br />
            <span class="input-group">
                <span id="resRifC"> </span>
                    <input type="text" class="form-control" name="nombre_m_m_prov" id="nombre_m_m_prov" pattern="[A-Za-z ñáéíóú ÑÁÉÍÓÚ 0-9]*" onBlur="javascript:this.value=this.value.toUpperCase();" lang="si-general" value="<?php echo $filas['nombre']?>" required>
               
                <span class="input-group-btn">
                <button id="btn" type="button" onclick="cURLrifC('nombre','rif_m_m_prov','form_mmProv','nombre_m_m_prov','resRifC',this.id);" class="btn btn-primary">Buscar (INTERNET)</button>
                </span>
            </span>
        </label>
        
        
    </div>
    <div class="row">
        <label class="col-md-6 col-lg-6">
            Telefono:<br>
            <input type="text" class="form-control" name="telefono_m_m_prov" id="telefono_m_m_prov" min="999999999" max="999999999999" pattern="[0][42][127][246][0-9]{7}" lang="no-telf" value="<?php echo $filas['telefono']?>" required>
            <span class="help-block">Formato: 04161234567</span>
        </label>
        <label class="col-md-6 col-lg-6">
            Direcci&oacute;n:<br />
            <input class="form-control" type="text" name="direccion_m_m_prov" id="direccion_m_m_prov" value="<?php echo $filas['direccion']?>" lang="no-general" required>
        </label>
    </div><!--row-->
</label>