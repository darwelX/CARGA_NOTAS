<?php
require_once '../classes/interface.Operaciones.php';
require_once '../classes/class.model.Connect.php';

class Trimestre implements Operaciones{

	private $numero;
	private $conexion;
	private $sqlAll = "SELECT TRIMESTRE FROM ESTUDIANTES_HORARIOS WHERE TRIMESTRE IS NOT NULL GROUP BY TRIMESTRE ORDER BY TRIMESTRE";
	private static $table = "ESTUDIANTES_HORARIOS";

	public function __construct(){
		$this->conexion = new Connect();
	}

	public function getNumero(){
		return $this->numero;
	}

	public function setNumero($numero){
		$this->numero = $numero;
	}

	public function find($id){

	}

	public function findAll(){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll);
		//echo $this->sqlAll;
		$indice = 0;
		$array=array();
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$trimestre=new Trimestre();
			$trimestre->numero = $rsd['TRIMESTRE'];
			$array[$indice]=$trimestre;
			$indice++;
			//return true;
		}
		return $array;

	}

	public function insert(){

	}

	public function update(){
	}

	public function findBy($condicion){
	}
}