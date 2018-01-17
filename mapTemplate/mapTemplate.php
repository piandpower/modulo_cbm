<?php

$tipo_proy = $_POST['tipoProy'];
$nom_proy = $_POST['nombreProy'];
$tipo_soft = $_POST['software'];



//Este script comienza como todo array desde cero, y el ciclo foreach agrega un lugar de mas. Con esto indicar el lugar n quedara en el lugar n+2

$fichero = 'templateArcPy.py';
$dir = date("Y-m-d")."_".date("H:i:s")."_".$fichero;

copy($fichero,$dir);

$lineNumber = 1;
$changeTo = "Todo mundo sabe".$tipo_proy;


$numeroLinea = 6;
$cambiarA = "Nadie Sabe".$nom_proy;

$otraLinea= 8;
$intercambiar = "Everybady knows".$tipo_soft;


$contents = file($dir);

$new_contents = array();
foreach ($contents as $key => $value) {
$new_contents[] = $value;



if ($key == $lineNumber) {
$new_contents[] = $changeTo;
}

if ($key == $numeroLinea) {
$new_contents[] = $cambiarA;
}

if ($key == $otraLinea) {
$new_contents[] = $intercambiar;
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
