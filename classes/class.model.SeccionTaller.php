<?php

require_once '../classes/class.model.Connect.php';

class SeccionTaller {
	private $id;
	private $descripcion;
	private $capacidad;
	public $lapso;
    private $stmt;
    private $conexion;
    private $sqlAll="SELECT * FROM SECCIONES_TALLERES ";
    
	public function __construct(){
		$this->lapso = new Lapso();
		$this->conexion = new Connect();
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		
		if(is_int($id) && $id > 0){
			$this->id = $id;
		}else{
			throw new Exception("Id de seccion invalido");
		}		
		
	}
	
	public function getDescripcion(){
		return $this->descripcion;
	}
	
	public function setDescripcion($descripcion){
		
		if(strlen($descripcion) > 0 && is_string($descripcion)){
			$this->descripcion = $descripcion;
		}else{
			throw new Exception("Descripcion de seccion incorrecta");
		}
	}
	
	public function getTrimestre(){
		return $this->trimestre;
	}
	
	public function setTrimestre($trimestre){
		
		if(is_int($trimestre) && $trimestre > 0){
			$this->trimestre = $trimestre;
		}else{
			throw new Exception("Trimestre de seccion invalido");
		}		
	}
	
	public function getCapacidad(){
		return $this->capacidad;
	} 
	
	public function setCapacidad($capacidad){
		
		if(is_int($capacidad) && $capacidad > 0){
			$this->capacidad = $capacidad;
		}else{
			throw new Exception("Capacidad de seccion invalido");
		}		
	}
	
	public function findByTaller($id,$lapso){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE TALLER = ".$id." AND LAPSO= $lapso");
		//echo $this->sqlAll." WHERE TALLER = ".$id." aquiiiiiiii";
		$indice = 0;
		$array=array();
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$seccion_taller=new SeccionTaller();
			$seccion_taller->id = $rsd['IDSECCION'];
			$seccion_taller->descripcion = $rsd['SECCION'];
			$seccion_taller->capacidad = $rsd['CAPACIDAD'];
			$seccion_taller->lapso->find($rsd['LAPSO']);
			$array[$indice]=$seccion_taller;
			$indice++;
		}
		return $array;
	}	
	
	public function find($id){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE IDSECCION = ".$id);
		//echo "<br>".$this->sqlAll." WHERE IDSECCION = ".$id." aquiiiiiiii";
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$this->id = $rsd['IDSECCION'];
			$this->descripcion = $rsd['SECCION'];
			$this->capacidad = $rsd['CAPACIDAD'];
			$this->lapso->find($rsd['LAPSO']);
			return true;
		}
		return false;
	}	
}
?>
