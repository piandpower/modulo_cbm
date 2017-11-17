<?php

$fichero = 'mapTemplate.py';
$nuevo_fichero = date("Y-m-d")."_".date("H:i:s")."_".$fichero;

copy($fichero,$nuevo_fichero);

echo $nuevo_fichero;

if ($nuevo_fichero){

$content = file($nuevo_fichero); //Read the file into an array. Line number => line content
foreach($content as $lineNumber => &$lineContent) { //Loop through the array (the "lines")
    if($lineNumber == 5) { //Remember we start at line 0.
        $lineContent .= "Hello World" . PHP_EOL; //Modify the line. (We're adding another line by using PHP_EOL)
    }
}

$allContent = implode("", $content); //Put the array back into one string
file_put_contents($file, $allContent); //Overwrite the file with the new content
}

?>
