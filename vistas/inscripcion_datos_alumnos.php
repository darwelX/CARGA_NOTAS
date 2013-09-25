<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Carga Evaluaciones</title>
  <!--<link rel="stylesheet" type="text/css" href="../css/main.css" media="screen" />-->
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
  
</head>
<body>
<?php require_once '../classes/class.model.Lapso.php';?>  
<!-- ../controllers/controller.cargaNota.php -->
<form class="form-horizontal" action="../controllers/controller.inscripcion.php" method="post" id="form1"  onsubmit="return validateForm(this);">
  <fieldset style="width: 50%">
  <legend>Busccar Estudiante</legend>


						 <?php 
		        		if(isset($mensaje) && $mensaje != ""){?>
                         <div class="alert alert-<?=$tipo_msg?>">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<?=$mensaje?>
						</div> <?php
                        }
					?>  	


     <div class="control-group">
        <label class="control-label">Lapso:</label>
           
           <div class="controls">
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
			
		   </div>
        </div>
        
		<div class="control-group">	
			<label class="control-label">Cedula:</label>
			<div class="controls">
			   <input type="text" name="cedula" id="cedula" data-validate="validate(required)" value="<?php echo (isset($_POST['cedula']))?$_POST['cedula']:'';?>"/>
			</div>
        </div>
       

        <input type="hidden" name="procesar" value="Buscar"/>
        
      <div class="control-group">
        <div class="controls">
    	   <button type="submit" name="procesarButton" value="Busccar" id="yourSubmitId" onclick="$('#form1').ketchup();">
    		<img alt="" src="../img/enviar.png" width="16" height="16"/>
    		Buscar
    	   </button><!-- onclick="javascript: form.action='../controllers/controller.cargaNota.php';" -->
    	</div>
      </div>

  </fieldset>
   
</form>
</body>
</html>