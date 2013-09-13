<?php
require_once '../classes/interface.Operaciones.php';
require_once '../classes/class.model.Lapso.php';
require_once '../classes/class.model.Carrera.php';
require_once '../classes/class.model.Estudiante.php';
require_once '../classes/class.model.Seccion.php';
require_once '../classes/class.model.Materia.php';
require_once '../classes/class.model.Connect.php';

class Horario implements Operaciones{

	public $estudiante;
	public $lapso;
	public $carrera;
	private $trimestre;
	public $seccion;
	public $materia;
	public $horario;
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
	
	public function findAll(){
		$this->conexion->conectar();
		$sql = $this->sqlAll." WHERE LAPSO = ".$this->lapso->getId()." AND CARRERA = ".$this->carrera->getId()." AND ESTUDIANTE = ".$this->estudiante->getId();
		$this->stmt = $this->conexion->ejecutar($sql);
		//echo $sql;
		$indice = 0;
		$array=[];
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$horario=new Horario();
			$horario->lapso->find($rsd['LAPSO']);
			$horario->carrera->find($rsd['CARRERA']);
			$horario->seccion->find($rsd['SECCION']);
			$horario->materia->find($rsd['ASIGNATURA']);
			$horario->estudiante->find($rsd['ESTUDIANTE']);
			$horario->setTrimestre($rsd['TRIMESTRE']);
			$horario->setCreditos($rsd['CREDITOS']);
			$horario->setHorario($rsd['HORARIO']);
			$array[$indice]=$horario;
			$indice++;
			//return true;
		}
		return $array;
	}
	
	public function find($id){
		
	}
	
	public function findBy($condicion){
		
	}
	
	public function insert(){
		$sql_horarios="SELECT DIA+' '+HORA_ENT+' - '+HORA_SAL+' AULA: '+AULA AS HORA FROM HORARIOS WHERE SECCION = ".$this->seccion->getId()." AND ASIGNATURA=".$this->materia->getId()." AND LAPSO = ".$this->lapso->getId();
		$this->conexion->conectar();
		//echo $sql_horarios."<br>";
		$sw_horarios = false;
		$this->stmt = $this->conexion->ejecutar($sql_horarios);
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$this->horario.=" ".$rsd['HORA']."<br>";
			$sw_horarios = true;
		}
		
		if($sw_horarios){
			$sql = "SELECT * FROM ".Horario::$table;
			$sql .= " WHERE LAPSO = '".$this->lapso->getId()."' AND CARRERA = ".$this->carrera->getId()." AND ESTUDIANTE = ".$this->estudiante->getId()." AND ASIGNATURA =".$this->materia->getId()." AND SECCION = ".$this->seccion->getId();
			$this->stmt = $this->conexion->ejecutar($sql);
			$rsd = $this->conexion->obtener_filas($this->stmt);
			if(!isset($rsd['ASIGNATURA'])){
				$sql = "INSERT INTO ".Horario::$table." (ESTUDIANTE,ASIGNATURA,CREDITOS,HORARIO,LAPSO,CARRERA,TRIMESTRE,SECCION) ";
				$sql.= " VALUES( ";
				$sql .= "'".$this->estudiante->getId()."', ";
				$sql .= "'".$this->materia->getId()."', ";
				$sql .= "'".$this->materia->getCreditos()."', ";
				$sql .= "'".$this->horario."', ";
				$sql .= "'".$this->lapso->getId()."', ";
				$sql .= "'".$this->carrera->getId()."', ";
				$sql .= "'".$this->trimestre."', ";
				$sql .= "'".$this->seccion->getId()."'";
				$sql .= ")";
				//echo $sql;
				$this->stmt = $this->conexion->ejecutar($sql);
				return $this->conexion->numeroFilas($this->stmt);
			}
			return true;
		}else{
			return false;
		}
		//$this->stmt = $this->conexion->ejecutar($sql);
				
	}
	
	public function update(){
		
	}
	
	public function eliminar(){
		$this->conexion->conectar();
	
		$sql = "DELETE FROM ".Horario::$table;
		$sql .= " WHERE LAPSO = '".$this->lapso->getId()."' AND CARRERA = ".$this->carrera->getId()." AND ESTUDIANTE = ".$this->estudiante->getId()." AND ASIGNATURA =".$this->materia->getId()." AND SECCION = ".$this->seccion->getId();
		//echo $sql;
		$this->stmt = $this->conexion->ejecutar($sql);
		return $this->conexion->numeroFilas($this->stmt);
	    //return 1;
	}
}
?>