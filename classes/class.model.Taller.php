<?php
require_once '../classes/interface.Operaciones.php';
require_once '../classes/class.model.Connect.php';

class Taller implements Operaciones{

	private $id;
	private $codigo;
	private $descripcion;
	private $conexion;
	private $sqlAll = "SELECT * FROM TALLERES";
	private static $table = "TALLERES";

	public function __construct(){
		$this->conexion = new Connect();
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
		
	}
	
	public function findBy($condicion){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE $condicion ");
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$this->id = $rsd['IDTALLER'];
			$this->descripcion = $rsd['TALLER'];
			$this->codigo = $rsd['CODIGO'];
			return true;
		}
		return false;
		
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
		
	}	
		
}
?>
