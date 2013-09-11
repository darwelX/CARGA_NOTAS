<?php
require_once '../classes/class.model.Connect.php';
require_once '../classes/class.model.Taller.php';
require_once '../classes/class.util.Convert.php';

$taller = new Taller();
$mensaje="";
$buscar = true;
if(isset($_POST)){
	
	if(isset($_POST['procesar']) && $_POST['procesar'] == "Guardar"){
		$taller->setCodigo($_POST['codigo']);
		$taller->setDescripcion($_POST['descripcion']);
		
		if($taller->insert()){
			$mensaje="Taller registrado";
		}else{
			$mensaje="El taller ya existe";
		}
		require_once '../vistas/inscribir_taller.php';
	}
	
	if(isset($_POST['procesar']) && $_POST['procesar'] == "Actualizar"){
		$taller->setId($_POST['id']);
		$taller->setCodigo($_POST['codigo']);
		$taller->setDescripcion($_POST['descripcion']);
		if($taller->update()){
			$mensaje="Taller acctualizado";
			unset($buscar);
			unset($_POST['id']);
			unset($_POST['codigo']);
			unset($_POST['descripcion']);
			unset($buscar);
		}
		require_once '../vistas/actualizar_taller.php';
	}
	
	if(isset($_POST['procesar']) && $_POST['procesar'] == "Buscar"){
		$taller->setCodigo($_POST['codigo']);
		if($taller->findBy("CODIGO = ".$taller->getCodigo())){
			$buscar=false;
			$_POST['codigo']=$taller->getCodigo();
			$_POST['descripcion']=$taller->getDescripcion();
			
		}else{
			$mensaje="Taller no encontrado";
			unset($buscar);
		}
		require_once '../vistas/actualizar_taller.php';
		
	}
	
	
}


?>