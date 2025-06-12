<?php

// This is a simplified example, which doesn't cover security of uploaded images.
// This example just demonstrate the logic behind the process.

// files storage folder
$dir = 'images/';

$_FILES['file']['type'] = strtolower($_FILES['file']['type']);

if ($_FILES['file']['type'] == 'image/png'
|| $_FILES['file']['type'] == 'image/jpg'
|| $_FILES['file']['type'] == 'image/gif'
|| $_FILES['file']['type'] == 'image/jpeg'
|| $_FILES['file']['type'] == 'image/pjpeg')
{
    // setting file's mysterious name
    $filename = $_FILES['file']['name'];
  //  $filename=$_FILES['file']['name'];
    $file = $dir.$filename;

    // copying

	move_uploaded_file($_FILES['file']['tmp_name'], $file);

    // displaying file
    $array = array(
        'url' => 'http://www.litos.web-sales.es/assets_back_office/js/plugins/redactor/'. $file
        //'id' => 123
    );
/*
	$json=fopen('files/files.json','w');
	$nueva=array(
				'title'=>$_FILES['file']['name'],
				'name'=>$_FILES['file']['name'],
				'size'=>$_FILES['file']['size'].'Kb'
			);
	fwrite($json, json_encode($nueva));
	
	fclose($json);
	*/
	$fichero = 'files/files.json';
// Abre el fichero para obtener el contenido existente
$actual = file_get_contents($fichero);

$actual=substr($actual,0,-1);

$nuevo="{'title:'".$_FILES['file']['name'].",
				'name:'".$_FILES['file']['name'].",
				'size:'".$_FILES['file']['size']."'Kb'}]";
// Añade una nueva persona al fichero
$actual .= $nuevo;
// Escribe el contenido al fichero
file_put_contents($fichero, $actual);
	
	//echo json_encode($nueva);
    echo stripslashes(json_encode($array));
	
}

?>