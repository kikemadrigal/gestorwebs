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


    	<link rel="icon" href="/imagenes/favicon.ico">
		
      	<title>Gestor de p&aacute;ginas webs</title>
		<link href="/css/miestilo.css" rel="stylesheet">
       <!-- Bootstrap core CSS -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <!-- Latest compiled and minified JavaScript -->
        <script src="/js/bootstrap.min.js"></script>
        <!-- Custom styles for this template -->
        <link href="/css/bootstrap-theme.css" rel="stylesheet">
        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
      </head>

      <body>
        <div class="container">
			<?php require('barrainicio.php'); ?>
			<?php require('barramenu.php'); ?>
			<?  require('mysqlusuarios.php'); ?>
		 <div class="row">

        <div class="col-xs-12 col-sm-6 col-md-4">
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
					if($_SESSION['nivelaccesousuario']==3){
						echo "<span style='color:red'>Tus categorias</span>";
						dibujarLayoutCategoriasUsuario();
					}
				}
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
        </div>
    	<div class="col-xs-12 col-sm-10 col-md-8">
       			 <?php
					if(isset($_GET['mensaje'])) echo "<h4><span class='label label-danger'>".$_GET['mensaje']."</span></h4>";
				?>



























<?php

	require('Mysql.php');
	require('Web.php');
	require('Mobile_Detect.php');
				
	
	
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
	function quitarEspaciosEnBlancoPrincipioYFinal($cadena){
		$cadenaLimpia=trim($cadena);
		//$cadenaLimpia=urlencode($cadenaLimpia);
		return $cadenaLimpia;
		
	}
	function recorrerCategoriasUsuario($nivelCategoria, $categoriaeshijade){//Esta funcion es solo par alos usuarios registrados
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
			echo "<li>".$espacios."|__  <a href=/usuarios/usuariosgestionarwebs.php?categoriaweb=$linea1[idcategoria] > ".$linea1['nombrecategoria']."</a></li>";
			if ($linea1['categoriaeshijade'] != null){
				recorrerCategoriasUsuario($nivelCategoria, $linea1['idcategoria'] );							
			}
		}
		$basededatos1->desconectar();
	}



	function dibujarLayoutCategoriasUsuario(){//Esta funcion es para los usuaros registrados
		$nivelCategoria=1;
		//echo "<div class='col-xs-6 col-md-2'>";
			$basededatos= new mysqlusuarios();
			$basededatos->conectar_mysql();
			$consulta= "SELECT * FROM categorias_".$_SESSION[idusuario]." WHERE nivelcategoria=".$nivelCategoria." ORDER BY nombrecategoria";
			$resultado=$basededatos->ejecutar_sql($consulta);
			echo "<ul style='list-style:none'>";
					while ($linea = mysqli_fetch_array($resultado)) 
					{
							echo "<li> <a href=/usuarios/usuariosgestionarwebs.php?categoriaweb=$linea[idcategoria] > ".$linea['nombrecategoria']."</a></li>";
							recorrerCategoriasUsuario($nivelCategoria, $linea['idcategoria'] );	
					}
					$basededatos->desconectar();
			echo "</ul>";
		//echo "</div>";
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
	function obtenerNombreCategoria($idCategoria){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT nombrecategoria FROM categorias WHERE idcategoria='".$idCategoria."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			return $linea['nombrecategoria'];
		}
		$basededatos->desconectar();
	}

	function url_exists($url)
	{
		$file_headers = @get_headers($url);
		if(strpos($file_headers[0],"200 OK")==false)
		{
			/*if(strpos($file_headers[0],"301 Moved")==true){
				$iframe=substr($file_headers[4], 10, strlen($file_headers[4]));
				//echo "Web movida a <a href='".$iframe."' target='_blank'>".$iframe."</a>";
				return false;
			}*/
			echo $file_headers[0];
			//print_r($file_headers);
			$exists = false;
			return false;
		}
		else
		{
			$exists = true;
			return true;
		}
	}
	function obtenerTituloCategoria($idCategoria){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT titulocategoria FROM categorias WHERE idcategoria='".$idCategoria."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			return $linea['titulocategoria'];
		}
		$basededatos->desconectar();
	}
	
	
	
	
	
	function paginacion($idCategoria, $inicio, $TAMANO_PAGINA){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta2  = "SELECT * FROM webs WHERE categoriaweb='".$idCategoria."' ORDER BY mediavotosweb DESC ";
		$consulta  = "SELECT * FROM webs WHERE categoriaweb='".$idCategoria."' ORDER BY mediavotosweb DESC limit ".$inicio .", ".$TAMANO_PAGINA." ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$resultado2=$basededatos->ejecutar_sql($consulta2);
		$total_registros=mysqli_num_rows($resultado);
		if($total_registros==FALSE){
			echo" <p>No se obtuvo ning&uacute;n resultado.</p>"	;
		}else{
				$total_registros_sin_limitacion=mysqli_num_rows($resultado2);
				$resultado=$basededatos->ejecutar_sql($consulta);
				$total_paginas = ceil($total_registros_sin_limitacion / $TAMANO_PAGINA); 
				if ($total_paginas > 1){
						for ($i=1;$i<=$total_paginas;$i++){
								if ( $pagina == $i){
											//si muestro el índice de la página actual, no coloco enlace
											echo  $pagina . " ";
								}
								else{
											//si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página
											echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='/gestionarwebs.php?pagina=" . $i ."&idCategoria=$idCategoria' ><span style='font-size:24px;color:red;'>" . $i . "</span></a> ";
								}
						}
				}
		}	
		
	}
	
	
	
	
	
	
	function obtenerTodosLasWebsDeUnaCategoria($idCategoria, $inicio, $TAMANO_PAGINA){
		
		$webs=array();
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs WHERE categoriaweb='".$idCategoria."' ORDER BY mediavotosweb DESC limit ".$inicio .", ".$TAMANO_PAGINA." ";
		
		$resultado=$basededatos->ejecutar_sql($consulta);
		
		while ($linea = mysqli_fetch_array($resultado)) 
		{
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
			$webs[]=$web;
		}
		$basededatos->desconectar();
		return $webs;
	}

	global $ruta;
	function obtenerArbolDeCategorias($idCategoria){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT idpadrecategoria FROM categorias WHERE idcategoria='".$idCategoria."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$idPadreCategoria=$linea['idpadrecategoria'];
			$GLOBALS["ruta"] .=">".$idPadreCategoria;
			if($idPadreCategoria != null){
				obtenerArbolDeCategorias($idPadreCategoria);
			}
		}
		$basededatos->desconectar();
	}
	
	
	
	function mostrarArbolDeCategorias($arbol){
		foreach ($arbol as $posicion=>$hoja){
			echo "<li><a href='#'>".$hoja."</a></li>";
		}
	}
	
	

	function pedirComentarioWeb($idWeb){
		
	?>
		<form method=post action='gestionarwebs.php' class='form-horizontal'>
		
			<div class='form-group contenedorcomentarios' style='font-size:14px' >
		            <label for='nombreComentarioWeb' class='control-label col-md-4'>Nombre:</label>
		            <div class='col-md-12'>
        						<input type='text' class='form-control' name='nombreComentarioWeb' id='nombreComentarioWeb'  title='Nombre de 3 a 5 carácteres alfanuméricos' pattern='[a-zA-Z0-9\d_ ]{3,50}' placeholder="Tu nombre:"  required >
                    </div>
		    </div> 
		    <div class='form-group' style='font-size:14px' >
		               <label for='textoComentarioWeb' class='control-label col-md-4'>Descripcion:</label>
		                <div class='col-md-12'>
                        	<textarea class='form-control' name='textoComentarioWeb' id='textoComentarioWeb'  title='De 3 a un motón de carácteres alfanuméricos sin símbolos raros ' pattern='[a-zA-Z0-9\d_]{3,50000}' placeholder="Comentario:" required></textarea>
                        </div>
		    </div>
		    <input type=hidden name='idWeb' value='<?php echo $idWeb;?>'></input>  
		 	<input type=hidden name='accion' value=6></input>  
		    <div class='form-group' > 
		          <div class='col-md-10 col-md-offset-4' >
                       <input type='submit' value='Insertar' class='btn btn-primary' ></input> 
                   </div>
		    </div> 
		
		  </form> 
         
		<?php	
		
		
		
	}


	
	
	
	
	function pedirComentarioCategoria($idCategoria){
	?>
		<form method=post action='/gestionarwebs.php' class='form-horizontal'>
			<div class='form-group'>
            	<label for='nombreComentarioCategoria' class='control-label '>Nombre:</label>
                <div class='col-md-12'>
                        <input type='text' class='form-control' name='nombreComentarioCategoria' id='nombreComentarioCategoria'  title='Nombre de 3 a 5 carácteres alfanuméricos' pattern='[a-zA-Z0-9\d_ ]{3,50}' placeholder="Tu nombre:"  required >
                
                 </div>
                 <div class='form-group'>
						<label for='textoComentarioWeb' class='control-label '>Descripcion:</label>
                        <div class='col-md-12'>
                        	<textarea class='form-control' name='textoComentarioCategoria' id='textoComentarioCategoria'  title='De 3 a un motón de carácteres alfanuméricos sin símbolos raros ' pattern='[a-zA-Z0-9\d_]{3,50000}' placeholder="Comentario:" required></textarea>
                         </div>
                 </div>
                 <input type=hidden name='idCategoria' value='<?php echo $idCategoria;?>'></input>  
                 <input type=hidden name='accion' value=7></input>  
                 <input type=hidden name='codigosecreto' value='locoweb'></input>
		 		 <div class='col-xs-2 col-sm-2 col-md-2'>
                    <img class="botonemoticono"  src='/imagenes/emoticonos/smiley/Smiley-03.png' width="30" height="30"></img>
                 </div>
                 <div class='col-xs-10 col-sm-10 col-md-10'>
                    <input type='submit' value='Comentar' class='form-control btn btn-primary' ></input> 
                 </div>
		
		</form> 
		<br />
		<br />
		<br />
		<div id="capaemoticonos">
			 	<img src='/imagenes/emoticonos/smiley/Smiley-01.png' id='botonemoticonossmiley' width='30' height='30'></img>
                <img src='/imagenes/emoticonos/naturaleza/Natur-01.png' id='botonemoticonosperro' width='30' height='30'></img>
                <img src='/imagenes/emoticonos/lugares/Orte-01.png' id='botonemoticonoslugar' width='30' height='30'></img>
                <img src='/imagenes/emoticonos/objetos/Objects-23.png' id='botonemoticonosobjetos' width='30' height='30'></img>
                <img src='/imagenes/emoticonos/simbolos/Symbols-183.png' id='botonemoticonossimbolos' width='30' height='30'></img>
                <img src='/imagenes/borrar.png' class='botonemoticono' width='30' height='30' class="pull-right"></img>
			 	<div id="subcapaemoticonos">
                </div>
             </div>
         <div id="respuestaServidor" style='color:red;font-size:16px'></div>
         <br />
         <br />

	<?php	
		
		
		
	}

	
	
	
	
	
	
	
	
	function enviarMensajeAEstrellaParaValidarComentarioWeb($codigoValidacion, $idWeb){
		//<a href="http://Www.tipolisto.es" target="_blank">Www.tipolisto.es</a>
		$direccion="www.gestorwebs.tipolisto.es/gestionarcomentariosweb.php?accion=2&codigoValidacion=$codigoValidacion&idWeb=$idWeb";
		
		$subject = "Ada";
		$txt = "<html> <head> <title>www.gestorwebs.tipolisto.es</title> </head> <body><p>".$direccion."</p><p>Este es un mensaje que han dejado en la web: ".obtenerNombreWeb($idWeb).", tienes que decir si lo quieres grabar o no pinchando en el enlace de arriba.</p><br /><br /><br /><br /><a href='".$direccion."' target='_blank'>Validar</body></html>";
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: ada@gestorwebs.tipolisto.es" . "\r\n";
		//mail("ada@gestorwebs.tipolisto.es",$subject,$txt,$headers);
		mail("ada@gestorwebs.tipolisto.es",$subject,$txt,$headers);
	}
	

	function enviarMensajeAEstrellaParaValidarComentarioCategoria($codigoValidacion, $idCategoria){
		//<a href="http://Www.tipolisto.es" target="_blank">Www.tipolisto.es</a>
		$direccion="www.gestorwebs.tipolisto.es/gestionarcomentarioscategoria.php?accion=2&codigoValidacion=$codigoValidacion&idCategoria=$idCategoria";
		
		$subject = "Ada";
		$txt = "<html> <head> <title>www.gestorwebs.tipolisto.es</title> </head> <body><p>".$direccion."</p><p>Este es un mensaje que han dejado en la categoria: ".obtenerNombreCategoria($idCategoria).", tienes que decir si lo quieres grabar o no pinchando en el enlace de arriba.</p><br /><br /><br /><br /><a href='".$direccion."' target='_blank'>Validar</body></html>";
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: ada@gestorwebs.tipolisto.es" . "\r\n";
		//mail("ada@gestorwebs.tipolisto.es",$subject,$txt,$headers);
		mail("ada@gestorwebs.tipolisto.es",$subject,$txt,$headers);
	}
	







	
	function aplicarInsercionComentarioWeb(){
		$fechaComentarioWeb=date("d-m-Y H:i:s");
		$bd= new Mysql();
		$bd->conectar_mysql();
		$sql="INSERT INTO comentariosweb VALUES ( '', '$_POST[nombreComentarioWeb]','$_POST[textoComentarioWeb]', '$fechaComentarioWeb', '0', '$_POST[idWeb]' ) ";
		$result=$bd->ejecutar_sql($sql);
		//$codigoValidacion=mysqli_insert_id();
		$codigoValidacion=$bd->enlace->insert_id;
		enviarMensajeAEstrellaParaValidarComentarioWeb($codigoValidacion, $_POST[idWeb]);
		$bd->desconectar();
		$mensaje="Comentario web nuevo insertado.";
		echo "<script type='text/javascript'>location.href='gestionarwebs.php?accion=1&idWeb=$_POST[idWeb]&mensaje=".$mensaje."';</script>";
	}
	
	
	
	
	
	
	
	
	function aplicarInsercionComentarioCategoria(){
		if($_POST['codigosecreto']=='locoweb'){
			$fechaComentarioCategoria=date("Y-m-d H:i:s");
			$bd= new Mysql();
			$bd->conectar_mysql();
			$sql="INSERT INTO comentarioscategoria VALUES ( '', '$_POST[nombreComentarioCategoria]','$_POST[textoComentarioCategoria]', '$fechaComentarioCategoria', '0', '$_POST[idCategoria]' ) ";
			$result=$bd->ejecutar_sql($sql);
			$codigoValidacion=$bd->enlace->insert_id;		
			//Paraece que un grupo de locas está utilizando la categoría 11 - paginasweb - para hablar entre ellas
			//Si es la categoría 11 no me envies mensajes
			if($_POST[idCategoria]!=11 && $_POST[idCategoria]!=136  && $_POST[idCategoria]!=78  && $_POST[idCategoria]!=151){
				//enviarMensajeAEstrellaParaValidarComentarioCategoria($codigoValidacion, $_POST[idCategoria]);
			}
			$bd->desconectar();
			$mensaje="Comentario categoria nuevo insertado.";
			echo "<script type='text/javascript'>location.href='gestionarwebs.php?idCategoria=$_POST[idCategoria]&mensaje=".$mensaje."';</script>";
		}else{
			echo "<script type='text/javascript'>location.href='noautorizado.php';</script>";
		}
	}
	
	
	
	
	
	
	
	
	
	
	function obtenerTodasLosComentariosDeUnaWeb($idWeb){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM comentariosweb WHERE idwebcomentarioweb='".$idWeb."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{

		
			echo "<div class='contenedorcomentarios' >";
								echo "<b>Fecha: ".$linea['fechacomentarioweb']."</b>";
								echo "<br /><strong>De: <font color=red>".$linea['nombrecomentarioweb']."</font></strong>";
								echo "<br />".$linea['textocomentarioweb'];
								echo "<br />---------------------";
			echo "</div>";
			
		}
		$basededatos->desconectar();
		return $comentarios;
	}
	
	/**********************************Comentarios categoria********************************/
	function buscarUnaRutaDeFoto($cadena){
		$buscada="[[";
		$seEncuentraUnaRutaDeFoto=strpos($cadena, $buscada);	
		return $seEncuentraUnaRutaDeFoto;
	}
	function cambiarRutasPorFotos($cadena){
		$finalCadena=strlen($cadena);
		$posicionAbrirBarras=strpos($cadena, "[[");
		$posicionCerrarBarras=strpos($cadena, "]]");
		$cadenaAnterior=substr($cadena, 0, $posicionAbrirBarras);
		$imagen=substr($cadena, $posicionAbrirBarras+2,$posicionCerrarBarras-3);
		if(strpos($imagen, "]]")!=false){
			$posicionnueva=strpos($imagen, "]]");
			$imagen=substr($imagen, 0,$posicionnueva);
			//$imagen="";
		}
		$comprobar=substr($imagen, 0,5);
		if ($comprobar =='natur'){
			$imagen="<img src=http://chat.tipolisto.es/imagenes/emoticonos/naturaleza/".$imagen. " width='30' height='30'/>";
		}
		if ($comprobar =='smile'){
			$imagen="<img src=http://chat.tipolisto.es/imagenes/emoticonos/smiley/".$imagen. " width='30' height='30'/>";
		}
		if ($comprobar =='orte-'){
			$imagen="<img src=http://chat.tipolisto.es/imagenes/emoticonos/lugares/".$imagen. " width='30' height='30'/>";
		}
		if ($comprobar =='objec'){
			$imagen="<img src=http://chat.tipolisto.es/imagenes/emoticonos/objetos/".$imagen. " width='30' height='30'/>";
		}
		if ($comprobar =='symbo'){
			$imagen="<img src=http://chat.tipolisto.es/imagenes/emoticonos/simbolos/".$imagen. " width='30' height='30'/>";
		}
		$cadenaPosterior=substr($cadena, $posicionCerrarBarras+3, $finalCadena);
		if(buscarUnaRutaDeFoto($cadenaPosterior)!=false){
			$cadenaPosterior=cambiarRutasPorFotos($cadenaPosterior);
		}
		$nuevaCadena=$cadenaAnterior.$imagen.$cadenaPosterior;
		return $nuevaCadena;		
	}
	
	function obtenerTodasLosComentariosDeUnaCategoria($idCategoria){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM comentarioscategoria WHERE idwebcomentariocategoria='".$idCategoria."' ORDER BY fechacomentariocategoria DESC";
		$resultado=$basededatos->ejecutar_sql($consulta);
		echo "<div>";
		$rutaSinFotos="";
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			if(buscarUnaRutaDeFoto($linea[textocomentariocategoria])!=false){
				$rutaSinFotos=cambiarRutasPorFotos($linea[textocomentariocategoria]);
			}else{
				$rutaSinFotos=$linea[textocomentariocategoria];
			}
					
		
								echo "<pre class='contenedorcomentarios'>";
								echo "<br /><b>Fecha: ".$linea['fechacomentariocategoria']."</b>";
								echo "<br /><strong>De: <font color=red>".$linea['nombrecomentariocategoria']."</font></strong>";
								echo "<br />".$rutaSinFotos;
								echo "</pre>";
								echo "<br />---------------------";
				
			
		}
		$basededatos->desconectar();
		echo "</div>";
	}
	function obtenerNumeroDeComentariosDeUnaCategoria($idCategoria){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM comentarioscategoria WHERE idwebcomentariocategoria='".$idCategoria."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$resultados=mysqli_num_rows ($resultado);
		$basededatos->desconectar();
		return $resultados;
	}
	function borraElUltimoComentarioSiHayMasDeDiezEnUnaCategoria($idCategoria){
		echo "<p>Borrado el *** comentario. Cteagoria: ".$idCategoria."</p>";
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		//$consulta  = "DELETE FROM comentarioscategoria WHERE idComentarioCategoria='$idCategoria' LIMIT 10" ;
		$consulta="DELETE FROM comentarioscategoria WHERE idwebcomentariocategoria='".$idCategoria."' LIMIT 5";
		$resultado=$basededatos->ejecutar_sql($consulta);

		//echo "<p>".$resultado."</p>";
		$basededatos->desconectar();






	}
	
	/****************************Fin de comenatarios categoria***************************************/







	function cortarString($string){
			$posicion=strrpos($string, ">");
			$longitud=strlen($string);
			$nombreCortado=substr($string, $posicion+1 ,$longitud);
			$restoString=substr($string, 0 ,$posicion);
			$nombreWeb=obtenerNombreCategoria($nombreCortado);
			if($nombreWeb!="Base"){
				echo "<li><a href='/gestionarwebs.php?idCategoria=$nombreCortado'>".$nombreWeb."</a></li>";
			}
		
			if((strrpos($restoString, ">"))>1) {
				cortarString($restoString);
			}else{
				echo "<li><a href='/gestionarwebs.php?idCategoria=$restoString'>".obtenerNombreCategoria($restoString)."</a></li>";
			}
	}
	
	
	
	function dibujarLayoutWebsConArray($webs, $idCategoria){
				$contador=0;
				obtenerArbolDeCategorias($idCategoria);
				echo "<ol class='breadcrumb'>";
				cortarString($idCategoria.$GLOBALS["ruta"]);
				echo "</ol>";
				echo "<p>&nbsp;&nbsp;&nbsp;".obtenerTituloCategoria($idCategoria)."</p>";
				foreach ($webs as $posicion=>$web){
					$contador++;
					echo"<center>";
					echo "<div class='contenedorimagenesdewebs' >";
								echo "<table class='table-responsive'>";
									echo "<tr><td>";
										if($contador==1 && !isset($_GET['pagina'])){
											echo" <img src='../imagenes/medallaoro.png' width='100px'></img>";
										}else if($contador==2 && !isset($_GET['pagina'])){
											echo" <img src='../imagenes/medallaplata.png' width='100px'></img>";
										}else if($contador==3 && !isset($_GET['pagina'])){
											echo" <img src='../imagenes/medallabronce.png' width='100px'></img>";
										}
									echo "</td><td>";
										echo "<a href='http://".$web->getNombreWeb()."' target='_blank' class='tituloweb' >";
										echo cortarCadena($web->getTituloWeb())."";
										echo "<br /><span style='color:black; font-size:10px;'>Enlace: ".cortarCadena($web->getNombreWeb())."</span></a>";
									echo "</td></tr>";
								echo "</table>";
								
								echo "<br /><pre class='contenedorcomentarios'>".$web->getDescripcionWeb()."</pre>";
								echo "<br /><a href='http://".$web->getNombreWeb()."' target='_blanck' class='tituloweb' ><img src='/imagenes/webs/".$web->getImagenWeb()."' width='500px' /></a>";
								echo "<br /><span>".$web->getMediaVotosWeb()." <a href='gestionarwebs?accion=4&idWeb=".$web->getIdWeb()."'> Votar</a></span>";
								
								echo "<br /><a href=/gestionarwebs.php?accion=1&idWeb=".$web->getIdWeb()." >Detalles...</a><br />";
								//echo "<br />";
								if($_SESSION['nivelaccesousuario']==1){
									echo "<a href='/adm/admgestionarwebs.php?accion=2&idWeb=".$web->getIdWeb()."'>Editar, <span style='color:red'> solo administrador</span></a>";
								}
							echo "</div>";
							echo "</center>";
							//require_once ('Mobile_Detect.php');
							$detect = new Mobile_Detect();
							if ($detect->isMobile()==false) {
								$url="http://".$web->getNombreWeb();
								$existe=url_exists($url);
								if($existe){
									echo "<div class='hidden-xs' style='max-width:1000px'>";
									echo "<iframe src='http://".$web->getNombreWeb()."' name='iframe1' width='100%' height='1000' scrolling='auto' frameborder='1'> <p>Texto alternativo para navegadores que no aceptan iframes.</p></iframe>";
									echo "</div>";
								}else{
									echo "<p>No se pudo abrir el enlace";
								}
							}
							
				}
				/*pedirComentarioCategoria($idCategoria);
				obtenerTodasLosComentariosDeUnaCategoria($idCategoria);
				if(obtenerNumeroDeComentariosDeUnaCategoria($idCategoria)>25){
					borraElUltimoComentarioSiHayMasDeDiezEnUnaCategoria($idCategoria);
				}*/
				
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function mostrarUnWeb($idWeb){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs WHERE idWeb='".$idWeb." ORDER BY mediavotosweb' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			echo "<div class='contenedorimagenesdewebs' >";
								echo "<center ><a href='http://".quitarEspaciosEnBlancoPrincipioYFinal($linea['nombreweb'])."' target='_blanck' class='tituloweb' >".cortarCadena($linea['nombreweb'])."</a></center><br />";
								echo "<img src='imagenes/webs/".$linea['imagenweb']."' width='500px' /></center>";
								echo "<br /><span>".$linea['mediavotosweb']." <a href='gestionarwebs?accion=4&idWeb=".$linea['idweb']."'> Votar</a></span >";
								echo "<br /><pre>".$linea['descripcionweb']."</pre>";
								echo "<br />Fecha: ".$linea['fechaweb'];
								echo "<br />Tags: ".$linea['tagsweb'];
								/*pedirComentarioWeb($linea['idweb']);
								obtenerTodasLosComentariosDeUnaWeb($linea['idweb']);*/
			echo "</div>";
							
			
		}
		$basededatos->desconectar();
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function consultarTags($tagsWeb){
		$contador=0;
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs WHERE tagsWeb LIKE '%".$tagsWeb."%' ORDER BY mediavotosweb DESC ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$total_registros=mysqli_num_rows($resultado);
		if($total_registros==FALSE){
			echo" <p>No se obtuvo ning&uacute;n resultado de ".$tagsWeb.".</p>"	;
		//echo "<br />Total registros ".$total_registros."<br />";
		}else{
			
			while ($linea = mysqli_fetch_array($resultado)) 
			{
				$contador++;
				echo "<div class='contenedorimagenesdewebs' >";
									echo "<center ><a href='http://".$linea[nombreweb]."' target='_blanck' class='tituloweb' >";
									echo cortarCadena($linea[tituloweb])."";
									echo "<br /><span style='color:black; font-size:10px;'>Enlace: ".cortarCadena($linea[nombreweb])."</span></a>";
									echo "<br /><pre>".$linea[descripcionweb]."</pre>";
									echo "<br /><a href='http://".$linea[nombreweb]."' target='_blanck' class='tituloweb' ><img src='imagenes/webs/".$linea[imagenweb]."' width='500px' /></a></center>";
									echo "<br /><span>".$linea[mediavotosweb]." <a href='gestionarwebs?accion=4&idWeb=".$linea[idweb]."'> Votar</a></span >";
									
									echo "<br /><a href=gestionarwebs.php?accion=1&idWeb=".$linea[idweb]." >Detalles...</a><br />";
									echo "<br />";
									if($_SESSION['nivelaccesousuario']==1){
										echo "<a href='adm/admgestionarwebs.php?accion=2&idWeb=".$linea[idweb]."'>Editar, <span style='color:red'> solo administrador</span></a>";
									}
				echo "</div>";
				echo "<br />";
				
			}
		}
		$basededatos->desconectar();
		
		
		
	}
	
	
	
	
	
	
	
	
	
	function votarUnaWeb($idWeb){
		?>
		<form method=post action='gestionarwebs.php'>
        <div class='form-group' >
        	<label for='Introduce tu voto:' class='control-label col-md-2'>Introduce tu voto:</label>
		    <div class='col-md-2'>            
                 <input type='text' class='form-control' name='nuevoVotoWeb' id='nuevoVotoWeb' size=10  maxlength='10'  title='Se necesita un voto' required >
            </div>    
      	</div> 
		<input type=hidden name=idWeb value='<?php echo $idWeb; ?>'></input> 
		<input type=hidden name=accion value=5></input> 
		     <div class='form-group' > 
		           <div class='col-md-2' >
                       <input type=submit value=Votar class='btn btn-primary' ></input>
				  </div>
		    </div> 
		 </form>
		<?php
	}
	
	
	
	
	
	
	
		
	
	
	
	
	
	
	
	function actualizarPorVotarUnaWeb($idWeb,$nuevoVotoWeb){
		//Obtenemos el numero total de votos
		$numeroVotosWeb;
		$idCategoria;
		$mediaVotosWeb;
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM webs WHERE idWeb='".$idWeb."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$numeroVotosWeb=$linea['numerovotosweb'];
			$mediaVotosWeb=$linea['mediavotosweb'];
			$idCategoria=$linea['categoriaweb'];
		}
		$basededatos->desconectar();
		//Sumamos uno al numero total de votos
		$nuevoNumeroVotosWeb=$numeroVotosWeb+1;
		$nuevaMediaWeb=(($mediaVotosWeb*$numeroVotosWeb)+$nuevoVotoWeb)/$nuevoNumeroVotosWeb;
		//Actualizamos el numero de votos web y le ponemos la nueva media
		
		$bd= new Mysql();
		$bd->conectar_mysql();
		$sql="update webs set numerovotosweb='$nuevoNumeroVotosWeb', mediavotosweb='$nuevaMediaWeb' where idweb='$idWeb'";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		$mensaje="Web ".obtenerNombreWeb($idWeb).", votada, voto: ".$nuevoVotoWeb;
		echo "<script type='text/javascript'>location.href='gestionarwebs.php?mensaje=".$mensaje."&idCategoria=".$idCategoria."';</script>";
	}
	
	
	
	
	
	
	
	
	
	
	
	
	/*********************************************Main*****************************************/
	if(!isset($_GET['accion']) && !isset($_POST['accion'])){
		$TAMANO_PAGINA = 3;
		$pagina = $_GET["pagina"];
		if (!$pagina) {
			$inicio = 0;
			$pagina=1;
		}
		else {
			$inicio = ($pagina - 1) * $TAMANO_PAGINA;
		} 
		$webs=array();
		$webs=obtenerTodosLasWebsDeUnaCategoria($_GET['idCategoria'],$inicio, $TAMANO_PAGINA);
		paginacion($_GET['idCategoria'], $inicio, $TAMANO_PAGINA);
		dibujarLayoutWebsConArray($webs, $_GET['idCategoria'], $inicio, $TAMANO_PAGINA);
		//paginacion($_GET['idCategoria'], $inicio, $TAMANO_PAGINA);
	}else{
		if($_GET['accion']==1){
			mostrarUnWeb($_GET['idWeb']);
		}else if($_GET['accion']==4){
			votarUnaWeb($_GET['idWeb']);
			mostrarUnWeb($_GET['idWeb']);
		}
	}





	if($_POST['accion']==5){
			actualizarPorVotarUnaWeb($_POST['idWeb'], $_POST['nuevoVotoWeb']);
	}else if($_POST['accion']==13){
			consultarTags($_POST['tagsWeb']);
	}else if($_POST['accion']==6){
			//aplicarInsercionComentarioWeb();	
	}else if($_POST['accion']==7){
			//aplicarInsercionComentarioCategoria();
	}







	

?>





































		




			</div><!--final del div central -->
           
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
            <script src="/js/bootstrap.min.js"></script>
            <script language="javascript" src="/js/micodigo.js"></script>
            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
            <script src="/js/ie10-viewport-bug-workaround.js"></script>
          </body>
        </html>
        