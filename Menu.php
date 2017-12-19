<?php 

ob_start();

 session_start();
if ( ! ($_SESSION['autenticado'] == 'SI' && isset($_SESSION['uid'])) )
{

		echo "<form name=\"error\"  id=\"frm_error\" method=\"post\" action=\"index.php\">";
			echo "<input type=\"hidden\" name=\"actualiza_error\" value=\"1\" />";
			echo "<input type=\"hidden\" name=\"msg_error\" value=\"FAVOR DE INICIAR SESSION\">";
		echo "</form>";
		echo "<script type=\"text/javascript\"> ";
			echo "document.error.submit();";
		echo "</script>";

}
else
{
	ini_set("display_errors", "on");
	header('Content-Type: text/html; charset=utf-8'); 
	require('PHP/conn.php');
	require('PHP/funciones.php');
	$db = conectar();
	if ($db)
	{
		$iden = $_SESSION['uid'];
		$password = $_SESSION['passw'];
		$fechaGuardada = $_SESSION["ultimoAcceso"];
		
		$ahora = date("Y-n-j H:i:s");  
       	$tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada)); 
		
		$sql = 'SELECT * FROM analistas where "idAnalista"='.$iden.';';
		$result = pg_query($db, $sql); 
		if (!$result) { exit("Error en la consulta"); } 
		
		if( $fila = pg_fetch_array($result) )
		$cv_principal = $fila['idAnalista']; 	
		$nombreUsuario = $fila['Persona'];
                $username = $fila['nom_user']; 
                $puesto = $fila['Puesto'];        
		
		if (empty($_GET["id"])) { $id=0;} 
		else { $id = $_GET["id"];}
	} //Cerrrar conexion a la BD
	 

    $nameFileSession = etiquetas("c_cobertura",$id , $cv_principal);

    $_SESSION['nameFileSession'] = $nameFileSession;


    $titleFileSession = etiquetas("c_nombre",$id , $cv_principal);

    $_SESSION['titleFileSession'] = $titleFileSession;

    $datumFileSession = etiquetas("c_datum",$id , $cv_principal);

    $_SESSION['datumFileSession'] = $datumFileSession;


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html >

  <head>
    <title>Menu</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
   <link rel="stylesheet" href="openLayers/v4.2.0/css/ol.css"  type="text/css"> 
    <link rel="stylesheet" href="CSS/style4.css" media="all" />
     <link href="CSS/jquery-ui.css" rel="stylesheet">
   <link rel="stylesheet" href="jquery/base/jquery.ui.core.css">
    <link rel="stylesheet" href="jquery/base/jquery.ui.dialog.css">
    <link rel="stylesheet" href="jquery/base/jquery.ui.button.css">
	  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	  <link href="https://fonts.googleapis.com/css?family=Oswald:300,500,700" rel="stylesheet">
   <!--<link rel="stylesheet" href="https://openlayers.org/en/v4.2.0/css/ol.css" type="text/css"> -->
    
<!--	<script src="Javascript/jquery-3.2.1.min.js"></script>-->
<!--	<script src="https://openlayers.org/en/v4.2.0/build/ol.js" type="text/javascript"></script>-->
<script src="openLayers/v4.2.0/build/ol.js" type="text/javascript"></script>
	<script src="Javascript/jquery-1.7.1.min.js"></script>






	<script src="Javascript/javascript.js"></script>
	<script src="Javascript/jquery.easyui.min.js"></script>
    <script src="Javascript/jquery.ui.datepicker-es.js"></script>
    <script src="Javascript/jquery-ui-1.10.4.custom.js"></script>
    <script src="jquery/ui/jquery.ui.core.js"></script>
	<script src="jquery/ui/jquery.ui.widget.js"></script>
	<script src="jquery/ui/jquery.ui.position.js"></script>
	<script src="jquery/ui/jquery.ui.button.js"></script>
	<script src="jquery/ui/jquery.ui.dialog.js"></script>
	<script src="ajax.js"></script>
  	<script src="Javascript/scriptMetadatos.js"></script>
<!--<script src="openLayers/v4.2.0/build/ol.js" type="text/javascript"></script>-->
<!--     <script>
      $(function(){
        $(document).tooltip();
      });

    </script>-->
   <!--  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
<script type="text/javascript">
$(document).ready(function(){
	$('.error').hide();
	var fileExtension = "";
	$(':file').change(function(){
		var file = $("#userfile")[0].files[0];
		var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        var fileSize = file.size;
        var fileType = file.type;
		
		if(fileExtension == "txt")
		{
			var formData = new FormData($(".formulario")[0]);
			var message = ""; 
			
			$.ajax({
				 url: 'subir.php', 
				 type: 'POST', 
				 data: formData,
				 dataType : "json",
				 cache: false,
				 contentType: false,
				 processData: false,
				}).done(function(result) {
				
				//var output = "<h1>" + result.message + "</h1>";
				var output = "";
				$.each(result.vector.linea, function( i, obj ) {
					$("#selectVector").append('<option value='+ obj+'>'+ result.vector.name [i]+'</option>');
					
				});
				
				$.each(result.tif.linea, function( i, obj ) {
					$("#selectTif").append('<option value='+ obj+'>'+ result.tif.name [i]+'</option>');
					//output += obj + "<br>";
				});
				

				
				
				$("#contenido").html(output );
				});

			
  
		}
	});
	
	$('#descarga').click(function(){
		window.location = "ficheros/metadatos.sfx.exe";
	});
	
	
});	

//como la utilizamos demasiadas veces, creamos una función para 
//evitar repetición de código
function showMessage(message){
    $(".messages").html("").show();
    $(".messages").html(message);
}

function isImage(extension)
{
    switch(extension.toLowerCase()) 
    {
        case 'txt': 
            return true;
        break;
        default:
            return false;
        break;
    }
}
$(document).ready(function(){	

	


	$("#selectVector").change(function () {
    	$("#selectVector option:selected").each(function () {
			elegido=$(this).val();
			if(elegido != "")	
			{
				
				vectores(elegido);	

				
			}
			//alert(elegido);
		});
	});
	
	$("#selectTif").change(function () {
    	$("#selectTif option:selected").each(function () {
			elegido=$(this).val();
			if(elegido != "")	
			{	
				
				archivosTif(elegido);
			}
		});
	});
});

