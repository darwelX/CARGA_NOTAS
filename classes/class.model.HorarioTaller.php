<?php
require_once '../classes/interface.Operaciones.php';
require_once '../classes/class.model.Lapso.php';
require_once '../classes/class.model.Carrera.php';
require_once '../classes/class.model.Estudiante.php';
require_once '../classes/class.model.SeccionTaller.php';
require_once '../classes/class.model.Taller.php';
require_once '../classes/class.model.Connect.php';

class HorarioTaller implements Operaciones{

	public $estudiante;
	public $lapso;
	public $carrera;
	public $taller;
	public $seccion;
	public $horario;
	private $conexion;
	private $sqlAll = "SELECT * FROM ESTUDIANTES_HORARIOS_TALLERES";
	private static $table = "ESTUDIANTES_HORARIOS_TALLERES";

	public function __construct(){
		$this->conexion = new Connect();
		$this->lapso = new Lapso();
		$this->taller = new Taller();
		$this->carrera = new Carrera();
		$this->estudiante = new Estudiante();
		$this->seccion = new SeccionTaller();

	}
	
	public function getHorario(){
		return $this->horario;
	}
	
	public function setHorario($horario){
		$this->horario = $horario;
	}
	
	public function findAll(){
		$this->conexion->conectar();
		$sql = $this->sqlAll." WHERE LAPSO = ".$this->lapso->getId()." AND CARRERA = ".$this->carrera->getId()." AND ESTUDIANTE = ".$this->estudiante->getId();
		$this->stmt = $this->conexion->ejecutar($sql);
		//echo $sql;
		$array=array();
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$horario=new HorarioTaller();
			$horario->lapso->find($rsd['LAPSO']);
			$horario->taller->find($rsd['ASIGNATURA']);
			$horario->carrera->find($rsd['CARRERA']);
			$horario->seccion->find($rsd['SECCION']);
			$horario->estudiante->find($rsd['ESTUDIANTE']);
			$horario->setHorario($rsd['HORARIO']);
			array_push($array,$horario);
			//return true;
		}
		return $array;
	}
	
	public function find($id){
	
	}
	
	public function findBy($condicion){
	
	}
	
	public function insert(){
		$sql_horarios="SELECT DIA+' '+HORA_ENT+' - '+HORA_SAL+' AULA: '+AULA AS HORA FROM HORARIO_TALLER WHERE SECCION = ".$this->seccion->getId()." AND ASIGNATURA=".$this->taller->getId()." AND LAPSO = ".$this->lapso->getId();
		$this->conexion->conectar();
		//echo $sql_horarios."<br>";
		$sw_horarios = false;
		$this->stmt = $this->conexion->ejecutar($sql_horarios);
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$this->horario.=" ".$rsd['HORA']."<br>";
			$sw_horarios = true;
		}
	
		if($sw_horarios){
			$sql = "SELECT * FROM ".HorarioTaller::$table;
			$sql .= " WHERE LAPSO = '".$this->lapso->getId()."' AND CARRERA = ".$this->carrera->getId()." AND ESTUDIANTE = ".$this->estudiante->getId()." AND ASIGNATURA =".$this->taller->getId()." AND SECCION = ".$this->seccion->getId();
			$this->stmt = $this->conexion->ejecutar($sql);
			$rsd = $this->conexion->obtener_filas($this->stmt);
			if(!isset($rsd['ASIGNATURA'])){
				$sql = "INSERT INTO ".HorarioTaller::$table." (ESTUDIANTE,ASIGNATURA,CREDITOS,HORARIO,LAPSO,CARRERA,TRIMESTRE,SECCION) ";
				$sql.= " VALUES( ";
				$sql .= "'".$this->estudiante->getId()."', ";
				$sql .= "'".$this->taller->getId()."', ";
				$sql .= "'0', ";
				$sql .= "'".$this->horario."', ";
				$sql .= "'".$this->lapso->getId()."', ";
				$sql .= "'".$this->carrera->getId()."', ";
				$sql .= "'0', ";
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
	
		$sql = "DELETE FROM ".HorarioTaller::$table;
		$sql .= " WHERE LAPSO = '".$this->lapso->getId()."' AND CARRERA = ".$this->carrera->getId()." AND ESTUDIANTE = ".$this->estudiante->getId()." AND ASIGNATURA =".$this->taller->getId()." AND SECCION = ".$this->seccion->getId();
		//echo $sql;
		$this->stmt = $this->conexion->ejecutar($sql);
		return $this->conexion->numeroFilas($this->stmt);
		//return 1;
	}
}

?>