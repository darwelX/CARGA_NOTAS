<?php
require_once '../classes/class.model.Connect.php';
require_once '../classes/class.model.Taller.php';
require_once '../classes/class.util.Convert.php';

$taller = new Taller();
$mensaje="";

if(isset($_POST)){
	
	if(isset($_POST['procesar']) && $_POST['procesar'] == "Guardar"){
		$taller->setCodigo($_POST['codigo']);
		$taller->setDescripcion($_POST['descripcion']);
		
		if($taller->insert()){
			$mensaje="Taller registrado";
		}else{
			$mensaje="El taller ya existe";
		}
		
	}
	
	if(isset($_POST['procesar']) && $_POST['procesar'] == "Actualizar"){
		
	}
	
	if(isset($_POST['procesar']) && $_POST['procesar'] == "Buscar"){
		
	}
	
	require_once '../vistas/inscribir_taller.php';
}


?>