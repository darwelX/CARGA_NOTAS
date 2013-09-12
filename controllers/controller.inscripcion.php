<?php
require_once '../classes/class.model.Connect.php';
require_once '../classes/class.model.Estudiante.php';
require_once '../classes/class.util.Convert.php';

$estudiante = new Estudiante();
$convert = new Convert();
$mensaje="";
$buscar = true;
if(isset($_POST)){

	if(isset($_POST['procesar']) && $_POST['procesar'] == "Guardar"){

	}

	if(isset($_POST['procesar']) && $_POST['procesar'] == "Actualizar"){

	}

	if(isset($_POST['procesar']) && $_POST['procesar'] == "Buscar"){
		$estudiante->setCedula($_POST['cedula']);
		
		if($estudiante->findBy("CEDULA = ".$estudiante->getCedula())){

			require_once '../vistas/inscripcion_alumno_regular.php';
			
		}else{
			$mensaje="Estudiante no encontrado";
			require_once '../vistas/inscripcion_datos_alumnos.php';
			unset($buscar);
		}
		

	}


}
?>