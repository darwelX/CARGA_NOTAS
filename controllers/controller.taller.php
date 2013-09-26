<?php
require_once '../classes/class.model.Connect.php';
require_once '../classes/class.model.Taller.php';
require_once '../classes/class.util.Convert.php';

$taller = new Taller();
$mensaje="";
$buscar = true;
$tipo_msg="";
if(isset($_POST)){
	
	if(isset($_POST['procesar']) && $_POST['procesar'] == "Guardar"){
		$taller->setCodigo($_POST['codigo']);
		$taller->setDescripcion($_POST['descripcion']);
		
		if($taller->insert()){
			$tipo_msg="info";
			$mensaje="Taller registrado";
		}else{
			$tipo_msg="error";
			$mensaje="El taller ya existe";
		}
		require_once '../vistas/inscribir_taller.php';
	}
	
	if(isset($_POST['procesar']) && $_POST['procesar'] == "Actualizar"){
		$taller->setId($_POST['id']);
		$taller->setCodigo($_POST['codigo']);
		$taller->setDescripcion($_POST['descripcion']);
		if($taller->update()){
			$tipo_msg="info";
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
			$tipo_msg="error";
			$mensaje="Taller no encontrado";
			unset($buscar);
		}
		require_once '../vistas/actualizar_taller.php';
		
	}
	
	
}


?>