<?php
$fileName="cvs/prueba.csv";

//Output a line of the file until the end is reached
$i=1;
$numeroCulumnas;
$errores = array();
$numeroErrores = array();
function contarLineas($archivo){
	//$file = fopen($archivo, "r") or exit("Unable to open file!");
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

$totalLineas = contarLineas($fileName);
echo $totalLineas;
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
		$numeroCulumnas = sizeof($vectorEncabezado)."<br>";
	}else{
		$vectorLinea = explode( ";", $linea );
		
		if( !(sizeof($vectorLinea) == $numeroCulumnas) ){
			$errores['liea'] = $i;
			$errores['error'] = "no tiene el mismo numero de columnas";
			$numeroErrores[$j]=$errores;
			$j++;
		}
	}
	
	$i++;
}
print_r($numeroErrores);
fclose($file);
?>