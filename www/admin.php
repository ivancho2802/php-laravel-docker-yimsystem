<?php
include_once('includes_SISTEM/include_header.php');
include_once('includes_SISTEM/include_login.php');
//$sistem_root = SISTEM_ROOT;



/* $consulta2=pg_query($conexion,sprintf("
SELECT * FROM reg_inventario, inventario WHERE
        reg_inventario.fk_inventario = inventario.codigo
        ORDER BY fecha_reg_inv ASC"));
// $filas2 = $c_inv_menor->fetch_assoc();
$filas2=pg_fetch_assoc($consulta2);
print_r(pg_fetch_all($consulta2)); */
?>
<!DOCTYPE HTML>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <!--
<link rel="stylesheet" type="text/css" href="css/estilos_entrada.css"/>
<link rel="stylesheet" type="text/css" href="menu_assets/styles.css"/>
-->
  <!--					ESTILOS, JS BOOTSTRAP, JQUERY-->
  <?php include_once('includes_SISTEM/include_head.php'); ?>
  <!--					JS DEL MENU-->
  <script type="text/javascript">
    //funcion ajax para cargar el menu	
    $(document).ready(function() {

      function ajustarAltoIframe(iframe, extra) { //ejemplo ajustarAltoIframe("lcomprai")
        //document.getElementById('Noite').style.display='block';
        if (window.innerHeight) {
          //navegadores basados en mozilla 
          espacio_iframe = window.innerHeight
          //alert(window.innerHeight)
        } else {
          if (document.body.clientHeight) {
            //Navegadores basados en IExplorer, es que no tengo innerheight 
            espacio_iframe = document.body.clientHeight
          } else {
            //otros navegadores 
            espacio_iframe = 478
          }
        }

        document.getElementById(iframe).height = espacio_iframe + extra;
      }

      $('#myTabs').click('show', function(e) {
        paneID = $(e.target).attr('href');
        console.log("myTabs show", paneID);
        src = $(paneID).attr('data-src');
        // if the iframe hasn't already been loaded once
        if ($(paneID + " iframe").attr("src") == "") {
          $(paneID + " iframe").attr("src", src);
        }
        //ajusto el iframe de compra
        //COMPRAS
        ajustarAltoIframe("lcomprai", 1200); //	LIBRO DE COMPRAS
        ajustarAltoIframe("ccomprai", 1200); //	CARGAR COMPRA
        ajustarAltoIframe("mcomprai", 1200); //	MODIFICAR COMPRA
        ajustarAltoIframe("rcomprai", 1200); //	RETEN COMPRA
        ajustarAltoIframe("crcomprai", 1200); //	APLIC RETEN COMPRA
        //VENTAS
        ajustarAltoIframe("lventai", 1200); //	LIBRO DE VENTAS
        ajustarAltoIframe("cfactventai", 1200); //	CONSULTA FACTURA VENTA
        ajustarAltoIframe("cventai", 1200); //	CARGAR VENTAS 
        //INVENTARIO
        ajustarAltoIframe("cinventi", 1200); //	CARGAR INVENTARIO
        ajustarAltoIframe("movUnidadesi", 1200); //	MOVIMINTO INVENTARIO
        ajustarAltoIframe("cretinventi", 1200); //	RETIROS INVENTARIO
        //STATUS
        ajustarAltoIframe("homei", 1200); //	LIBRO DE COMPRAS

      });
      /*
      $('#principal').load( function () {
      	$(this).contents().css({});
      });
      
      $('.dropdown-menu').on('hidden.bs.collapse', function(e) {
      		
      alert();
      	paneID = $(e.target).attr('href');
      	src = $(paneID).attr('data-src');
      	// if the iframe hasn't already been loaded once
      	if($(paneID+" iframe").attr("src")=="" || $(paneID+" iframe").attr("src")=="unknown")
      	{
      		$(paneID+" iframe").attr("src",src);
      	}//$(paneID+" iframe").attr("src",src);
      });
      $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href") // activated tab
        alert(target);
      });
      $('#myTabs').on('shown.bs.myTabs', function () {
        // do something…
        alert();
      });
      $(function() {
      	$('.nav a').on('click', function(){ 
      		if($('.navbar-toggle').css('display') !='none'){
      			$(".navbar-toggle").trigger( "click" );
      		}
      	});
      });
      $(document).on('show.bs.tab', 'a[data-bs-toggle="tab"]', function (e) {
      	alert(target);
      	var tab = $(e.target);
      	var contentId = tab.attr("href");
      
      	//This check if the tab is active
      	if (tab.parent().hasClass('active')) {
      		 console.log('the tab with the content id ' + contentId + ' is visible');
      	} else {
      		 console.log('the tab with the content id ' + contentId + ' is NOT visible');
      	}
      
      });
      */
    });
  </script>
</head>

