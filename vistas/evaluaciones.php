<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Carga Evaluaciones</title>
  <!--<link rel="stylesheet" type="text/css" href="../css/main.css" media="screen" />-->
  <link rel="stylesheet" type="text/css" href="../css/jquery.ketchup.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../css/jquery.ui.all.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" media="screen" />
  <script type="text/javascript" src="../js/bootstrap.min.js"></script> 
  <script type="text/javascript" src="../js/jquery.js"></script>
  <script type="text/javascript" src="../js/jquery.ketchup.all.min.js"></script>
  <script type="text/javascript" src="../js/jquery.ui.core.js"></script>
  <script type="text/javascript" src="../js/jquery.ui.widget.js"></script>
  <script type="text/javascript" src="../js/jquery.ui.datepicker.js"></script>
  <script type="text/javascript">
  $(function() {
		$( ".datepicker" ).datepicker();
	});
  </script>
</head>
<body>
    <?php require_once '../classes/class.model.Docente.php';
    $docente= new Docente();
    $cedula="";
    if( isset($_GET['cedula']) || isset($_POST['cedula']) ){
          $cedula = (isset($_GET['cedula']))? intval($_GET['cedula']) : intval($_POST['cedula']);
    	  $docente->findBy("CEDULA = $cedula");
    }else{
         require_once 'login.php';
         exit;
    }?>
    
    <?php require_once 'menu.php';
          ?>
<!-- ../controllers/controller.cargaNota.php -->

<form action="../controllers/controller.cargaNota.php" method="post" id="form1">
  <input type="hidden" name="cedula" value="<?=$_POST['cedula']?>"/>
  <input type="hidden" name="lapso" value="<?=$_POST['lapso']?>"/>
  <input type="hidden" name="seccion" value="<?=$_POST['seccion']?>"/>
  <input type="hidden" name="materia" value="<?=$_POST['materia']?>"/>
  <input type="hidden" name="cantidad" value="<?=$evaluacion->getCantidadEvaluaciones()?>"/>
  <input type="hidden" name="control" value="<?=$evaluacion->getId()?>"/>
  
  <fieldset>
  <legend>Control de Evaluacion</legend>
  <table>
    <tr>
    	<th colspan="8" style="font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: red;">
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
		<th>Lapso:</th>
		<td>
		     <?= $lapso->getDescripcion()?>
		</td>

		<th>Seccion:</th>
		<td>
		    <?= $seccion->getDescripcion()?>
		</td>	

		<th>Carrera:</th>
		<td><?= $seccion->carrera->getDescripcion()?></td>	

		<th>Materia:</th>
		<td>
			<?= $materia->getNombre()?>
		</td>
     </tr>

    </table>
  </fieldset>
  
  <br/>
  
  <fieldset>
		<legend>Evaluaciones</legend>  
		<table>
		        
		        <tr>
		        	<th colspan="3" style="font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: red;">
	                 <?php 
		        		if(isset($mensaje2) && $mensaje2 != ""){?>
                         <div class="alert alert-<?=$tipo_msg?>">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<?=$mensaje2?>
						</div> <?php
                        }
					?>  
		        	</th>
		        </tr>
		        
		        <?php for($i=1; $i <= intval($evaluacion->getCantidadEvaluaciones()) ;$i++ ){?>
				<tr>
				    <th><label>Evaluacion <?=$i?></label><input type="text" name="descripcion<?=$i?>" data-validate="validate(required)" size="40" value="<?= (isset($_POST['descripcion'.$i]))?$_POST['descripcion'.$i]:"";?>" ></th>
				    <th><label>Fecha:</label><input type="text" name="fecha<?=$i?>" data-validate="validate(required)" value="<?= (isset($_POST['fecha'.$i]))?$_POST['fecha'.$i]:"";?>" class="datepicker"></th>
				    <th><label>Porcentaje:</label><input type="text" name="porcentaje<?=$i?>" value="<?= (isset($_POST['porcentaje'.$i]))?$_POST['porcentaje'.$i]:"";?>" data-validate="validate(required,number,range(5, 30))"></th>
				<tr>
				<?php }?>
				
				<tr>
				    <td colspan="1">
    	               <button type="submit" name="procesar" value="Guardar" id="yourSubmitId" onclick="$('#form1').ketchup();">
    		               <img alt="" src="../img/enviar.png" width="16" height="16"/>
    		               Guardar
    	               </button>
    	               
    	               <button type="reset" name="procesar" value="Limpiar">
    		               <img alt="" src="../img/remove.png" width="16" height="16"/>
    		               Limpiar
    	               </button>    	               
                    </td>
				</tr>
		</table>
		
  </fieldset>
   
</form>

</body>
</html>