<?php
	session_start();
	if(isset($_COOKIE['idusuario'])){
		//header("Location: usuarios/usuariosgestionarwebs.php");
		echo "<script type='text/javascript'>location.href='usuarios/usuariosgestionarwebs.php';</script>";
		exit();
	}
?>
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
        
    	<link rel="icon" type="image/png" href="/imagenes/icono.png" />
		
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
			<?  require('barrainicio.php'); ?>
			<?  require('barramenu.php'); ?>
            <?  require('mysqlusuarios.php'); ?>
		 <div class="row">

        <div class="col-xs-12 col-sm-6 col-md-2">
        	 <div id="girando">GW</div>
				<?php									
				if($_SESSION['nivelaccesousuario']==null || $_SESSION['nivelaccesousuario']==0){ //usuario no logeado
					echo "<ul class='nav navbar-nav' >";
					echo "<li><a href='http://www.gestorwebs.tipolisto.es/gestionarusuarios.php?accion=20' >Mis datos</a></li>";
					echo "<li><a href='http://www.gestorwebs.tipolisto.es/gestionarusuarios.php?accion=20' >Gestionar mis categorias</a></li>";
                    echo "<li><a href='http://www.gestorwebs.tipolisto.es/gestionarusuarios.php?accion=20'  >Gestionar mis webs</a></li>";
					echo "</ul>";
					echo "<span style='color:red'>Tus categorias</span>";
				}else if($_SESSION['nivelaccesousuario']==1){ //administrador
					?>
						 <ul class="nav navbar-nav" >
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admgestionarusuarios.php'  >Gestionar usuarios</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admcategorias.php'  >Gestionar categorias</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admgestionarwebs.php'>Gestionar webs</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admgestionarimagenes.php'  >Gestionar imagenes</a></li>
                            <li><a href='http://www.gestorwebs.tipolisto.es/adm/admgestionarpasear.php'  >Gestionar pasear</a></li>
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
					echo "<span style='color:red'>Tus categorias</span>";
					if($_SESSION['nivelaccesousuario']==3){
						dibujarLayoutCategorias();
					}
				}
				?>
                
        </div>
    	<div class="col-xs-12 col-sm-8 col-md-6">
       			 <?php
					if(isset($_GET['mensaje'])) echo "<h4><span class='label label-danger'>".$_GET['mensaje']."</span></h4>";
				?>






























