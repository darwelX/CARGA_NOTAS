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

		if(formObj.procesar.value == "Buscar"){
      		$("#yourSubmitId").html("Porfavor Espere..")
      		formObj.procesarButton.disabled = true;  
		}else if(formObj.procesar.value == "Actualizar"){
      		$("#yourSubmitId2").html("Porfavor Espere..")
      		formObj.procesarButton2.disabled = true;
		}
      	return true; 
	  } 

  }
  </script>
  
</head>
<body>
    
<!-- ../controllers/controller.cargaNota.php -->
<form action="../controllers/controller.Taller.php" method="post" id="form1"  onsubmit="return validateForm(this);">
  <input type="hidden" name="id" value="<?php echo (!isset($buscar))?'':$taller->getId();?>"/> 
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
					<td><input type="text" name="codigo" id="codigo"
						data-validate="validate(required,number,minlength(3),maxlength(5))"
						value="<?php echo (isset($_POST['codigo']))?$_POST['codigo']:"";?>" />
						
						<button type="submit" name="procesarButton" value="Busccar"
							id="yourSubmitId" onclick="$('#form1').ketchup();" <?php echo (isset($buscar) && !$buscar)? "disabled='disabled'":"";?>>
							<img alt="" src="../img/search.png" width="16" height="16" />
							Buscar
						</button>
					</td>
				</tr>

				<tr>
        <td><label>Descripci&oacute;n:</label></td>
        <td><input type="text" name="descripcion" id="descripcion" <?php echo (isset($buscar) && !$buscar)? "data-validate='validate(required)'":"";?> value="<?php echo (isset($_POST['descripcion']))?$_POST['descripcion']:"";?>" <?php echo (isset($buscar) && !$buscar)? "":"disabled='disabled'";?> size="40"/></td>
    </tr>
        
    <tr>
      <td colspan="2" align="center">
        <input type="hidden" name="procesar" value="<?php echo (!isset($buscar))?'Buscar':'Actualizar'?>"/>
    	<button <?php echo (isset($buscar) && !$buscar)? "":"disabled='disabled'";?> type="submit" name="procesarButton2" value="Actualizar" id="yourSubmitId2" onclick="$('#form1').ketchup();">
    		<img alt="" src="../img/add.png" width="16" height="16"/>
    		Actualizar
    	</button><!-- onclick="javascript: form.action='../controllers/controller.cargaNota.php';" -->
      </td>
    </tr>
    
  </table>
  </fieldset>
   
</form>
</body>
</html>