<?php
require_once '../classes/interface.Operaciones.php';
/**
 * @author darwelX
 *
 */
class Examen implements Operaciones{
	private $idcontrol;
	private $descripcion;
	private $porcentaje;
	private $numero;
	private $fecha;
	private $conexion;
	private $stmt;
	private $sqlAll = "SELECT * FROM PORCENTAJENOTA ";
	private static $table = "PORCENTAJENOTA";

	public function __construct(){
		$this->conexion = new Connect();
	}
	
	public function getIdControl(){
		return $this->idcontrol;
	}
	
	public function setIdControl($idcontrol){
		$this->idcontrol=$idcontrol;
	}
	
	public function getDescripcion(){
		return $this->descripcion;
	}
	
	public function setDescripcion($descripcion){
		$this->descripcion=$descripcion;
	}
	
	public function getPorcentaje(){
		return $this->porcentaje;
	}
	
	public function setPorcentaje($porcentaje){
		$this->porcentaje=$porcentaje;
	}
	
	public function getNumero(){
		return $this->numero;
	}
	
	public function setNumero($numero){
		$this->numero=$numero;
	}
	
	public function getFecha(){
		return $this->fecha;
	}
	
	public function setFecha($fecha){
		$this->fecha=$fecha;
	}
	
	public function find($id){
		/*$this->conexion->conectar();
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
		return false;*/
	}
	
	public function findBy($condicion){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE $condicion ");
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$this->idcontrol = $rsd['CONTROL'];
			$this->descripcion = $rsd['EVALUACION'];
			$this->porcentaje = $rsd['PORCENTAJE'];
			$this->numero = $rsd['NROEVALUACION'];
			$this->fecha = $rsd['FECHA'];
			return true;
		}
		return false;
	}

	public function findAll($control){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE CONTROL  = $control ORDER BY NROEVALUACION");
		//print $this->sqlAll." WHERE CONTROL  = $control ORDER BY NROEVALUACION";
		$examenes = array();
		$indice = 0;
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$objExamen = new Examen();
			$objExamen->setIdcontrol($rsd['CONTROL']);
			$objExamen->setDescripcion($rsd['EVALUACION']);
			$objExamen->setPorcentaje($rsd['PORCENTAJE']);
			$objExamen->setNumero($rsd['NROEVALUACION']);
			$objExamen->setFecha($rsd['FECHA']);
			$examenes[$indice] = $objExamen;
			$indice++;
		}
		return $examenes;
	}
		
	public function insert(){
		$this->conexion->conectar();
		$sw = $this->findBy("CONTROL=$this->idcontrol AND NROEVALUACION= $this->numero");
	
		if(!$sw){
			$sql = "INSERT INTO ".Examen::$table." (CONTROL,EVALUACION,PORCENTAJE,NROEVALUACION,FECHA) ";
			$sql.= " VALUES( ";
			$sql .= "'".$this->idcontrol."', ";
			$sql .= "'".$this->descripcion."', ";
			$sql .= "'".$this->porcentaje."', ";
			$sql .= "'".$this->numero."', ";
			$sql .= "'".$this->fecha."'";
			$sql .= ")";
			#echo $sql;
			$this->stmt = $this->conexion->ejecutar($sql);
			return $this->conexion->numeroFilas($this->stmt);
		}else{
			return false;
		}
	}
	
	public function update(){
			
	}
}
?>