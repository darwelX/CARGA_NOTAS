<?php
require_once '../classes/class.model.Connect.php';
require_once '../classes/class.model.Carrera.php';
require_once '../classes/interface.Operaciones.php';

class Estudiante implements Operaciones{
	private $id;
	private $nacionalidad;
	private $cedula;
	private $nombres;
	private $apellidos;
	private $proceso;
	public $carrera;
	private $conexion;
	private $stmt;
	private $sqlAll = "SELECT * FROM PERSONAS";
	
	public function __construct(){
		$this->conexion = new Connect();
		$this->carrera = new Carrera();
	}
		
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getNacionalidad(){
		return $this->nacionalidad;
	}
	
	public function setNacionalidad($nacionalidad){
		$this->nacionalidad;
	}
	
	public function getCedula(){
		return $this->cedula;
	}
	
	public function setCedula($cedula){
		$this->cedula = $cedula;
	}
	
	public function getNombres(){
		return $this->nombres;
	}
	
	public function setNombres($nombres){
		$this->nombres = $nombres;
	}
	
	public function setApellidos($apellidos){
		$this->apellidos = $apellidos;
	}

	public function getApellidos(){
		return $this->apellidos;
	}
	
	public function getProceso(){
		return $this->proceso;
	}
	
	public function setProceso($proceso){
		$this->proceso = $proceso;
	}
	
	public function find($id){
		$this->conexion->conectar();
		//echo $this->sqlAll." WHERE IDPERSONA = ".$id." AND PROCESO=3";
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE IDPERSONA = ".$id." AND PROCESO=3");
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$this->id = $rsd['IDPERSONA'];
			$this->nacionalidad = $rsd['NACIONALIDAD'];
			$this->cedula = $rsd['CEDULA'];
			$this->apellidos= $rsd['APELLIDOS'];
			$this->nombres = $rsd['NOMBRES'];
			$this->proceso= $rsd['PROCESO'];
			$this->carrera->find($rsd['CARRERAPRE']);
			return true;
		}
		return false;		
	}
	
	public function findBy($condicion){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE $condicion "." AND PROCESO=3");
		//echo $this->sqlAll." WHERE $condicion "." AND PROCESO=3"; 
		$rsd=$this->conexion->obtener_filas($this->stmt);
		if(isset($rsd['IDPERSONA'])){
			$this->id = $rsd['IDPERSONA'];
			$this->nacionalidad = $rsd['NACIONALIDAD'];
			$this->cedula = $rsd['CEDULA'];
			$this->apellidos= $rsd['APELLIDOS'];
			$this->nombres = $rsd['NOMBRES'];
			$this->proceso= $rsd['PROCESO'];
			$this->carrera->find($rsd['CARRERAPRE']);
			return true;
		}
		return false;
		
	}
	
	public function insert(){
		
	}
	
	public function update(){
	
	}	
}
?>