<?php
	
	session_start();
	//setcookie('idusuario', $_SESSION['idusuario'], time()+(60*60*24*365));
	if($_GET['accion']==7){
		setcookie("idusuario","", time()-3600);
		unset ($_COOKIE['idusuario']);
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
    	<div class="col-xs-12 col-sm-10 col-md-10">
       			 <?php
					if(isset($_GET['mensaje'])) echo "<h4><span class='label label-danger'>".$_GET['mensaje']."</span></h4>";
				?>











































<?php
	require('mysqlusuarios.php');
	include ("Usuario.php");
	require('Mysql.php');
	
	

	function cortarCadena($cadena){
		//Strip_tags: retira las etiquetas HTML y PHP de un String
		//substr($cadena, corta inicio, corta final)
		//strlen: devuelve la longitud de la cadena
		$longitud = 40;
		$stringDisplay = substr(strip_tags($cadena), 0, $longitud);
		if (strlen(strip_tags($cadena)) > $longitud)
        	$stringDisplay .= ' ...';
		return $stringDisplay;
	}
	function cerrarSesion(){
		if(isset($_SESSION['idusuario'])){
			
		 	$mensaje= "Sesion cerrada.";
			//session_destroy();
			session_unset();
			session_destroy();
			
		}else{
			$mensaje="No existe sesion para cerrar.";
		}
		echo "<script type='text/javascript'>location.href='http://www.gestorwebs.tipolisto.es/index.php?mensaje=$mensaje'</script>";
	}
	function obtenerNombreusuario($idusuario){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT nombreusuario FROM usuarios WHERE idusuario='".$idusuario."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			return $linea['nombreusuario'];
		}
		$basededatos->desconectar();
	}
	function obteneridusuario($nombreusuario){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT idusuario FROM usuarios WHERE nombreusuario='".$nombreusuario."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			return $linea['idusuario'];
		}
		$basededatos->desconectar();
	}
	function obtenerNombreusuarioAtravesDeCorreo($correousuario){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT nombreusuario FROM usuarios WHERE correousuario='".$correousuario."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			return $linea['nombreusuario'];
		}
		$basededatos->desconectar();
		
	}
	function obtenerIdUsuarioAtravesDeCorreo($correousuario){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT idusuario FROM usuarios WHERE correousuario='".$correousuario."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			return $linea['idusuario'];
		}
		$basededatos->desconectar();
		
	}
	function obtenerNivelAccesoAtravesDeIdUsuario($idusuario){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT nivelaccesousuario FROM usuarios WHERE idusuario='".$idusuario."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			return $linea['nivelaccesousuario'];
		}
		$basededatos->desconectar();
		
	}
	function enviarCorreoAlAdministrador($mensaje){
		$personaAEnviarCorreo="kikemadrigal@hotmail.com";
		$subject = "Nuevo mensaje de gestorwebs.tipolisto.es";
		$txt = "<html> <head> <title>gestorwebs.tipolisto.es</title> </head> <body><p>".$mensaje."</p></body></html>";
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: adm@gestorwebs.tipolisto.es" . "\r\n" ."CC: ";
		mail($personaAEnviarCorreo,$subject,$txt,$headers);
	}
	function generarCodigoActivacion($longitud,$especiales){
		// Array con los valores a escoger
		$semilla = array();
		$semilla[] = array('a','e','i','o','u');
		$semilla[] = array('b','c','d','f','g','h','j','k','l','m','n','p','q','r','s','t','v','w','x','y','z');
		$semilla[] = array('0','1','2','3','4','5','6','7','8','9');
		$semilla[] = array('A','E','I','O','U');
		$semilla[] = array('B','C','D','F','G','H','J','K','L','M','N','P','Q','R','S','T','V','W','X','Y','Z');
		$semilla[] = array('0','1','2','3','4','5','6','7','8','9');
 
		// si puede contener caracteres especiales, aumentamos el array $semilla
		if ($especiales) { 
			$semilla[] = array('$','#','%','&amp;','@','-','?','¿','!','¡','+','-','*');
		}
 
		// creamos la clave con la longitud indicada
		for ($bucle=0; $bucle<$longitud; $bucle++)
		{
			// seleccionamos un subarray al azar
			$valor = mt_rand(0, count($semilla)-1);
			// selecccionamos una posición al azar dentro del subarray
			$posicion = mt_rand(0,count($semilla[$valor])-1);
			// cogemos el carácter y lo agregamos a la clave
			$clave .= $semilla[$valor][$posicion];
		}
		// devolvemos la clave
		return $clave;
	}
	
	
	
	
	
	
	
	
	
























