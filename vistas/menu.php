<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title></title>
  <link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />
</head>
<body>
    <div id="nav">
    	<ul>
    		<li><a href="../vistas/crear_plan_evaluacion.php?&cedula=<?php echo $docente->getCedula();?>">Cargar Plan De Evaluacion</a></li>
    		<li><a href="../vistas/imprimir_planilla_notas.php?&cedula=<?php echo $docente->getCedula();?>">Imprimir Planilla de Notas</a></li>
    		<li><a href="../vistas/cargar_notas.php?&cedula=<?php echo $docente->getCedula();?>">Cargar Notas</a></li>
    		<li><a href="../vistas/inscribir_taller.php">Inscribir Taller</a></li>
    		<li><a href="../vistas/actualizar_taller.php">Actualizar Taller</a></li>
    		<li><a href="../vistas/login.php">Salir</a></li>
    	</ul>
    </div>
</body>
</html>