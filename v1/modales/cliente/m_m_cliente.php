<?php include_once('../../includes_SISTEM/include_head.php');?>

<script>
//estas lineas estan en la funcion mmProv
function modRCliente(formulario) {
	//funcion de validacion
	//alert(formulario);
	var valido = validarFormulario(formulario);
	
	if(valido==1)
	{
	  //paramentros y funciones de registro AJAX	
	  var xhttp;
	  //variables contenidas en el formulariuo
	  var ced_cliente_m_vie = $("input#ced_cliente_m_vie").val();
	  var ced_cliente_m_nue = $("input#ced_cliente_m_nue").val();
	  var nom_cliente_m = $("input#nom_cliente_m").val();
	  var contri_cliente_m = document.getElementById("contri_cliente_m").value;
	  var email_cliente_m = $("input#email_cliente_m").val();
	  var tel_cliente_m = $("input#tel_cliente_m").val();
	  var dir_cliente_m = $("input#dir_cliente_m").val();
	  var fech_i_cliente_m = $("input#fech_i_cliente_m").val();


	  
	  xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  document.getElementById("txtEdomodRCliente").innerHTML = xhttp.responseText;
		  consulCliente(" ");
		}
	  };
	  //xhttp.open("GET", "c.php?q="+str, true);
	  //xhttp.send();
	  
		xhttp.open("POST", extra+"modales/cliente/m_cliente.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("ced_cliente_m_nue="+ ced_cliente_m_nue +"&ced_cliente_m_vie="+ ced_cliente_m_vie +"&nom_cliente_m="+ nom_cliente_m +"&contri_cliente_m="+ contri_cliente_m +"&email_cliente_m="+ email_cliente_m +"&tel_cliente_m="+ tel_cliente_m +"&dir_cliente_m="+ dir_cliente_m +"&fech_i_cliente_m="+ fech_i_cliente_m);
		
		//consulProv(" ");
		//si esto compila se puede insertar y seleccionar
		//selecProv(rif,nombre);
	}
		
}
</script>
<!-- Modal mmProv-->
    <div id="mmCliente" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modificar Proveedor</h4>
          </div>
          <form name="form_mmCliente" id="form_mmCliente">
            <div class="modal-body">
              <div class="form-group" id="res_mmCliente">
              
              </div><!--form-group-->
            </div><!--modal-bosy-->
            
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="modRCliente(this.form);" >Modificar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <!-- onblur="codFactProvee('form1', 'serie_fact_compra', 'num_fact_compra', 'fk_proveedor', 'id_fact_compra');"-->
            </div>
          </form><!--form_mmProv-->
        </div><!--modal-content-->
      </div><!--modal-dialog modal-lg-->
    </div><!--mmProv-->
<script></script>