/************************************************Acciones de registrar nuevo usuario y confirmar activacion por correo (acciones del 10 al 19)*************************************************************************************************************************************/	
	
	function crearEstructuraDeBaseDeDatos($idUsuario){
		$sqlCartegorias="CREATE TABLE IF NOT EXISTS `categorias_".$idUsuario."` (
		  `idcategoria` int(11) NOT NULL AUTO_INCREMENT,
		  `nombrecategoria` varchar(500) COLLATE latin1_spanish_ci NOT NULL,
		  `titulocategoria` varchar(500) COLLATE latin1_spanish_ci NOT NULL,
		  `categoriaeshijade` varchar(500) COLLATE latin1_spanish_ci NOT NULL,
		  `idpadrecategoria` varchar(500) COLLATE latin1_spanish_ci NOT NULL,
		  `nivelcategoria` int(50) NOT NULL,
		  PRIMARY KEY (`idcategoria`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;
			";
		$sqlWebs="CREATE TABLE IF NOT EXISTS `webs_".$idUsuario."` (
		  `idweb` int(11) NOT NULL AUTO_INCREMENT,
		  `nombreweb` varchar(500) COLLATE latin1_spanish_ci NOT NULL,
		  `tituloweb` varchar(5000) COLLATE latin1_spanish_ci NOT NULL,
		  `descripcionweb` varchar(500) COLLATE latin1_spanish_ci NOT NULL,
		  `fechaweb` varchar(500) COLLATE latin1_spanish_ci NOT NULL,
		  `tagsweb` varchar(500) COLLATE latin1_spanish_ci NOT NULL,
		  `numerovotosweb` int(100) NOT NULL,
		  `mediavotosweb` int(100) NOT NULL,
		  `contadorweb` int(100) NOT NULL,
		  `imagenweb` varchar(500) COLLATE latin1_spanish_ci NOT NULL,
		  `categoriaweb` varchar(500) COLLATE latin1_spanish_ci NOT NULL,
		  PRIMARY KEY (`idweb`)
		)  ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;
			";
		$sqlInsertCategoria="INSERT INTO `categorias_".$idUsuario."` (`idcategoria`, `nombrecategoria`, `categoriaeshijade`, `idpadrecategoria`, `nivelcategoria`) VALUES
(2, 'Base', '', '', 1)";
		$basededatos= new mysqlusuarios();
		$basededatos->conectar_mysql();
		
		$resultado=$basededatos->ejecutar_sql($sqlCartegorias);
		$resultado2=$basededatos->ejecutar_sql($sqlWebs);
		$resultado3=$basededatos->ejecutar_sql($sqlInsertCategoria);
		
		$basededatos->desconectar();
			
	}


	
	function registrarNuevoUsuarioPorCorreo(){ //accion 10 registrar nuevo usuario
			$codigoActivacion=sha1(generarCodigoActivacion(20,false));
		?>
			<p>Reg&iacute;strate en este sitio</p>
			<form class='form-horizontal' name="registerform" id="registerform" action="gestionarusuarios.php" method="post">
				<div class='form-group'>
                    <label for="nombreusuario" class='control-label col-md-2'>Nombre de usuario</label>
                    <div class='col-md-4'>
                    	<input type="text" class="form-control" name="nombreusuario" id="nombreusuario" title='El nombre debe de contener entre 4 y 15 letras o números sin espacios' placeholder="Nombre:" pattern="[a-zA-Z0-9\d_]{4,15}" required />
                    </div>
				</div>
				<div class='form-group'>
                    <label for="correousuario" class='control-label col-md-2'>Correo:</label>
                    <div class='col-md-4'>
                    	<input type="email" class="form-control" name="correousuario" id="correousuario" placeholder="Correo:" required />
                    </div>
				</div> 
				<p>Recibirás una contrase&ntilde;a en este correo electr&oacute;nico.</p>
				<br />
                <input type="hidden" name="accion" id="accion" value=11  />
                <input type="hidden" name="codigoActivacion" id="codigoActivacion" value='<?php echo $codigoActivacion; ?>'  >
                <div class='form-group' > 
		        	<div class='col-md-6 col-md-offset-2' >
						<input type="submit" class="button btn-primary btn-large" value="Registrarse" />
                    </div>
		    	</div> 
			</form>
			<p>
            <a href="gestionarusuarios.php?accion=20">Acceder</a> |
            <a href="gestionarusuarios.php?accion=30" title="Recupera tu contrase&ntilde;a perdida">¿Has perdido tu contrase&ntilde;a?</a>
       		</p>
            <p><a href="index.php" title="¿Te has perdido?">Volver a Gestor de webs</a></p>
	<?php
		
	}
	function comprobarSiExisteCoreoYaRegistrado($correo){
		$basededatos2= new Mysql();
		$basededatos2->conectar_mysql();
		$consulta2  = "SELECT correousuario FROM usuarios WHERE correousuario='".$correo."' ";
		$resultado2=$basededatos2->ejecutar_sql($consulta2);
		$numeroFilas=mysqli_num_rows($resultado2);
		if($numeroFilas==false){
			return false;	
		}else{
			return true;
		}
		$basededatos2->desconectar();
	}	
	function mailActivacion($correousuario, $usuario,$codigoactivacion)/*accion 11 $POST una vez recibido los datos del formulario comprobamos que no exista le enviamos un mensaje al correo que puso*/
	{
		$existeCorreo=comprobarSiExisteCoreoYaRegistrado($correousuario);
		if ($existeCorreo==true){
			echo "<a href=$pagina?accion=10>Este correo ya existe. Volver.</a>";
		}else{
			$fecha=date("d/m/Y");
			$basededatos= new Mysql();
			$basededatos->conectar_mysql();
			$consulta  = "SELECT * FROM usuarios WHERE nombreusuario='".$usuario."' ";
			$resultado=$basededatos->ejecutar_sql($consulta);
			$numeroFilas=mysqli_num_rows($resultado);
			if($numeroFilas==false){
				$basededatos->desconectar();
				$to = $correousuario;
				$subject = "Crea tu cuenta en gestorwebs.tipolisto.es";
				$txt = "<html> <head> <title>gestorwebs.tipolisto.es</title> </head> <body><p>Usuario: ".$usuario."</p><p>Contrase&ntilde;a: ".$codigoactivacion." </p><p><a href=http://www.gestorwebs.tipolisto.es/gestionarusuarios.php?accion=12&codigoactivacion=$codigoactivacion&nombreusuario=$usuario>Picha aquí para dar de alta en gestorwebs.tipolisto.es</a></p><p>Por favor, revisa los mensajes de spam</p></body></html>";
				$headers = "MIME-Version: 1.0\r\n"; 
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
				$headers .= "From: adm@gestorwebs.tipolisto.es" . "\r\n" .
				"CC: ";
				mail($correousuario,$subject,$txt,$headers);
				
				$bd2= new Mysql();
				$bd2->conectar_mysql();
				//$codigoactivacion=sha1($codigoactivacion);
				$sql2="INSERT INTO usuarios (idusuario, nombreusuario, claveusuario, nivelaccesousuario, correousuario, nombrerealusuario, apellidosusuario, webusuario, validadousuario,contadorusuario, fechausuario,datosusuario)  VALUES ( '', '$usuario','$codigoactivacion', '3', '$correousuario', '$nombrerealusuario', '$apellidosusuario', '$webusuario', '0', '0', '$fecha', 'clave generada por defecto') ";
				
				if($bd2->ejecutar_sql($sql2)==null){
					//echo "<h1>Error</h1>";
					$mensaje="Error, no se pudo crear el usuario.";
				}else{
					$mensaje="Revisa el correo ".$correousuario." para la activación.";
					echo "<script type='text/javascript'>location.href='gestionarusuarios.php?mensaje=$mensaje&accion=20'</script>";
				}
				$bd2->desconectar();
				enviarCorreoAlAdministrador("Desde gestorwebs se ha enviado un correo a: ".$correousuario.", para darlo de alta al usuario: ".$usuario);
			}else{
				echo "<a href=$pagina?accion=10>El usuario ya existe. Volver.</a>";
			}
			$basededatos->desconectar();	
		}//fin de si el correono existe
	}
		
	function confirmarActivacionPorCorreo($codigoDeActivacion, $nombreUsuario){ /*accion 12, una vez que se ha pinchado en el enlace del correo se comprueba si la clave de usuario es igual a la almacenda en la base de datos y se redirige a acción 15 para que cree su contraseña, esa función será utilizada para el olvido de contraseña también, por ultimo creamos sus tablas para que meta webs  categorias*/
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT idusuario, claveusuario FROM usuarios WHERE nombreusuario='".$nombreUsuario."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			if($linea['claveusuario']==$codigoDeActivacion){
				$idusuario=$linea['idusuario'];
				$mensaje="Hola! ".$nombreUsuario;
				echo "<script type='text/javascript'>location.href='http://www.gestorwebs.tipolisto.es/gestionarusuarios.php?mensaje=$mensaje&idusuario=$idusuario&accion=15'</script>";
			}
		}
		$basededatos->desconectar();
		crearEstructuraDeBaseDeDatos(obteneridusuario($nombreUsuario));	
		enviarCorreoAlAdministrador("En gestorwebs se ha confirmado el usuario: ".$nombreusuario.", se le han creado las tablas.");
	}
	
