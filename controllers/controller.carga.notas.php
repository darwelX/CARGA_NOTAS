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
$errores = array();
$cedulasNoRegistradas="";
$cedulasNoMatriculadas="";
$tipo_msg="";
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
				$objReadCSV = new ReadCSV($uploadfile);
				$errores=$objReadCSV->validarColumnasCSV($uploadfile);
				if(sizeof($errores) > 0){
					$swCargar = false;
				}else{
					$cantidadEstudiantesNoRegistrados=0;
					$cantidadEstudiantesNoMatriculados=0;
					$matriz = $objReadCSV->convertriArreglo();
					
					for($i=1; $i < sizeof($matriz); $i++){
						$cedula =  $objConversion->eliminarPuntos($matriz[$i][0]);
						$objEst = new Estudiante();
						
						if($objEst->findBy("CEDULA = $cedula")){
							$existe=$objCeccion->findEstudianteByMateria($materia->getId(), $objEst->getId());
							if(!$existe){
								$cantidadEstudiantesNoMatriculados++;
								$cedulasNoMatriculadas.=$cedula.",";
							}
						}else{
							$cantidadEstudiantesNoRegistrados++;
							$cedulasNoRegistradas.=$cedula.",";
						}
					}
				    $tipo_msg="info";	
					$mensaje = "Archivo cargado exitosamente";
					if($cantidadEstudiantesNoRegistrados) $mensaje.="<br> Se encontraron en el archivo $cantidadEstudiantesNoRegistrados estudiantes, no registrados en el sistema ($cedulasNoRegistradas)";
					if($cantidadEstudiantesNoMatriculados) $mensaje.="<br> Se encontraron en el archivo $cantidadEstudiantesNoMatriculados estudiantes, no inscritos en la asignatura ($cedulasNoMatriculadas)";
					$swCargar = true;
				}
			} else {
				$tipo_msg="error";
				$mensaje = "Fallo la carga del archivo";
			}

		}else{
			$tipo_msg="error";
			$mensaje ="No existe un Control de Evaluacion creado debe de <a href='../vistas/crear_plan_evaluacion.php?&cedula=".$docente->getCedula()."'>crear</a> uno antes de cargar notas";
		}

		require_once '../vistas/cargar_notas.php';
	}

	if(isset($_POST['procesar']) && $_POST['procesar'] == "Guardar"){
		$objReadCSV = new ReadCSV($_POST['nombreArchivo']);
		$matriz = $objReadCSV->convertriArreglo();

		$cantidadEstudiantesNoInscritos=0;
		$cantidadNotasRegistradas=0;
		$cantidadNotasDefinitivas=0;
		$cantidadEvaluaciones = intval(sizeof($matriz[0])) - 3;

		$evaluacion->findBy("IDDOCENTE=".$docente->getId()." AND IDSECCION= ".$objCeccion->getId()." AND IDASIGNATURA = ".$materia->getId()." AND IDLAPSO=".$lapso->getId());

		for($i=1; $i < sizeof($matriz); $i++){
			$cedula =  $objConversion->eliminarPuntos($matriz[$i][0]);
			$suma=0;
			$objEst;
			$existeMatricula = false;
			for($j=3; $j < sizeof($matriz[0]); $j++ ){
				
				$objEst = new Estudiante();
				
				if($objEst->findBy("CEDULA = $cedula")){
					
					$existeMatricula=$objCeccion->findEstudianteByMateria($materia->getId(), $objEst->getId());
					
					if($existeMatricula){
						$objNota = new Nota();
						$objNota->setIdEstudiante($objEst->getId());
						$no = 0;
						if(! ($matriz[$i][$j] == "-" || $matriz[$i][$j] == "NP") ){
							$no = floatval($objConversion->cambiarPuntoDecimal($matriz[$i][$j]));
						}
						$suma+=$no;
						$objNota->setNota($no);
						$objNota->setNumeroEvaluacion($j-2);
						$objNota->setControl($evaluacion->getId());
						$swInsert = $objNota->insert();
						if($swInsert){
							$cantidadNotasRegistradas++;
						}
					}
				}

			}

			if($existeMatricula){
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
				$objNotaDefinitiva->setCreditos($materia->getCreditos());
				$wsNotaDef=$objNotaDefinitiva->insert();
				if($wsNotaDef){
					$cantidadNotasDefinitivas++;
				}
			}else{
				$cantidadEstudiantesNoInscritos++;
			}

		}
		$estudiantes = $cantidadNotasRegistradas/$cantidadEvaluaciones;
		$tipo_msg="info";
		$mensaje2="Total de notas desglosadas registradas $cantidadNotasRegistradas <br> Numero de estudiantes procesados $estudiantes";
		$mensaje2.="<br> Total de notas Definitivas registradas $cantidadNotasDefinitivas";
		$mensaje2.="<br>$cantidadEstudiantesNoInscritos estudiantes no inscritos en la asignatura tiene el archivo";
		require_once '../vistas/cargar_notas.php';
	}
}
?>
