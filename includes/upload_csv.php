<?php

use Controllers\ReadCsv;

$path = preg_replace('/wp-content.*$/','',__DIR__);
require_once($path.'wp-load.php');
require_once(EFI_CV_PATH.'Controllers/ReadCsv.php');
// Movemos el csv a un archivo temporal para manejar los datos
$tmpcsv = EFI_UPLOADS_TMP.'tmpcsv.csv';
move_uploaded_file($_FILES['dataCsv']['tmp_name'], $tmpcsv);

// Obtenemos los usuarios de tipo candidate que existen en la base de datos
$json = new WP_User_Query(array('role'  => 'candidate'));
// var_dump($json->results[0]->data);

if(file_exists($tmpcsv)) {
    $csv = new ReadCsv();
    $arrayCsv = $csv->getCsv($tmpcsv);
    print_r($arrayCsv); exit;
    $msg = 'Se cargo un archivo csv';
    $memory_usage = round(memory_get_usage()/1048576);
} else {
    $memory_usage = round(memory_get_usage()/1048576);
    $msg = 'Hubo un error en el sistema';
}

wp_safe_redirect($_SERVER['HTTP_REFERER']."&message=$msg&memory=$memory_usage");