/***************************************************************Fin de acciones registrar nuevo usuario (del 10 al 19)******************************************************************/


























	
	
	
	
	
	
	
	
	/**************************************mostrar y actualizar*******************************************************************************************/
	
	function mostrarUnusuario($idusuario){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM usuarios WHERE idusuario='".$idusuario."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$bgcolor='#BBFFFF';
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			
		
		  echo "<div class='table-responsive col-md-8'>";
			echo"<table class='table table-striped table-bordered table-hover' >";
				/*echo"  <tr > ";
				echo"              <th valign='top'>Id usuario</th>";
				echo"              <td>".$linea['idusuario']."</td>";
				echo"   </tr>";*/
				echo"  <tr class='info'> ";
				
				echo"              <th class='col-md-2'>Nombre usuario</th>";
				echo"              <td class='col-md-6'>".$linea['nombreusuario']."</td>";
				echo"   </tr>";
				echo"   <tr class='danger'> ";
				echo"              <th class='col-md-2'>Clave usuario encriptada</th>";
				echo"              <td class='col-md-6'>***********************************</td>";
				echo"    </tr>";
				/*echo "<tr > ";
				echo"              <th valign='top'>Nivel de acceso</th>";
				echo"              <td>".$linea['nivelaccesousuario']."</td>";
				echo"   </tr>";*/
				echo "<tr class='success' >";
				echo"              <th class='col-md-2' >Correo electr&oacute;nico:</th>";
				echo"              <td class='col-md-6'>".$linea['correousuario']."</td>";
				echo"   </tr>";
				
				echo"  <tr > ";
				echo"              <th class='col-md-2'>Nombre real</th>";
				echo"              <td class='col-md-6'>".$linea['nombrerealusuario']."</td>";
				echo"   </tr>";
				echo"  <tr > ";
				echo"              <th class='col-md-2' >Apellidos</th>";
				echo"              <td class='col-md-6'>".$linea['apellidosusuario']."</td>";
				echo"   </tr>";
				echo"  <tr > ";
				echo"              <th class='col-md-2'>Web usuario</th>";
				echo"              <td class='col-md-6'>".$linea['webusuario']."</td>";
				echo"   </tr>";
				/*echo"  <tr > ";
				echo"              <th valign='top'>Estado</th>";
				echo"              <td>".$linea['validadousuario']."</td>";
				echo"   </tr>";*/
				echo"  <tr> ";
				echo"              <td colspan='2' class='col-md-8'><a href=$pagina?accion=5&idusuario='".$linea['idusuario']."' title='Editar'><img src='imagenes/actualizar.png'></img>Editar</a></td>";
				echo"   </tr>";
			echo"</table>";
			echo "<div class='textoClaveActualizar'>&nbsp;</div>";
          echo "</div>";
		}
		$basededatos->desconectar();
	
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function actualizarusuario($idusuario){
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM usuarios WHERE idusuario='.$idusuario.' ';
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado )) 
		{
				$usuario=new usuario($linea['idusuario']);
				$usuario->setNombreusuario($linea['nombreusuario']);
				$usuario->setClaveUsuario($linea['claveusuario']);
				
				$usuario->setCorreoUsuario($linea['correousuario']);
				$usuario->setNombreRealUsuario($linea['nombrerealusuario']);
				$usuario->setApellidosUsuario($linea['apellidosusuario']);
				$usuario->setWebUsuario($linea['webusuario']);
			
		}
		$basededatos->desconectar();
		echo"<p>Menu Actualizar usuario</p>";
		echo "<div class='table-responsive col-md-8'>";
			echo"<form name='formulariorepitecontrasenaactualizar' id='formulariorepitecontrasenaactualizar' method=post action=gestionarusuarios.php onsubmit='return validarFormularioActualizarUsuario()' >";
		
				echo"<table class='table table-striped table-bordered table-hover'>";
				echo"  <tr> ";
				echo"              <th>Usuario:</th>";
				echo"              <td>".cortarCadena($usuario->getNombreusuario())."</td>";
				echo"   </tr>";
						echo"  <tr> ";
				echo"              <th>Correo:</th>";
				echo"              <td><input type='text' class='form-control' name='correousuario' value='".cortarCadena($usuario->getCorreoUsuario())."' required='required' /></td>";
				echo"   </tr>";	
				echo"   <tr>";
				echo"   <tr>";
				echo"              <th>Contrase&ntilde;a: nueva</th>";
				echo"              <td><input type='password' class='form-control' name='claveusuarioactualizar' id='claveusuarioactualizar' value='".$usuario->getClaveUsuario()."' title='Minimo 5 carácteres' placeholder='Contrase&ntilde;a:' pattern='[a-zA-Z0-9]{5,40}' required='required' /></input></td>";
				echo"    </tr>";
				echo"   <tr> ";
				echo"              <th>Repita la nueva contrase&ntilde;a:</th>";
				echo"              <td><input type='password' class='form-control' name='claveusuariodosactualizar' id='claveusuariodosactualizar' value='".$usuario->getClaveUsuario()."'  title='Minimo 5 carácteres' placeholder='Contrase&ntilde;a:' pattern='[a-zA-Z0-9]{5,40}' required='required' ></input></td>";
				echo"    </tr>";
				echo"  <tr> ";
				echo"              <th>Nombre:</th>";
				echo"              <td><input type='text' class='form-control'  name='nombrerealusuario' value='".cortarCadena($usuario->getNombreRealUsuario())."' ></input></td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th>Apellidos:</th>";
				echo"              <td><input type='text' class='form-control' name='apellidosusuario' value='".cortarCadena($usuario->getApellidosUsuario())."' ></input></td>";
				echo"   </tr>";
				echo"  <tr> ";
				echo"              <th>Web:</th>";
				echo"              <td><input type='text' class='form-control' name='webusuario' value='".$usuario->getWebUsuario()."' ></input></td>";
				echo"   </tr>";
			
				echo"    <tr>"; 	
				echo" 		   <input type=hidden name=accion value=6></input>";	
				echo" 		   <input type=hidden name=idusuario value='".$usuario->getIdusuario()."'></input>";
				echo"          <td colspan=2  align=center><input type=submit value='Actualizar usuario' class='btn btn-danger btn-large' ></td>";
				echo"    </tr>";
				echo"</table>";
		
			echo" </form>";
		echo "</div>";	
		
	}
	
	
	
	
	
	function aplicarActualizacionusuario($idusuario){
		$_POST[claveusuarioactualizar]=sha1($_POST[claveusuarioactualizar]);
		$mensaje="usuario ".obtenerNombreusuario($idusuario)." actualizado.";
		$bd= new Mysql();
		$bd->conectar_mysql();
		$sql="update usuarios set claveusuario='$_POST[claveusuarioactualizar]', correousuario='$_POST[correousuario]', nombrerealusuario='$_POST[nombrerealusuario]', apellidosusuario='$_POST[apellidosusuario]', webusuario='$_POST[webusuario]' where idusuario='$idusuario'";
		$bd->ejecutar_sql($sql);
		$bd->desconectar();
		echo "<script type='text/javascript'>location.href='http://www.gestorwebs.tipolisto.es/$pagina?mensaje=$mensaje';</script>";
	}
	
	
	
	
	/************************************Fin demostrar y actualizar usuarios*******************************************************************************/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	













































	