function archivosTif(nameTif) {
	var archivoTxt = $("#userfile").val();
	var fileName = archivoTxt.split("\\");
	var fileName = fileName[fileName.length-1];
	var dato = nameTif;
	var hoja = "tif";
	var dataString = {metadato : nameTif , fileMetadato : fileName, contenido : hoja}

		$.ajax({
		data: dataString,
		url: 'subir2.php', 
		type: "GET",
		dataType : "json",
		}).done(function(result) {
			//alert(result.tif);
				$("#c_datum").val("WGS_1984");
				$("#c_estructura_dato").val("Raster");
				$("#c_tipo_dato").val(result.tifDato);
				$("#c_total_datos").val(result.count);
				$("#c_elipsoide").val("GCS_WGS_1984");	
				$("#c_oeste").val(result.Xmin); 
				$("#c_sur").val(result.Ymin);
				$("#c_este").val(result.Xmax);
				$("#c_norte").val(result.Ymax);
				$("#c_id_proyeccion").val("Geográfica");
				$("#r_num_columnas").val(result.tifColunmas);
				$("#r_nun_renglones").val(result.tifRenglones);
				$("#r_pixel_X").val(result.tifPixelX);
				$("#r_pixel_Y").val(result.tifPixelY);
				$("#r_COOR_X").val(result.tifRasterX);
				$("#r_COOR_Y").val(result.tifRasterY);
				
				
			
		});
	//alert(nameMetadato);
}

function vectores(nameMetadato) {
	
	var archivoTxt = $("#userfile").val();
	var fileName = archivoTxt.split("\\");
	var fileName = fileName[fileName.length-1];
	var dato = nameMetadato;
	var hoja = "vectores";
	var dataString = {metadato : nameMetadato , fileMetadato : fileName , contenido : hoja}

		$.ajax({
		data: dataString,
		url: 'subir2.php', 
		type: "GET",
		dataType : "json",
				}).done(function(result) {
				$("#c_datum").val(result.datumName);
				$("#c_tipo_dato").val(result.geometry);
				$("#c_total_datos").val(result.count);
				$("#c_elipsoide").val(result.geogcssName);	
				$("#c_oeste").val(result.Xmin); 
				$("#c_sur").val(result.Ymin);
				$("#c_este").val(result.Xmax);
				$("#c_norte").val(result.Ymax);
				$("#c_id_proyeccion").val(result.proyeccion);
				
				if((result.geometry == 'Point') || (result.geometry =='Polygon') || (result.geometry =='Line String'))
				{
					$("#c_estructura_dato").val("Vector");
				}
				//$("#contenido").html(result.Xmin);
				$("#r_num_columnas").val("");
				$("#r_nun_renglones").val("");
				$("#r_pixel_X").val("");
				$("#r_pixel_Y").val("");
				$("#r_COOR_X").val("");
				$("#r_COOR_Y").val("");
			//	alert((result.geometry).length);
				
			
		});
	//alert(nameMetadato);
}
</script>

<script type="text/javascript">

function habilitar(obj) {
  var hab;
//  frm=obj.id;
  num=obj.selectedIndex;
  if (num==1) hab=false;
  else if (num==2) hab=true;
  document.getElementById('c_nombre').disabled=hab;
  document.getElementById('tabla_1').disabled=hab;
  document.getElementById('autores').disabled=hab;
  document.getElementsByName('datos').disabled=hab;
}
</script>

<script type="text/javascript">

function habilitar() {
        var x = document.getElementById("boton_subir");
            x.disabled = false;
}


</script>



</head>
<body>
	<div id="hd">
    	<table width="1200px">
          <tr>
            <td width="20%" valign="middle" align="center"><a href="http://www.biodiversidad.gob.mx/" target="_blank"><img src="CSS/images/logo-conabio-bco.png" width="200"></a></td>
            <td width="80%" class="title"><span>
			  <p class="txtN1">Direcci&oacute;n General de Geom&aacute;tica</p>
              <p class="txtN2">Subcoordinaci&oacute;n de Sistemas de Informaci&oacute;n Geogr&aacute;fica</p>
			  <div class="liner"></div>
<!--<?php echo $iden ;?><br />
<?php echo $cv_principal;?>	
<?php echo $tooltipNomArchivo; ?> -->

			</span></td>
          </tr>
        </table>
	</div> <!-- FIN <div id="hd">-->
    <div id="nu">&nbsp;&nbsp; Bienvenido <b><?php echo $nombreUsuario; ?></b></div>
    <div id="cn">
		<div id="lf">
	    	<div id="lf1">
 
            	<input type="button" id="nuevo" value="Nuevo Registro">
                <input type="button" id="duplica" value="Duplicar Registro">
				<?php if ($cv_principal == 28) {echo 
                '<input type="button" id="borrar" value="Borrar Registro">'
				;}; ?>   
                <input type="button" id="cerrarSesion" value="Cerrar Sesi&oacute;n">
	      	
			</div> 
			<div class="separador"></div>
          	<div id="lf2" class="accordion">
	        	<p>Seleccione el registro a editar o revisar:</p>    
	        	<?php seleccion($id, $cv_principal);?>
            	<h1> Informaci&oacute;n b&aacute;sica </h1>
				<div>
                  <input type="button" onclick="cambiar.accion (1)" value="Datos Generales">
                  <!--<input type="button" onclick="cambiar.accion (2)" value="Ubicaci&oacute;n Geogr&aacute;fica">-->
                  <input type="button" onclick="cambiar.accion (3)" value="Restricciones">
                  <input type="button" onclick="cambiar.accion (4)" value="Palabras Clave">
                  <input type="button" onclick="cambiar.accion (5)" value="Ambiente de Trabajo">
	
				</div>
			  <h1>Calidad de los datos</h1>
				<div style="display:none;">
                  <input type="button" onclick="cambiar.accion (6)" value="Calidad de los Datos">
                  <input type="button" onclick="cambiar.accion (7)" value="Taxonom&iacute;a">
				</div>
			  <h1> Informaci&oacute;n espacial y atributos</h1>
				<div style="display:none;">
                	
                  <input type="button" onclick="cambiar.accion (9)" value="Datos  Espaciales">
                  <input type="button" onclick="cambiar.accion (10)" value="Atributos">
                  <?php if ($cv_principal == 28){?>
                  <input type="button" onclick="cambiar.accion (11)" value="Clasificaci&oacute;n y Analista">
				  <?php }?>	                   	
				</div>		

			  <h1> Cartograf&iacute;a</h1>  
				<div style="display:none;">
<!--                  <input type="button" id="zip" value="Subir zip">   Este botón está por si se necesita una ventana popup-->

<!--  Botones de Subir archivos, Registro de Colaboradores, Aprobar Metadatos  -->

                                 <?php if ($puesto == "Administrador de Metadatos" || $puesto == "administrador" || $puesto == "analista") {echo 
                 		'<input type="button" onclick="cambiar.accion (14)" value="Subir archivos">'                  
				;}; ?>   

                                 <?php if ($puesto == "Administrador de Metadatos" || $puesto == "analista") {echo 
                 		'<input type="button" onclick="cambiar.accion (15)" value="Generar Plantilla">'                  
				;}; ?>   
                                 
				<?php if ($puesto == "Administrador de Metadatos" || $puesto == "administrador" || $puesto == "analista") {echo 
				'<input type="button" onclick="cambiar.accion (12)" value="Registro de colaborador">'
				;}; ?>   
		
<!--                                 <?php if ($puesto == "administrador" || $puesto == "analista") {echo 
				'<input type="button" onclick="cambiar.accion (13)" value="Aprobar Metadato">'
				;}; ?>  Queda pendiente esta funcionalidad
