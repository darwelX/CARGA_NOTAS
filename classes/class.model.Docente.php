<?php
require_once '../classes/class.model.Connect.php';
require_once '../classes/class.model.Seccion.php';
require_once '../classes/class.model.Materia.php';
require_once '../classes/class.model.Lapso.php';
require_once '../classes/interface.Operaciones.php';

class Docente implements Operaciones{
	private $id;
	private $nombre;
	private $cedula;
	private $profesion;
	private $conexion;
	private $stmt;
	public $secciones;
	public $materias;
	private static $table = "DOCENTES";
	private $sqlAll = "SELECT * FROM DOCENTES";
	
	public function __construct($id=0,$nombre="",$cedula=0,$profesion=""){
		$this->id = $id;
		$this->nombre = $nombre;
		$this->cedula = $cedula;
		$this->profesion = $profesion;
		$this->conexion = new Connect();
		
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		if(is_int($id) && $id > 0){
			$this->id = $id;
		}else{
			throw new Exception("Id de docente invalido");
		}
	}
	
	public function setNombre($nombre){
		
		if(strlen($nombre) > 0 && is_string($nombre)){
			$this->nombre = $nombre;
		}else{
			throw new Exception("Nombre de Docente incorrecto");
		}
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function getCedula(){
		return $this->cedula;
	}
	
	public function setCedula($cedula){
		if(is_int($cedula) && $cedula > 0){
			$this->cedula = $cedula;
		}else{
			throw new Exception("Cedula de docente invalido");
		}		
	}

	public function setProfesion($profesion){
		if(strlen($profesion) > 0 && is_string($profesion)){
			$this->profesion = $profesion;
		}else{
			throw new Exception("Profesion de Docente incorrecto");
		}		
	}
	
	public function getProfesion(){
		return $this->profesion;
	}
	/*
	 * Esta funcion retorna un objeto
	* docente encontrado por el id
	* en la base de datos
	*/
	public function find($id){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE IDDOCENTE = ".$id);
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$this->id = $rsd['IDDOCENTE'];
			$this->nombre = $rsd['APELLIDOSYNOMBRES'];
			$this->cedula = $rsd['CEDULA'];
			$this->profesion = $rsd['PROFESION'];
			$this->conexion->desconectar();
			return true;
		}
		$this->conexion->desconectar();
		return false;
	}

	/*
	 * Esta funcion retorna un objeto
	* docente encontrado por el id
	* en la base de datos
	*/
	public function findBy($condicion){
		$this->conexion->conectar();
		$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE $condicion ");
		while ($rsd=$this->conexion->obtener_filas($this->stmt)){
			$this->id = $rsd['IDDOCENTE'];
			$this->nombre = $rsd['APELLIDOSYNOMBRES'];
			$this->cedula = $rsd['CEDULA'];
			$this->profesion = $rsd['PROFESION'];
			return true;
		}
		return false;
	}
		
	/*
	 * Esta funcion retorna un coleccion
	 * con todos los profesores existentes
	 * en la base de datos
	 */
	public function consultarTodos(){
		$this->stmt = $this->conexion->ejecutar($this->sqlAll);
		$indice = 0;
		$array;
		while ($rs=$this->conexion->obtener_filas($this->stmt)){
			$objDocente = new Docente($rs['IDDOCENTE'], $rs['APELLIDOSYNOMBRES'], $rs['CEDULA'], $rs['PROFESION']);
			//$objDocente = new self()
			$array[$indice] = $objDocente;
			$indice++;
		}
		return $array;		
	}
	
	/*
	 * Esta funcion retorna un objeto
	 * Docente en la posicion especificada
	 * por parametro
	 */
	public function seek($fila){
		$this->stmt = $this->conexion->ejecutar($this->sqlAll);
		$i = 0;
		while ($rs=$this->conexion->obtener_filas($this->stmt)){
			$i++;
			if($fila == $i){
				$objDocente = new Docente($rs['IDDOCENTE'], $rs['APELLIDOSYNOMBRES'], $rs['CEDULA'],$rs['PROFESION']);
				return $objDocente;
			}
		}
	}	
	
