<?php
require_once '../classes/interface.Operaciones.php';
require_once '../classes/class.model.SeccionTaller.php';
require_once '../classes/class.model.Connect.php';

class Taller implements Operaciones{

	private $id;
	private $codigo;
	private $descripcion;
	private $conexion;
	public $secciones;
	private $sqlAll = "SELECT * FROM TALLERES";
	private static $table = "TALLERES";

	public function __construct(){
		$this->conexion = new Connect();
		$this->secciones = array();
	}
	
	public function getDescripcion(){
		return $this->descripcion;	
	}
	
	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}
	
	public function getCodigo(){
		return $this->codigo;	
	}
	
	public function setCodigo($codigo){
		$this->codigo = $codigo;	
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getId(){
		return $this->id;
	}
	public function find($id){
		$this->conexion->conectar();
		//echo "<h1>".$this->sqlAll." WHERE $condicion </h1>aquiiiiiii 2 <br>";
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE IDTALLER = $id ");
		
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$this->id = $rsd['IDTALLER'];
			$this->descripcion = $rsd['TALLER'];
			$this->codigo = $rsd['CODIGO'];
				
		
			return true;
		}
		return false;
	}
	
	public function findBy($condicion){
		$this->conexion->conectar();
		//echo "<h1>".$this->sqlAll." WHERE $condicion </h1>aquiiiiiii 2 <br>";
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE $condicion ");
		
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$this->id = $rsd['IDTALLER'];
			$this->descripcion = $rsd['TALLER'];
			$this->codigo = $rsd['CODIGO'];
			
				
			return true;
		}
		return false;
	
	}	
	
	public function findSeccionesByLapso($lapso){
		$seccion_taller = new SeccionTaller();
		$this->secciones = $seccion_taller->findByTaller($this->getId(),$lapso);
	}
	
	public function insert(){
		$this->conexion->conectar();
		$sw = $this->findBy("CODIGO=$this->codigo");
		
		if(!$sw){
			$sql = "INSERT INTO ".Taller::$table." (CODIGO,TALLER) ";
			$sql.= " VALUES( ";
			$sql .= "'".$this->codigo."', ";
			$sql .= "'".$this->descripcion."'";
			$sql .= ")";
			//echo $sql;
			$this->stmt = $this->conexion->ejecutar($sql);
			$this->findBy("CODIGO=$this->codigo");
			return $this->conexion->numeroFilas($this->stmt);
		}else{
			return false;
		}
	}
	
	public function update(){
		$this->conexion->conectar();
		
			$sql = "UPDATE ".Taller::$table;
			$sql.= " SET ";
			$sql .= "CODIGO = '".$this->codigo."', ";
			$sql .= "TALLER = '".$this->descripcion."'";
			$sql .= " WHERE IDTALLER = '".$this->id."'";
			//echo $sql;
			$this->stmt = $this->conexion->ejecutar($sql);
			return $this->conexion->numeroFilas($this->stmt);
	
	}

	public function findAll(){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll);
		$indice = 0;
		$array=array();
		$seccion_taller = new SeccionTaller();
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$taller=new Taller();
			$taller->id = $rsd['IDTALLER'];
			$taller->descripcion = $rsd['TALLER'];
			$taller->codigo = $rsd['CODIGO'];
			//$taller->secciones = $seccion_taller->findByTaller($rsd['IDTALLER']);
			$array[$indice]=$taller;
			$indice++;
			//return true;
		}
		return $array;
	}
		
}
?>