<?php if ($cv_principal == 28){?> 

 Fin de botones de Subir archivos, Registro de Colaboradores, Aprobar Metadatos  

                <input type="button" onclick="cambiar.accion (11)" value="Clasificaci&oacute;n y Analista">

<?php }?>-->
   
                           
				</div>		


	
	      	</div> <!--FIN <div id="lf2" class="accordion">-->
        </div> <!--FIN <div id="lf">-->       
	</div> <!--FIN <div id="cn">-->
    <div id="rg">
    		<div id="validaError" class="error" ></div>
         	 <div style="display:block" id="div1" class="element">
             	<div id="contenido">
                    <form name="datos" method="POST" >
                        <input type = "submit" value = "Guardar" id="datos" onclick = "this.form.action = 'guardar.php?hoja=datos&id=<?php echo $id;?>&cv_principal=<?php echo $cv_principal;?>'" />
                      	<div id="autores">Autores: 		<?php  global $id;  tabla("x_origin","30px",$id , $cv_principal,"Autores"); ?>  </div><br />
							<table id="tabla_1" width="869">
                            	<tr> 
                                	<td width="180">&nbsp;</td>
									<td colspan="5" align="center"> 
                                            <?php
                                                 if( isset( $_POST['actualiza'] ) && $_POST['actualiza'] != '' ){echo "<font color=\"green\"><ul id=\"msgs_actualiza\">".$_POST['msgs_actualiza']."</ul></font>"; }
                                                 if( isset( $_POST['error'] ) && $_POST['error'] != '' ) 		{echo "<font color=\"red\"><ul id=\"msgs_actualiza\">".$_POST['msgs_error']."</ul></font>";       }
                                            ?>
                                                          
                                    </td>
                              </tr>
                                 <tr >
                                    <td>T&iacute;tulo del mapa:</td>
                                    <td colspan="6"><?php 	$tooltipTitulo = "Título del mapa";
                                                 global $id; genera("c_nombre","extenso",$id , $cv_principal , "txt" , $tooltipTitulo);?></td>
                                 </tr>
                                 <tr >
                                    <td>Nombre del archivo:</td>
                                                 <td colspan="6"><?php  	$tooltipNomArchivo = "Nombre del dato geoespacial o capa digital"; 
                                                 global $id;  genera("c_cobertura","extenso",$id , $cv_principal , "txt" , $tooltipNomArchivo); ?></td>
                                 </tr>
                                 <tr valign="top">
                                   	<td>Fecha de ingreso:</td>
                                    <td width="125"><?php 	$tooltipFechaIngres = "Fecha de captura de metadato";
                                                      		global $id;  genera("c_fecha_inicial","corto",$id , $cv_principal, "calendario" , $tooltipFechaIngres); ?></td>
                                                            
                                    <td width="166">Fecha de actualizaci&oacute;n:</td>
                                    <td width="125"><?php 	$tooltipFechaAct = "";
                                                      		global $id;  genera("c_fecha","corto",$id , $cv_principal, "calendario" , $tooltipFechaAct);?></td>
                                    <td width="120">Versi&oacute;n FGDC:</td>
                                    <td width="125" colspan="2"><?php $tooltipVerFGDC = "";
                                                                  global $id;  genera("c_version","corto",$id , $cv_principal, "numeros" , $tooltipVerFGDC);?></td>
            					</tr>
                           	</table>
                          	<table width="869">
                                <tr> 
                                	<td colspan="6"><h3>Cita de la informaci&oacute;n</h3></td>
                              	</tr>
                                <tr>
                                    <td width="180">Instituci&oacute;n responsable:</td>
                                    <td colspan="6"><?php 	$tooltipInsti = "";
                                                      		global $id;  genera("c_publish","extenso",$id , $cv_principal , "txt", $tooltipInsti); ?></td>
                              	</tr>
                                <tr>
                                    <td>Siglas de la instituci&oacute;n:</td>
                                    <td colspan="6"><?php 	$tooltipSigla = ""; 
                                                      		global $id;  genera("c_publish_siglas","extenso",$id , $cv_principal , "txt" , $tooltipSigla);?></td>
                                </tr>
                                <tr>
                                     <td rowspan="3">Lugar de publicaci&oacute;n:</td>
                                     <td width="150">País:</td>
                                     <td width="15">&nbsp;</td>
                                     <td width="150">Estado:</td>
                                     <td width="15">&nbsp;</td>
                                     <td width="150">Municipio:</td>
                                     <td width="30">&nbsp;</td>
                                     <td width="150" colspan="2">Localidad:</td>
                                </tr>
                                <tr>
                                  <td><?php global $id;  selects("pais","147px",$id , $cv_principal); ?></td> 
                                  <td>&nbsp;</td>
                                  <td><?php global $id;  selects("estado","147px",$id , $cv_principal); ?></td>
                                  <td>&nbsp;</td>
                                  <td><?php global $id;  selects("municipio","147px",$id , $cv_principal); ?></td>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><?php global $id;  selects("localidad","147px",$id , $cv_principal); ?></td>
                                </tr>
                                <tr>
                                     <td colspan="6"><div id="OTRO"  style="display: none;" class="element">
									 <?php  
									 		$tooltipOtro = ""; 
									 		global $id;  genera("c_pubplace","extenso",$id , $cv_principal , "txt", $tooltipOtro); ?> </div></td>
                              </tr>
                                 <tr>
                                    <td>Fecha de publicaci&oacute;n:</td>
                                    <td><?php  	$tooltipFechaPub = "Fecha de elaboración o modificación de dato geoespacial";
                                          		global $id;  genera("c_pubdate","corto",$id , $cv_principal , "calendario" , $tooltipFechaPub); ?></td>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Versi&oacute;n:</td>
                                    <td><?php 	$tooltipVersion = "Sinónimo de edición";
                                          		global $id;  genera("c_edition","corto",$id , $cv_principal , "txt" , $tooltipVersion);  ?></td>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Escala:</td>
                                    <td><?php 	$tooltipEscala = "Escala del dato escrita como una razón";
                                          		global $id;  genera("c_escala","corto",$id , $cv_principal , "numeros" , $tooltipEscala); ?> </td>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Clave:</td>
                                    <td><?php  	$tooltipClave = "Clave de proyecto asignada por CONABIO";
                                          		global $id;  genera("c_clave","corto",$id , $cv_principal , "txt", $tooltipClave);  ?> </td>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                
                                
                                 <tr valign="top">
                                     <td>Descripci&oacute;n del metadato:</td>
                                     <td colspan="6"><?php  $tooltipDescMetad = "Información complementaria a la cita del dato geoespacial";
                                                        	global $id;  genera("c_issue","95px",$id , $cv_principal , "txtarea", $tooltipDescMetad); ?></td>
                                 </tr>
                                 <tr valign="top">
                                     <td>Resumen:</td>
                                     <td colspan="6"><?php 	$tooltipResum = "Descripción breve del contenido, área cubierta y tema que representa el dato"; 
                                                       		global $id;  genera("c_resumen","95px",$id , $cv_principal , "txtarea" , $tooltipResum); ?></td>
                                 </tr>
                                 <tr valign="top">
                                     <td>Abstract:</td>
                                     <td colspan="6"><?php 	$tooltipAbst = "";
                                                      		global $id;  genera("c_abstract","95px",$id , $cv_principal , "txtarea", $tooltipAbst);  ?></td>
                                 </tr>
                                 <tr valign="top">
                                     <td>Objetivos generales:</td>
                                     <td colspan="6"><?php 	$tooltipObje = "Propósito de la creación del dato"; 
                                                       		global $id;  genera("c_objetivo","95px",$id , $cv_principal , "txtarea", $tooltipObje); ?></td>
                                 </tr>
                                 <tr valign="top">
                                     <td>Datos complementarios:</td>
                                     <td colspan="6"><?php 	$tooltipDatComp = "Información complementaria a cerca del dato"; 
                                                       		global $id;  genera("c_datos_comp","95px",$id , $cv_principal , "txtarea", $tooltipDatComp); ?></td>
                                </tr>
                         	</table>
                            <table width="869">
                            	<tr>
                                  	<td width="279">Tiempo comprendido:</td>
                                  	<td width="30">del: </td>
                                  	<td width="138"><?php global $id;  genera("c_tiempo","corto",$id , $cv_principal , "calendario",  ""); ?></td>
                                  	<td width="30">al:</td>
                                  	<td width="138"><?php global $id;  genera("c_tiempo2","corto",$id , $cv_principal , "calendario",  ""); ?></td>
                                  	<td width="226" colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                  	<td >Nivel de avance:</td>
                                  	<td colspan="6"> <?php 	$tooltipNive = ""; 
                                                       		global $id;  genera("c_avance","extenso",$id , $cv_principal , "txt" , $tooltipNive); ?> </td>
                                </tr>
                                <tr>
                                  	<td>Mantenimiento:</td>
                                  	<td colspan="6"> <?php  $tooltipMante = "Frecuencia de actualización del dato"; 
                                                       		global $id;  genera("c_mantenimiento","extenso",$id , $cv_principal, "txt" , $tooltipMante);  ?> </td>
                                </tr>
                                <tr>
                                  	<td>Tama&ntilde;o del dato geoespacial en MB: </td>
                                  	<td colspan="6"> <?php 	$tooltipTamañ = "Tamaño en megabytes del o los archivos que contiene el dato"; 
                                                        	global $id;  genera("c_tamano","extenso",$id , $cv_principal, "numeros" , $tooltipTamañ); ?> </td>
                                </tr>
                                <tr>
                                  	<td>Formato del dato geoespacial: </td>
                                  	<td colspan="6"> <?php 	$tooltipFormat = "Formato digital correspondiente a los lineamientos cartográficos estipulados por CONABIO"; 
                                                        	global $id;  genera("c_geoform","extenso",$id , $cv_principal, "txt" , $tooltipFormat); ?> </td>
                                </tr>
                                <tr>
                                  	<td>Ligas www:</td>
                                  	<td colspan="6">&nbsp;</td>
                                </tr>
                                <tr>
                                  	<td colspan="7"><?php  global $id;  tabla("l_liga_www","100px",$id , $cv_principal ,"Ligas_www"); ?></td>
                                </tr>
                          	</table>
					</form>
                </div>
             </div>
             <div id="div2"  class="element">
             	<div id="contenido">
                    <form name="datos" method="POST" >
                      
                        <input type = "submit" value = "Guardar"  id="ubicacion" onclick = "this.form.action = 'guardar.php?hoja=ubicacion&id=<?php echo $id;?>&cv_principal=<?php echo $cv_principal;?>'"/>
							<table width="869">
                            	<tr> 
                                	<td width="250">&nbsp;</td>
									<td colspan="2" align="center"></td>
                        		</tr>
                                <tr >
                                    <td>&Aacute;rea geogr&aacute;fica:</td>
                                    <td colspan="3"><?php  // global $id;  genera("c_area_geo","100px",$id , $cv_principal , "txtarea"); ?></td>
                                </tr>
                                <tr >
                                    <td colspan="4"><h3>Coordenadas del extremo:</h3></td>
                                </tr>
                                <tr >
                                   	<td>Coordenadas del extremo oeste:</td>
                                    <td width="400"><?php // global $id;genera("c_oeste","corto",$id , $cv_principal, "numeros");?></td>
                                   	<td width="203" colspan="2">&nbsp;</td>
                        		</tr>
                                <tr >
                                   <td>Coordenadas del extremo este:</td>
                                   <td><?php // global $id;genera("c_este","corto",$id , $cv_principal, "numeros");?></td>
                                   <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr >
                                   <td>Coordenadas del extremo norte:</td>
                                   <td><?php // global $id;genera("c_norte","corto",$id , $cv_principal, "numeros");?></td>
                                   <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr >
                                   <td>Coordenadas del extremo sur:</td>
                                   <td><?php // global $id;genera("c_sur","corto",$id , $cv_principal, "numeros");?></td>
                                   <td colspan="2">&nbsp;</td>
                                </tr>
                           </table>
                    </form>
                </div>
             </div>
             <div id="div3"  class="element">
             	<div id="contenido">
                    <form name="datos" method="POST" >
                        <input type = "submit" value = "Guardar"  id="restricciones" onclick = "this.form.action = 'guardar.php?hoja=restricciones&id=<?php echo $id;?>&cv_principal=<?php echo $cv_principal;?>'"/>
							<table width="869">
                            	<tr>
                                	<td>&nbsp;</td>
                                    <td>&nbsp;</td>
                            	</tr>
                                <tr>
                                   	<td colspan="2"><h3>Restricciones</h3></td>
                                </tr>
                                <tr>
                                   	<td width="107">Acceso:</td>
                                   	<td><?php  	$tooltipAcces = "Restricciones y prerrequisitos legales del acceso al dato";
                                          		global $id;genera("c_acceso","extenso",$id , $cv_principal , "txt" , $tooltipAcces);?></td>
                                </tr>
                                <tr>
                                   	<td>Uso:</td>
                                   	<td><?php 	$tooltipUso = "Restricciones y prerrequisitos legales del uso del dato";
                                          		global $id;genera("c_uso","extenso",$id , $cv_principal , "txt" , $tooltipUso);?></td>
                                </tr>
                                <tr>
                                  <td>Observaciones:</td>
                                  <td><?php $tooltipObser = "";
                                        	global $id;genera("c_observaciones","100px",$id , $cv_principal , "txtarea" , $tooltipObser);?></td>
                                </tr>
                           	</table>
                    </form>
                </div>
             </div>
             <div id="div4"  class="element">
             	<div id="contenido">
                    <form name="datos" method="POST" >
                        <input type = "submit" value = "Guardar"  id="palabrasClave" onclick = "this.form.action = 'guardar.php?hoja=palabrasClave&id=<?php echo $id;?>&cv_principal=<?php echo $cv_principal;?>'"/>
							 <table width="869">
                                 <tr >
                                   	<td width="107">&nbsp;</td>
                                    <td width="750">&nbsp;</td>
                        		</tr>
                                <tr valign="top">
                                   <td><h3>Temas:</h3>	</td>
                                   <td><?php  global $id;  tabla("m_Palabra_Clave","100px",$id , $cv_principal,"Temas",""); ?></td>
                                </tr>
                                <tr valign="top">
                                  <td><h3>Sitios:</h3></td>
                                  <td><?php  global $id;  tabla("s_Sitios_Clave","100px",$id , $cv_principal,"Sitios",""); ?></td>
                                </tr>
                           </table>
                           
                    </form>
                </div>
             </div> 
             <div id="div5"  class="element">
             	<div id="contenido">
                    <form name="datos" method="POST" >
                        <input type = "submit" value = "Guardar"  id="ambienteDeTrabajo" onclick = "this.form.action = 'guardar.php?hoja=ambienteDeTrabajo&id=<?php echo $id;?>&cv_principal=<?php echo $cv_principal;?>'"/>
							<table width="869">
                            	<tr >
                                   	<td width="200">&nbsp;</td>
                                    <td width="657">&nbsp;</td>
                        		</tr>
                                <tr >
                                   <td>Software y hardware:</td>
                                   <td><?php 	$tooltipSoft = "Programa de cómputo utilizado, incluyendo versión y equipo para elaboración del dato geoespacial";
                                        		global $id;  genera("c_software_hardware","extenso",$id , $cv_principal, "txt" , $tooltipSoft);  ?></td>
                                 </tr>
                                 <tr >
                                   <td>Sistema operativo:</td>
                                   <td><?php 	$tooltipSiste = "Nombre y versión del sistema operativo instalado en el equipo de cómputo empleado"; 
                                          		global $id;  genera("c_sistema_operativo","extenso",$id , $cv_principal, "txt" , $tooltipSiste); ?></td>
                                 </tr>
                                 <tr >
                                   <td>Requisitos t&eacute;cnicos:</td>
                                   <td><?php 	$tooltipRequis = "Especificaciones de software y hardware requerido para utilizar el dato, si es necesario"; 
                                          		global $id;  genera("c_tecnicos","extenso",$id , $cv_principal, "txt" , $tooltipRequis);  ?></td>
                                 </tr>
                                 <tr >
                                   <td>Ruta y nombre de archivo:</td>
                                   <td><?php 	$tooltipRuta = ""; 
                                          		global $id;  genera("c_path","extenso",$id , $cv_principal, "txt", $tooltipRuta);  ?></td>
                                 </tr>
                           	</table>
                    </form>
                </div>
             </div>

             <div id="div12"  class="element">

                <div id="contenido">











                    <form name="datos" method="POST" >
                        <input type = "submit" value = "Guardar"  id="RegistroColaborador" onclick = "this.form.action = 'guardar.php?hoja=RegistroColaborador&id=<?php echo $id;?>&cv_principal=<?php echo $cv_principal;?>'"/>
							<table width="869">
                            	<tr >
                                   	<td width="200">&nbsp;</td>
                                    <td width="657">&nbsp;</td>
                        		</tr>
                                <tr >
                                   <td>Nombre</td>
                                   <td><input id="nombreColaborador" type="text" name="nombreCapturista" class="extenso"/>
