<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Carga Notas</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/jquery.ketchup.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" media="screen" />
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>  
  <script type="text/javascript" src="../js/jquery.js"></script>
  <script type="text/javascript" src="../js/jquery.ketchup.all.min.js"></script>
<script type="text/javascript">


</script>
<!--  <link rel="stylesheet" type="text/css" href="../css/main.css" media="screen" />-->
</head>
<body>

  
<form action="../controllers/controller.login.php" id="form1" method="post">

  <fieldset style="width: 30%; padding-left: 35%;">
  <legend>Inicio de Sesion</legend>
  <table>
    
    <tr>
        <td colspan="2">
                        <?php 
		        		if(isset($mensaje) && $mensaje != ""){?>
						<div class="alert alert-<?=$tipo_msg?>">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<?=$mensaje?>
						</div> <?php
                        }
                        ?>
       </td>
    </tr>
    <tr>
		<td><label>Login:</label></td>
		<td><input type="text" name="login" value="<?php if(isset($_POST['login'])) echo $_POST['login'];?>" data-validate="validate(required)"/></td>
    </tr>
    
    <tr>
       <td><label>Password:</label></td>
       <td><input type="password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'];?>" data-validate="validate(required)"/></td>
    </tr>
    
    <tr>
      <td colspan="2" align="center">
    	<button type="submit" name="procesar" value="Iniciar" id="yourSubmitId" onclick="$('#form1').ketchup();" >
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