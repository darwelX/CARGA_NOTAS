<?php
/*$cadena = "Tecnologia de la Informaci�n";
echo strlen($cadena)-1;
for($i=0; $i < strlen($cadena)-1; $i++){
	echo $cadena{$i}."<br";
	//print "hola<br>";
}*/
$vocales = array("�", "�", "�", "�", "�", " ");
$solo_consonantes = str_replace($vocales, "", "Tecnologia de la Informaci�n");
echo $solo_consonantes;
?>