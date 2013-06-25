<?php
require_once '../classes/class.model.Connect.php';
require_once '../classes/interface.Operaciones.php';

class Lapso implements Operaciones{

	private $id;
	private $descripcion;
	private $inicio;
	private $fin;
	private $conexion;
	private $stmt;
	private $sqlAll = "SELECT * FROM LAPSOS";
	
	public function __construct(){
		$this->conexion = new Connect();
	}
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}
	
	public function getDescripcion(){
		return $this->descripcion;
	}

	public function setInicio($inicio){
		$this->inicio = $inicio;
	}
	
	public function getInicio(){
		return $this->inicio;
	}	
	
	public function setFin($fin){
		$this->fin = $fin;
	}
	
	public function getFin(){
		return $this->fin;
	}	
	/*
	 * Esta funcion retorna un objeto
	* docente encontrado por el id
	* en la base de datos
	*/
	public function find($id){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE IDLAPSO = ".$id);
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$this->id = $rsd['IDLAPSO'];
			$this->descripcion = $rsd['LAPSO'];
			$this->inicio = $rsd['INICIO'];
			$this->fin = $rsd['FINAL'];
            return true;
		}
		return false;
	}
	
	/*
	 * Esta funcion retorna un objeto
	* docente encontrado por el id
	* en la base de datos
	*/
	public function findAll(){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." ORDER BY IDLAPSO DESC");
		$indice = 0;
		$array=[];
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$lapso=new Lapso();
			$lapso->id = $rsd['IDLAPSO'];
			$lapso->descripcion = $rsd['LAPSO'];
			$lapso->inicio = $rsd['INICIO'];
			$lapso->fin = $rsd['FINAL'];
			$array[$indice]=$lapso;
			$indice++;
			//return true;
		}
		return $array;
	}
		
	/*
	 * Esta funcion retorna un objeto
	* docente encontrado por el id
	* en la base de datos
	*/
	public function findBy($condicion){
		/*$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE $condicion ");
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$this->id = $rsd['IDDOCENTE'];
			$this->nombre = $rsd['APELLIDOSYNOMBRES'];
			$this->cedula = $rsd['CEDULA'];
			$this->profesion = $rsd['PROFESION'];
			return true;
		}
		return false;*/
	}	
	
	public function insert(){
		
	}
	
	public function update(){
		
	}
}
?>