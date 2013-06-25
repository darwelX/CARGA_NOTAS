<?php
require_once '../classes/interface.Operaciones.php';
require_once '../classes/class.model.Connect.php';
class Carrera implements Operaciones{
	private $id;
	private $descripcion;
	private $conexion;
	private $stmt;
	private $sqlAll = "SELECT * FROM CARRERAS";
	
	public function __construct(){
		$this->conexion = new Connect();	
	}
	
	public function getId(){
		return $this->id;	
	}
	
	public function setId($id){
		
		if(is_int($id) && $id > 0){
			$this->id = $id;
		}else{
			throw new Exception("Id de carrera invalido");
		}	
	}
	
	public function getDescripcion(){
		return $this->descripcion;
	}
	
	public function setDescripcion($descripcion){
		
		if(strlen($descripcion) > 0 && is_string($descripcion)){
		   $this->descripcion = $descripcion;
		}else{
			throw new Exception("Descripcion incorrecta");
		}
	}
	
	public function insert(){
		
	}
	
	public function update(){
		
	}
	
	public function findBy($condicion){
		
	}
	
	public function find($id){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE IDCARRERA = ".$id);
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$this->id = $rsd['IDCARRERA'];
			$this->descripcion = $rsd['CARRERA'];
			return true;
		}
		return false;
	}
}
?>
