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
	  aler('hola') 
	  if($('#form1').ketchup('isValid')){
      	$("#yourSubmitId").html("Porfavor Espere..")
      	formObj.procesarButton.disabled = true;  
      	return true; 
	  } 

  }
  </script>
  
</head>
<body>
    <?php require_once '../classes/class.model.Docente.php';
    $docente= new Docente();
    $cedula="";
    if( isset($_GET['cedula']) || isset($_POST['cedula']) ){
          $cedula = (isset($_GET['cedula']))? intval($_GET['cedula']) : intval($_POST['cedula']);
          //echo $cedula;
    	  $docente->findBy("CEDULA = $cedula");
    }else{
         require_once 'login.php';
         exit;
    }?>
    
    <?php require_once 'menu.php';
          ?>
<!-- ../controllers/controller.cargaNota.php -->
<form action="../controllers/controller.cargaNota.php" method="post" id="form1"  onsubmit="return validateForm(this);">
  <input type="hidden" name="cedula" value="<?php echo $cedula;?>"/>
  <fieldset style="width: 50%">
  <legend>Carga de Evaluaciones</legend>
  <table>
    
    <tr>
		<td><label>Lapso:</label></td>
		<td>
			<select name="lapso" onchange="javascript: form.action='';form.submit()" data-validate="validate(required)">
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
		<td><label>Seccion:</label></td>
		<td>
			<select name="seccion" onchange="javascript: form.action='';form.submit()" data-validate="validate(required)">
			        <option value="">--</option>
			        <?php
			           if(isset($_POST['lapso']) && $_POST['lapso'] != ""){
			           		$docente->findAllSeccionesByLapso($_POST['lapso']);
			           		foreach ($docente->secciones as $sec){
                           		if(isset($_POST['seccion']) && $_POST['seccion'] != "0"){
                                	if($_POST['seccion'] == $sec->getId()){
                                   		echo "<option value='".$sec->getId()."' selected> SECCION: ".$sec->getDescripcion()." - (".$sec->carrera->getDescripcion().") TRIMESTRE: ".$sec->getTrimestre()."</option>";
                                	}else{
                                   		echo "<option value='".$sec->getId()."'> SECCION: ".$sec->getDescripcion()." - (".$sec->carrera->getDescripcion().") TRIMESTRE: ".$sec->getTrimestre()."</option>";
                                	}
                                
                           		}else{
                                    echo "<option value='".$sec->getId()."'> SECCION: ".$sec->getDescripcion()." - (".$sec->carrera->getDescripcion().") TRIMESTRE: ".$sec->getTrimestre()."</option>";
                           		}
					   		}
					  } 
			        ?>
			        
			</select>
			<a href="../vistas/trimestres.html" target="_blank" onClick="window.open(this.href, this.target, 'width=300,height=280,top=100, left=700'); return false;">
				<img alt="tabla de trimestres" src="../img/help.png" width="16" height="16" >
			</a>
		</td>		
    </tr>
    
    <tr>
		<td><label>Materia:</label></td>
		<td>
			<select name="materia" data-validate="validate(required)">
			        <option value="">--</option>
			        <?php
			           if(isset($_POST['seccion']) && $_POST['seccion'] != ""){
                        $seccion = $_POST['seccion'];
			           	$docente->findAllMateriasBySeccion($seccion);
			           	foreach ($docente->materias as $mat){
                        	   echo "<option value='".$mat->getId()."'>".$mat->getNombre()."</option>";
					   	}
					   }
			        ?>
			        
			</select>
		</td>
    </tr>
    
    <tr>
        <td><label>Cantidad de Evaluaciones:</label></td>
        <td><input type="text" name="cantidad" id="cantidad" data-validate="validate(required,number,min(4),max(10))" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="hidden" name="procesar" value="Crear"/>
    	<button type="submit" name="procesarButton" value="Crear" id="yourSubmitId" onclick="$('#form1').ketchup();">
    		<img alt="" src="../img/enviar.png" width="16" height="16"/>
    		Siguiente
    	</button><!-- onclick="javascript: form.action='../controllers/controller.cargaNota.php';" -->
      </td>
    </tr>
    
  </table>
  </fieldset>
   
</form>
</body>
</html>