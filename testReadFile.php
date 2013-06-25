<?php
$fileName="cvs/prueba.csv";

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


function validarCSV($fileName,$totalLineas){
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

$totalLineas = contarLineas($fileName);
echo $totalLineas."<br>";
$err=validarCSV($fileName,$totalLineas);
//print_r($err);
for($i=0; $i < sizeof($err); $i++){
	print($err[$i]['linea']." error ".$err[$i]['error']);
	print "<br>";
}
?>