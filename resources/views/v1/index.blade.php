<?php
@session_start();
@$_SESSION["acceso"]=0;
@$_SESSION["usuario"]="";
@$_SESSION["privilegio"]="";
@session_destroy();
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/estilos_entrada.css" type="text/css"/>
<link  rel="stylesheet" type="text/css" href="menu_assets/styles.css"/>
-->
<!--					ESTILOS, JS BOOTSTRAP, JQUERY-->
<?php require_once('includes_SISTEM/include_head.php');?>
<script>
	<?php
	if(isset($_POST["msm"]) || isset($_SESSION["msm"])){//osea cuando cierro session por admin
		
	?>
	$( document ).ready(function() {
		document.getElementById('msm_login').setAttribute("class", "alert alert-danger alert-dismissible fade in");
	});
	<?php
	}
	?>
</script>
</head>
<body style="background:#f1f1f1;">
  <div class="" >
  	<h2 class="form-signin-heading" align="center">
      <label class="img-responsive">
        <img src="<?php if(isset($_SESSION['urlPrev']) && strpos($_SESSION['urlPrev'], 'modales'))
        					echo "../../logo.ico";
                         else 
						 	echo "logo.ico";?>" class="img_logo img-thumbnail" alt="Sistema">
      </label>
  	</h2>
    
	<form name="formulario" id="formulario" action="controladores/entrada.php" method="POST" class="form-signin">
        <div id="msm_login" class="alert alert-danger alert-dismissible fade" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <strong>Atenci&oacute;n!</strong> .<?php if(isset($_SESSION["msm"]) && $_SESSION["msm"] !== "")
		  												echo $_SESSION["msm"];
													elseif(isset($_POST["msm"]))
														echo $_POST["msm"];?>
        </div>
        <?php
			if(isset($_SESSION['urlPrev']) && strpos($_SESSION['urlPrev'], 'modales')){
				
			}else{
		?>
    	<h2 align="center">Bienvenidos</h2>
        <div class="row">
        <input type="hidden" name="urlPrev" value="<?php if(isset($_SESSION['urlPrev'])){
															if(strpos($_SESSION['urlPrev'], 'modales'))
																echo "";
															else
																echo $_SESSION['urlPrev'];
														 }
													?>"/>
        <label for="inputEmail" class="col-xs-12 col-md-12 col-lg-12">
          Usuario (admin)<br>
          <input type="text" name="usuario" id="usuario" class="form-control" value="<?php //echo $_SESSION['urlPrev']?>" required autofocus/>
        </label>
        </div>
        <div class="row">
        <label for="inputPassword" class="col-xs-12 col-md-12 col-lg-12">
          Contrase&ntilde;a (admin)<br>
          <input type="password" name="clave" id="clave" class="form-control" required>
        </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Recordarme
            </label>
        </div>
        <?php }?>
        <div class="row">
        	<label class="col-xs-12 col-md-12 col-lg-12">
	        <button name="Submit" class="btn btn-lg btn-primary btn-block" type="submit">
            Iniciar Sesi&oacute;n
            </button>
            </label>
        </div>
	</form>
  </div><!-- Container-->
</body>
</html>