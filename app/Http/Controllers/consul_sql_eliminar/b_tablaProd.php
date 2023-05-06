<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');


if(isset($_POST['id_fact_compra']))
{		
		//recibo la variable post
		$fact = $_POST['id_fact_compra'];	
		//realizo el sql
		$consulta=pg_query($conexion,sprintf("SELECT * FROM fact_compra, compra, inventario WHERE
									fact_compra.id_fact_compra = '%s' AND
									compra.fk_fact_compra = fact_compra.id_fact_compra AND
									compra.fk_inventario = inventario.codigo",
									$fact));
		$filas=pg_fetch_assoc($consulta);
		$total_consulta = pg_num_rows($consulta);
}
?>
<table class="table_nada table table-bordered table_black">
  <thead id="resCompra">
    <tr>
        <th width="16.5%"><p>Codigo Producto</p></th>
        <th width="16.5%"><p>Nombre Producto</p></th>
        <th width="16.5%"><p>Costo (BsF.) &frasl; Precio de Venta</p></th>
        <th width="16.5%"><p>Cantidad</p></th>
        <th width="24%"><p>Tipo de Compra</p></th>
        <th width="10%"><p align="center">Accion</p></th>
    </tr>
    <?php
	if($total_consulta >= 1){
		$i = 1;
		do{
		
		
		$consulta2 = pg_query($conexion,sprintf("SELECT * FROM inventario, reg_inventario WHERE
									reg_inventario.fk_inventario = inventario.codigo AND
									reg_inventario.fk_inventario = '%s'",
									$filas['codigo']));
		// $filasPMPVJ = $consultaPMPVJ->fetch_assoc();
        $filas2=pg_fetch_assoc($consulta2);
		$total_consultaPMPVJ = pg_num_rows($consulta2);
		
	?>
    	
        
        <tr class="alert fade in">
        <td>
        <input name="id_compra<?php echo $i?>" hidden="">
        <input name="fk_inventario<?php echo $i?>" class="form-control btn-primary active" required="" onclick="ctrlSelecProd(<?php echo $i?>)" onfocus="ctrlSelecProd(<?php echo $i?>)" readonly="readonly" placeholder="Clic aqui" value="<?php echo $filas['codigo']?>">
        </td>
        <td>
        <input name="nom_fk_inventario<?php echo $i?>" class="form-control btn-primary active" onclick="ctrlSelecProd(<?php echo $i?>)" readonly="readonly" placeholder="Clic aqui" value="<?php echo $filas['nombre_i']?>">
        </td>
        <td>
        <input class="form-control btn-primary active" name="costo<?php echo $i?>" required="" type="number" min="0" step="0.0000001" value="<?php echo $filas['costo']?>" placeholder="0.00 Clic aqui" onblur="fcalculo()"/>
        <br>
        <span class="input-group">
            <input class="form-control" name="pmpvj<?php echo $i?>" id="pmpvj<?php echo $i?>" type="number" min="0" step="0.0000001" value="<?php echo $filas2['pmpvj']?>" placeholder="0.00"  required="required"  readonly="readonly"/>
            <span class="input-group-btn">
                <button class="btn btn-primary" type="button" onclick="ctrlSelecPMPVJ(<?php echo $i?>)">P. Venta</button>
            </span>
        </span>
        </td>
        <td>
        <span class="input-group">
            <input class="form-control" name="cantidad<?php echo $i?>" required="" type="number" min="0" onblur="fcalculo()" value="<?php echo $filas['cantidad']?>"/>
                <span class="input-group-addon">
                    /
                </span>
            <input class="form-control" name="stock<?php echo $i?>" type="text" value="<?php echo $filas['stock']?>" readonly="readonly">
        </span>
        </td>
        <td>
        <select name="tipoCompra<?php echo $i?>" id="tipoCompra<?php echo $i?>" class="selectpicker form-control" data-style="btn-primary" onchange="fcalculo(1)">
            <optgroup label="Internas">
                <option value="<?php echo $filas['tipoCompra']?>" ><?php echo $filas['tipoCompra']?></option>
                <option value="IN_EX">Internas Exentas</option>
                <option value="IN_EXO">Internas Exoneradas</option>
                <option value="IN_NS">Internas No Sujetas</option>
                <option value="IN_SDCF">Internas Sin derecho a Credito Fiscal</option>
                <option value="IN_BI_12">Internas Base Imponible al 12%</option>
                <option value="IN_BI_8">Internas Base Imponible al 8%</option>
                <option value="IN_BI_27">Internas Base Imponible al 27%</option>
            </optgroup>
            <optgroup label="Importaciones">
                <option value="IM_EX">Importaciones Exentas</option>
                <option value="IM_EXO">Importaciones Exoneradas</option>
                <option value="IM_NS">Importaciones No Sujetas</option>
                <option value="IM_SDCF">Importaciones Sin derecho a Credito Fiscal</option>
                <!--<option value="IM_BI_12">Importaciones Base Imponible al 12%</option>-->
                <option value="IM_BI_8">Importaciones Base Imponible al 8%</option>
                <option value="IM_BI_27">Importaciones Base Imponible al 27%</option>
            </optgroup>
        </select>
        </td>
        <td align="center">
        	<?php if($i == 1){?>
			
			<?php }else{?>
        	<button class="btn btn-sm btn-danger" type="button" data-dismiss="alert" aria.label="close" onclick="elimInput(<?php echo $i?>)"><span class="glyphicon glyphicon-minus"></span></button>
            <?php }?>
        </td>
    </tr>
	<?php
			$i++;
		}while($filas=pg_fetch_assoc($consulta));
	}else{
	?>
		<tr>
		  <td colspan="5"><div>No hay resultados La Factura Debe Existir en el Sistema??</div></td>
	<!--data-bs-toggle="modal" data-target="#nueProv" para agregar y con dismis cierra el actual-->
		</tr>
	<?php    
	}
	?>
  </thead>
  <tbody>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center">
            <input type="hidden" name="numCampos" value="<?php echo $total_consulta?>">
            <input type="hidden" name="numCampoActual" /><!--solo para el modal seleccion-->
            <button class="btn btn-sm btn-primary" type="button" onClick="agreInput(document.form1.numCampos.value)">
            <span class="glyphicon glyphicon-plus"></span>
            </button>
        </td>
    </tr>
  </tbody>
</table>