	public function insert(){
		$sql = "INSERT INTO ".Docente::$table." (CEDULA,APELLIDOSYNOMBRES,PROFESION) ";
		$sql.= " VALUES( ";
		$sql .= "".$this->cedula.", ";
		$sql .= "'".$this->nombre."', ";
		$sql .= "'".$this->profesion."'";
		$sql .= ")";	
		//echo $sql."<br>";	
	}
	
	public function update(){
		
	}
	
	public function findAllSecciones(){
		$sql = "SELECT * FROM SECCIONES WHERE IDSECCION";
		$sql.= " IN (SELECT SECCION FROM HORARIOS WHERE DOCENTE = $this->id)";
		//print $sql;
		$this->stmt = $this->conexion->ejecutar($sql);
        $indice = 0;
        $this->secciones = array();
		while ($rs=$this->conexion->obtener_filas($this->stmt)){
        		$objSeccion = new Seccion();
        		$objSeccion->setId(intval($rs['IDSECCION']));
        		$objSeccion->setDescripcion($rs['SECCION']);
        		$objSeccion->setTrimestre(intval($rs['TRIMESTRE']));
        		$objSeccion->setCapacidad(intval($rs['CAPACIDAD']));
        		$objSeccion->lapso->find($rs['LAPSO']);
        		$objSeccion->carrera->find($rs['CARRERA']);
				$this->secciones[$indice]= $objSeccion;
				$indice++;
			
		}
	}
	
	public function findAllSeccionesByLapso($lapso){
		$sql = "SELECT * FROM SECCIONES WHERE IDSECCION";
		$sql.= " IN (SELECT SECCION FROM HORARIOS WHERE DOCENTE = $this->id AND LAPSO = $lapso)";
		//print $sql;
		$this->stmt = $this->conexion->ejecutar($sql);
		$indice = 0;
		$this->secciones = array();
		while ($rs=$this->conexion->obtener_filas($this->stmt)){
			$objSeccion = new Seccion();
			$objSeccion->setId(intval($rs['IDSECCION']));
			$objSeccion->setDescripcion($rs['SECCION']);
			$objSeccion->setTrimestre(intval($rs['TRIMESTRE']));
			$objSeccion->setCapacidad(intval($rs['CAPACIDAD']));
			$objSeccion->lapso->find($rs['LAPSO']);
			$objSeccion->carrera->find($rs['CARRERA']);
			$this->secciones[$indice]= $objSeccion;
			$indice++;
				
		}
	}
		
	public function findAllMaterias(){
		$sql = "SELECT IDASIGNATURA, CODIGO, TRIMESTRE, NOMBRE FROM PENSUN WHERE IDASIGNATURA "; 
		$sql.= "IN (SELECT ASIGNATURA FROM HORARIOS GROUP BY ASIGNATURA, DOCENTE HAVING DOCENTE = $this->id)";
		$this->stmt = $this->conexion->ejecutar($sql);
		$indice = 0;
		$this->materias = array();
		while ($rs=$this->conexion->obtener_filas($this->stmt)){
			$objMateria = new Materia();
			$objMateria->setId($rs['IDASIGNATURA']);
			$objMateria->setCodigo($rs['CODIGO']);
			$objMateria->setTrimestre(intval($rs['TRIMESTRE']));
			$objMateria->setNombre($rs['NOMBRE']);
			$this->materias[$indice]= $objMateria;
			$indice++;
				
		}
	}
	
	public function findAllMateriasBySeccion($seccion){
		$sql = "SELECT IDASIGNATURA, CODIGO, TRIMESTRE, NOMBRE FROM PENSUN WHERE IDASIGNATURA ";
		$sql.= "IN (SELECT ASIGNATURA FROM HORARIOS GROUP BY ASIGNATURA, DOCENTE, SECCION HAVING DOCENTE = $this->id AND SECCION=$seccion)";
		//echo "<h1>".$sql."</h1>";
		$this->stmt = $this->conexion->ejecutar($sql);
		$indice = 0;
		$this->materias = array();
		while ($rs=$this->conexion->obtener_filas($this->stmt)){
			$objMateria = new Materia();
			$objMateria->setId($rs['IDASIGNATURA']);
			$objMateria->setCodigo($rs['CODIGO']);
			$objMateria->setTrimestre(intval($rs['TRIMESTRE']));
			$objMateria->setNombre($rs['NOMBRE']);
			$this->materias[$indice]= $objMateria;
			$indice++;
	
		}
	}	
}
?>