/*************************************También está el botón de acceder, para que acceda un usuario registrado (acciones del 20 al 29)*************************************************/
	function menuAccederUsuario(){ //accion 20
		?>
		<form name="loginform"  class='form-horizontal' id="loginform" action="gestionarusuarios.php" method="post">
			<div class='form-group'>
                <label for="nombreusuario" class='control-label col-md-2'>Nombre de usuario</label>
                 <div class='col-md-2'>
                	<input type="text" class="form-control" name="nombreusuario" id="nombreusuario" title='Se necesita un nombre' placeholder="Nombre:" required />
                 </div>
			</div>
			<div class='form-group'>
                <label for="claveusuario"  class='control-label col-md-2'>Contrase&ntilde;a</label>
                <div class='col-md-2'>
                	<input type="password" class="form-control" name="claveusuario" id="claveusuario"  title='Se necesita una clave' placeholder="Contrase&ntilde;a:" required />
                </div>
			</div>
            <input type="hidden" name="accion" id="accion" value=21  />
			<div class='form-group' > 
		          <div class='col-md-2 col-md-offset-2' >
						<input type="submit" class="btn btn-primary btn-large" value="Acceder" />
                   </div>
		    </div> 
			
		</form>
        <a href="gestionarusuarios.php?accion=30" title="Recupera tu contrase&ntilde;a perdida">¿Has perdido tu contrase&ntilde;a?</a>
		<?php
		//Al enviar al control usuario puede devolver accion 15 si el validadousuario es 0 entrar de nuevo esn esta web dándo la bienvenida con sesion iniciada.
	}
	
	
	
	
	
	
	
	
	
	function controlUsuarios($usuario, $clave){ //Accion 21
		//$clave=sha1($clave);
		$pagina=$_POST['pagina'];
		$basededatos= new Mysql();
		$basededatos->conectar_mysql();
		
		$consulta  = "SELECT * FROM usuarios WHERE nombreusuario='".$usuario."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$total_registros = mysqli_num_rows ($resultado);
		if($total_registros==false){
			$mensaje= "El nombre de usuario no existe.";
			echo "<script type='text/javascript'>location.href='http://www.gestorwebs.tipolisto.es/gestionarusuarios.php?mensaje=$mensaje&accion=20'</script>";
		}else{
			while ($linea = mysqli_fetch_array($resultado )) 
			{
						if($linea['nombreusuario']==$usuario){
							if($linea['claveusuario']==sha1($clave)){
								if( $linea['validadousuario'] == '0'){
									$_SESSION['nombreusuario']=$linea['nombreusuario'];
									$_SESSION['claveusuario']=$linea['claveusuario'];
									$_SESSION['idusuario']=$linea['idusuario'];
									$_SESSION['validadousuario']=$linea['validadousuario'];
									$_SESSION['nivelaccesousuario']=$linea['nivelaccesousuario'];
									$idusuario=$linea['idusuario'];
									$mensaje="Usuario: ".$_SESSION['nombreusuario'].", clave ".$linea['claveusuario'];
									echo "<script type='text/javascript'>location.href='http://www.gestorwebs.tipolisto.es/gestionarusuarios.php?idusuario=$idusuario&accion=15&mensaje=$mensaje'</script>";
								//Si el usurio está ya validado...
								}else{
									$_SESSION['claveusuario']=$linea['claveusuario'];
									$_SESSION['idusuario']=$linea['idusuario'];
 									?>
									<script type='text/javascript'>
                                        document.cookie = 'idusuario=<?php echo $linea['idusuario'];?>; expires=Thu, 18 Dec 2020 12:00:00 UTC'; 
                                    </script>
                                    <?php
									$_SESSION['nombreusuario']=$linea['nombreusuario'];
									$_SESSION['nivelaccesousuario']=$linea['nivelaccesousuario'];
									$_SESSION['validadousuario']=$linea['validadousuario'];
									$mensaje="¡Hola!: ".$usuario;
									echo "<script type='text/javascript'>location.href='index.php?mensaje=$mensaje'</script>";
								}
							}else{
								$mensaje= "La clave del usuario ".$usuario." es incorrecta.";
								echo "<script type='text/javascript'>location.href='gestionarusuarios.php?mensaje=$mensaje&accion=20'</script>";
							}
						}else{
							echo "";
						}
			}
		}
		$basededatos->desconectar();
		
	
	}
	
