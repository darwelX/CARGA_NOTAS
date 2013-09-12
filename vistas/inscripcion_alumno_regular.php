<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Carga Evaluaciones</title>
  <link rel="stylesheet" type="text/css" href="../css/main.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../css/jquery.ketchup.css" media="screen" />
  <script type="text/javascript" src="../js/jquery.js"></script>
  <script type="text/javascript" src="../js/jquery.ketchup.all.min.js"></script>
  <script type="text/javascript">
  function validateForm(formObj) {
	  if($('#form1').ketchup('isValid')){
      	$("#yourSubmitId").html("Porfavor Espere..")
      	formObj.procesarButton.disabled = true;  
      	return true; 
	  } 

  }
  </script>
  
</head>
<body>
    
<!-- ../controllers/controller.cargaNota.php -->
<form action="../controllers/controller.Taller.php" method="post" id="form1"  onsubmit="return validateForm(this);">
  <fieldset style="width: 99%%">
  <legend>INSCRIPCI&Oacute;N</legend>
  <table border="1" style="width: 98%;">

    <tr>
    	<th colspan="2" style="font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: red;">
  		        	<?php 
		        		if(isset($mensaje)){
							echo $mensaje;
                        }
					?>  	
    	</th>
    </tr>
    
    <tr>
      <td colspan="2" style="text-align: center;">
          INSCRIPCI&Oacute;N ALUMNO REGULAR EN NUEVO SEMESTRE
      </td>
    </tr>
    
    <tr>
        <td>CEDULA:<b><?php echo $convert->formatoCedula($estudiante->getCedula());?></b></td>
        <td>CARRERA:<b><?php echo $estudiante->carrera->getDescripcion();?></b></td>
    </tr>
    
    <tr>
    	<td colspan="2">APELLIDOS Y NOMBRES:<b><?php echo $estudiante->getApellidos(). " ".$estudiante->getNombres();?></b></td>
    </tr>
    
    <tr>
       <td colspan="2" style="text-align: center;">CARGA ACADEMICA</td>
    </tr>
    
    <tr>
        <td style="text-align: center;">
        	DISPONIBLE
        	<center>
        	<table border="1" style="width: 100%;">
        		<tr>
        			<td style="text-align: center;">TRIMESTRE</td>
        			<td style="text-align: center;">ASIGNATURAS</td>
        			<td style="text-align: center;">SECCION</td>
        		</tr>

        	</table>
        	</center>
        </td>
        
        <td style="text-align: center;">
           SELECCIONADO
        </td>
    </tr> 
    
    <tr>
        <td style="text-align: center;">
        				TALLERES PERMANENTES
        </td>
        			
        <td style="text-align: center;">
        			    SELECCIONADO
        </td>
    </tr>  
  </table>
  </fieldset>
   
</form>
</body>
</html>