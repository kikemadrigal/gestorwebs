<?php

if($_POST['imagenWeb']!="sinimagen1.jpg"){
						//echo "entra porqui";
						$nombre_archivo = $_FILES['file']['name']; 
						$tipo_archivo = $_FILES['file']['type']; 
						$nombreImagen=$nombre_archivo;
						
						//echo "<br />El archivo pasado es: <br />".$nombreImagen;
						$tamano_archivo = $_FILES['file']['size']; 
						$bd= new Mysql();
						$bd->conectar_mysql();
						if (!(strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "png") || $tamano_archivo > 900000)) 
						{
							$nombreImagen="sinimagen.png";
							$bd->ejecutar_sql($sql);
							if(!$bd)
							{
								echo "Error al insertar.";	
							}
							echo "La foto no tiene el formato o el tam&ntilde;o correcto, solo se aceptan, jpg o png menores de 90Mb.<br />";
						}else
						{ 
								move_uploaded_file($_FILES['file']['tmp_name'], "../imagenes/webs/".$nombreImagen);
								$sql="INSERT INTO imagenes VALUES ( '', '$nombreImagen', '0') ";
								$bd->ejecutar_sql($sql);
								if(!$bd)
								{
									echo "Error al insertar.";	
								}
								$mensaje="Imagen ".$nombreImagen." subida!!!.";
								echo "<script type='text/javascript'>location.href='admgestionarwebs.php?accion=43&imagenWeb=$nombreImagen&categoriaweb=$_POST[categoriaweb]'</script>";
   						} 					
						$bd->desconectar();	
					}else{ //si $_POST['imagenWeb']="sinimagen1.jpg"
						echo "<script type='text/javascript'>location.href='admgestionarwebs.php?accion=43&imagenWeb=$_POST[imagenWeb]&categoriaweb=$_POST[categoriaweb]'</script>";
					}

?>