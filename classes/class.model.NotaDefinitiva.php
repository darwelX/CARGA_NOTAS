<?php
require_once '../classes/interface.Operaciones.php';

class NotaDefinitiva implements Operaciones{
	private $idAlumno;
	private $idAsignatura;
	private $idcarrera;
	private $idLapso;
	private $trimestre;
	private $idSeccion;
	private $nota;
	private $mostrar;
	private $creditos;
	private $conexion;
	private $stmt;
	private $sqlAll = "SELECT * FROM NOTAS ";
	private static $table = "NOTAS";
	
	public function __construct(){
		$this->conexion = new Connect();
	}
	
	public function getCreditos(){
		return $this->creditos;
	}
	
	public function setCreditos($creditos){
		$this->creditos=$creditos;
	}
	
	public function setMostrar($mostrar){
		$this->mostrar=$mostrar;	
	}
	
	public function getMostrar(){
		return $this->mostrar;	
	}
	
	public function setNota($nota){
		$this->nota=$nota;	
	}
	
	public function getNota(){
		return $this->nota;	
	}
	
	public function setTrimestre($trimestre){
		$this->trimestre=$trimestre;	
	}
	
	public function getTrimestre(){
		return $this->trimestre;	
	}
	
	public function setIdSeccion($id){
		$this->idSeccion=$id;	
	}
	
	public function getIdSeccion(){
		return $this->idSeccion;
	}
	
	public function getIdLapso(){
		return $this->idLapso;
	}
	public function setIdLapso($id){
		$this->idLapso = $id;
	}
	public function getIdCarrera(){
		return $this->idcarrera;	
	}
	
	public function setIdCarrera($id){
		$this->idcarrera = $id;	
	}
	
	public function setIdAsignatura($id){
		$this->idAsignatura =$id;
	}
	
	public function getIdAsignatura(){
		return $this->idAsignatura;	
	}
	
	public function setIdAlumno($idalumno){
		$this->idAlumno=$idalumno;	
	}
	
	public function getIdAlumno(){
		return $this->idAlumno;
	}
	
	public function find($id){
		
	}
	
	public function findBy($condicion){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE $condicion ");
		//while ($rsd=$this->conexion->obtener_filas($this->stmt)){
		$rsd=$this->conexion->obtener_filas($this->stmt);
		if(isset($rsd['ALUMNO'])){
			$this->idAlumno = $rsd['ALUMNO'];
			$this->idAsignatura = $rsd['ASIGNATURA'];
			$this->idcarrera = $rsd['CARRERA'];
			$this->idLapso = $rsd['LAPSO'];
			$this->idSeccion = $rsd['SECCION'];
			$this->nota = $rsd['NOTA'];
			$this->mostrar = $rsd['MOSTRAR'];
			$this->trimestre = $rsd['TRIMESTRE'];			
			return true;
		}
		return false;		
	}
	
	public function insert(){
		$this->conexion->conectar();
		$sw = $this->findBy("ALUMNO=$this->idAlumno AND ASIGNATURA=$this->idAsignatura AND LAPSO =$this->idLapso AND SECCION=$this->idSeccion AND CARRERA=$this->idcarrera");
		
		if(!$sw){
			$sql = "INSERT INTO ".NotaDefinitiva::$table." (ALUMNO,ASIGNATURA,CARRERA,LAPSO,SECCION,NOTA,MOSTRAR,CREDITOS,TRIMESTRE) ";
			$sql.= " VALUES( ";
			$sql .= "'".$this->idAlumno."', ";
			$sql .= "'".$this->idAsignatura."', ";
			$sql .= "'".$this->idcarrera."', ";
			$sql .= "'".$this->idLapso."', ";
			$sql .= "'".$this->idSeccion."', ";
			$sql .= "'".$this->nota."', ";
			$sql .= "'".$this->mostrar."', ";
			$sql .= "'".$this->creditos."', ";
			$sql .= "'".$this->trimestre."'";
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