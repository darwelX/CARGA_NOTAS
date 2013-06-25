<?php
require_once '../classes/class.model.Connect.php';
require_once '../classes/class.model.Docente.php';
require_once '../classes/class.model.Seccion.php';
$mensaje="";
$docente = new Docente();
if($_POST['procesar'] == "Iniciar"){
	
	$cedula = intval($_POST['cedula']);
	//$docente->setCedula($cedula);
	if($docente->findBy("CEDULA = $cedula")){
		require_once '../vistas/index.php';
	}else{
		$mensaje="Profesor no encontrado";
		require_once '../vistas/login.php';
	}
	   
	/*if($docente->findBy("CEDULA = $cedula")){
		//print $docente->getNombre()."<br>";
	}*/	
}
?>