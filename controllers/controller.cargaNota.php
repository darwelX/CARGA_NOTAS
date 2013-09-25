<?php
require_once '../classes/class.model.Connect.php';
require_once '../classes/class.model.Docente.php';
require_once '../classes/class.model.Seccion.php';
require_once '../classes/class.model.Carrera.php';
require_once '../classes/class.model.Estudiante.php';
require_once '../classes/class.model.Lapso.php';
require_once '../classes/class.model.Materia.php';
require_once '../classes/class.model.Examen.php';
require_once '../classes/class.model.Evaluacion.php';

$docente = new Docente();
$lapso = new Lapso();
$seccion = new Seccion();
$materia = new Materia();
$evaluacion = new Evaluacion();
$tipo_msg="";
if(isset($_POST)){
	
	$cedula = intval($_POST['cedula']);
	$docente->findBy("CEDULA = $cedula");
	$lapso->find($_POST['lapso']);
	$seccion->find($_POST['seccion']);
	$materia->find($_POST['materia']);
	
	$evaluacion->setIdDocente($docente->getId());
	$evaluacion->setIdLapso($lapso->getId());
	$evaluacion->setIdMateria($materia->getId());
	$evaluacion->setIdSeccion($seccion->getId());
	
	if(isset($_POST['procesar']) && $_POST['procesar'] == "Crear"){
		//echo $docente->getNombre()." ".$lapso->getDescripcion()." ".$seccion->getDescripcion()." ".$materia->getNombre();
		$cantidad = $_POST['cantidad'];
		$evaluacion->setCantidadEvaluaciones($cantidad);
		$filas = $evaluacion->insert();
		if($filas){
			$tipo_msg="info";
			$mensaje1="Se creo el control de notas Exitosamente";
			//echo $evaluacion->getId()." registro insertado<br>";
			require_once '../vistas/evaluaciones.php';
		}else{
			//echo "no se inserto<br>";
			require_once '../vistas/evaluaciones.php';
		}
		
		
		
	}
	
	if(isset($_POST['procesar']) && $_POST['procesar'] == "Guardar"){
		$evaluacion->findBy("IDDOCENTE=".$evaluacion->getIdDocente()." AND IDSECCION= ".$evaluacion->getIdSeccion()." AND IDASIGNATURA = ".$evaluacion->getIdMateria()." AND IDLAPSO=".$evaluacion->getIdLapso());
		
		$sum=0;
		
		for($i=1; $i<=intval($evaluacion->getCantidadEvaluaciones()); $i++){
			$sum+= $_POST["porcentaje".$i];
			
		}
		
		if($sum < 100 || $sum > 100){
			//echo "añadir";
			$tipo_msg="error";
			$mensaje="La suma de los porcentajes es de $sum% y debe ser del 100%";
			require_once '../vistas/evaluaciones.php';
		}else{
			$examenes=0;
			for($i=1; $i<=intval($evaluacion->getCantidadEvaluaciones()); $i++){
				$control = $evaluacion->getId();
				$descripcion = $_POST["descripcion".$i];
				$fecha = $_POST["fecha".$i];
				$porcentaje = $_POST["porcentaje".$i];
				$examen= new Examen();
				$examen->setIdControl($control);
				$examen->setDescripcion($descripcion);
				$examen->setFecha($fecha);
				$examen->setPorcentaje($porcentaje);
				$examen->setNumero($i);
				$examenes+=$examen->insert();
					
			}
			$tipo_msg="info";
			$mensaje2="Se registraron ".$examenes." examenes";
			require_once '../vistas/evaluaciones.php';
		}
		
		
	}
}
?>