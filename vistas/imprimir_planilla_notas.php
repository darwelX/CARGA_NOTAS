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
         echo "login.php";
         require_once 'login.php';
         exit;
    }?>
    
    <?php require_once 'menu.php';
          ?>
<!-- ../controllers/controller.cargaNota.php -->

<form action="../controllers/controller.imprimir.listado.php" method="post" id="form1">
  <input type="hidden" name="cedula" value="<?php echo $cedula;?>"/>
  <fieldset style="width: 50%">
  <legend>Imprimir Control de Notas</legend>
  <table>
    <tr>
         <th colspan="2" style="font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: red;"><?php
                 if(isset($mensaje)){
                    echo $mensaje;
                 } 
             ?>
         </th>
    </tr>
    
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
                                   		echo "<option value='".$sec->getId()."' selected> SECCION: ".$sec->getDescripcion()." - (".$sec->carrera->getDescripcion().")"."</option>";
                                	}else{
                                   		echo "<option value='".$sec->getId()."'> SECCION: ".$sec->getDescripcion()." - (".$sec->carrera->getDescripcion().")"."</option>";
                                	}
                                
                           		}else{
                                    echo "<option value='".$sec->getId()."'> SECCION: ".$sec->getDescripcion()." - (".$sec->carrera->getDescripcion().")"."</option>";
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
                            if(isset($_POST['materia']) && $_POST['materia'] != ""){

                                if($_POST['materia'] == $mat->getId()){
                                     echo "<option value='".$mat->getId()."' selected>".$mat->getNombre()."</option>";
                                }else{
                                     echo "<option value='".$mat->getId()."'>".$mat->getNombre()."</option>";
                                }
                            }else{
                        	   echo "<option value='".$mat->getId()."'>".$mat->getNombre()."</option>";
                        	}
					   	}
					   }
			        ?>
			        
			</select>
		</td>
    </tr>
    
    <tr>
      <td colspan="2" align="center">
    	<button type="submit" name="procesar" value="Buscar" id="yourSubmitId" onclick="$('#form1').ketchup();">
    		<img alt="" src="../img/search.png" width="16" height="16"/>
    		Buscar
    	</button><!-- onclick="javascript: form.action='../controllers/controller.cargaNota.php';" -->
    	
    	<button type="reset" name="procesar" value="Limpiar">
    	     <img alt="" src="../img/remove.png" width="16" height="16"/>
    	     Limpiar
    	</button> 
      </td>
    </tr>
    
  </table>
  </fieldset>
  <br>
  <?php 
  if( (isset($_POST['procesar']) && $_POST['procesar']=="Buscar") ||  (isset($_POST['procesar']) && $_POST['procesar']=="Imprimir")){?>   
     <fieldset style="width: 50%">
      <legend align="center">
           Listado de Estudiantes
      </legend>
      <center>
      <table id="listado">
           <tr>
               <th colspan="4" style="font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: red;">
               <?php if(isset($mensaje)){
               	       echo $mensaje;
                     }
               	?>
              </th>
           </tr>
           <tr>
             <th>N°</th>
             <th>CEDULA</th>
             <th>NOMBRES</th>
             <th>APELLIDOS</th>
           </tr>  
             <?php
                require_once '../classes/class.util.Convert.php';
                $objCon = new Convert();
                
                if(sizeof($objCeccion->estudiantes) > 0){
                  $i=1;
                  foreach ($objCeccion->estudiantes as $estudiante){
                    $estilo = ( ($i % 2) == 0 )?"par":"impar";
                    echo "<tr id='$estilo'>";
                    echo "<td>$i</td>";
                    echo "<td>".$objCon->formatoCedula($estudiante->getCedula())."</td>";
                    echo "<td>".$estudiante->getApellidos()."</td>";
                    echo "<td>".$estudiante->getNombres()."</td>";
                    echo "</tr>"; 
                    $i++;
                  }
                }
             ?>
             
             <tr>
                <td colspan="4" align="center">
                    	<button type="submit" name="procesar" value="Imprimir" id="yourSubmitId">
    						<img alt="" src="../img/print.png" width="16" height="16"/>
    					</button>
                </td>
             </tr>
      </table>
      </center>
     </fieldset>
<?php }?>
</form>
</body>
</html>