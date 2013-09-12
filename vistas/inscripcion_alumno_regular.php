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
	  //if($('#form1').ketchup('isValid')){
      	$("#yourSubmitId").html("Porfavor Espere..")
      	formObj.procesarButton.disabled = true;  
      	return true; 
	  //} 

  }
  </script>
  
</head>
<body>
<?php require_once '../classes/class.model.Trimestre.php';
require_once '../classes/class.model.Materia.php';
?>    
<!-- ../controllers/controller.cargaNota.php -->
<form action="../controllers/controller.inscripcion.php" method="post" id="form1"  onsubmit="return validateForm(this);">
  <input type="hidden" name="id_estudiante" value="<?php echo (isset($_POST['id_estudiante']))?$_POST['id_estudiante']:"";?>">
  <input type="hidden" id="procesar" name="procesar" value="">
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
      <td colspan="2" style="text-align: left;">
          <b>LAPSO:</b><?php echo $lapso->getDescripcion();?>
          <input type="hidden" name="lapso" value="<?php echo (isset($_POST['lapso']))? $_POST['lapso']:"";?>"/>
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
       <td colspan="2" style="text-align: center;"><b>CARGA ACADEMICA</b></td>
    </tr>
    
    <tr>
        <td style="text-align: center;">
        	<b>DISPONIBLE</b>
        	<center>
        	<table border="1" style="width: 100%;">
        		<tr>
        			<td style="text-align: center;">
        			    TRIMESTRE<br>
        			<select name="trimestre" onchange="javascript: form.submit()" size="14">
			        <option value="">--</option>
			        <?php
			           $trimestre = new Trimestre();
			           $trimestres =$trimestre->findAll();
			           
			           foreach ($trimestres as $tri){
                           if(isset($_POST['trimestre']) && $_POST['trimestre'] != ""){
                               if($_POST['trimestre'] == $tri->getNumero()){
						       	  echo "<option value='".$tri->getNumero()."' selected>".$tri->getNumero()."</option>";
						       }else{
                                  echo "<option value='".$tri->getNumero()."'>".$tri->getNumero()."</option>";
                               }
						       
                           }
                           else{
                           	   echo "<option value='".$tri->getNumero()."'>".$tri->getNumero()."</option>";
                           }
                       } 
			        ?>
			        </select>
        			</td>
        			
        			<td style="text-align: center;">
        			ASIGNATURAS<br> 
        			<select name="asignatura" onchange="javascript: form.submit()" size="14">
			        <option value="">--</option>
        			<?php
        			if(isset($materias) && count($materias) > 0 ){
 						foreach ($materias as $mat){
						  if(isset($_POST['asignatura']) && $_POST['asignatura'] != ""){
		                       if($_POST['asignatura'] == $mat->getId()){
			                      echo "<option value='".$mat->getId()."' selected>".$mat->getNombre()."</option>";
		                       }else{
			                      echo "<option value='".$mat->getId()."'>".$mat->getNombre()."</option>";
		                       }
		                       
		                  }//end if
			              else{
		                      echo "<option value='".$mat->getId()."'>".$mat->getNombre()."</option>";
	                      }
                        }//end foreach
                        
                      }//endif?>
                      </select>
        			</td>
        			<td style="text-align: center;">SECCION</td>
        		</tr>

        	</table>
        	</center>
        </td>
        
        <td style="text-align: center;">
           SELECCIONADO
           <button type="submit" name="procesarButton" value="Busccar" id="yourSubmitId" onclick="$('#procesar').attr('value','Agregar Unidad');">
    		<img alt="" src="../img/enviar.png" width="16" height="16"/>
    		Cargar Unidad
    	    </button>
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