<?php
require_once '../classes/excelwriter.inc.php';
require_once '../classes/class.model.Connect.php';
require_once '../classes/class.model.Docente.php';
require_once '../classes/class.model.Nota.php';
require_once '../classes/class.model.Seccion.php';
require_once '../classes/class.model.Carrera.php';
require_once '../classes/class.model.Estudiante.php';
require_once '../classes/class.model.Lapso.php';
require_once '../classes/class.model.Materia.php';
require_once '../classes/class.model.Examen.php';
require_once '../classes/class.model.Evaluacion.php';
require_once '../classes/class.util.ReadCSV.php';
require_once '../classes/class.util.Convert.php';
require_once '../classes/class.model.NotaDefinitiva.php';

$docente = new Docente();
$lapso = new Lapso();
$objCeccion = new Seccion();
$materia = new Materia();
$evaluacion = new Evaluacion();
$mensaje ="";
$uploadfile;
$objReadCSV;
$objConversion = new Convert();
$swCargar = false;
if(isset($_POST)){
	$cedula = intval($_POST['cedula']);
	$docente->findBy("CEDULA = $cedula");
	$lapso->find($_POST['lapso']);

	if($_POST['materia'] != ""){
		$materia->find($_POST['materia']);
	}
	if($_POST['seccion'] != ""){
		$objCeccion->find($_POST['seccion']);
	}

	if(isset($_POST['procesar']) && $_POST['procesar'] == "Cargar"){

		if($evaluacion->findBy("IDDOCENTE=".$docente->getId()." AND IDSECCION= ".$objCeccion->getId()." AND IDASIGNATURA = ".$materia->getId()." AND IDLAPSO=".$lapso->getId())){
			$uploaddir = '../cvs/';
			$uploadfile = $uploaddir . basename($_FILES['file']['name']);

			if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
			    $mensaje = "Archivo cargado exitosamente";
			    $swCargar = true;
			} else {
				$mensaje = "Fallo la carga del archivo";
			}
		}else{
			$mensaje ="No existe un Control de Evaluacion creado debe de <a href='../vistas/crear_plan_evaluacion.php?&cedula=".$docente->getCedula()."'>crear</a> uno antes de cargar notas";	
		}

		require_once '../vistas/cargar_notas.php';
	}
	
	if(isset($_POST['procesar']) && $_POST['procesar'] == "Guardar"){
		$objReadCSV = new ReadCSV($_POST['nombreArchivo']);
		$matriz = $objReadCSV->convertriArreglo();
		
		$cantidadNotasRegistradas=0;
		$cantidadNotasDefinitivas=0;
		$cantidadEvaluaciones = intval(sizeof($matriz[0])) - 3;
		
		$evaluacion->findBy("IDDOCENTE=".$docente->getId()." AND IDSECCION= ".$objCeccion->getId()." AND IDASIGNATURA = ".$materia->getId()." AND IDLAPSO=".$lapso->getId());
		
		for($i=1; $i < sizeof($matriz); $i++){
			$cedula =  $matriz[$i][0];
			$suma=0;
			$objEst;
			for($j=3; $j < sizeof($matriz[0]); $j++ ){
				$objEst = new Estudiante();
				if($objEst->findBy("CEDULA = $cedula")){
				   $suma+=$matriz[$i][$j];
				   $objNota = new Nota();
				   $objNota->setIdEstudiante($objEst->getId());
				   $objNota->setNota($matriz[$i][$j]);
				   $objNota->setNumeroEvaluacion($j-2);
				   $objNota->setControl($evaluacion->getId());
				   $swInsert = $objNota->insert();
				   if($swInsert){
				   	 $cantidadNotasRegistradas++;
				   }
				}
				
			}
			
			$objConver = new Convert();
			$objNotaDefinitiva = new NotaDefinitiva();
			$objNotaDefinitiva->setIdAlumno($objEst->getId());
			$objNotaDefinitiva->setIdAsignatura($materia->getId());
			$objNotaDefinitiva->setIdCarrera($objCeccion->carrera->getId());
			$objNotaDefinitiva->setIdLapso($lapso->getId());
			$objNotaDefinitiva->setIdSeccion($objCeccion->getId());
			$objNotaDefinitiva->setMostrar(1);
			$objNotaDefinitiva->setNota($objConver->conversionNota($suma));
			$objNotaDefinitiva->setTrimestre($materia->getTrimestre());
			$wsNotaDef=$objNotaDefinitiva->insert();
			if($wsNotaDef){
				$cantidadNotasDefinitivas++;
			}
			
		}
		$estudiantes = $cantidadNotasRegistradas/$cantidadEvaluaciones;
		$mensaje2="Total de notas desglosadas registradas $cantidadNotasRegistradas <br> Numero de estudiantes procesados $estudiantes";
		$mensaje2.="<br> Total de notas Definitivas registradas $cantidadNotasDefinitivas";
		require_once '../vistas/cargar_notas.php';
	}
}
?>
