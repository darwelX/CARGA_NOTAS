<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Carga Evaluaciones</title>
  <!--  <link rel="stylesheet" type="text/css" href="../css/main.css" media="screen" />-->
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

<form enctype="multipart/form-data" action="../controllers/controller.carga.notas.php" method="post" id="form1">
  <input type="hidden" name="cedula" value="<?php echo $cedula;?>"/>
  <fieldset style="width: 100%">
  <legend>Imprimir Control de Notas</legend>
  <table>
    <tr>
         <th colspan="2" style="font-family: Arial, Helvetica,  sans-serif; font-size: 16px; font-weight: bold; color: red;">
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
         <th colspan="2" style="font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: red;"><?php
             
              if(isset($errores)){
                 if(sizeof($errores)>0){

                    for($i=0; $i < sizeof($errores); $i++){
		                print("Error en linea ".$errores[$i]['linea']." ".$errores[$i]['error']);
	                    print "<br>";
                    }
                 }

               }
             ?>
         </th>
    </tr>
        
    <tr>
         <th colspan="2" style="font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: red;">
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
		<td><label>Archivo CVS:</label></td>
		<td>
		     <input name="file" type="file" data-validate="validate(required)"/>
		</td>
    </tr>
        
    <tr>
      <td colspan="2" align="center">
    	<button type="submit" name="procesar" value="Cargar" id="yourSubmitId" onclick="$('#form1').ketchup();">
    		<img alt="" src="../img/search.png" width="16" height="16"/>
    		Cargar
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
  if( (isset($_POST['procesar']) && $_POST['procesar']=="Cargar") && $swCargar){?>   
     <fieldset style="width: 95%">
      <input type="hidden" name="nombreArchivo" value="<?=$uploadfile?>"/>
      <legend align="center">
           Listado de Estudiantes
      </legend>
      <center>
      <table class="table table-striped table-bordered table-hover">
           <tr>
                <?php 
                $objReadCSV = new ReadCSV($uploadfile);
                $matrizNotas = $objReadCSV->convertriArreglo();
             	$k=sizeof($matrizNotas[0]) + 3 ;
             	?>           
               <th colspan="<?=$k;?>" style="font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: red;">
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
           <tr>
             <th>N°</th>
             <th>CEDULA</th>
             <th>NOMBRES</th>
             <th>APELLIDOS</th>
             <?php
             	$i=3;
             	for($i=3; $i < sizeof($matrizNotas[0]); $i++ ){
   					echo "<th>".$matrizNotas[0][$i]."</th>"; // Muestra todos los campos de la fila actual
   				}

             ?>
             <th>100%</th>
             <th>Conversion</th>
           </tr>  
             <?php
             	$k=1;
             	for($i=1; $i < sizeof($matrizNotas); $i++){
             		
             		echo "<tr>";
             	    echo "<td>$k</td>";
             	    $suma=0;
             	    for($j=0; $j<sizeof($matrizNotas[$i]); $j++ ){
             			echo "<td>".$matrizNotas[$i][$j]."</td>";
             			if($j>2){
                          $suma+=intval($matrizNotas[$i][$j]);
                        }
             		}
             		echo "<td>$suma</td>";
             		$notaFinal = $objConversion->conversionNota($suma);
             		$estiloNotaPasada=($notaFinal < 12)?"color: red;":"";
             		echo "<td style='$estiloNotaPasada'>$notaFinal</td>";
             		echo "</tr>";
             		
             		$k++;
             	}
             ?>
             
             <tr>
                <td colspan="<?=$k;?>" align="center">
                    	<button type="submit" name="procesar" value="Guardar" id="yourSubmitId">
    						<img alt="" src="../img/enviar.png" width="16" height="16"/>
    						Guardar
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