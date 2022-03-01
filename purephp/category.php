<?php

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