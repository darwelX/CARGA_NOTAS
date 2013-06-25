<?php
require_once '../classes/interface.Operaciones.php';
class Evaluacion implements Operaciones{
	private $id;
	private $idmateria;
	private $iddocente;
	private $idlapso;
	private $idseccion;
	private $cantidadEvaluaciones;
	private $examenes;
	private $conexion;
	private $stmt;
	private $sqlAll = "SELECT * FROM CONTROLDEEVALUACIONES ";
	private static $table = "CONTROLDEEVALUACIONES";
	
	public function __construct(){
		$this->conexion = new Connect();
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function setIdMateria($idmateria){
		$this->idmateria = $idmateria;
	}
	
	public function getIdMateria(){
		return $this->idmateria;
	}
	
	public function getIdDocente(){
		return $this->iddocente;
	}
	
	public function setIdDocente($iddocente){
		$this->iddocente = $iddocente;
	}
	
	public function getIdLapso(){
		return $this->idlapso;
	}
	
	public function setIdLapso($idlapso){
		$this->idlapso = $idlapso;
	}
	
	public function setIdSeccion($idseccion){
		$this->idseccion = $idseccion;
	}
	
	public function getIdSeccion(){
		return  $this->idseccion;
	}
	
	public function getCantidadEvaluaciones(){
		return $this->cantidadEvaluaciones;
	}
	
	public function setCantidadEvaluaciones($cantidadEvaluaciones){
		$this->cantidadEvaluaciones = $cantidadEvaluaciones;
	}
	
	public function find($id){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE IDCONTROL = ".$id);
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$this->id = $rsd['IDCONTROL'];
			$this->iddocente = $rsd['IDDOCENTE'];
			$this->idlapso = $rsd['IDLAPSO'];
			$this->idmateria = $rsd['IDASIGNATURA'];
			$this->idseccion = $rsd['IDSECCION'];
			$this->cantidadEvaluaciones = $rsd['CANTEVALUACIONES'];
			return true;
		}
		return false;
	}
	
	public function findBy($condicion){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE $condicion ");
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$this->id = $rsd['IDCONTROL'];
			$this->iddocente = $rsd['IDDOCENTE'];
			$this->idlapso = $rsd['IDLAPSO'];
			$this->idmateria = $rsd['IDASIGNATURA'];
			$this->idseccion = $rsd['IDSECCION'];
			$this->cantidadEvaluaciones = $rsd['CANTEVALUACIONES'];
			return true;
		}
		return false;
	}
	
	public function insert(){
		$this->conexion->conectar();
		$sw = $this->findBy("IDDOCENTE=$this->iddocente AND IDSECCION= $this->idseccion AND IDASIGNATURA = $this->idmateria AND IDLAPSO=$this->idlapso");
		
		if(!$sw){
			$sql = "INSERT INTO ".Evaluacion::$table." (IDDOCENTE,IDLAPSO,IDASIGNATURA,IDSECCION,CANTEVALUACIONES) ";
			$sql.= " VALUES( ";
			$sql .= "'".$this->iddocente."', ";
			$sql .= "'".$this->idlapso."', ";
			$sql .= "'".$this->idmateria."', ";
			$sql .= "'".$this->idseccion."', ";
			$sql .= "'".$this->cantidadEvaluaciones."'";		
			$sql .= ")";
			//echo $sql;
			$this->stmt = $this->conexion->ejecutar($sql);
			$this->findBy("IDDOCENTE=$this->iddocente AND IDSECCION= $this->idseccion AND IDASIGNATURA = $this->idmateria AND IDLAPSO=$this->idlapso");
			return $this->conexion->numeroFilas($this->stmt);
		}else{
			return false;
		}
	}
	
	public function update(){
			
	}
}
?>