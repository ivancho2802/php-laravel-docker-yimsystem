<?php
	if( isset($_GET['id']) ){
		//RDV
		//FNULL
		if($_GET['id'] == 'ND' || $_GET['id'] == 'NC'){
			//CONSULTA DE TODAS LOSDOCUMENTO TIPO FACTURAS Y DE HAY LA SELECCIONA
			include_once("../conexion.php");	
			$consulDocu = pg_query($conexion,"SELECT * FROM fact_venta WHERE tipo_fact_venta = 'F'");
			$resconsulDocu = $consulDocu->fetch_assoc();
			$total_consulDocu = mysqli_num_rows($consulDocu);
?>
			<span id="span_resTipoDoc">N° Factura Afectada:<br></span>
            <input type="hidden" name="reg_maq_fis">
            <input list="browsers" name="nfact_afectada" placeholder="Si no existe debe registrarla" required>
            <datalist id="browsers">
                <?php do{?>
                      <option value="<?php echo $resconsulDocu['serie_fact_venta'].$resconsulDocu['num_fact_venta'];?>">
                <?php }while($resconsulDocu = $consulDocu->fetch_assoc())?>
            </datalist>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		}else echo "Seleccione";
	}