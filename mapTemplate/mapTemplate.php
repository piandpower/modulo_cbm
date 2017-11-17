<?php
$fichero = 'mapTemplate.py';
$dir = date("Y-m-d")."_".date("H:i:s")."_".$fichero;

copy($fichero,$dir);

$lineNumber = 3;
$changeTo = "         the changed line\n";

$contents = file($dir);

$new_contents = array();
foreach ($contents as $key => $value) {
$new_contents[] = $value;
if ($key == $lineNumber) {
$new_contents[] = $changeTo;
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
