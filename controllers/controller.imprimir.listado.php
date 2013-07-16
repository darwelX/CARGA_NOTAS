<?php
require_once '../classes/excelwriter.inc.php';
require_once '../classes/class.model.Connect.php';
require_once '../classes/class.model.Docente.php';
require_once '../classes/class.model.Seccion.php';
require_once '../classes/class.model.Carrera.php';
require_once '../classes/class.model.Estudiante.php';
require_once '../classes/class.model.Lapso.php';
require_once '../classes/class.model.Materia.php';
require_once '../classes/class.model.Examen.php';
require_once '../classes/class.model.Evaluacion.php';
require_once '../classes/class.util.Convert.php';

$objConv= new Convert();
$docente = new Docente();
$lapso = new Lapso();
$objCeccion = new Seccion();
$materia = new Materia();
$evaluacion = new Evaluacion();
$mensaje="";

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

	$evaluacion->setIdDocente($docente->getId());
	$evaluacion->setIdLapso($lapso->getId());
	$evaluacion->setIdMateria($materia->getId());
	$evaluacion->setIdSeccion($objCeccion->getId());

	if(isset($_POST['procesar']) && $_POST['procesar'] == "Buscar"){
		//echo "buscando";
		$objCeccion->findEstudiantesByMateria($materia->getId());
		if(sizeof($objCeccion->estudiantes) <= 0){
			$mensaje="No posee estudiantes asignados para esta materia";
		}
		require_once '../vistas/imprimir_planilla_notas.php';
	}

	if(isset($_POST['procesar']) && $_POST['procesar'] == "Imprimir"){
		//echo "imprimiendo";
		$mensaje="";
		if($evaluacion->findBy("IDDOCENTE=".$docente->getId()." AND IDSECCION= ".$objCeccion->getId()." AND IDASIGNATURA = ".$materia->getId()." AND IDLAPSO=".$lapso->getId())){
			
			$objCeccion->findEstudiantesByMateria($materia->getId());
			
			$vocales = array("á", "é", "í", "ó", "ú","ò");
			$nombre = str_replace($vocales, "", $materia->getNombre());
			
			$nombreXls = $docente->getCedula()."_".$nombre.".xls";
			$excel=new ExcelWriter("../tmp/$nombreXls");

			if($excel==false) {
				echo $excel->error;
			}

			$excel->writeRow();
			$excel->writeCol("Cedula");
			$excel->writeCol("Apellidos");
			$excel->writeCol("Nombres");
            
            $examen = new Examen();
            $examenes = $examen->findAll($evaluacion->getId());

            foreach ($examenes as $exa){
            	$excel->writeCol("<center>Nota ".$exa->getNumero()." ".$exa->getDescripcion()." ".$exa->getPorcentaje()."%</center>");
            }
			
			foreach ($objCeccion->estudiantes as $est){
				//echo $est->getCedula()."<br>";
				$excel->writeRow();
				$excel->writeCol($objConv->formatoCedula($est->getCedula()));
				$excel->writeCol($est->getApellidos());
				$excel->writeCol($est->getNombres());
					
			}
			$excel->close();
			header("location:../tmp/$nombreXls");
		}else{
			$mensaje="El plan de Evaluacion aun no esta cargado, Porfavor carguelo y luego imprima el listado";
		}
		require_once '../vistas/imprimir_planilla_notas.php';
		
	}
	
	require_once '../vistas/imprimir_planilla_notas.php';
}else{
  echo "hola";
}
?>