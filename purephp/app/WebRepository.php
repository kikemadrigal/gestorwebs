<?php

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


?>