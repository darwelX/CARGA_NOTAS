
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/bootstrap-responsive.css" media="screen" />
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/twitter-bootstrap-hover-dropdown.min.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.ketchup.all.min.js"></script>
  <script type="text/javascript" src="../js/jquery.ui.core.js"></script>
  <script type="text/javascript" src="../js/jquery.ui.widget.js"></script>
  <script type="text/javascript" src="../js/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" media="screen" />
<meta charset="ISO-8859-1">
<title></title>
  <link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />
</head>
<body>
    <?php if($_SESSION['NIVEL']==5 || $_SESSION['NIVEL']==1){?>
	<div class="btn-group">
	    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Notas <span class="caret"></span></button>
		<ul class="dropdown-menu">
			<!-- dropdown menu links -->
    		<li><a href="../vistas/crear_plan_evaluacion.php?&cedula=<?=$_SESSION['CEDULA']?>">Cargar Plan De Evaluacion</a></li>
    		<li><a href="../vistas/imprimir_planilla_notas.php?&cedula=<?=$_SESSION['CEDULA']?>">Imprimir Planilla de Notas</a></li>
    		<li><a href="../vistas/cargar_notas.php?&cedula=<?=$_SESSION['CEDULA']?>">Cargar Notas</a></li>
		</ul>
	</div>
	<?php }?>
	
	<?php if($_SESSION['NIVEL']==1){?>
	<div class="btn-group">
	    <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Talleres <span class="caret"></span></button>
		<ul class="dropdown-menu">
			<!-- dropdown menu links -->
    		<li><a href="../vistas/inscribir_taller.php">Inscribir Taller</a></li>
    		<li><a href="../vistas/actualizar_taller.php">Actualizar Taller</a></li>
		</ul>
	</div>
<?php }?>

<?php if($_SESSION['NIVEL']==1){?>
	<div class="btn-group">
	    <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Inscripciones <span class="caret"></span></button>
		<ul class="dropdown-menu">
			<!-- dropdown menu links -->
    		<li><a href="../vistas/inscripcion_datos_alumnos.php">Alumno Regular</a></li>
    		<li><a href="#">Nuevo Ingreso</a></li>
		</ul>
	</div>
<?php }?>	


<?php if($_SESSION['NIVEL']==1){?>
	<div class="btn-group">
	    <button class="btn btn-success dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Usuarios <span class="caret"></span></button>
		<ul class="dropdown-menu">
			<!-- dropdown menu links -->
    		<li><a href="../vistas/setear_password_profesores.php">Setear el password de los profesores</a></li>
		</ul>
	</div>
<?php }?>
	
    <div class="btn-group">
		<a class="btn btn-inverse dropdown-toggle" data-toggle="dropdown" href="../controllers/controller.salir.php"> Salir
			
		</a>
	</div>
</body>
</html>