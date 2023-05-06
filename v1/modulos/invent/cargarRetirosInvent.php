<?php 
	include_once('../../includes_SISTEM/include_head.php');
	include_once('../../includes_SISTEM/include_login.php');
	//llamado de modales el id es "busProd"
  $extra = "../../";
	include_once($extra."modales/prod/m_b_prod.php");
?>
<br>
<div class="bs-example" id="cargarRetInvent">
    <div class="">
    	<h1 class="bd-title">Aplicar Retiro al Inventario</h1>    
        
    </div>
	<div class="bs-marco-form">
      <form id="form1" name="form1" method="post" action="recibirRetirosInventario.php">
        <div class="row">
          <div class="col-xs-4 col-md-4 col-lg-4">
            <!--campos ocultos-->
            <input type="hidden" name="numCampos" />
            <input type="hidden" name="fk_usuariosRI" value="<?php echo $_SESSION["id_usu"]?>"/>
            <!--que usuario operador hiso el registro-->
            <!--CAMPOS QUE PUSE PARA QUE NO ME DE ERROR YA QUE EN COMPRAS VACIO CANTIDAD Y PVPMVJ-->
            <input name="cantidad" type="hidden" />
            <input name="pmpvj" type="hidden" />
            <label>Codigo Producto</label>
            <div class="list-group">
                <input name="fk_inventario" class="form-control list-group-item" id="fk_inventario" required="" onfocus="$('#busProd').modal('show');" onblur="javascript:this.value=this.value.toUpperCase();" data-bs-toggle="modal" data-target="#busProd" readonly="readonly" placeholder="Seleccionar Producto">
                <button type="button" class="list-group-item active" onclick="$('#busProd').modal('show');">Seleccionar Producto</button>
            </div>
          </div>
          <div class="col-xs-4 col-md-4 col-lg-4">
            <label>Nombre Producto</label>
            <div class="list-group">
                <input name="nom_fk_inventario" class="form-control list-group-item"  placeholder="Seleccionar Producto" onfocus="$('#busProd').modal('show');" onblur="javascript:this.value=this.value.toUpperCase();" data-bs-toggle="modal" data-target="#busProd" readonly="readonly">
                <button type="button" class="list-group-item active" onclick="$('#busProd').modal('show');">Seleccionar Producto</button>
            </div>
          </div>
          <div class="col-xs-4 col-md-4 col-lg-4">
            <label>Cantidad Actual</label>
            <div class="list-group">
                <input type="number" min="0" name="stock" class="form-control list-group-item" placeholder="Seleccionar Producto" readonly="readonly">
                <button type="button" class="list-group-item active" onclick="$('#busProd').modal('show');">Seleccionar Producto</button>
            </div>
            <!--cantidad actual en la bd es cant_a-->
          </div>
        </div><!--row-->
        <div class="row">
          <div class="col-xs-4 col-md-4 col-lg-4">
            <label>Costo Actual</label>
            <div class="list-group">
                <input type="number" min="0" step="0.01" name="costo" class="form-control list-group-item" placeholder="Seleccionar Producto" readonly>
                <button type="button" class="list-group-item active" onclick="$('#busProd').modal('show');">Seleccionar Producto</button>
            </div>
            <!--costo actual en la bd es costo_a-->
          </div>
          <div class="col-xs-4 col-md-4 col-lg-4" id="res_fecha_inv_retiros">
          	<span id="cont_fecha_inv_retiros">
            <label>Fecha de Retiro</label>
            <input type="date" name="fecha_inv_retiros" id="fecha_inv_retiros" class="form-control" onblur="val_comp_ii_fech(this.value, 'fecha_inv_retiros');" required/>
            </span>
          </div>
          <div class="col-xs-4 col-md-4 col-lg-4">
            <label>Cantidad a Retirar</label>
            <input type="number" min="0" name="cant_inv_retiros" id="cant_inv_retiros" class="form-control" onblur="valCantidadStock(this.value, document.form1.elements['stock'].value, 'cant_inv_retiros')" required/>
          </div>
        </div>
        <div class="row">
		  <div class="col-xs-4 col-md-4 col-lg-4">
            <label>Numero de Orden</label>
            <input type="text" name="orden_inv_retiros" class="form-control" required="required"/>
          </div>
          <div class="col-xs-4 col-md-4 col-lg-4">
            <label>Observaci&oacute;n</label>
            <input type="text" name="obs_inv_retiros" class="form-control"/>
          </div>
        </div>
        <hr id="res_restInvent" class="featurette-divider">
        <div class="row">
          <div class="col-xs-12 col-md-12 col-lg-12">
          <button type="submit" class="btn btn-lg btn-success col-xs-12 col-md-12 col-lg-12">Aplicar Retiro</button>
          </div>
        </div>
      </form>
    </div>
</div>
