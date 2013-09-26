<?php session_start();?>
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

function validateForm(formObj) {
	  if($('#form1').ketchup('isValid')){
    	$("#yourSubmitId").html("Porfavor Espere..")
    	formObj.procesarButton.disabled = true;  
    	return true; 
	  } 

}
</script>
<!--  <link rel="stylesheet" type="text/css" href="../css/main.css" media="screen" />-->
</head>
<body>

 <?php if( !isset($_SESSION['LOGIN']) ){
         require_once 'login.php';
         exit;
       }?>
<div class="row">
  <div class="span12"><img alt="" src="../img/MEMBRETE.jpg"></div>
</div>

<div class="row-fluid">
  <div class="span12">
    <?php require_once 'menu.php';?>
  </div>
</div>    

<div class="row-fluid">
  <div class="span12">
<form action="../controllers/controller.login.php" id="form1" method="post">

  <fieldset style="width: 30%; padding-left: 35%;">
  <legend>Setear Password de Profesores</legend>
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
		<td><label>Password:</label></td>
		<td><input type="password" name="password1" value="<?php if(isset($_POST['password1'])) echo $_POST['password1'];?>" data-validate="validate(required)"/></td>
    </tr>
    
    <tr>
       <td><label>Repetir Password:</label></td>
       <td><input type="password" name="password2" value="<?php if(isset($_POST['password2'])) echo $_POST['password2'];?>" data-validate="validate(required)"/></td>
    </tr>
    
    <tr>
      <td colspan="2" align="center">
    	<button type="submit" name="procesar" value="Setear" id="yourSubmitId" onclick="$('#form1').ketchup();" >
    		<img alt="" src="../img/enviar.png" width="16" height="16"/>
    		Reset
    	</button>
      </td>
    </tr>
    
  </table>
  </fieldset>
   
</form>
  </div>
</div>
</body>
</html>