<?php include_once('../../includes_SISTEM/include_head.php');?>

<script>
//estas lineas estan en la funcion mmProv
function modRProd(formulario) {
	//funcion de validacion
	//alert(formulario);
	var valido = validarFormulario(formulario);
	
	if(valido==1)
	{
	  //paramentros y funciones de registro AJAX	
	  var xhttp;
	  //variables contenidas en el formulariuo
	  var codigo_m_m_prod_vie = $("input#codigo_m_m_prod_vie").val();
	  var codigo_m_m_prod_nue = $("input#codigo_m_m_prod_nue").val();
	  var nombre_i_m_m_prod = $("input#nombre_i_m_m_prod").val();
	  var cant_min_m_m_prod = $("input#cant_min_m_m_prod").val();
	  var cant_max_m_m_prod = $("input#cant_max_m_m_prod").val();
	  var descripcion_m_m_prod = $("input#descripcion_m_m_prod").val();
	  //var stock_m_m_prod = $("input#stock_m_m_prod").val();
	  //var valor_unitario_m_m_prod = $("input#valor_unitario_m_m_prod").val();
	  //var fecha_m_m_prod = $("input#fecha_m_m_prod").val();
	  
	  xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  document.getElementById("txtEdomodRProd").innerHTML = xhttp.responseText;
		  consulProd(" ");
		}
	  };
	  //xhttp.open("GET", "c.php?q="+str, true);
	  //xhttp.send();
	  
		xhttp.open("POST", extra+"modales/prod/m_prod.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("codigo_m_m_prod_vie="+ codigo_m_m_prod_vie +"&codigo_m_m_prod_nue="+ codigo_m_m_prod_nue +"&nombre_i_m_m_prod="+ nombre_i_m_m_prod +"&cant_min_m_m_prod="+ cant_min_m_m_prod +"&cant_max_m_m_prod="+ cant_max_m_m_prod +"&descripcion_m_m_prod="+ descripcion_m_m_prod);
		
		//YA NO VAN	 +"&stock_m_m_prod="+ stock_m_m_prod +"&valor_unitario_m_m_prod="+ valor_unitario_m_m_prod +"&fecha_m_m_prod="+ fecha_m_m_prod
		
		//si esto compila se puede insertar y seleccionar
		//selecProv(rif,nombre);
	}
		
}
</script>
<!-- Modal mmProv-->
    <div id="mmProd" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modificar Producto</h4>
          </div>
          <form name="form_mmProd" id="form_mmProd">
            <div class="modal-body">
              <div class="form-group" id="res_mmProd">
              
              </div><!--form-group-->
            </div><!--modal-bosy-->
            
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="modRProd(this.form);" >Modificar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <!-- onblur="codFactProvee('form1', 'serie_fact_compra', 'num_fact_compra', 'fk_proveedor', 'id_fact_compra');"-->
            </div>
          </form><!--form_mmProv-->
        </div><!--modal-content-->
      </div><!--modal-dialog modal-lg-->
    </div><!--mmProv-->
<script></script>