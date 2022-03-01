
<!DOCTYPE html>
	<html lang="en">
  	<head>
    	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
   		<meta name="description" content="gestinar paginas web">
    	<meta name="author" content="tipolisto">
        
    	<link rel="icon" href="file:///C|/Seguridad/Mis aparatos/Webs/tipolisto.es/imagenes/favicon.ico">
		
      	<title>Juegos Tipo listo</title>
		<link href="http://tipolisto.es/css/miestilo.css" rel="stylesheet">
       
      </head>

      <body ">
        <div class="container">
			<br /><br /><br /><br />
		 	
			 <div>
				
              
                <p><?php
					if(isset($_COOKIE['micookie']))
						echo "He recibido el valor de la cookie y es el siguiente: <i>".$_COOKIE['micookie']."</i>";
					else
						echo "No tengo la micookie.";
					echo "<br>";
					if(isset($_COOKIE['cookie1ano']))
						echo "Tengo la cookie que caduca más adelante del tiempoi, con valor: <i>".$_COOKIE['cookie1ano']."</i>";
					else
						echo "No tengo la cookie1ano.";
				 ?>
                 </p>
               
        	</div>
        
    	
        	
            <footer>
               <br /><br /><br /><br /><p>&copy; Tipolisto.es 2015</p>
            </footer>
     	</div> <!-- final del container -->
        
        
            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script src="file:///C|/Seguridad/Mis aparatos/Webs/tipolisto.es/js/bootstrap.min.js"></script>
            <script language="javascript" src="file:///C|/Seguridad/Mis aparatos/Webs/tipolisto.es/js/micodigo.js"></script>
            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
            <script src="file:///C|/Seguridad/Mis aparatos/Webs/tipolisto.es/js/ie10-viewport-bug-workaround.js"></script>
          </body>
        </html>
        