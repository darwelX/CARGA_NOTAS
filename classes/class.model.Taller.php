<?php
require_once '../classes/interface.Operaciones.php';
require_once '../classes/class.model.Connect.php';

class Taller implements Operaciones{

	private $id;
	private $codigo;
	private $descripcion;
	
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
		
	}
	
	public function insert(){
		
	}
	
	public function update(){
		
	}	
		
}
?>