</td>
                                 </tr>
                                <tr><td>Puesto</td>
                                    <td><select id="puestoColaborador" name="puestoCapturista">
                                 <?php if ($puesto == "Administrador de Metadatos") {echo 
                                 '<option value="Administrador de Metadatos">Administrador</option>
                                 <option value="capturista">Capturista</option>
                                 <option value="analista">Analista</option>';} 
                                       if ($puesto == "analista") {echo 
                                 '<option value="capturista">Capturista</option>';} ?>
                                    </select></td>
                                </tr>
 



                                <tr >
                                   <td>Login</td>
                                   <td><input id="userColaborador" type="text" name="userCapturista" class="extenso" />
</td>
                                 </tr>
                                 <tr >
                                   <td>Password</td>
                                   <td><input id="passColaborador" type="text" name="passCapturista" class="extenso" />
</td>
                                 </tr>
                                 <tr >
                                   <td>Correo</td>       <td><input id="correoColaborador" type="text" name="correoCapturista" class="extenso" />

</td>
                                 </tr>
                                <tr >
                                   <td>Tel&eacute;fono</td>
                                   <td><input type="text" name="telCapturista" class="extenso" />
</td>
                                 </tr>
                                <tr><td>Activo</td>
                                    <td><select name="activoCapturista">
                                    <option value="1">1</option>
                                    <option value="0">0</option>
                                    </select></td>
                                </tr>
                          	</table>
                    </form>
</div>
</div>


             <div id="div13"  class="element">

                <div id="contenido">

                    <form name="datos" method="POST" >
                        <input type = "submit" value = "Guardar"  id="aprobarMetadato" onclick = "this.form.action = 'guardar.php?hoja=aprobarMetadato&id=<?php echo $id;?>&cv_principal=<?php echo $cv_principal;?>'"/>
							<table width="869">
                            	<tr >
                                   	<td width="200">&nbsp;</td>
                                    <td width="657">&nbsp;</td>
                        		</tr>
                                <tr >
                                   <td>Responsable:</td>
                                   <td><?php echo $nombreUsuario; ?></td>
                                 </tr>
                                <tr><td>Puesto:</td>
                                   <td><?php echo $puesto;?></td>
                                </tr>

                                <tr><td>Fecha:</td>
                                   <td><?php $time = time(); echo date("d-m-Y (H:i:s)", $time); ?></td>
                                </tr>

                                <tr><td>Aprobar metadato:</td>
                                    <td><select name="activoCapturista">
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                    </select></td>
                                </tr>
                          	</table>
                    </form>
</div>
</div>

             <div id="div14"  class="element">

                <div id="contenido">

<div id="nameOfFile">
                                      <form>                                                  
                                       <p class="txtN1">Adjunta tu archivo: <?php echo $nameFileSession;?>.zip</p>
                                       </form>
                                      
  <form class="formulario_modulo_cbm" id="formulario_modulo_cbm" action="modulo_cbm.php"  method="post" enctype="multipart/form-data">
    <input id="boton_buscar" type="file" name="nameOfFile" accept=".zip" onclick="habilitar()">
	<input type="submit" id="boton_subir" name="boton_subir" value="Subir" access="application/zip" onclick="alert('Espera por favor, comienza la carga del archivo a los servidores de la CONABIO. En seguida coemnzará el proceso de configuración del shapefile. Proceso: 1/6')" disabled="true"  ;>                                       






<div style="padding:20px">	
  <div class="progreso">
    <div class="barra"></div >
    <div class="percentage">0%</div>
  </div>
  
  <div id="status_bar"></div>

</div>	

                                       
</div>
                                
<script src="jquery.form.js"></script>
                                       
<script>
(function() 
{
    
    var bar = $('.barra');
    var percent = $('.percentage');
    var status = $('#status_bar');
       
    $('.formulario_modulo_cbm').ajaxForm({
        beforeSend: function() {
            status.empty();
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal);
            percent.html(percentVal);
            // console.log(percentVal, position, total);
        },
        success: function() {
            var percentVal = '100%';
            bar.width(percentVal);
            percent.html(percentVal);
            var avance = percent.html(percentVal);
		
        },
        complete: function(xhr) {
            status.html(xhr.responseText);
//	mostrar(); //función que muestra el botón "Mostrar" en la visualización del mapa
        }
    }); 
})();       
</script>
  </form>

                                      <form>                                                  
