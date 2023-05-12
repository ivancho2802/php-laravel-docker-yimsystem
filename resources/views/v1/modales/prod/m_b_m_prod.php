<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');

if(isset($_POST['codigo_prod']))
{		
		//recibo la variable post
		$codigo_prod = $_POST['codigo_prod'];	
		//realizo el sql
		$consulta=pg_query($conexion,sprintf("SELECT * FROM inventario WHERE
									inventario.codigo = '%s'",
									$codigo_prod));
        $filas=pg_fetch_assoc($consulta);
		// $f_mm_prod=$c_mm_prod->fetch_assoc();
		$t_mm_prod = pg_num_rows($consulta);
}
?>
<label>
    <div class="row">
        <!--para mostrar resultado de acciones de insercion y demas-->
        <label class="col-md-12 col-lg-12" id="txtEdomodRProd" data-dismiss="modal"></label>
    </div>
    <div class="row">
        <!--con el rif se manda a validar si existe con la funcino , y con cURLrif obtener el nombre-->
        <label class="col-md-4 col-lg-4" id="res_codigo">
            Codigo:<br>
            <span class="input-group" id="cont_codigo">
                <input type="text" class="form-control" name="codigo_m_m_prod_nue" id="codigo_m_m_prod_nue" lang="si-general" value="<?php echo $filas['codigo'];?>" required>
                <input type="hidden" name="codigo_m_m_prod_vie" id="codigo_m_m_prod_vie" value="<?php echo $filas['codigo'];?>"/>
                <!--validar_repetidoM('inventario', 'codigo', this.value, 'codigo')-->
                <span class="input-group-btn">
                <button type="button" class="btn btn-primary" onclick="genCodRand('codigo','<?php echo $_SESSION["alias"].$_SESSION["version"]."-";?>')">Generar Codigo</button>
                </span>
            </span>
        </label>
        <label class="col-md-4 col-lg-4" id="res_nombre_i">
            <span id="cont_nombre_i">
            Nombre:<br>
            <input type="text" class="form-control" name="nombre_i_m_m_prod" id="nombre_i_m_m_prod" pattern="[A-Za-z ñáéíóú ÑÁÉÍÓÚ 0-9]*" onBlur="javascript:this.value=this.value.toUpperCase();validar_repetidoM('inventario', 'nombre_i', this.value, 'nombre_i');" lang="si-general" value="<?php echo $filas['nombre_i'];?>" required>
            </span>
        </label>
        
        <label class="col-md-4 col-lg-4">
            Stock &oacute; Existencia:<br>
            <input type="number" min="0" class="form-control" name="stock_m_m_prod" id="stock_m_m_prod" lang="no-number" disabled="disabled" value="<?php echo $filas['stock'];?>">
        </label>
    </div>
    <div class="row">
        <label class="col-md-4 col-lg-4">
            Valor Unitario:<br>
            <input type="number" min="0" step="0.01" class="form-control"  name="valor_unitario_m_m_prod" id="valor_unitario_m_m_prod" lang="si-number" value="<?php echo round($filas['valor_unitario'],2);?>" disabled="disabled">
        </label>
        <label class="col-md-4 col-lg-4">
            Precio de Venta<br>
            <span class="input-group bpmpvj_open_modal">
                <input class="form-control" name="pmpvj" id="pmpvj" type="number" min="0" step="0.01" value="<?php echo $filas['pmpvj_actual'];?>" placeholder="0.00" disabled="disabled"/>
                <span class="input-group-btn">
                    <button class="btn btn-primary" name="bpmpvj" type="button" disabled="disabled">P. Venta</button>
                </span>
            </span>
        </label>
        <label class="col-md-4 col-lg-4">
            Fecha de Inventario Inicial:<br>
            <input type="date" class="form-control"  name="fecha_m_m_prod" id="fecha_m_m_prod" value="<?php echo $filas['fecha'];?>" lang="si-general" disabled="disabled"/>
        </label>
    </div><!--row-->
    <div class="row">
        <label class="col-md-4 col-lg-4">
            Descripcion:<br>
            <input type="text" class="form-control" name="descripcion_m_m_prod" id="descripcion_m_m_prod" lang="no-general" value="<?php echo $filas['descripcion'];?>">
        </label>
        <label class="col-md-4 col-lg-4">
            Cantidad Minima:<br>
            <input type="number" min="0" class="form-control" name="cant_min_m_m_prod" id="cant_min_m_m_prod" lang="no-number" value="<?php echo $filas['cant_min'];?>">
        </label>
        <label class="col-md-4 col-lg-4">
            Cantidad Maxima:<br />
            <input type="number" min="0" class="form-control"  name="cant_max_m_m_prod" id="cant_max_m_m_prod" lang="no-number" value="<?php echo $filas['cant_max'];?>">
        </label>
    </div><!--row-->
</label>