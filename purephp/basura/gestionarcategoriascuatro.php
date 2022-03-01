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
         
		 <script type="text/javascript">
		  	//var cambiarimagen=0;
			function cambiarImagen(elemento){
				console.log('antes de hacer nada la imagen es: '+elemento.src);
				//imagenmas=document.getElementById('imagenmas');
				if(elemento.className=='imagenmas') {
   					elemento.src='http://www.gestorwebs.tipolisto.es/imagenes/mas.png';
   					console.log('imagen cambiada a mas.png');
   					elemento.classList.remove('imagenmas');
   					elemento.classList.add('imagenmenos');
   					//cambiarimagen=1;
 				}
				else {
   					elemento.src='http://www.gestorwebs.tipolisto.es/imagenes/menos.png';
   					console.log('imagen cambiada a menos.png');
   					elemento.classList.remove('imagenmenos');
   					elemento.classList.add('imagenmas');
  				 	//cambiarimagen=0;
 				}
			}
			function mostrarOOcultar(idCategoria){
				console.log(idCategoria);
				var elemento=document.getElementById(idCategoria);
				//cambiarImagen(elemento);
				//console.log(elemento.getAttribute('id'));
				//var valorDisplay=new String(elemento.style.item(0).value);
				//var valorDisplay=elemento.style.display;
				console.log("dice que antes de hacer nada: "+elemento.style.display);
				//var booleano=false;
				if(elemento.style.display=='none'){
					elemento.style.display = 'block';
					//elemento.style.visibility='true';
					
					console.log("Como estaba a none ahora lo cambiamos a : "+elemento.style.display);
				}
				else if(elemento.style.display=='block'){
				  elemento.style.display = 'none';
				  //elemento.style.visibility='false';
				  console.log("Como estaba a block ahora lo cambiamos a : "+elemento.style.display);
				}
				
			}
			

 
		</script>
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
	require('mysql.php');
	

	function comprobarSiAlgunaCategoriaTieneDePadreEsteID($idpadrecategoria){
		$basededatos1= new Mysql();
		$basededatos1->conectar_mysql();
		//comprobar si existe alguna categoria que tenga de padre esta
		$consulta1  = "SELECT * FROM categorias WHERE idpadrecategoria='".$idpadrecategoria."' ";
		$resultado1=$basededatos1->ejecutar_sql($consulta1);
		$total_registros=mysql_num_rows($resultado1);		

		$basededatos1->desconectar();
		return $total_registros;
	}



	function recorrerCategorias($nivelCategoria, $categoriaeshijade){
		$nivelCategoria++;
		$basededatos1= new Mysql();
		$basededatos1->conectar_mysql();
		$consulta1  = "SELECT * FROM categorias WHERE nivelcategoria='".$nivelCategoria."' && categoriaeshijade='".$categoriaeshijade."' ORDER BY nombrecategoria";
		$resultado1=$basededatos1->ejecutar_sql($consulta1);
		$total_registros=mysql_num_rows($resultado1);	
		for($i=2;$i<$nivelCategoria;$i++){
			$espacios=$espacios."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		while ($linea1 = mysql_fetch_array($resultado1, MYSQL_ASSOC)) 
		{
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$numeroDeHijosQuetieneHijosEstaCategoria=comprobarSiAlgunaCategoriaTieneDePadreEsteID($linea1[idcategoria]);
			if($numeroDeHijosQuetieneHijosEstaCategoria==0){
				echo "<li>".$espacios."|__ <a href=categoria/$linea1[idcategoria]>".$linea1['nombrecategoria']."</a></li>";
			}
			else{
				echo "<li>".$espacios."|__ <a href=categoria/$linea1[idcategoria] > <a href=categoria/$linea1[idcategoria]>".$linea1['nombrecategoria']."</a><img src='http://www.gestorwebs.tipolisto.es/imagenes/mas.png' onclick='mostrarOOcultar($linea1[idcategoria]);cambiarImagen(this);'></img>".$numeroDeHijosQuetieneHijosEstaCategoria."</li>";
				if ($linea1['categoriaeshijade'] != null){
					echo "<div id='".$linea1[idcategoria]."' style='display:none;'>";
						recorrerCategorias($nivelCategoria, $linea1['nombrecategoria'] );
					echo "</div>";					
				}
			}
			
		}
		$basededatos1->desconectar();
	}



	function dibujarLayoutCategorias(){
		$nivelCategoria=2;
		echo "<div class='divcategorias'>";
			echo "<h3>Gestor de Webs<br /></h3>";
			$basededatos= new Mysql();
			$basededatos->conectar_mysql();
			$consulta= "SELECT * FROM categorias WHERE nivelcategoria=".$nivelCategoria." ORDER BY nombrecategoria";
			$resultado=$basededatos->ejecutar_sql($consulta);
			//$total_registros=mysql_num_rows($resultado);	
			//echo "Obtenidos: ".$total_registros;	
			echo "<ul class='breadcrumb'>";
					while ($linea = mysql_fetch_array($resultado, MYSQL_ASSOC)) 
					{
							echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							$numeroDeHijosQuetieneHijosEstaCategoria=comprobarSiAlgunaCategoriaTieneDePadreEsteID($linea[idcategoria]);
							if($numeroDeHijosQuetieneHijosEstaCategoria==0){
								echo "<li>|__ <a href=categoria/$linea[idcategoria]>".$linea['nombrecategoria']."</a></li>";
							}else{
								echo "<li>|__ <a href=categoria/$linea[idcategoria]>".$linea['nombrecategoria']."</a><img src='http://www.gestorwebs.tipolisto.es/imagenes/mas.png' onclick='mostrarOOcultar($linea[idcategoria]);cambiarImagen(this);'></img>".$numeroDeHijosQuetieneHijosEstaCategoria."</li>";
								echo "<div id='".$linea[idcategoria]."' style='display:none;'>";
									recorrerCategorias($nivelCategoria, $linea['nombrecategoria'] );	
								echo "</div>";
							}
					}
					$basededatos->desconectar();
			echo "</ul>";
		echo "</div>";
	}
	
	
	
	
			
	
	dibujarLayoutCategorias();
	



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
            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
            <script src="js/ie10-viewport-bug-workaround.js"></script>
            <script language="javascript" src="js/micodigo.js"></script>
          </body>
        </html>
        