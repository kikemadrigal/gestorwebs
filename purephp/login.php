<?php
require('app/Mysql.php');
require('app/Web.php');
include("includes/document-start.php");
include('includes/barrainicio.php'); 
include('includes/barramenu.php'); 
include('app/UserRepository.php');
?>

<div class="col-md-6 text-center">
    <p class='bg-danger'>Por favor, modifica tu contrase&ntilde;a: que se asign&oacute; por defecto.</p> 
            
    <!-- <form class='form-horizontal' method='post' id='formulariorepitecontrasena' name='formulariorepitecontrasena'  > -->
    <form  id='formulariorepitecontrasena' name='formulariorepitecontrasena' class='form-horizontal' method='post' action="<?php echo $SERVER['PHP_SELF'] ?>" onsubmit="return validar()" > 
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
</div>

<?php
include("includes/document-end.php");	
?>