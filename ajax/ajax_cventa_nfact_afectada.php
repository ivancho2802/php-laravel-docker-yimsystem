<?php
	if( isset($_GET['id']) ){
		//RDV
		//FNULL
		if($_GET['id'] == 'ND' || $_GET['id'] == 'NC'){
			//CONSULTA DE TODAS LOSDOCUMENTO TIPO FACTURAS Y DE HAY LA SELECCIONA
			include_once("../conexion.php");	
			$consulta = pg_query($conexion,"SELECT * FROM fact_venta WHERE tipo_fact_venta = 'F'");
			// $resconsulDocu = $consulDocu->fetch_assoc();
			$filas=pg_fetch_assoc($consulta);

			$total_consulDocu = pg_num_rows($consulDocu);
?>
			<span id="span_resTipoDoc">N° Factura Afectada:<br></span>
            <input type="hidden" name="reg_maq_fis">
            <input list="browsers" name="nfact_afectada" placeholder="Si no existe debe registrarla" required>
            <datalist id="browsers">
                <?php do{?>
                      <option value="<?php echo $filas['serie_fact_venta'].$filas['num_fact_venta'];?>">
                <?php //}while($filas=pg_fetch_assoc($consulta))?>
                <?php }while($filas = pg_fetch_assoc($consulta))?>
            </datalist>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		}else echo "Seleccione";
	}