<?php
	require('Mysql.php');
	require('Web.php');
	


	

	
	
	function cortarCadena($cadena){
		//Strip_tags: retira las etiquetas HTML y PHP de un String
		//substr($cadena, corta inicio, corta final)
		//strlen: devuelve la longitud de la cadena
		$longitud = 20;
		$stringDisplay = substr(strip_tags($cadena), 0, $longitud);
		if (strlen(strip_tags($cadena)) > $longitud)
        	$stringDisplay .= ' ...';
		return $stringDisplay;
	}
	function formatearCadena($cadena){
		//$arrayDeAsABuscar=array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä');
        //$arrayDeAsSustituidas('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A');
		$cadena=html_entity_decode($cadena);
		$cadena= str_replace(" ", "&nbsp;", $cadena);
		return $cadena;
	}
	function quitarEspaciosEnBlancoPrincipioYFinal($cadena){
		$cadenaLimpia=trim($cadena);
		//$cadenaLimpia=urlencode($cadenaLimpia);
		return $cadenaLimpia;
		
	}
	function obtenerNombreWeb($idWeb){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs WHERE idWeb='".$idWeb."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			return $linea['nombreweb'];
		}
		$basededatos->desconectar();
	}
	function obtenerTodosLasUltimasCincoWebs(){
		$webs=array();
		$mysql=new Mysql();
		$mysql->conectar_mysql();
		$consulta  = "SELECT * FROM webs ORDER BY idweb DESC LIMIT 3";
		$resultado=$mysql->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) {
			$web=new Web($linea['idweb']);
			$web->setNombreWeb($linea['nombreweb']);
			$web->setTituloWeb($linea['tituloweb']);
			$web->setDescripcionWeb($linea['descripcionweb']);
			$web->setFechaWeb($linea['fechaweb']);
			$web->setTagsWeb($linea['tagsweb']);
			$web->setCategoriaWeb($linea['categoriaweb']);
			$web->setNumeroVotosWeb($linea['numerovotosweb']);
  			$web->setMediaVotosWeb($linea['mediavotosweb']);
			$web->setImagenWeb($linea['imagenweb']);
			$web->setContadorWeb($linea['contadorweb']);
			$webs[]=$web;
		}
		$mysql->desconectar();
		/*$mysql=new mysqli('db591523582.db.1and1.com', 'dbo591523582', '41434143','db591523582');
		$consulta  = "SELECT * FROM webs ORDER BY idweb DESC LIMIT 3";
		$resultado=$mysql->query($consulta);
		while ($linea = mysqli_fetch_array($resultado)) {
			$web=new Web($linea['idweb']);
			$web->setNombreWeb($linea['nombreweb']);
			$web->setTituloWeb($linea['tituloweb']);
			$web->setDescripcionWeb($linea['descripcionweb']);
			$web->setFechaWeb($linea['fechaweb']);
			$web->setTagsWeb($linea['tagsweb']);
			$web->setCategoriaWeb($linea['categoriaweb']);
			$web->setNumeroVotosWeb($linea['numerovotosweb']);
  			$web->setMediaVotosWeb($linea['mediavotosweb']);
			$web->setImagenWeb($linea['imagenweb']);
			$web->setContadorWeb($linea['contadorweb']);
			$webs[]=$web;
		}
		$mysql->close();*/
		return $webs;		
	}
	
	
	
	function recorrerCategorias($nivelCategoria, $categoriaeshijade){//Esta funcion es solo par alos usuarios registrados
		$nivelCategoria++;
		$basededatos1= new mysqlusuarios();
		$basededatos1->conectar_mysql();
		$consulta1  = "SELECT * FROM categorias_".$_SESSION[idusuario]." WHERE nivelcategoria='".$nivelCategoria."' && idpadrecategoria='".$categoriaeshijade."' ORDER BY nombrecategoria";
		$resultado1=$basededatos1->ejecutar_sql($consulta1);
		for($i=2;$i<$nivelCategoria;$i++){
			$espacios=$espacios."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		while ($linea1 = mysqli_fetch_array($resultado1)) 
		{
			echo "<li>".$espacios."|__  <a href=usuarios/usuariosgestionarwebs.php?categoriaweb=$linea1[idcategoria] > ".$linea1['nombrecategoria']."</a></li>";
			if ($linea1['categoriaeshijade'] != null){
				recorrerCategorias($nivelCategoria, $linea1['idcategoria'] );							
			}
		}
		$basededatos1->desconectar();
	}



	function dibujarLayoutCategorias(){//Esta funcion es para los usuaros registrados
		$nivelCategoria=1;
		//echo "<div class='col-xs-6 col-md-2'>";
			$basededatos= new mysqlusuarios();
			$basededatos->conectar_mysql();
			$consulta= "SELECT * FROM categorias_".$_SESSION[idusuario]." WHERE nivelcategoria=".$nivelCategoria." ORDER BY nombrecategoria";
			$resultado=$basededatos->ejecutar_sql($consulta);
			echo "<ul style='list-style:none'>";
					while ($linea = mysqli_fetch_array($resultado)) 
					{
							echo "<li> <a href=usuarios/usuariosgestionarwebs.php?categoriaweb=$linea[idcategoria] > ".$linea['nombrecategoria']."</a></li>";
							recorrerCategorias($nivelCategoria, $linea['idcategoria'] );	
					}
					$basededatos->desconectar();
			echo "</ul>";
		//echo "</div>";
	}


	
	function dibujarLayoutWebs($webs){
			$contador=0;
			foreach ($webs as $posicion=>$web){
				$bgcolor='#B3FFF3';
				$contador++;
				if (($contador%2)==0){
						$bgcolor='#FAFEB1';
				}
				echo "<div class='contenedorimagenesdewebs' >";
				echo "<center ><a href='http://".$web->getNombreWeb()."' target='_blank' class='tituloweb' >";
				echo cortarCadena($web->getTituloWeb())."";
				echo "<br /><span style='color:black; font-size:10px;'>Enlace: ".cortarCadena($web->getNombreWeb())."</span></a>";
				echo "<br /><pre class='contenedorcomentarios'>".$web->getDescripcionWeb()."</pre>";
				echo "<br /><a href='http://".$web->getNombreWeb()."' target='_blanck' class='tituloweb' ><img src='imagenes/webs/".$web->getImagenWeb()."'  class='img-responsive' width='500px' /></a></center>";
				echo "<br /><span>".$web->getMediaVotosWeb()." <a href='gestionarwebs?accion=4&idWeb=".$web->getIdWeb()."'> Votar</a></span >";
				echo "<br /><a href=gestionarwebs.php?accion=1&idWeb=".$web->getIdWeb()." >Detalles...</a><br />";
				echo "<br />";
				if($_SESSION['nivelaccesousuario']==1){
						echo "<a href='adm/admgestionarwebs.php?accion=2&idWeb=".$web->getIdWeb()."'>Editar, <span style='color:red'> solo administrador</span></a>";
				}
				echo "</div>";
				echo "<br />";
			}
	}
		
		
			
			
	
	/*********************************************Main*****************************************/
		
		$webs=array();
		$webs=obtenerTodosLasUltimasCincoWebs();
		dibujarLayoutWebs($webs);
		
?>


		






















			



			</div><!--final del div central -->
            <?php
			/*
			require_once ('Mobile_Detect.php');
				$detect = new Mobile_Detect();
				if ($detect->isMobile()==false) {
					echo "<div class='col-xs-12 col-sm-12 col-md-4'>";
						echo "<iframe src='http://www.chat.tipolisto.es/chat.php?idchat=32' name='iframe1' height='800px' scrolling='no' frameborder='0'></iframe>";
					echo "</div>";
				}
			*/
             ?>
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
        