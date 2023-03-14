<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');

if(isset($_POST['ced_cliente']))
{		
		//recibo la variable post
		$ced_cliente = $_POST['ced_cliente'];	
		//realizo el sql
		$consulta=pg_query($conexion,sprintf("SELECT * FROM cliente WHERE
									cliente.ced_cliente = '%s'",
									$ced_cliente));
		// $f_mm_cliente = $c_mm_cliente->fetch_assoc();
        $filas=pg_fetch_assoc($consulta);
		$t_mm_cliente = pg_num_rows($consulta);
}
?>
<label>
    <div class="row">
        <!--para mostrar resultado de acciones de insercion y demas-->
        <label class="col-md-12 col-lg-12" id="txtEdomodRCliente" data-dismiss="modal"></label>
    </div>
   <div class="row">
        <!--con el rif se manda a validar si existe con la funcino buscar_dato, y con cURLrif obtener el nombre-->
        <label class="col-md-4 col-lg-4" id="res_ced_cliente">
            Documento del Cliente<br>
            <span id="cont_ced_cliente">
            <input type="text" class="form-control" name="ced_cliente_m_nue" id="ced_cliente_m_nue" pattern="[JVEGP][0-9]{9}" onBlur="javascript:this.value=this.value.toUpperCase();" onKeyUp="autos_tipo_contri(this.value,'contri_cliente_m');" lang="si-general" value="<?php echo $filas['ced_cliente'];?>" required>
            <input type="hidden" name="ced_cliente_m_vie" id="ced_cliente_m_vie" value="<?php echo $filas['ced_cliente'];?>"/>
            <span class="help-block">Formato: V012223334</span>
            </span>
        </label>
        <!--validar_repetidoM('cliente', 'ced_cliente', this.value, 'ced_cliente');-->
        <label class="col-md-8 col-lg-8">
            Nombre o Raz&oacute;n Social:<br />
            <span class="input-group">
                <span id="resRifC"></span>
                    <input type="text" class="form-control" name="nom_cliente_m" id="nom_cliente_m" pattern="[A-Za-z ñáéíóú ÑÁÉÍÓÚ 0-9]*" onBlur="javascript:this.value=this.value.toUpperCase();" lang="si-general" value="<?php echo $filas['nom_cliente'];?>" required>
                
                <span class="input-group-btn">
                    <button id="btn" type="button" onclick="cURLrifC('nombre','ced_cliente','formModal','nom_cliente','resRifC',this.id);" class="form-control btn btn-primary">
                    Buscar(INTERNET)
                    </button>
                </span>
            </span>
        </label>
        
    </div>
    <div class="row">
        <label class="col-md-4 col-lg-4">
            Tipo de Contribuyente
            <select class="form-control" name="contri_cliente_m" id="contri_cliente_m" lang="si-general" required>
                <option value="<?php echo $filas['contri_cliente'];?>"><?php echo $filas['contri_cliente'];?></option>
                <option value="CONTRI_ORD">Contribuyente Ordinario</option>
                <option value="CONTRI_ESP">Contribuyente Especial</option>
                <option value="NO_CONTRI">No Contribuyente</option>
            </select>
        </label>
        <label class="col-md-4 col-lg-4">
            Fecha de Registro:<br>
            <input type="date" class="form-control" name="fech_i_cliente_m" id="fech_i_cliente_m" value="<?php echo $filas['fech_i_cliente'];?>"/>
        </label>
        
        <label class="col-md-4 col-lg-4">
            Telefono:<br>
            <input type="text" class="form-control" name="tel_cliente_m" id="tel_cliente_m" min="999999999" max="999999999999" pattern="[0][42][127][246][0-9]{7}" lang="no-telf" value="<?php echo $filas['tel_cliente'];?>">
            <span class="help-block">Formato: 04161234567</span>
        </label>
        
    </div><!--row-->
    <div class="row">
        <label class="col-md-4 col-lg-4">
            E-mail:<br>
            <input type="text" class="form-control" name="email_cliente_m" id="email_cliente_m" lang="no-email" value="<?php echo $filas['email_cliente'];?>">
        </label>
        <label class="col-md-4 col-lg-4">
            Direcci&oacute;n:<br />
            <input class="form-control" type="text" name="dir_cliente_m" id="dir_cliente_m" value="<?php echo $filas['dir_cliente'];?>" required>
        </label>
    </div><!--row-->
</label>