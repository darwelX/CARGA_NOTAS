<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Carga Notas</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">

</script>
<link rel="stylesheet" type="text/css" href="../css/main.css" media="screen" />
</head>
<body>
<?php
   if(isset($mensaje)){
      echo $mensaje;
   } 
?>
  
<form action="../controllers/controller.login.php" method="post">

  <fieldset style="width: 30%">
  <legend>Inicio de Sesion</legend>
  <table>
    
    <tr>
		<td><label>Cedula:</label></td>
		<td><input type="text" name="cedula" value="<?php if(isset($_POST['cedula'])) echo $_POST['cedula'];?>" /></td>
    </tr>
    
    <tr>
       <td><label>Password:</label></td>
       <td><input type="password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'];?>" /></td>
    </tr>
    
    <tr>
      <td colspan="2" align="center">
    	<button type="submit" name="procesar" value="Iniciar" id="yourSubmitId">
    		<img alt="" src="../img/enviar.png" width="16" height="16"/>
    		Iniciar
    	</button>
      </td>
    </tr>
    
  </table>
  </fieldset>
   
</form>
 
</body>
</html>