/***********************************************Fin de acceder usuarios ya registrado (acciones del 20 al 29)********************************************************************************/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/************************************Menu si se le olvido la clave (del 30 al 39)*******************************************************************************************/
	function enviarMensajeConNuevaClavePorOlvidoDeClave(){ //accion 30, se gnera un nuevo código de activación y se envía el correo por olvido de clave
		/*$codigoActivacion=sha1(generarCodigoActivacion(20,false));
		$personaAEnviarCorreo="kikemadrigal@hotmail.com";
		$subject = "Nuevo mensaje de gestorwebs.tipolisto.es";
		$txt = "<html> <head> <title>gestorwebs.tipolisto.es</title> </head> <body><p>".$mensaje."</p></body></html>";
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: adm@gestorwebs.tipolisto.es" . "\r\n" ."CC: ";
		mail($personaAEnviarCorreo,$subject,$txt,$headers);*/
		?>
	
		<form name="lostpasswordform" id="lostpasswordform" action="gestionarusuarios.php" method="post">
			<p>
			<label for="correousuario">Correo electr&oacute;nico:<br>
			<input type="email" name="correousuario" id="correousuario" title="Introduzca un correo válido" required /></label>
			</p>
            <input type="hidden" name="accion" id="accion" value=31  />
            <input type="hidden" name="codigodeactivacion" id="codigodeactivacion" value='<?php echo $codigoActivacion; ?>'/ >
			<p><input type="submit" class="btn btn-primary btn-large" value="Obtener una contrase&ntilde;a nueva" /></p>
		</form>
	<?php
	}
	
	
	
	
	
	
	
	
	
	
	
	
	function mailActivationPorOlvidoDeClave($correousuario, $codigoactivacion)//accion 31, obtenemos a través del correo el idusuario y el nombreusuario, le enviamos un email y le actualizamos la clave y el validadousuario a cero para que l epida cambiar contraseña
	{
			$existeCorreo=comprobarSiExisteCoreoYaRegistrado($correousuario);
			if($existeCorreo==false){
				echo "<a href=$pagina?accion=30>Este correo no existe. Volver.</a>";
			}else{
				$idusuario=obtenerIdUsuarioAtravesDeCorreo($correousuario);
				$nombreusuario=obtenerNombreusuarioAtravesDeCorreo($correousuario);


				$codigoActivacion=generarCodigoActivacion(20,false);
				$bd= new Mysql();
				$bd->conectar_mysql();
				$sql="update usuarios set claveusuario='$codigoactivacion', validadousuario='0' where idusuario='$idusuario'";
				$bd->ejecutar_sql($sql);
				$bd->desconectar();



				$subject = "Mensaje para recuperar clave en gestorwebs.tipolisto.es";
				$txt = "<html> <head> <title>gestorwebs.tipolisto.es</title> </head> <body><a href=http://www.gestorwebs.tipolisto.es/gestionarusuarios.php?accion=15&idusuario=$idusuario&claveusuario=$codigoactivacion&nombreusuario=$nombreusuario&mensaje=$mensaje>Recupera tu cuenta con Gestorpaginasweb.tipolisto.es pinchando aqu&iacute;.</a></body></html>";
				$headers = "MIME-Version: 1.0\r\n"; 
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
				$headers .= "From: adm@gestorwebs.tipolisto.es" . "\r\n" ."CC: ";
				mail($correousuario,$subject,$txt,$headers);

				echo "<a href=gestionarusuarios.php?accion=20>Mensaje enviado a: ".$correousuario.", id: ".$idusuario.", nombre: ".$nombreusuario." revisa tu correo. Volver.</a>";
				
				/*$subject = "Mensaje para recuperar clave en gestorwebs.tipolisto.es";
				$mensaje="Usuario:".$nombreusuario.",clave:".$codigoactivacion;
				$txt = "<html> <head> <title>Gestorpaginasweb.tipolisto.es</title> </head> <body><p>Usuario: ".$nombreusuario."</p><p>Contrase&ntilde;a: ".$codigoactivacion." </p><p><a href=http://www.gestorwebs.tipolisto.es/gestionarusuarios.php?accion=15&idusuario=$idusuario&codigoactivacion=$codigoactivacion&nombreusuario=$nombreusuario&mensaje=$mensaje>Recupera tu cuenta con Gestorpaginasweb.tipolisto.es pinchando aqu&iacute;.</a></p></body></html>";
				$headers = "MIME-Version: 1.0\r\n"; 
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
				$headers .= "From: ada@gestorwebs.tipolisto.es" . "\r\n" .
				"CC: ";
				mail($correousuario,$subject,$txt,$headers);*/
				
			}
				
	}
	
	
	
	
	
	/************************************Fin de menu de olvido de clave*******************************************************************************************************/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
















	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	




