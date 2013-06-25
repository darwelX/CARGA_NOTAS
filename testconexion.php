<?php
require_once 'classes/class.model.Connect.php';
require_once 'classes/class.model.Docente.php';
require_once 'classes/class.model.Seccion.php';

$docente = new Docente();
if($docente->find(123)){
	print $docente->getNombre()."<br>";
}

/*if($docente->findBy("CEDULA = 15686543")){
	print $docente->getNombre()."<br>";
}*/
$docente->findAllSecciones();

/*foreach ($docente->secciones as $sec){
	//print $sec->getDescripcion()." ".$sec->getTrimestre()." ".$sec->getCapacidad()." ".$sec->lapso->getDescripcion()." ".$sec->carrera->getDescripcion()."<br>";
	//print $sec->getDescripcion()." ".$sec->lapso->getDescripcion()." ".$sec->carrera->getDescripcion()."<br>";
	$sec->findAllEstudiantes();
	foreach ($sec->estudiantes as $est){
		//print $est->getCedula()."<br>";
	}
	
}*/
$lapso = new Lapso();
$lapsos =$lapso->findAll();
print_r($lapsos);
/*foreach ($lapsos as $lap){
	echo "<option value=".$lap->getId().">".$lap->getDescripcion()."</option>";
}*/
/*$objDoc = new Docente();
$objDoc->setCedula(intval("123456789"));
$objDoc->setNombre("TIBURCIO ANGULO");
$objDoc->setProfesion("INGNIERO");
$objDoc->insert();*/
/*$doc = $docente->seek(1);
print $doc->getCedula()."<br>";
foreach ($docente->consultarTodos() as $doc){
	print $doc->getNombre()."<br>";
}*/
//echo $server." ".$user." ".$password." ".$database;
//$connect = new Connect($server,$user,$password,$database);
//$connect->conectar();

//$sql='SELECT * FROM DOCENTES';

/*Ejecutamos la query*/
//$stmt1=$connect->ejecutar($sql);
//$stmt2=$connect->ejecutar($sql);
/*Realizamos un bucle para ir obteniendo los resultados*/

/*function seek($stmt,$fila,$connect){
	$i = 0;
	while ($x=$connect->obtener_fila($stmt)){
		$i++;
		if($fila == $i){
			$objDocente = new Docente($x['IDDOCENTE'], $x['APELLIDOSYNOMBRES'], $x['CEDULA']);
			return $objDocente;
		}
	}
}

function all($stmt,$connect){
	
	$indice = 0;
	$array;
	while ($x=$connect->obtener_fila($stmt)){
		$objDocente = new Docente($x['IDDOCENTE'], $x['APELLIDOSYNOMBRES'], $x['CEDULA']);
		$array[$indice] = $objDocente;
		$indice++;
	}
	return $array;
}

$docentes = all($stmt2,$connect);
$doc = seek($stmt1, 2, $connect);
print($doc->getCedula());
foreach ($docentes as $doc){
	print $doc->getNombre()."<br>";
}*/
?>