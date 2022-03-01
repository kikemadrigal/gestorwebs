<?php
	
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


?>