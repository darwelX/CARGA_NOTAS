<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Carga Evaluaciones</title>
  <!--<link rel="stylesheet" type="text/css" href="../css/main.css" media="screen" />-->
  <link rel="stylesheet" type="text/css" href="../css/jquery.ketchup.css" media="screen" />
  <!--<link rel="stylesheet" type="text/css" href="../css/bootstrap-responsive.css" media="screen" />-->
  <!--<link rel="stylesheet" type="text/css" href="../css/bootstrap-responsive.min.css" media="screen" />-->
  <!--<link rel="stylesheet" type="text/css" href="../css/bootstrap.css" media="screen" />-->
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" media="screen" />
  <script type="text/javascript" src="../js/jquery.js"></script>
  <!--<script type="text/javascript" src="../js/jquery.ketchup.all.min.js"></script>-->
  <!-- <script type="text/javascript" src="../js/bootstrap.js"></script>-->
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
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
require_once '../classes/class.model.Horario.php';
require_once '../classes/class.model.Taller.php';
?>    
<!-- ../controllers/controller.cargaNota.php -->
<form action="../controllers/controller.inscripcion.php" method="post" id="form1"  onsubmit="return validateForm(this);">
  <input type="hidden" name="id_estudiante" value="<?php echo (isset($_POST['id_estudiante']))?$_POST['id_estudiante']:"";?>">
  <input type="hidden" id="procesar" name="procesar" value="">
  <input type="hidden" id="id_asignatura_eliminar" name="id_asignatura_eliminar" value=""/>
  <input type="hidden" id="id_seccion_eliminar" name="id_seccion_eliminar" value=""/>
  <fieldset style="width: 150%">
  <legend>INSCRIPCI&Oacute;N</legend>
  <table class="table table-striped table-bordered" style="width: 100%;">

    <tr>
    	<th colspan="2" >
						 <?php 
		        		if(isset($mensaje) && $mensaje != ""){?>
                         <div class="alert alert-<?=$tipo_msg?>">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<?=$mensaje?>
						</div> <?php
                        }
					?>  	
    	</th>
    </tr>
    
    <tr>
      <td colspan="2" style="text-align: center;">
          <h4>INSCRIPCI&Oacute;N ALUMNO REGULAR EN NUEVO SEMESTRE</h4>
      </td>
    </tr>
 
    <tr>
      <td colspan="2" style="text-align: left;">
          LAPSO:<b><?php echo $lapso->getDescripcion();?></b>
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
       <td colspan="2" style="text-align: center;"><h5>CARGA ACADEMICA</h5></td>
    </tr>
    
    <tr>
        <td style="text-align: center;">
        	<h5>DISPONIBLE</h5>
        	<center>
        	<table class="table table-striped table-bordered" style="width: 100%;">
        		<tr>
        			<td style="text-align: center;">
        			    TRIMESTRE<br>
        			<select class="span1" name="trimestre" onchange="javascript: form.submit()" size="14">
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
        			<select class="span8" name="asignatura" onchange="javascript: form.submit()" size="14">
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
        			
        			<td style="text-align: center;">SECCION<br>
        			<select class="span1" name="seccion" onchange="javascript: form.submit()" size="14">
			        <option value="">--</option>
        			<?php
        			if(isset($secciones) && count($secciones) > 0 ){
 						foreach ($secciones as $sec){
						  if(isset($_POST['seccion']) && $_POST['seccion'] != ""){
		                       if($_POST['seccion'] == $sec->getId()){
			                      echo "<option value='".$sec->getId()."' selected>".$sec->getDescripcion()."</option>";
		                       }else{
			                      echo "<option value='".$sec->getId()."'>".$sec->getDescripcion()."</option>";
		                       }
		                       
		                  }//end if
			              else{
		                      echo "<option value='".$sec->getId()."'>".$sec->getDescripcion()."</option>";
	                      }
                        }//end foreach
                        
                      }//endif?>
                      </select>        			
        			</td>
        		</tr>

        	</table>
        	</center>
        </td>
        
        <td style="text-align: center;">
           SELECCIONADO
           <button type="submit" name="procesarButton" value="Busccar" id="yourSubmitId" class="btn" onclick="$('#procesar').attr('value','Agregar Unidad');">
    		<img alt="" src="../img/enviar.png" width="16" height="16"/>
    		Cargar Unidad
    	    </button>
    	    <br>
    	     
    	    <table class="table table-striped table-hover table-bordered">
    	       <tr>
    	        <th>SECCION</th>
    	    	<th>ASIGNATURA</th>
    	    	<th>HORARIO</th>
    	    	<th>BORRAR</th>
    	       </tr>
    	       
    	       <?php foreach ($horarios as $hor){
    	       	   echo "<tr>";
    	       	   echo "<td style='text-align: left;'>".$hor->seccion->getDescripcion()."</td>";
    	       	   echo "<td style='text-align: left;'>".$hor->materia->getNombre()."</td>";
    	       	   echo "<td style='text-align: left;'>".$hor->getHorario()."</td>";?>
    	       	   <td>
    	       	   
    	       	   <button type="submit" name="procesarButton" value="Busccar" id="yourSubmitId" class="btn btn-primary" onclick="$('#id_seccion_eliminar').attr('value','<?=$hor->seccion->getId()?>');$('#id_asignatura_eliminar').attr('value','<?=$hor->materia->getId()?>');$('#procesar').attr('value','Eliminar');">
    		        Eliminar
    	           </button>
    	           </td>
    	       	   <?php echo "</tr>";
    	       }?>
    	    </table>
        </td>
    </tr> 
    
    <tr>
        <td style="text-align: center;">
        				<h5>TALLERES PERMANENTES</h5>
        	<table class="table table-striped table-bordered">
        		<tr>
        		    <td style="text-align: center;">TALLER<br>
        		    <select class="span4" name="taller" onchange="javascript: form.submit()" size="7">
			        <option value="">--</option>
			        <?php
			           $taller = new Taller();
			           $talleres =$taller->findAll();
			           
			           foreach ($talleres as $ta){
                           if(isset($_POST['taller']) && $_POST['taller'] != ""){
                               if($_POST['taller'] == $ta->getId()){
						       	  echo "<option value='".$ta->getId()."' selected>".$ta->getDescripcion()."</option>";
						       }else{
                                  echo "<option value='".$ta->getId()."'>".$ta->getDescripcion()."</option>";
                               }
						       
                           }
                           else{
                           	   echo "<option value='".$ta->getId()."'>".$ta->getDescripcion()."</option>";
                           }
                       } 
			        ?>
			        </select>
        	    	</td>
        	    	
        		    <td style="text-align: center;">SECCION<br>
        		    <select class="span1" name="seccion_taller" onchange="javascript: form.submit()" size="7">
			        <option value="">--</option>
			        <?php
			           if(isset($_POST['taller']) && $_POST['taller'] != ""){

			           $taller = new Taller();
			           $taller->findBy("IDTALLER = ".$_POST['taller']);
			           $taller->findSeccionesByLapso($lapso->getId());
			           
			           foreach ($taller->secciones as $sec){
                           if(isset($_POST['seccion_taller']) && $_POST['seccion_taller'] != ""){
                               if($_POST['seccion_taller'] == $ta->getId()){
						       	  echo "<option value='".$sec->getId()."' selected>".$sec->getDescripcion()."</option>";
						       }else{
                                  echo "<option value='".$sec->getId()."'>".$sec->getDescripcion()."</option>";
                               }
						       
                           }
                           else{
                           	   echo "<option value='".$sec->getId()."'>".$sec->getDescripcion()."</option>";
                           }
                       } 
                       
                       }
			        ?>
			        </select>
        	    	</td>        	    	
        		</tr>
        	</table>
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