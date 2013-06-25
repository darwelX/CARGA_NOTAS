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
   }
?>