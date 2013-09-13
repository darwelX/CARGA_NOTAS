<?php
require_once '../classes/class.model.Connect.php';
require_once '../classes/class.model.Estudiante.php';
require_once '../classes/class.model.Materia.php';
require_once '../classes/class.model.Seccion.php';
require_once '../classes/class.model.Lapso.php';
require_once '../classes/class.util.Convert.php';

$estudiante = new Estudiante();
$materias = [];
$secciones = [];
$lapso = new Lapso();
$convert = new Convert();
$mensaje="";
$buscar = true;
if(isset($_POST)){
    
	if(isset($_POST['id_estudiante'])){
		$estudiante->find($_POST['id_estudiante']);
	}

	if(isset($_POST['lapso'])){
		$lapso->find($_POST['lapso']);
	}
	
	if(isset($_POST['trimestre']) && $_POST['trimestre'] != ""){
		$materia = new Materia();
		$materias = $materia->findMateriasPorTrimestreYCarrera($_POST['trimestre'], $estudiante->carrera->getId());
		if(isset($_POST['asignatura']) && $_POST['asignatura'] != ""){
			$seccion = new Seccion();
			$secciones = $seccion->findSeccionsByLapsoYCarreraYTrimestre($lapso->getId(),$estudiante->carrera->getId(),$_POST['trimestre']);
			
		}		
	}
		
	if(isset($_POST['procesar']) && $_POST['procesar'] == "Agregar Unidad"){
		
		if( !isset($_POST['trimestre']) || $_POST['trimestre'] == "" ){
			$mensaje="Seleccione un Trimestre<br>";
		}else{
			if( !isset($_POST['asignatura']) || $_POST['asignatura'] == "" ){
				$mensaje="Seleccione una Asignatura<br>";
			}
			else{
				if(!isset($_POST['seccion']) || $_POST['seccion'] == ""){
					$mensaje="Seleccione una Seccion<br>";
				}else{
					
				}
			}
		}
	}

	if(isset($_POST['procesar']) && $_POST['procesar'] == "Actualizar"){

	}

	if(isset($_POST['procesar']) && $_POST['procesar'] == "Buscar"){
		$estudiante->setCedula($_POST['cedula']);
		
		if($estudiante->findBy("CEDULA = ".$estudiante->getCedula())){
			$_POST['id_estudiante'] = $estudiante->getId();
			
		}else{
			$mensaje="Estudiante no encontrado";
			require_once '../vistas/inscripcion_datos_alumnos.php';
			unset($buscar);
		}
		

	}

	require_once '../vistas/inscripcion_alumno_regular.php';
}
?>