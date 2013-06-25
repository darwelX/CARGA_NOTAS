<?php

class Connect {
	private $server;
	private $ususario;
	private $password;
	private $database;
	private $conexion;
	private $stmt;
	private $array;
	
	public function __construct($server="PERSONAL\SQLEXPRESS",$usuario="sa",$password="root",$database="ControlAcademico"){
		$this->server = $server;
		$this->ususario = $usuario;
		$this->password = $password;
		$this->database = $database;
	}
	
	public function conectar(){
	
		$this->conexion = odbc_connect("Driver={SQL Server};Server=$this->server;Database=$this->database",$this->ususario,$this->password); 

		if(! is_resource($this->conexion) ){
			throw new Exception('Unable to connect to the database..');
		}
	}

    public function desconectar(){
   	   odbc_close($this->conexion);
    }
   
	public function ejecutar($sql){
		$this->stmt=odbc_exec($this->conexion,$sql);
		return $this->stmt;
	}
	
	public function numeroFilas($stmt){
		
		return odbc_num_rows($stmt);
	}
	/*Método para obtener una fila de resultados de la sentencia sql*/
	public function obtener_filas($stmt){
		
		$this->array=odbc_fetch_array($stmt);
		
		return $this->array;
	}	
}
?>