<body>
  <header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-bs-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Sistema</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">

          <ul class="nav navbar-nav" id="myTabs">
            <li class="active"><a href="#home" data-bs-toggle="tab">Home</a></li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Compras <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="#lcompra" data-bs-toggle="tab">Libro de Compras</a></li>
                <li><a href='#ccompra' data-bs-toggle="tab">Cargar Compras</a></li>
                <li><a href='#mcompra' data-bs-toggle="tab">Modificar Compras</a></li>
                <li role="separator" class="divider"></li>
                <li><a href='#rcompra' data-bs-toggle="tab">Reimprimir Comprobante</a></li>
                <li><a href='#crcompra' data-bs-toggle="tab">Aplicar Retencion</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Ventas <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href='#lventa' data-bs-toggle="tab">Libro de Ventas</a></li>
                <li><a href='#cventa' data-bs-toggle="tab">Cargar Ventas</a></li>
                <li><a href='#cfactventa' data-bs-toggle="tab">Consultar Fact. de Ventas</a></li>

                <!--
                <li role="separator" class="divider"></li>
                <li><a target='principal' href='modulos/ventas/'>Aplicar Retencion</a></li>
                -->
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Movimiento de Unidades <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a data-bs-toggle="tab" href='#cinvent'>Cargar Inventario Inicial</a></li>
                <li><a data-bs-toggle="tab" href='#movUnidades'>Consultar Movimiento de Unidades</a></li>
                <li><a data-bs-toggle="tab" href='#cretinvent'>Cargar Retiros del Inventario</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Utilidades <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a target='principal' href='modulos/user/#'>Usuarios</a></li>
              </ul>
            </li>
          </ul>

          <form class="bav navbar-nav navbar-form navbar-right" action="index.php" method="POST">
            <input type="hidden" name="msm" value="Tu Sesi&oacute;n a sido cerrada">
            <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-off"></span> Cerrar Sesi&oacute;n</button>
          </form>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Contactenos</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
  </header>
  <div class="container">
    <div class="tab-content">
      <div class="tab-pane" id="home" data-src="modulos/home/status.php">
        <iframe id="homei" src="" width="100%" height="" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
      </div>

      <div class="tab-pane" id="lcompra" data-src="modulos/compras/libroCompra.php">
        <iframe id="lcomprai" src="" width="100%" height="" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
      </div>

      <div class="tab-pane" id="ccompra" data-src="modulos/compras/cargarCompra.php">
        <iframe id="ccomprai" src="" width="100%" height="" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
      </div>

      <div class="tab-pane" id="mcompra" data-src="modulos/compras/modificarCompra.php">
        <iframe id="mcomprai" src="" width="100%" height="" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
      </div>

      <div class="tab-pane" id="rcompra" data-src="modulos/compras/retenCompra.php">
        <iframe id="rcomprai" src="" width="100%" height="" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
      </div>

      <div class="tab-pane" id="crcompra" data-src="modulos/compras/cargarRetenCompra.php">
        <iframe id="crcomprai" src="" width="100%" height="" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
      </div>
      <!--///////////////////////////////		VENTAS-->
      <div class="tab-pane" id="lventa" data-src="modulos/ventas/libroVenta.php">
        <iframe id="lventai" src="" width="100%" height="" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
      </div>

      <div class="tab-pane" id="cfactventa" data-src="modulos/ventas/factVenta.php">
        <iframe id="cfactventai" src="" width="100%" height="" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
      </div>

      <div class="tab-pane" id="cventa" data-src="modulos/ventas/cargarVenta.php">
        <iframe id="cventai" src="" width="100%" height="" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
      </div>
      <!--///////////////////////////////// INVENTARIO		-->
      <div class="tab-pane" id="cinvent" data-src="modulos/invent/cargarInvent.php">
        <iframe id="cinventi" src="" width="100%" height="" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
      </div>

      <div class="tab-pane" id="movUnidades" data-src="modulos/invent/movUnidad.php">
        <iframe id="movUnidadesi" src="" width="100%" height="" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
      </div>

      <div class="tab-pane" id="cretinvent" data-src="modulos/invent/cargarRetirosInvent.php">
        <iframe id="cretinventi" src="" width="100%" height="" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
      </div>




    </div>

    <div id="pie">
    </div> <!-- FIN pie -->
    </br>
    </br>
    <div id="perfil"></div>
    </br>
    </br>
    </br>
    </br>
    </br>
    </br>
    </br>
    <!-- Three columns of text below the carousel -->
    <div class="perfil">
      <div class="row">
        <div class="col-lg-4">
        </div>

        <div class="col-lg-4">
          <img class="img-thumbnail" src="logo.ico" alt="Generic placeholder image" title="IVT SAE" width="140" height="140">
          <!--para un circulo lo de src fino-->
          <!--<img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">-->

          <h2>Programador</h2>
          <p class="text_footer">
            ...
            <!--
                    Esta intranet esta desarrollada con el fin de satisfacer las necesidades tecnologicas en cuanto a la gestion y control de expedientes ,doy gracias por la oportunidad brindada pues sin uds grandes trabajadores esto no seria posible.<br>
                    Quien suscribe Pasante Ivan O. Diaz C. y recuerda.
                -->
          </p>
          <i>&ldquo; Nada es Imposible Para un corazon dispuesto &rdquo;.</i>
          <p><a class="btn btn-default" href="#" role="button">Ver detalles &raquo;</a></p>
          <br>
          <br>
          <br>
          <br>

        </div><!-- /.col-lg-4 -->

        <div class="col-lg-4">
        </div>
      </div><!--row perfil-->
    </div><!--div perfil-->
    <footer class="footer">
      <div class="container">
        <p class="text-footer">&copy; 2017-2018 for Ingeniero Ivan O. Diaz C. San Antonio-T&aacute;chira-Venezuela.</p>
        <time pubdate datetime="2017-12-01"></time>
      </div>
    </footer>
  </div> <!-- /container -->
<script type="text/javascript" src="<?php echo $uri.$extra?>js/jquery-3.6.0.min.js"></script>
  <script src="<?php echo $uri.$extra?>js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  
</body>

</html>
<?php
ob_end_flush();
?>