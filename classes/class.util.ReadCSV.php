<?php
class ReadCSV {
	private $nombreArchivoCSV;

	public function __construct($nombreArchivo=""){
		$this->nombreArchivoCSV = $nombreArchivo;
	}

	public function convertriArreglo(){
		$matriz = array();
		 
		$fp = fopen ( $this->nombreArchivoCSV, "r" );
		$i=0;
		while (( $data = fgetcsv ( $fp , 1000 , ";" )) !== FALSE ) { // Mientras hay líneas que leer...
			$filas = array();
			$j=0;
			foreach($data as $row) {
				$filas[$j] = $row;
				$j++;
			}
			$matriz[$i]=$filas;
			$i++;
		}

		return $matriz;
	}

	private function contarLineas($archivo){
		$lineas=0;
		$file = fopen($archivo, "r") or exit("Unable to open file!");

		while(!feof($file))
		{
			$linea = fgets($file);
			$lineas++;
		}
		fclose($file);
		return $lineas;
	}
	
	function validarColumnasCSV($fileName){
		$totalLineas = $this->contarLineas($fileName);
		$numeroCulumnas;
		$i=1;
		$errores = array();
		$numeroErrores = array();
		$file = fopen($fileName, "r") or exit("Unable to open file!");
		$j=0;
		while(!feof($file))
		{
			if(($totalLineas) == $i){
				break;
			}
	
			$linea = fgets($file);
			if($i == 1){
				$vectorEncabezado = explode( ";", $linea );
				$numeroCulumnas = sizeof($vectorEncabezado);
			}else{
				$vectorLinea = explode( ";", $linea );
	
				if( !(sizeof($vectorLinea) == $numeroCulumnas) ){
					$errores['linea'] = $i;
					$errores['error'] = "no tiene el mismo numero de columnas";
					$numeroErrores[$j]=$errores;
					$j++;
				}
			}
	
			$i++;
		}
		return $numeroErrores;
		fclose($file);
	}	
}
?>