<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/bootstrap-responsive.css" media="screen" />
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" media="screen" />
<meta charset="ISO-8859-1">
<title></title>
  <link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />
</head>
<body>
	<div id="principal1" class="btn-group">
	    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" onclick='$("#principal1").addClass( "open" );'>Notas <span class="caret"></span></button>
		<ul class="dropdown-menu">
			<!-- dropdown menu links -->
    		<li><a href="../vistas/crear_plan_evaluacion.php?&cedula=<?php echo $docente->getCedula();?>">Cargar Plan De Evaluacion</a></li>
    		<li><a href="../vistas/imprimir_planilla_notas.php?&cedula=<?php echo $docente->getCedula();?>">Imprimir Planilla de Notas</a></li>
    		<li><a href="../vistas/cargar_notas.php?&cedula=<?php echo $docente->getCedula();?>">Cargar Notas</a></li>
		</ul>
	</div>
	
	<div id="principal2" class="btn-group">
	    <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown" onclick='$("#principal2").addClass( "open" );'>Talleres <span class="caret"></span></button>
		<ul class="dropdown-menu">
			<!-- dropdown menu links -->
    		<li><a href="../vistas/inscribir_taller.php">Inscribir Taller</a></li>
    		<li><a href="../vistas/actualizar_taller.php">Actualizar Taller</a></li>
		</ul>
	</div>
	
	<div id="principal3" class="btn-group">
	    <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown" onclick='$("#principal3").addClass( "open" );'>Inscripciones <span class="caret"></span></button>
		<ul class="dropdown-menu">
			<!-- dropdown menu links -->
    		<li><a href="../vistas/inscripcion_datos_alumnos.php">Alumno Regular</a></li>
    		<li><a href="#">Nuevo Ingreso</a></li>
		</ul>
	</div>
	
	
    <div class="btn-group">
		<a class="btn btn-inverse dropdown-toggle" data-toggle="dropdown" href="../vistas/login.php"> Salir
			
		</a>
	</div>
</body>
</html>