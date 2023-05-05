<?php include_once('../../includes_SISTEM/include_head.php');?>

<script>
//estas lineas estan en la funcion mmProv
function modRProv(formulario) {
	//funcion de validacion
	//alert(formulario);
	var valido = validarFormulario(formulario);
	
	if(valido==1)
	{
	  //paramentros y funciones de registro AJAX	
	  var xhttp;
	  //variables contenidas en el formulariuo
	  var rif_vie = $("input#rif_m_m_prov_vie").val();
	  var rif_nue = $("input#rif_m_m_prov").val();
	  var nombre = $("input#nombre_m_m_prov").val();
	  var telefono = $("input#telefono_m_m_prov").val();
	  var direccion = $("input#direccion_m_m_prov").val();
	  
	  
	  xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  document.getElementById("txtEdomodRProv").innerHTML = xhttp.responseText;
		  consulProv(" ");
		}
	  };
	  //xhttp.open("GET", "c.php?q="+str, true);
	  //xhttp.send();
	  
		xhttp.open("POST", extra+"modales/prov/m_prov.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("rif_nue="+ rif_nue +"&rif_vie="+ rif_vie +"&nombre="+ nombre +"&telefono="+ telefono +"&direccion="+ direccion);
		
		//consulProv(" ");
		//si esto compila se puede insertar y seleccionar
		//selecProv(rif,nombre);
	}
		
}
</script>
<!-- Modal mmProv-->
    <div id="mmProv" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modificar Proveedor</h4>
          </div>
          <form name="form_mmProv" id="form_mmProv">
            <div class="modal-body">
              <div class="form-group" id="res_mmProv">
              
              </div><!--form-group-->
            </div><!--modal-bosy-->
            
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="modRProv(this.form);" >Modificar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <!-- onblur="codFactProvee('form1', 'serie_fact_compra', 'num_fact_compra', 'fk_proveedor', 'id_fact_compra');"-->
            </div>
          </form><!--form_mmProv-->
        </div><!--modal-content-->
      </div><!--modal-dialog modal-lg-->
    </div><!--mmProv-->
<script></script>