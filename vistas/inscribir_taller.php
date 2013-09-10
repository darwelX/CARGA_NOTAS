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
  <fieldset style="width: 50%">
  <legend>Crear Taller</legend>
  <table>

    <tr>
    	<th colspan="8" style="font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: red;">
  		        	<?php 
		        		if(isset($mensaje)){
							echo $mensaje;
                        }
					?>  	
    	</th>
    </tr>
    
    <tr>
        <td><label>C&oacute;digo:</label></td>
        <td><input type="text" name="codigo" id="codigo" data-validate="validate(required,number,minlength(3),maxlength(5))" value="<?php echo $_POST['codigo'];?>"/></td>
    </tr>
    
    <tr>
        <td><label>Descripci&oacute;n:</label></td>
        <td><input type="text" name="descripcion" id="descripcion" data-validate="validate(required)" value="<?php echo $_POST['descripcion'];?>"/></td>
    </tr>
        
    <tr>
      <td colspan="2" align="center">
        <input type="hidden" name="procesar" value="Guardar"/>
    	<button type="submit" name="procesarButton" value="Guardar" id="yourSubmitId" onclick="$('#form1').ketchup();">
    		<img alt="" src="../img/add.png" width="16" height="16"/>
    		Guardar
    	</button><!-- onclick="javascript: form.action='../controllers/controller.cargaNota.php';" -->
      </td>
    </tr>
    
  </table>
  </fieldset>
   
</form>
</body>
</html>