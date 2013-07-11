<?php
  class Convert{
  	
  	public function conversionNota($nota){
  		$not=intval($nota);
  		switch (true) {
  			case ($nota <= 5):
  				       return 1;
  				       break;
  		    case ($nota > 5 && $not <= 10):
  				       return 2;
  				       break;
  		    case ($nota > 10 && $not <= 15):
  			           return 3;
  				       break;
  		    case ($nota > 15 && $not <= 20):
  				       return 4;
  				       break;
  		    case ($nota > 20 && $not <= 25):
  				       return 5;
  				       break;
  		    case ($nota > 25 && $not <= 30):
  				       return 6;
  				       break;
  		    case ($nota > 30 && $not <= 35):
  				       return 7;
  				       break; 
  		    case ($nota > 35 && $not <= 40):
  				       return 8;
  				       break; 
  		    case ($nota > 40 && $not <= 45):
  				       return 9;
  				       break;
  		    case ($nota > 45 && $not <= 50):
  				       return 10;
  				       break;  	
  		    case ($nota > 50 && $not <= 55):
  			           return 11;
  				       break;
  		    case ($nota > 55 && $not <= 60):
  				       return 12;
  				       break;
  		    case ($nota > 60 && $not <= 65):
  				       return 13;
  				       break;
  		    case ($nota > 65 && $not <= 70):
  				       return 14;
  				       break;
  		    case ($nota > 70 && $not <= 75):
  				       return 15;
  				       break;
  			case ($nota > 75 && $not <= 80):
  				       return 16;
  				       break;
  		    case ($nota > 80 && $not <= 85):
  				       return 17;
  				       break;
  		    case ($nota > 85 && $not <= 90):
  				       return 18;
  				       break;
  			case ($nota > 90 && $not <= 95):
  				       return 19;
  				       break;
  			case ($nota > 95 && $not <= 100):
  				       return 20;
  				       break;
  		}
  	}
  	
  	public function convertDate($fecha){
  		return substr($fecha,6)."/".substr($fecha,3,2)."/".substr($fecha,0,2);     // bcdef
  	} 	
  	
  	public function eliminarPuntos($cadena){
  		return str_replace(".", "", $cadena);
  	}
  	
  	public function cambiarPuntoDecimal($cadena){
  		return str_replace(",", ".", $cadena);
  	}
  }
?>