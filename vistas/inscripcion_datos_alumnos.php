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
<?php require_once '../classes/class.model.Lapso.php';?>  
<!-- ../controllers/controller.cargaNota.php -->
<form action="../controllers/controller.inscripcion.php" method="post" id="form1"  onsubmit="return validateForm(this);">
  <fieldset style="width: 50%">
  <legend>Busccar Estudiante</legend>
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
		<td><label>Lapso:</label></td>
		<td>
			<select name="lapso" data-validate="validate(required)">
			        <option value="">--</option>
			        <?php
			           $lapso = new Lapso();
			           $lapsos =$lapso->findAll();
			           
			           foreach ($lapsos as $lap){
                           if(isset($_POST['lapso']) && $_POST['lapso'] != ""){
                               if($_POST['lapso'] == $lap->getId()){
						       	  echo "<option value='".$lap->getId()."' selected>".$lap->getDescripcion()."</option>";
						       }else{
                                  echo "<option value='".$lap->getId()."'>".$lap->getDescripcion()."</option>";
                               }
						       
                           }
                           else{
                           	   echo "<option value='".$lap->getId()."'>".$lap->getDescripcion()."</option>";
                           }
                       } 
			        ?>
			</select>
		</td>
    </tr>
        
    <tr>
        <td><label>Cedula:</label></td>
        <td><input type="text" name="cedula" id="cedula" data-validate="validate(required)" value="<?php echo (isset($_POST['cedula']))?$_POST['cedula']:'';?>"/></td>
    </tr>
    
       
    <tr>
      <td colspan="2" align="center">
        <input type="hidden" name="procesar" value="Buscar"/>
    	<button type="submit" name="procesarButton" value="Busccar" id="yourSubmitId" onclick="$('#form1').ketchup();">
    		<img alt="" src="../img/enviar.png" width="16" height="16"/>
    		Buscar
    	</button><!-- onclick="javascript: form.action='../controllers/controller.cargaNota.php';" -->
      </td>
    </tr>
    
  </table>
  </fieldset>
   
</form>
</body>
</html>