/*****************Estas dos acciones pueden ser utilizadas tanto por el menu de usuario nuevo que viene de registrase como por un o que se le olvido la contraseña*************************/
	
	
	
	function actualizarusuarioQueVieneDeRegistrarse($idusuario){ //accion 15
	?>
    	
		 <p class='bg-danger'>Por favor, modifica tu contrase&ntilde;a: que se asign&oacute; por defecto.</p> 
		
		 <!-- <form class='form-horizontal' method='post' id='formulariorepitecontrasena' name='formulariorepitecontrasena'  > -->
		  <form  id='formulariorepitecontrasena' name='formulariorepitecontrasena' class='form-horizontal' method='post' action="gestionarusuarios.php" onsubmit="return validar()" > 
			  <div class='form-group' > 
              		<label for='claveusuario' class='control-label col-md-4'>Contrase&ntilde;a nueva</label>
		            <div class='col-md-6'>
            
		               
                    <!--  <input type='password'  class='form-control' id='claveusuario' name='claveusuario'  title='Debe contener 1 letra mayúscula, 1 letra minúscula, 1 número, minimo 5 caracteres' placeholder="Contrase&ntilde;a:" pattern="(?=^.{5,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$  " required="required" ></input>   -->
                     <input type='password'  class='form-control' id='claveusuario' name='claveusuario'  title='Minimo 5 caracteres, máximo 15' placeholder="Contrase&ntilde;a:" pattern="[a-zA-Z0-9\d_]{5,15}" required ></input> 
                    </div>
		     </div>  
				    
		     <div class='form-group' >   
             		   <label for='claveusuariodos' class='control-label col-md-4'>Repita la nueva contrase&ntilde;a:</label>
		               <div class='col-md-6'>
                        <!--   <input type='password' class='form-control' id='claveusuariodos' name='claveusuariodos'  title='Debe contener 1 letra mayúscula, 1 letra minúscula, 1 número, minimo 5 caracteres' pattern="(?=^.{5,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$  " placeholder="Repite contrase&ntilde;a:" required="required"></input> --> 
                          <input type='password' class='form-control' id='claveusuariodos' name='claveusuariodos'  title='Minimo 5 caracteres, máximo 15'  placeholder="Repite contrase&ntilde;a:" pattern="[a-zA-Z0-9\d_]{5,15}" required></input>  
                       </div>
                      
		      </div>  
			 
              <input type='hidden' name=accion value=16 ></input>  
		  	  <input type='hidden' name='idusuario' value='<?php echo $idusuario; ?>' ></input>  
               
		     <div class='form-group' > 
		         <div class='col-md-6 col-md-offset-4' >
                  			<!-- <input type='button' id='btnEnviarFormularioRepiteContrasena' value='Actualizar'  /> -->
                            <input type='submit' value='Actualizar' class="btn btn-primary"  />
				 </div>
		     </div> 
		  
		   </form>  
           <div id="textoClave">&nbsp;</div>
		<?php
		
	}
	
	
	
	
	
	function validarusuario($idusuario,$claveusuario){ //accion 16, esta función recibo el formulario de cambio de contraseña y modifica a usuario validado, encripta la clave de usuario, y almacena la clave de usuario sin encriptar
		$nombreusuario=obtenerNombreusuario($idusuario);
		$nivelaccesousuario=obtenerNivelAccesoAtravesDeIdUsuario($idusuario);
		$claveusuariosha1=sha1($claveusuario);
		$bd= new Mysql();
		$bd->conectar_mysql();
		$sql="update usuarios set validadousuario='1', claveusuario='$claveusuariosha1', datosusuario='$claveusuario' where idusuario='".$idusuario."'";
		if($bd->ejecutar_sql($sql)==null){
			$mensaje="No se pudo validar el usuario.";
		}else{
			session_start();
			$mensaje="¡Hola!:".$nombreusuario;
			$_SESSION['idusuario']=$idusuario;
			$_SESSION['nombreusuario']=$nombreusuario;
			$_SESSION['nivelaccesousuario']=$nivelaccesousuario;
			$_SESSION['validadousuario']=1;
		}
		$bd->desconectar();
		//echo "ide: "+$idusuario+", clave: "+$claveusuario+", nombre usuario: "+$nombreusuario+", clave sha1: "+$claveusuariosha1;
		echo "<script type='text/javascript'>location.href='http://www.gestorwebs.tipolisto.es/index.php?mensaje=$mensaje'</script>";
	}
	
	
	
	
