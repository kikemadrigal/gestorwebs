<?php
/*
	En esta vista mostramos las 5 últimas webs subidas
*/
session_start();
if(isset($_COOKIE['idusuario'])){
	//header("Location: usuarios/usuariosgestionarwebs.php");
	echo "<script type='text/javascript'>location.href='usuarios/usuariosgestionarwebs.php';</script>";
	exit();
}
require('app/Mysql.php');
require('app/Web.php');
require('app/WebRepository.php');
//Para el cortarCadena()
require('app/Utils.php');


include("includes/document-start.php");
include('includes/barrainicio.php'); 
include('includes/barramenu.php'); 
		
$webs=array();
$webs=obtenerTodosLasUltimasCincoWebs();
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
	/*if($_SESSION['nivelaccesousuario']==1){
			echo "<a href='adm/admgestionarwebs.php?accion=2&idWeb=".$web->getIdWeb()."'>Editar, <span style='color:red'> solo administrador</span></a>";
	}*/
	echo "</div>";
	echo "<br />";
}
		
include("includes/document-end.php");	
?>


		






















			



