<?php
require_once '../classes/interface.Operaciones.php';
require_once '../classes/interface.Lapso.php';
require_once '../classes/interface.Carrera.php';
require_once '../classes/interface.Estudiante.php';
require_once '../classes/interface.Seccion.php';
require_once '../classes/interface.Materia.php';
require_once '../classes/class.model.Connect.php';

class Taller implements Operaciones{

	private $estudiante;
	private $lapso;
	private $carrera;
	private $trimestre;
	private $seccion;
	private $materia;
	private $horario;
	private $creditos;
	private $conexion;
	private $sqlAll = "SELECT * FROM ESTUDIANTES_HORARIOS";
	private static $table = "ESTUDIANTES_HORARIOS";

	public function __construct(){
		$this->conexion = new Connect();
		$this->lapso = new Lapso();
		$this->carrera = new Carrera();
		$this->estudiante = new Estudiante();
		$this->seccion = new Seccion();
		$this->materia = new Materia();
		
	}

	public function getCreditos(){
		return $this->creditos;
	}

	public function setCreditos($creditos){
		$this->creditos = $creditos;
	}

	public function getHorario(){
		return $this->horario;
	}

	public function setHorario($horario){
		$this->horario = $horario;
	}

	public function getTrimestre(){
		return $this->trimestre;
	}
	
	public function setTrimestre($trimestre){
		$this->trimestre = $trimestre;
	}	
}
?>