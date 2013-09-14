<?php
class Materia {
	private $id;
	private $codigo;
	private $trimestre;
	private $nombre;
	private $creditos;
	private $conexion;
	private $stmt;
	private $sqlAll = "SELECT * FROM PENSUN ";
	
	public function __construct(){
		$this->conexion = new Connect();
	}

	public function getCreditos(){
		return $this->creditos;
	}
	
	public function setCreditos($creditos){
		$this->creditos=$creditos;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id=$id;
	}
	
	public function getCodigo(){
		return $this->codigo;
	}
	
	public function setCodigo($codigo){
		$this->codigo=$codigo;
	}

	public function getTrimestre(){
		return $this->trimestre;
	}
	
	public function setTrimestre($trimestre){
		$this->trimestre=$trimestre;
	}	
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function setNombre($nombre){
		$this->nombre=$nombre;
	}	
	
	public function find($id){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE IDASIGNATURA = ".$id);
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$this->id = $rsd['IDASIGNATURA'];
			$this->codigo = $rsd['CODIGO'];
			$this->trimestre = $rsd['TRIMESTRE'];
			$this->nombre = $rsd['NOMBRE'];
			$this->creditos = $rsd['CREDITOS'];
			return true;
		}
		return false;
	}

	public function findMateriasPorTrimestreYCarrera($trimestre,$carrera){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE TRIMESTRE = $trimestre AND CARRERA = $carrera");
		$indice = 0;
		$array=array();
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$materia=new Materia();
			$materia->id = $rsd['IDASIGNATURA'];
			$materia->codigo = $rsd['CODIGO'];
			$materia->trimestre = $rsd['TRIMESTRE'];
			$materia->nombre = $rsd['NOMBRE'];
			$materia->creditos = $rsd['CREDITOS'];
			$array[$indice]=$materia;
			$indice++;
			//return true;
		}
		return $array;		
	}
}