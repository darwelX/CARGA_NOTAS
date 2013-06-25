<?php
require_once 'classes/class.util.ReadCSV.php';

$objCSV = new ReadCSV('cvs/prueba.csv');

print_r($objCSV->convertriArreglo());
/*foreach ($objCSV->convertriArreglo() as $fila){
	print_r($fila);
	echo "</br>";
}*/
/*$matriz = $objCSV->convertriArreglo();
//echo $matriz['0']
for($i=0; $i< sizeof($matriz); $i++){
	print_r($matriz[$i][0]);
	echo "<br>";
}*/
?>