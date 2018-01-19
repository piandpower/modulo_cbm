<?php

session_start();

$nombreUsuario = $_SESSION['nombreUsuario'];

$tipo_proy = $_POST['tipoProy'];
$nom_proy = $_POST['nombreProy'];
$tipo_soft = $_POST['software'];

//Este script comienza como todo array desde cero, y el ciclo foreach agrega un lugar de mas. Con esto indicar el lugar n quedara en el lugar n+2

$fichero = 'mapTemplate.py';
$dir = date("Y-m-d")."_".date("H:i:s")."_".$fichero;

copy($fichero,$dir);


if ($tipo_proy == dist){

    $lista_shapes = "lista_shapes = os.listdir(r'T:\\\\jm\\\\".$nom_proy."\\\\dist\\\\shp')";
    $layer = "    newlayer1 = arcpy.mapping.Layer(r'T:\\\\jm\\\\".$nom_proy."\\\\dist\\\\'+shapefile+'')";
    $desc = "   desc = arcpy.Describe(r'T:\\\\jm\\\\".$nom_proy."\\\\dist\\\\'+shapefile+'')";
    $simbolo = "        symbologyLayer = (r'J:\\\\USUARIOS\\\\SISTEM\\\\GMAGALLANES\\\\template\\\\base\\\\color_dp.lyr')";




} else {
    $lista_shapes = "lista_shapes = os.listdir(r'T:\\\\jm\\\\".$nom_proy."\\\\sitios\\\\shp')";
    $layer = "    newlayer1 = arcpy.mapping.Layer(r'T:\\\\jm\\\\".$nom_proy."\\\\sitios\\\\'+shapefile+'')";
    $desc = "    desc = arcpy.Describe(r'T:\\\\jm\\\\".$nom_proy."\\\\sitios\\\\'+shapefile+'')";
    $simbolo = "        symbologyLayer = (r'J:\\\\USUARIOS\\\\SISTEM\\\\GMAGALLANES\\\\template\\\\base\\\\color_sr.lyr')";

}

$ln_lista_shapes = 33;
$ln_layer = 207;
$ln_desc = 225;
$ln_simbolo_dp = 245;
$ln_simbolo_sr = 420;




$ln_existImage_dp = 341;
$ln_existImage_sr = 467;
$existImage_dp = "        existImage = os.path.isfile(r'T:\\\\jm\\\\".$nom_proy."\\\\img\\\\'+filename+'.jpg')";
$existImage_sr = "        existImagep = os.path.isfile(r'T:\\\\jm\\\\".$nom_proy."\\\\img\\\\'+filename+'.jpg')";



$contents = file($dir);

$new_contents = array();
foreach ($contents as $key => $value) {
$new_contents[] = $value;


if ($key == $ln_lista_shapes) {
$new_contents[] = $lista_shapes;
}

if ($key == $ln_layer) {
$new_contents[] = $layer;
}


if ($key == $ln_desc) {
$new_contents[] = $desc;
}



if ($key == $ln_simbolo_dp) {
$new_contents[] = $simbolo;
}


if ($key == $ln_simbolo_sr) {
$new_contents[] = $simbolo;
}


if ($key == $ln_existImage_dp) {
$new_contents[] = $existImage_dp;
}


if ($key == $ln_existImage_sr) {
$new_contents[] = $existImage_sr;
}


}

file_put_contents($dir, implode('',$new_contents));

//-----Descarga del archivo

if (is_file($dir)) {
header("Content-Disposition: attachment; filename=\"$dir\"");
readfile($dir);
} else {
die("Error: no se encontró el archivo '$dir'");
}

?>
