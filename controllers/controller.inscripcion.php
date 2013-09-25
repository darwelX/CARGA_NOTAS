<?php
require_once '../classes/class.model.Connect.php';
require_once '../classes/class.model.Horario.php';
require_once '../classes/class.model.HorarioTaller.php';
require_once '../classes/class.model.Estudiante.php';
require_once '../classes/class.model.Materia.php';
require_once '../classes/class.model.Seccion.php';
require_once '../classes/class.model.Lapso.php';
require_once '../classes/class.util.Convert.php';
require_once '../classes/class.model.SeccionTaller.php';

$estudiante = new Estudiante();
$tipo_msg="";
$materias = array();
$secciones = array();
$horarios = array();
$horariosTaller = array();
$lapso = new Lapso();
$convert = new Convert();
$mensaje="";
$buscar = true;
//print_r($_POST);
if(isset($_POST)){
	$h = new Horario();
	$ht = new HorarioTaller();
	$swh1=false;
	$swh2=false;
	if(isset($_POST['id_estudiante'])){
		
		if($estudiante->find($_POST['id_estudiante'])){
			$h->estudiante->find($estudiante->getId());
			$h->carrera->find($estudiante->carrera->getId());
			$swh1=true;
		}else{
			$tipo_msg="error";
			$mensaje="Estudiante no encontrado";			
		}

	
	}else if(isset($_POST['cedula'])){
		$estudiante->setCedula($_POST['cedula']);
	    if($estudiante->findBy("CEDULA = ".$estudiante->getCedula())){
	    	$h->estudiante->find($estudiante->getId());
	    	$h->carrera->find($estudiante->carrera->getId());
	    	$_POST['id_estudiante'] = $estudiante->getId();
	    	$swh1=true;
	    }else{
	    	$tipo_msg="error";
	    	$mensaje="Estudiante no encontrado";	    	
	    }

	}
	
	if($swh1){
		$ht->estudiante->find($estudiante->getId());
		$ht->carrera->find($estudiante->carrera->getId());
	}
	
	
	if(isset($_POST['lapso'])){
		$lapso->find($_POST['lapso']);
		$h->lapso->find($lapso->getId());
		$swh2=true;
	}
	
	if($swh2){
		$ht->lapso->find($lapso->getId());
	}   
    //echo $swh1." - ".$swh2;
	
	if(isset($_POST['trimestre']) && $_POST['trimestre'] != ""){
		$materia = new Materia();
		$materias = $materia->findMateriasPorTrimestreYCarrera($_POST['trimestre'], $estudiante->carrera->getId());
		if(isset($_POST['asignatura']) && $_POST['asignatura'] != ""){
			$seccion = new Seccion();
			$secciones = $seccion->findSeccionsByLapsoYCarreraYTrimestre($lapso->getId(),$estudiante->carrera->getId(),$_POST['trimestre']);
			
		}		
	}

	if(isset($_POST['procesar']) && $_POST['procesar'] == "Eliminar Taller"){
		$horario = new HorarioTaller();
		$horario->lapso->find($lapso->getId());
		$horario->carrera->find($estudiante->carrera->getId());
		//print_r($_POST); 
		$horario->seccion->find($_POST['id_seccion_taller_eliminar']);
		$horario->estudiante->find($estudiante->getId());
		$horario->taller->find($_POST['id_taller_eliminar']);
		
		$eli = $horario->eliminar();
		if($eli){
			$tipo_msg="info";
			$mensaje="Se eliminaron $eli registros en horarios talleres";
		}else{
			$tipo_msg="info";
			$mensaje="Registro no eliminado";
		}
	}
	
	if(isset($_POST['procesar']) && $_POST['procesar'] == "Agregar Taller"){
		
			if( !isset($_POST['taller']) || $_POST['taller'] == "" ){
				$tipo_msg="error";
				$mensaje="Seleccione un Taller";
			}
			else{
				if(!isset($_POST['seccion_taller']) || $_POST['seccion_taller'] == ""){
					$tipo_msg="error";
					$mensaje="Seleccione una Seccion para el Taller";
				}else{
					
					$horarioT = new HorarioTaller();
					$horarioT->lapso->find($lapso->getId());
					$horarioT->carrera->find($estudiante->carrera->getId());
					$horarioT->seccion->find($_POST['seccion_taller']);
					$horarioT->taller->find($_POST['taller']);
					$horarioT->estudiante->find($estudiante->getId());
					
					$num = $horarioT->insert();
					if(!$num){
						$tipo_msg="error";
						$mensaje="No existe horario relacionado con Taller indicado";
					}else{
						$tipo_msg="info";
						$mensaje = "Se registraron $num registros en horarios Talleres ";
					}
					
					
				}
			}
		
	}
	
	if(isset($_POST['procesar']) && $_POST['procesar'] == "Agregar Unidad"){
	
		if( !isset($_POST['trimestre']) || $_POST['trimestre'] == "" ){
			$tipo_msg="error";
			$mensaje="Seleccione un Trimestre";
		}else{
			if( !isset($_POST['asignatura']) || $_POST['asignatura'] == "" ){
				$tipo_msg="error";
				$mensaje="Seleccione una Asignatura";
			}
			else{
				if(!isset($_POST['seccion']) || $_POST['seccion'] == ""){
					$tipo_msg="error";
					$mensaje="Seleccione una Seccion";
				}else{
						
					$horario = new Horario();
					$horario->lapso->find($lapso->getId());
					$horario->carrera->find($estudiante->carrera->getId());
					$horario->seccion->find($_POST['seccion']);
					$horario->estudiante->find($estudiante->getId());
					$horario->setTrimestre($_POST['trimestre']);
					$horario->materia->find($_POST['asignatura']);
						
					$num = $horario->insert();
					if(!$num){
						$tipo_msg="error";
						$mensaje="No existe horario relacionado con la asignatura y seccion para el trimestre indicado";
					}else{
						$tipo_msg="info";
						$mensaje = "Se registraron $num registros en horarios";
					}
						
						
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
			$tipo_msg="info";
			$mensaje="Estudiante no encontrado";
			require_once '../vistas/inscripcion_datos_alumnos.php';
			unset($buscar);
			exit();
		}
		

	}

	if($swh1 && $swh2){
		$horarios = $h->findAll();
		$horariosTaller = $ht->findAll();
	}
	
	require_once '../vistas/inscripcion_alumno_regular.php';
}
?>