<input id='NoOculto' style='display:block; margin-left:auto; margin-right:auto; width:270px;'  type="button" value="Mostrar Previsualización" disabled="true"> 
                                       </form>


<div id="map" class="map" ></div>
<script type="text/javascript">


var nombreDeCapa = '<?php echo $nameFileSession;?>';

if(nombreDeCapa){
    document.getElementById('NoOculto').disabled = false;
    document.getElementById('boton_buscar').disabled = false;
}


var layers = new ol.layer.Tile({
source: new ol.source.TileWMS({
url: 'http://ssig.conabio.gob.mx:2900/capas_cbm'+'/myworkspace/wms',
params: {'LAYERS': nombreDeCapa},

})});

var raster = new ol.layer.Tile({
source: new ol.source.OSM()
});

var map = new ol.Map({
layers: [raster, layers],
target: 'map',
controls:[],
view: new ol.View({
center: ol.proj.fromLonLat([-94.17,19.24]), 
zoom: 3
})
});


//Añadimos un control de zoom

//map.addControl(new ol.control.ZoomSlider()); 
//map.addControl(new ol.control.MousePosition({ numDigits: 2 }));
map.addControl(new ol.control.ScaleLine());


document.getElementById('NoOculto').onclick = function() { //Esta función hace que aparezca en cuanto se presiona el bótón. Se tiene que hacer así, sino no se ve el mapa
map.updateSize();
map.render();
map.renderSync();
}



