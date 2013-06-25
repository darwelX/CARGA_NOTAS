<?php
/*$cadena = "Tecnologia de la Información";
echo strlen($cadena)-1;
for($i=0; $i < strlen($cadena)-1; $i++){
	echo $cadena{$i}."<br";
	//print "hola<br>";
}*/
$vocales = array("á", "é", "í", "ó", "ú", " ");
$solo_consonantes = str_replace($vocales, "", "Tecnologia de la Información");
echo $solo_consonantes;
?>