<?php
require_once '../classes/class.model.Carrera.php';
require_once '../classes/class.model.Connect.php';
require_once '../classes/class.model.Estudiante.php';
class Seccion {
	private $id;
	private $descripcion;
	private $trimestre;
	private $capacidad;
	public $lapso;
	public $carrera;
    public $estudiantes;
    private $stmt;
    private $conexion;
    private $sqlAll="SELECT * FROM SECCIONES ";
	public function __construct(){
		$this->carrera = new Carrera();	
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
	
	public function findAllEstudiantes(){
		$sql = "SELECT * FROM PERSONAS WHERE IDPERSONA ";
		$sql.= " IN (SELECT ESTUDIANTE FROM ESTUDIANTES_HORARIOS GROUP BY ESTUDIANTE,SECCION HAVING SECCION = $this->id)";
		//print $sql."<br>";
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($sql);
		$indice = 0;
		while ($rs=$this->conexion->obtener_filas($this->stmt)){
			$objEstudiante = new Estudiante();
			$objEstudiante->setId($rs['IDPERSONA']);
			$objEstudiante->setNacionalidad($rs['NACIONALIDAD']);
			$objEstudiante->setCedula($rs['CEDULA']);
			$objEstudiante->setNombres($rs['NOMBRES']);
			$objEstudiante->setApellidos($rs['APELLIDOS']);
			$objEstudiante->setProceso($rs['PROCESO']);
			$this->estudiantes[$indice]= $objEstudiante;
			$indice++;
				
		}
	}	
	
	public function findEstudiantesByMateria($idmateria){
		$sql = "SELECT * FROM PERSONAS WHERE IDPERSONA ";
		$sql.= " IN (SELECT ESTUDIANTE FROM ESTUDIANTES_HORARIOS GROUP BY ESTUDIANTE,SECCION,ASIGNATURA HAVING SECCION = $this->id AND ASIGNATURA=$idmateria) ORDER BY APELLIDOS";
		//print $sql."<br>";
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($sql);
		$indice = 0;
		while ($rs=$this->conexion->obtener_filas($this->stmt)){
			$objEstudiante = new Estudiante();
			$objEstudiante->setId($rs['IDPERSONA']);
			$objEstudiante->setNacionalidad($rs['NACIONALIDAD']);
			$objEstudiante->setCedula($rs['CEDULA']);
			$objEstudiante->setNombres($rs['NOMBRES']);
			$objEstudiante->setApellidos($rs['APELLIDOS']);
			$objEstudiante->setProceso($rs['PROCESO']);
			$this->estudiantes[$indice]= $objEstudiante;
			$indice++;
	
		}
		//print_r($this->estudiantes);
	}
	
	public function findEstudianteByMateria($idmateria,$idestudiante){
		$sql = "SELECT * FROM PERSONAS WHERE IDPERSONA ";
		$sql.= " IN (SELECT ESTUDIANTE FROM ESTUDIANTES_HORARIOS GROUP BY ESTUDIANTE,SECCION,ASIGNATURA HAVING SECCION = $this->id AND ASIGNATURA=$idmateria AND ESTUDIANTE=$idestudiante) ORDER BY APELLIDOS";
		//print $sql."<br>";
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($sql);
		while ($rs=$this->conexion->obtener_filas($this->stmt)){
			$objEstudiante = new Estudiante();
			$objEstudiante->setId($rs['IDPERSONA']);
			$objEstudiante->setNacionalidad($rs['NACIONALIDAD']);
			$objEstudiante->setCedula($rs['CEDULA']);
			$objEstudiante->setNombres($rs['NOMBRES']);
			$objEstudiante->setApellidos($rs['APELLIDOS']);
			$objEstudiante->setProceso($rs['PROCESO']);
	        return true;
		}
		return false;
		//print_r($this->estudiantes);
	}	
	public function find($id){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE IDSECCION = ".$id);
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$this->id = $rsd['IDSECCION'];
			$this->descripcion = $rsd['SECCION'];
			$this->trimestre = $rsd['TRIMESTRE'];
			$this->capacidad = $rsd['CAPACIDAD'];
			$this->carrera->find($rsd['CARRERA']);
			return true;
		}
		return false;
	}	
}
?>