</script>



</div>
</div>

<!------------------------------Abre zona de Generar plantilla     --------------------->

             <div id="div15"  class="element">

                <div id="contenido">

                    <form name="datos" method="POST" >
                        <input type = "submit" value = "Generar Plantilla"  id="RegistroColaborador" onclick = "this.form.action = 'guardar.php?hoja=RegistroColaborador&id=<?php echo $id;?>&cv_principal=<?php echo $cv_principal;?>'"/>
							<table width="869">
                            	<tr >
                                   	<td width="200">&nbsp;</td>
                                    <td width="657">&nbsp;</td>
                                                       <tr><td>Nombre de proyecto</td>
                                   <td><select id="nombreProy" name="nombreProy">
                                 <option value="jm022">jm022</option>
                                 <option value="jm053">jm053</option>
                                 <option value="jm023">jm023</option>
                                 <option value="jm024">jm024</option>
                                 <option value="jm025">jm025</option>
                                 <option value="jm026">jm026</option>
                                 <option value="jm027">jm027</option>
                                 <option value="jm028">jm028</option>
                                 <option value="jm029">jm029</option>
                                    </select></td>
                                </tr>
                                                       <tr><td>Tipo de proyecto</td>
                                   <td><select id="tipoProy" name="tipoProy">
                                 <option value="dist">Distribución</option>
                                 <option value="sitios">Sitios de recolecta</option>
                                </tr>
                                                       <tr><td>Software</td>
                                   <td><select id="software" name="software">
                                 <option value="arc">ArcGis</option>
                                 <option value="quantum">QuantumGis</option>
                                </tr>
 
                          	</table>
                    </form>
<!--
<div id="nameOfFile">
                                      <form>                                                  
                                       <p class="txtN1">Generar plantilla <?php echo $nameFileSession;?>.jpg</p>
                                       </form>
                                      
  <form class="formulario_plantilla" id="formulario_plantilla" action="plantilla.php"  method="post" enctype="multipart/form-data">
	<input type="submit" id="boton_generar" name="boton_generar" value="Generar">                                       
  </form>

</div> 
-->

</div>
</div>