/************************Fin de las dos acciones compartidas porel menu de crear un usuario nuevo o olvido de contraseña*********************************************/
	
	
	
	
	
	
	
	
	
	
	









	



	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
/***************************Main*********************************************/
	
	
	if(isset($_SESSION['idusuario']) && $_GET['accion']==4){
		mostrarUnusuario($_GET['idusuario']);
	}else if(isset($_SESSION['idusuario']) && $_GET['accion']==5){
		actualizarusuario($_GET['idusuario']);
	}
	
	
	if($_GET['accion']==7){
		cerrarSesion();
	}else if($_GET['accion']==10){
		//registrarNuevoUsuarioPorCorreo();
		//echo "<p>Robot detectado..</p>";
	}else if($_GET['accion']==12){
		confirmarActivacionPorCorreo($_GET['codigoactivacion'], $_GET['nombreusuario'] );
	}else if($_GET['accion']==20){
		menuAccederUsuario();
	}else if($_GET['accion']==30){
		enviarMensajeConNuevaClavePorOlvidoDeClave();
	}else if($_GET['accion']==15){
		actualizarusuarioQueVieneDeRegistrarse($_GET['idusuario']);
	}
	
	
	
	if($_SESSION['idusuario'] && $_POST['accion']==6){
		aplicarActualizacionusuario($_POST['idusuario']);
	}
	
	if($_POST['accion'] == 11){
		mailActivacion($_POST['correousuario'], $_POST['nombreusuario'],$_POST['codigoActivacion']);
	}else if($_POST['accion'] == 12){
		aplicarInsercionusuario($_POST);
	}else if($_POST['accion'] == 21){
		controlUsuarios($_POST['nombreusuario'], $_POST['claveusuario']);
	}else if($_POST['accion'] == 22){
		aplicarActualizacionusuario($_POST['idusuario'], $_POST);
	}else if($_POST['accion']==16){
		validarusuario($_POST['idusuario'],$_POST['claveusuario']);
	}else if($_POST['accion']==31){
		mailActivationPorOlvidoDeClave($_POST['correousuario'], $_POST['codigodeactivacion']);
	}
/****************************************************************************/


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
            <script src="js/bootstrap.min.js"></script>
            <script language="javascript" src="js/micodigo.js"></script>
            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
            <script src="js/ie10-viewport-bug-workaround.js"></script>
          </body>
        </html>

