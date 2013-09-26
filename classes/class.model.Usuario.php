<?php
require_once '../classes/interface.Operaciones.php';
require_once '../classes/class.model.Connect.php';

  class Usuario implements Operaciones{
  	
  	 private $id;
  	 private $cedula;
  	 private $nivel;
  	 private $login;
  	 private $password;
  	 private $sqlAll = "SELECT * FROM USUARIOS";
  	 private static $table = "USUARIOS";
  	 
  	 public function __construct(){
  	 	$this->conexion = new Connect();
  	 }
  	 
  	 public function getId(){
  	       return $this->id;	
  	 }
  	 
  	 public function setId($id){
  	 		$this->id = $id;
  	 }
  	 
  	 public function setPassword($password){
  	        $this->password=$password;
  	 }
  	 
  	 public function getPassword(){
  	 	return $this->password;
  	 }
  	 
  	 public function getLogin(){
  	 	return $this->login;
  	 }
  	 
  	 public function setLogin($login){
  	 	$this->login = $login;
  	 }
  	 
  	 public function setNivel($nivel){
  	 	$this->nivel = 	$nivel;
  	 }
  	 
  	 public function getNivel(){
  	 	return $this->nivel;
  	 }
  	 
  	 public function getCedula(){
  	 	return $this->cedula;
  	 }
  	 
  	 public function setCedula($cedula){
  	 	$this->cedula=$cedula;
  	 }

  	 public function find($id){
  	 	$this->conexion->conectar();
  	 	//echo "<h1>".$this->sqlAll." WHERE $condicion </h1>aquiiiiiii 2 <br>";
  	 	$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE IDTALLER = $id ");
  	 
  	 	while ($rsd=$this->conexion->obtener_filas($this->stmt)){
  	 		$this->id = $rsd['IDUSUARIO'];
  	 		$this->cedula = $rsd['CEDULA'];
  	 		$this->login = $rsd['LOGIN'];
  	 		$this->nivel = $rsd['NIVEL'];
  	 		$this->password = $rsd['PASS'];
  	 
  	 
  	 		return true;
  	 	}
  	 	return false;
  	 }
  	 
  	 public function findBy($condicion){
  	 	$this->conexion->conectar();
  	 	//echo "<h1>".$this->sqlAll." WHERE $condicion </h1>aquiiiiiii 2 <br>";
  	 	$this->stmt = $this->conexion->ejecutar($this->sqlAll." WHERE $condicion ");
  	    //echo $this->sqlAll." WHERE $condicion ";
  	 	while ($rsd=$this->conexion->obtener_filas($this->stmt)){
  	 		$this->id = $rsd['IDUSUARIO'];
  	 		$this->cedula = $rsd['CEDULA'];
  	 		$this->login = $rsd['LOGIN'];
  	 		$this->nivel = $rsd['NIVEL'];
  	 		$this->password = $rsd['PASS'];
  	 			
  	 
  	 		return true;
  	 	}
  	 	return false;
  	 
  	 }
  	 
  	 public function insert(){
  	 	$this->conexion->conectar();
  	 	$sw = $this->findBy("CODIGO=$this->codigo");
  	 
  	 	if(!$sw){
  	 		$sql = "INSERT INTO ".Taller::$table." (CEDULA,LOGIN,PASS,NIVEL) ";
  	 		$sql.= " VALUES( ";
  	 		$sql .= "'".$this->cedula."', ";
  	 		$sql .= "'".$this->login."'";
  	 		$sql .= "'".md5($this->password)."'";
  	 		$sql .= "'".$this->nivel."'";
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
  	 
  	 	$sql = "UPDATE ".Usuario::$table;
  	 	$sql.= " SET ";
  	 	$sql .= "LOGIN = '".$this->login."', ";
  	 	$sql .= "NIVEL = '".$this->login."', ";
  	 	$sql .= "PASS = '".md5($this->password)."'";
  	 	$sql .= " WHERE IDUSUARIO = '".$this->id."'";
  	 	//echo $sql;
  	 	$this->stmt = $this->conexion->ejecutar($sql);
  	 	return $this->conexion->numeroFilas($this->stmt);
  	 
  	 }

  	 public function setDefaultPassword($password,$nivel=5){
  	 	$this->conexion->conectar();
  	 
  	 	$sql = "UPDATE ".Usuario::$table;
  	 	$sql.= " SET ";
  	 	$sql .= "PASS = '".md5($password)."' ";
  	 	$sql .= " WHERE NIVEL = $nivel";
  	 	

  	 	$this->stmt = $this->conexion->ejecutar($sql);
  	 	return $this->conexion->numeroFilas($this->stmt);
  	 
  	 }
  	 
  	 public function findAll(){
  	 	$this->conexion->conectar();
  	 	$this->stmt = $this->conexion->ejecutar($this->sqlAll);
  	    $array=array();
  	 	$seccion_taller = new SeccionTaller();
  	 	while ($rsd=$this->conexion->obtener_filas($this->stmt)){
  	 		$usuario=new Usuario();
  	 		$usuario->id = $rsd['IDUSUARIO'];
  	 		$usuario->cedula = $rsd['CEDULA'];
  	 		$usuario->login = $rsd['LOGIN'];
  	 		$usuario->nivel = $rsd['NIVEL'];
  	 		$usuario->password = $rsd['PASS'];
  	 		
  	 		array_push($array,$usuario);

  	 		
  	 	}
  	 	return $array;
  	 }
  }
?>