<!------------------------------Cierra zona de Generar plantilla    ---------------------->
             <div id="div6"  class="element">
             	<div id="contenido">
                    <form name="datos" method="POST" >
                        <input type = "submit" value = "Guardar"  id="calidadDeDatos" onclick = "this.form.action = 'guardar.php?hoja=calidadDeDatos&id=<?php echo $id;?>&cv_principal=<?php echo $cv_principal;?>'"/>
							<table width="869">
                            	<tr >
                                   	<td width="230">&nbsp;</td>
                                    <td width="627">&nbsp;</td>
                        		</tr>
                                <tr valign="top">
                                   	<td>Metodolog&iacute;a:</td>
                                   	<td><?php  	$tooltipMetodo = "Tipo de investigación según el lugar de aplicación para obtener o generar los datos";
                                          		global $id;  genera("c_metodologia","extenso",$id , $cv_principal, "txt" , $tooltipMetodo); ?></td>
                                 </tr>
                                 <tr valign="top">
                                   	<td>Descripci&oacute;n de la metodolog&iacute;a:</td>
                                   	<td><?php  	$tooltipDescMet = "Se describe, de manera general, el o los métodos empleados en el proceso de elaboración del dato ";
                                          		global $id;  genera("c_descrip_metodologia","95px",$id , $cv_principal, "txtarea", $tooltipDescMet);  ?></td>
                                 </tr>
                                 <tr valign="top">
                                   	<td>Descripci&oacute;n del proceso:</td>
                                   	<td><?php  	$tooltipDescProc ="Describe ampliamente cómo se hizo el dato, explicando lo realizado en cada uno de los métodos empleados";
                                          		global $id;  genera("c_descrip_proceso","90px",$id , $cv_principal, "txtarea" , $tooltipDescProc);?></td>
                                 </tr>
                                 <tr >
                                   	<td colspan="2"><h3>Referencia de los datos originales</h3></td>
                                 </tr>
                           	</table>
                            <?php   global $id;  tabla_d("corto",$id , $cv_principal, "Datos" ); ?>
                	</form>
               	</div>
             </div>
             <div id="div7"  class="element">
             	<div id="contenido">
                    <form name="datos" method="POST" >
                        <input type = "submit" value = "Guardar"  id="taxonomia" onclick = "this.form.action = 'guardar.php?hoja=taxonomia&id=<?php echo $id;?>&cv_principal=<?php echo $cv_principal;?>'"/>
							<table width="869">
                            	<tr >
                                   	<td width="230">&nbsp;</td>
                                    <td width="627">&nbsp;</td>
                        		</tr>
                                 <tr >
                                   	<td colspan="2"><h3>TAXONOM&Iacute;A:</h3></td>
                                 </tr>
                                 <tr >
                                   	<td width="230"></td>
                                    <td width="627">&nbsp;</td>
                        		</tr>
                           	</table>
                            
                            <?php  global $id;  tabla_t("extenso","corto",$id , $cv_principal, "Taxonom&iacute;a"); ?>
                            
                	</form>
               	</div>
             </div>
             <div id="div8"  class="element">
             	<div id="contenido">
                    <form name="datos" method="POST" >
                        <input type = "submit" value = "Guardar"  id="estructuraRaster" onclick = "this.form.action = 'guardar.php?hoja=estructuraRaster&id=<?php echo $id;?>&cv_principal=<?php echo $cv_principal;?>'"/>
							<table width="869">
                            	<tr>
                                	<td>&nbsp;</td>
                                    <td width="697">&nbsp;</td>
   								</tr>
                                <tr>
                                   	<td colspan="2"><h3>Informaci&oacute;n espacial: </h3> </td>
                                </tr>
                                <tr>
                                   	<td width="160">Estructura del dato:</td>
                               	  <td><?php  // global $id;  genera("c_estructura_dato","extenso",$id , $cv_principal, "txt"); ?></td>
                                </tr>
                                <tr>
                                   	<td>Tipo del dato:</td>
                                   	<td><?php  // global $id;  genera("c_tipo_dato","extenso",$id , $cv_principal, "txt"); ?></td>
                                </tr>
                                <tr>
                                  <td>N&uacute;mero total del dato:</td>
                                  <td><?php  // global $id;  genera("c_total_datos","extenso",$id , $cv_principal, "numeros"); ?></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><h3>Si la estructura es raster : </h3></td>
                                </tr>
                           	</table>
                            <table width="962" border="10">
                            	<tr>
                                  	<td width="150"><p>N&uacute;mero de renglones:</p></td>
                                  	<td width="150"><p>N&uacute;mero de columnas:</p></td>
                                  	<td width="150"><p>Tama&ntilde;o del pixel de X en metros:</p></td>
                                  	<td width="150"><p>Tama&ntilde;o del pixel de Y en metros:</p></td>
                                  	<td width="150"><p>Coordenada X del origen del raster:</p></td>
                                  	<td width="154"><p>Coordenada Y del origen del raster:</p></td>
                                </tr>
                                <tr>
                                  	<td align="center"><p><?php   // global $id;  genera("r_nun_renglones","15px",$id , $cv_principal, "numeros"); ?>	</p></td>
                                  	<td align="center"><p><?php   // global $id;  genera("r_num_columnas","15px",$id , $cv_principal, "numeros"); ?>		</p></td>
                                  	<td align="center"><p><?php   // global $id;  genera("r_pixel_X","15px",$id , $cv_principal, "numeros"); ?>			</p></td>
                                  	<td align="center"><p><?php   // global $id;  genera("r_pixel_Y","15px",$id , $cv_principal, "numeros"); ?>       	</p></td>
                                  	<td align="center"><p><?php   // global $id;  genera("r_COOR_X","15px",$id , $cv_principal, "numeros"); ?>        	</p></td>
                                  	<td align="center"><p><?php   // global $id;  genera("r_COOR_Y","15px",$id , $cv_principal, "numeros"); ?>        	</p></td>
                                </tr>	
                            </table>	
                    </form>
                </div>
             </div>
 <div id="div9"  class="element">
             		<div id="contenido">
                    <form name="datos" method="POST" class="formulario">
                        <input type = "submit" value = "Guardar"  id="proyeccion" onclick = "this.form.action = 'guardar.php?hoja=proyeccion&id=<?php echo $id;?>&cv_principal=<?php echo $cv_principal;?>'"/>
<table width="867" border="0">
  <tr>
    <td ><input type="button" value="Descargar ejecutable" id="descarga"/></td>
    <td colspan="2" ><input name="userfile" type="file" class="box" id="userfile" /></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" ><h3>Información espacial:</h3></td>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr  valign="top">
    <td width="237">Estructura del dato:</td>
    <td width="272"><?php  $tooltipEstruc ="Se especifica la estructura del dato geoespacial (Vector o Raster).";
								  			  global $id;  genera("c_estructura_dato","extenso",$id , $cv_principal, "txt",$tooltipEstruc); ?></td>
    <td width="145">Archivos shp</td>
    <td width="195"><select name="selectVector" id="selectVector">
      <option value="">Seleccione un archivo</option>
    </select></td>
  </tr>
  <tr valign="top">
    <td>Tipo del dato:</td>
    <td><?php  	$tooltipDato = "Representado por: puntos, líneas y polígonos (si la estructura es vectorial); y píxel (si la estructura es raster).";
												 global $id;  genera("c_tipo_dato","extenso",$id , $cv_principal, "txt", $tooltipDato); ?></td>
    <td>Archivos raster</td>
    <td><select name="selectTif" id="selectTif">
      <option value="">Seleccione un archivo</option>
    </select></td>
  </tr>
  <tr valign="top">
    <td>N&uacute;mero total del dato:</td>
    <td><?php  	$tooltiNumpDato = "Total de elementos si es vectorial, y si es raster se debe multiplicar las columnas por renglones.";
								  				 global $id;  genera("c_total_datos","extenso",$id , $cv_principal, "numeros", $tooltiNumpDato); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" >&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" ><h3>Coordenadas del extremo:</h3></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="237">Coordenadas del extremo oeste:</td>
    <td width="272"><?php 	$tooltipOeste="";
															 global $id;genera("c_oeste","corto",$id , $cv_principal, "numeros", $tooltipOeste);?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Coordenadas del extremo este:</td>
    <td><?php 	$tooltipEste = "";
								   				 global $id;genera("c_este","corto",$id , $cv_principal, "numeros", $tooltipEste);?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Coordenadas del extremo norte:</td>
    <td><?php	$tooltipNorte="";
								   				 global $id;genera("c_norte","corto",$id , $cv_principal, "numeros", $tooltipNorte);?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Coordenadas del extremo sur:</td>
    <td><?php 	$tooltipSur="";
								   				 global $id;genera("c_sur","corto",$id , $cv_principal, "numeros", $tooltipSur);?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" ><h3>Proyecci&oacute;n cartogr&aacute;fica:</h3></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Datum horizontal:</td>
    <td><?php   global $id;  genera("c_datum","30px",$id , $cv_principal , "txt",  ""); ?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Nombre del elipsoide:</td>
    <td><?php   global $id;  genera("c_elipsoide","30px",$id , $cv_principal , "txt",  ""); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Proyecci&oacute;n cartogr&aacute;fica</td>
    <td><?php   global $id;  genera("c_id_proyeccion","10px",$id , $cv_principal, "txt",  ""); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td>&Aacute;rea geogr&aacute;fica:</td>
    <td colspan="3"><?php 	$tooltipGeografica = "Descripción textual breve de la distribución geográfica del dato geoespacial";
															 global $id;  genera("c_area_geo","100px",$id , $cv_principal , "txtarea", $tooltipGeografica); ?></td>
  </tr>
  <tr>
    <td colspan="2" >&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" ><h3>Si la estructura es raster :</h3></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>N&uacute;mero de renglones:</td>
    <td><?php  global $id;  genera("r_nun_renglones","13px",$id , $cv_principal, "numeros",""); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>N&uacute;mero de columnas:</td>
    <td><?php  global $id;  genera("r_num_columnas","13px",$id , $cv_principal, "numeros",""); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Tama&ntilde;o del pixel de X en metros:</td>
    <td><?php  global $id;  genera("r_pixel_X","15px",$id , $cv_principal, "numeros",""); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Tama&ntilde;o del pixel de Y en metros:</td>
    <td><?php  global $id;  genera("r_pixel_Y","13px",$id , $cv_principal, "numeros",""); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Coordenada X del origen del raster:</td>
    <td><?php  global $id;  genera("r_COOR_X","13px",$id , $cv_principal, "numeros",""); ?>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Coordenada Y del origen del raster:</td>
    <td><?php  global $id;  genera("r_COOR_Y","13px",$id , $cv_principal, "numeros",""); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

