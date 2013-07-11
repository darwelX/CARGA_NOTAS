<?php
require_once '../classes/interface.Operaciones.php';

class Nota implements Operaciones{
	private $idestudiante;
	private $nota;
	private $control;
	private $numeroEvaluacion;
	private $conexion;
	private $stmt;
	private $sqlAll = "SELECT * FROM NOTASDESGLOSADAS ";	
	private static $table = "NOTASDESGLOSADAS";

	public function __construct(){
		$this->conexion = new Connect();
	}
	
	public function getIdEstudiante(){
		return $this->idestudiante;
	}
	
	public function setIdEstudiante($id){
		$this->idestudiante = $id;
	}
	
	public function getNota(){
		return $this->nota;
	}
	
	public function setNota($nota){
		$this->nota=$nota;
	}
	
	public function getControl(){
		return $this->control;
	}
	
	public function setControl($control){
		$this->control=$control;
	}
	
	public function getNumeroEvaluacion(){
		return $this->numeroEvaluacion;
		
	}
	
	public function setNumeroEvaluacion($numero){
		$this->numeroEvaluacion = $numero;
	}
	
	public function find($id){
		
	}
	
	public function findBy($condicion){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE $condicion ");
		//while ($rsd=$this->conexion->obtener_filas($this->stmt)){
		$rsd=$this->conexion->obtener_filas($this->stmt);
		if(isset( $rsd['IDESTUDIANTE'])){
			$this->idestudiante = $rsd['IDESTUDIANTE'];
			$this->nota = $rsd['NOTASOBTENIDAS'];
			$this->control = $rsd['CONTROL'];
			$this->numeroEvaluacion = $rsd['NROEVALUACION'];
			return true;
		}
		return false;		
	}
	
	public function insert(){
		$this->conexion->conectar();
		$sw = $this->findBy("IDESTUDIANTE=$this->idestudiante AND CONTROL= $this->control AND NROEVALUACION = $this->numeroEvaluacion");
		
		if(!$sw){
			$sql = "INSERT INTO ".Nota::$table." (IDESTUDIANTE,NOTASOBTENIDAS,CONTROL,NROEVALUACION) ";
			$sql.= " VALUES( ";
			$sql .= "'".$this->idestudiante."', ";
			$sql .= "'".$this->nota."', ";
			$sql .= "'".$this->control."', ";
			$sql .= "'".$this->numeroEvaluacion."'";
			$sql .= ")";
			//echo $sql."<br>";
			$this->stmt = $this->conexion->ejecutar($sql);
			return $this->conexion->numeroFilas($this->stmt);
			//return 1;
		}else{
			return false;
		}		
	}
	
	public function update(){
		
	}	
}
?>