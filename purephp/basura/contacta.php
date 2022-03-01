<!DOCTYPE html>
	<html lang="en">
  	<head>
    	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <meta name="application-name" content="Gestor de páginas web" />
      <meta name="author" content="tipolisto.es">
      <meta name="description" content="Tipolisto es un sistema de puntuación y clasificación de webs, para que siempre estés al día de las mejores webs, puedes gestionar gestionar tus propias webs.">
      <meta name="generator" content="Bootstrap" />
      <meta name="keywords" content="Gestor webs, páginas web, websites, manager websites" />
        
    	<link rel="icon" href="imagenes/favicon.ico">
		
      	<title>Gestor de p&aacute;ginas webs</title>
		<link href="css/miestilo.css" rel="stylesheet">
       <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Latest compiled and minified JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Custom styles for this template -->
        <link href="css/bootstrap-theme.css" rel="stylesheet">
        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
      </head>

      <body ">
        <div class="container">
			<?php require('barrainicio.php'); ?>
			<?php require('barramenu.php'); ?>

		 <div class="row">

        <div class="col-xs-12 col-sm-6 col-md-2">
        	 <div id="girando">GW</div>
				<?php
				if($_SESSION['nivelaccesousuario']==null || $_SESSION['nivelaccesousuario']==0){ //usuario no logeado
					echo "";
				}else if($_SESSION['nivelaccesousuario']==1){ //administrador
					?>
						 <ul class="nav navbar-nav" >
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admgestionarusuarios.php'  >Gestionar usuarios</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admcategorias.php'  >Gestionar categorias</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admgestionarwebs.php'>Gestionar webs</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admgestionarpasear.php'  >Gestionar pasear</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admgestionarimagenes.php'  >Gestionar imagenes</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/gestionarcomentariosweb.php' >Gestionar comentarios web</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/gestionarcomentarioscategoria.php'>Gestionar comentarios categoria</a></li>
						</ul>   
					<?php
				}else{ //Usuario logeado
					?>
                     	<ul class="nav navbar-nav" >
                    <?php
							echo "<li><a href='http://www.gestorwebs.tipolisto.es/gestionarusuarios.php?accion=4&idusuario=$_SESSION[idusuario]' >Mis datos</a></li>";
					?>
                            <li><a href='http://www.gestorwebs.tipolisto.es/usuarios/usuariosgestionarcategorias.php' >Gestionar mis categorias</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/usuarios/usuariosgestionarwebs.php'  >Gestionar mis webs</a></li>
                        </ul>
               		<?php
				}
				?>
        </div>
    	<div class="col-xs-12 col-sm-10 col-md-6">
       			 <?php
					if(isset($_GET['mensaje'])) echo "<h4><span class='label label-danger'>".$_GET['mensaje']."</span></h4>";
				?>






	




                        <img src="imagenes/estrella.png"  style="float:left; padding:20px;"/>
                        <p>Hola, soy Ada, estás en mi web.</p>
                        <p>Tipolisto es un sistema de puntuación y clasificación de webs, para que siempre estés al día de las mejores webs, como leer la prensa, encontrar trabajo , compras, etc...</p>
                        <p>Todas las webs tienen una categoría, las mejores webs son premiadas con la medala de oro, plata y bronce.</p>
                        <p>Tú, votando a una web haces que la web sea la medalla de oro de esa categoría</p>
                        <p>Son muy importantes tus comentarios para mí,ya sea de una web o de una categoría, así me permitirás ordenar las webs de una forma más eficiente o poner webs que no conocía para que los demás la voten.</p>
                        <p>Si pinchas en pasear, podr&aacute;s ver las webs que m&aacute;s me han gustado.</p>
                        <p>He creado un sistema en el que puedes gestionar tus propias webs y categorías, cada vez que abras la web tipolisto.es verás diréctamente tus webs organizadas como tú las configures.</p>
                        <!-- <p>Si pagas 1 euro, tendrás un usuario privilegiado y podrás crear todas las categorias y webs que quieras en tu menú personal, también podrás asignarle imágenes a las webs.</p>. -->
                        <p>Para cualquier consulta que quieras hacerme puedes dejarme un comentario en el foro o enviarme un email a ada@gestorwebs.tipolisto.es</p>
                        <p>Un beso, atte: Ada</p>
                        
                        
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
   
    
    
			</div><!--final del div central -->
            <div class="col-xs-12 col-sm-12 col-md-4">
           		<iframe src="http://www.chat.tipolisto.es/chat.php?idchat=32" name="iframe1" height='800px' scrolling="no" frameborder="0"></iframe>
            </div>
        </div> <!-- final de la fila -->
            <hr>
        	
            <footer>
               <br /><br /><br /><br /><p>&copy; Tipolisto.es 2015</p>
            </footer>
     </div> <!-- final del container -->
        
        
            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script language="javascript" src="js/micodigo.js"></script>
            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
            <script src="js/ie10-viewport-bug-workaround.js"></script>
          </body>
        </html>
        