</table>
         
                    </form>
                </div>
             </div>
             <div id="div10" class="element">
             	<div id="contenido">
                    <form name="datos" method="POST" >
                        <input type = "submit" value = "Guardar"  id="atributos" onclick = "this.form.action = 'guardar.php?hoja=atributos&id=<?php echo $id;?>&cv_principal=<?php echo $cv_principal;?>'"/>
							<table width="869" border="0">
                            	<tr>
                                	<td>&nbsp;</td>
                                	<td>&nbsp;</td>
                               	</tr>
                              	<tr valign="top">
                                	<td width="241">Nombre de la entidad (tabla):</td>
                                	<td width="618"><?php  	$tooltipNomEnti = "Nombre del archivo que contiene los atributos del dato geoespacial";
                                                    		global $id;  genera("c_tabla","extenso",$id , $cv_principal , "txt" , $tooltipNomEnti); ?> </td>
                              	</tr>
                              	<tr valign="top">
                                	<td>Descripci&oacute;n de la entidad (tabla):</td>
                                	<td><?php  	$tooltipDescEnti="Descripción breve del contenido de la tabla del dato geoespacial";
                                        		global $id;  genera("c_descrip_tabla","80px",$id , $cv_principal , "txtarea" , $tooltipDescEnti);  ?></td>
                              	</tr>
                                <tr>
                                	<td colspan="2"><h3>Atributos</h3></td>
                                </tr>
                           </table>
                           <table width="1249" border="1">
                           		<tr>
                                    <td width="350" align="center">Nombre:</td>
                                    <td width="395" align="center">Descripci&oacute;n:</td>
                                    <td width="200" align="center">Fuente:</td>
                                    <td width="150" align="center">Unidades de medida:</td>
                                    <td width="120" align="center">Tipo de dato:</td>
                          		</tr>
                          </table>
                          <?php  global $id;  tabla_a("extenso",$id , $cv_principal, "Atributos" ); ?>
                    </form>
                </div>
             </div>
             <div id="div11" class="element">
             	<div id="contenido">
                    <form name="datos" method="POST" >
                        <input type = "submit" value = "Guardar"  id="arbol" onclick = "this.form.action = 'guardar.php?hoja=arbol&id=<?php echo $id;?>&cv_principal=<?php echo $cv_principal;?>'"/>
                        <br />
							 <table width="869" border="0">
                            	<tr>
                                	<td>&nbsp;</td>
                                	<td colspan="2">&nbsp;</td>
                               	</tr>
                              	<tr>
                                	<td width="118"><h3>Clasificaci&oacute;n</h3></td>
                                	<td width="657"><input type="text" name="c_clasif_ruta" class="extenso" /></td>
                              	    <td width="80"><?php  global $id;  genera("c_clasificacion","corto",$id , $cv_principal , "txt",""); ?></td>
                              	</tr>
                              	<tr>
                                	<td>&nbsp;</td>
                                	<td colspan="2">&nbsp;</td>
                              	</tr>
                                <tr>
                                	<td colspan="3">&nbsp;</td>
                                </tr>
                           </table>
						   <p><?php  crea_arbol($id , $cv_principal); ?> </p>      
                    </form>
                </div>
             </div>
             
             <div id="dialog_nuevo"  title="Crear nuevo Metadato">
                <p class="validateTips">T&iacute;tulo del mapa:</p>
                <form name="nuevo" method="post" action="nuevo.php" id="formNuevo">
                        <input type="text" name="name" id="name" class="text  ui-corner-all" />
                        <input type="hidden" name="cv_principal" id="cv_principal" value="<?php echo $cv_principal;?>"/>
                        <input type="hidden"  name="id_general" id="id_general" value="<?php echo $id;?>"/>
                </form>
            </div>

            <div id="dialog_duplica"  title="Duplicar Metadato">
                <p class="validateTips">T&iacute;tulo del mapa:</p>
                <form name="duplica" method="post" action="duplica.php" id="formDuplica">
                        <input type="text" name="nameDuplica" id="nameDuplica" class="text  ui-corner-all" />
                        <input type="hidden" name="cv_principal" id="cv_principal" value="<?php echo $cv_principal;?>"/>
                        <input type="hidden"  name="id_general" id="id_general" value="<?php echo $id;?>"/>
                </form>
            </div>



            <div id="dialog_borrar"  title="Borrar Metadato">
                <p class="validateTips">¿Est&aacute; seguro de borrar el metadato: <?php echo $nameFileSession;?>?</p>
                <form name="delete_metadato" method="post" action="borrar.php" id="formBorrar">
                        <input type="hidden" name="cv_principal" id="cv_principal" value="<?php echo $cv_principal;?>"/>
                        <input type="hidden"  name="id_general" id="id_general" value="<?php echo $id;?>"/>
                </form>
            </div>


            <div id="cerrar_sesion"  title="Finalizar Sesión">
                <form name="terminoSesion" method="post" action="PHP/cerrarSesion.php" id="formTerminoSesion">
                        <img src="CSS/images/alert.png" class="alert"  /><p class="validateTips cerrarsesion">Guardar su informaci&oacute;n antes de salir</p>
                </form>
            </div>

            <div id="dialog_zip"  title="ZIP">
                        
                      <p class="validateTips">Recuerde que antes de adjuntar su zip debe de asegurarse que toda la informaci&oacute;n es correcta. Revise si los pol&iacute;gonos deben de cerrar correctametne.</p>
                          
            </div>                          
            
        </div> <!--FIN <div id="rg">-->
        
 <?php 
 		pg_close($db);
 }	
 
 ?>
</body>
</html>








