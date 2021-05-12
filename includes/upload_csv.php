<?php

use Controllers\ReadCsv;
use Controllers\PostResume;
$path = preg_replace('/wp-content.*$/','',__DIR__);
require_once($path.'wp-load.php');
require_once(EFI_CV_PATH.'Controllers/ReadCsv.php');
require_once(EFI_CV_PATH.'Controllers/PostResume.php');
// Movemos el csv a un archivo temporal para manejar los datos
$tmpcsv = EFI_UPLOADS_TMP.'uploadsCV.csv';
move_uploaded_file($_FILES['dataCsv']['tmp_name'], $tmpcsv);
$users = get_users(array('role' => 'candidate'));

if(file_exists($tmpcsv)) {
    global $wpdb;
    $csv = new ReadCsv();
    $post = new PostResume();
    $csv = $csv->getCsv($tmpcsv);
    $arraycsv = $csv['csv'];
    $save = 0;      // Contador de usuarios a los que se le creo un CV
    $contcsv = 0;   // Contador de registros recorridos desde el CSV
    $contexist = 0; // Contador de usuarios que ya tienen un CV cargado en sistema
    $post_type = 'resume';
    foreach($arraycsv as $row) {
        $contcsv++;
        foreach($users as $user) {
            if($row[2] == $user->user_email) {
                $post_exist = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = $user->ID AND post_status = 'publish' AND post_type = '$post_type'");
                if($post_exist == 0) {
                    $contentresume = "<h3>Editando tu curriculum, podras añadir la descripcion de tu perfil profesional</h3><br/><p>Para ello dirigete a tu pagina de usuario y edita este curriculum.</p>";
                    $postname = $row[0]."_".$row[1];
                    $candidatename = ucwords(strtolower($user->display_name));
                    $dataeduone = $post->verifyedu('Bachiller',$row[6],$row[7],$row[8],$row[9],$row[10]);
                    $dataedutwo = $post->verifyedu('Técnico Profesional',$row[11],$row[12],$row[13],$row[14],$row[15]);
                    $dataeduthree = $post->verifyedu('Profesional',$row[16],$row[17],$row[18],$row[19],$row[20]);
                    $dataexpone = $post->verifyexp($row[21],$row[22],$row[23],$row[24],$row[25]);
                    $dataexptwo = $post->verifyexp($row[26],$row[27],$row[28],$row[29],$row[30]);
                    //array de datos para el postmeta
                    $metaedu = $post->arraymeta([$dataeduone, $dataedutwo, $dataeduthree]);
                    $metaexp = $post->arraymeta([$dataexpone, $dataexptwo]);
                    $metaarray = [
                        '_candidate_education'      => $metaedu,
                        '_candidate_experience'     => $metaexp,
                        '_featured'                 => 0,
                        '_public_submission'        => 1,
                        '_applying_for_job_id'      => 0,
                        '_candidate_name'           => $candidatename,
                        '_resume_content'           => 'Edita tu perfil profesional',
                        '_candidate_skill'          => '',
                        '_job_listing_languaje'     => ['Español'],
                        '_candidate_city'           => $row[31],
                        '_candidate_province'       => $row[5],
                        '_candidate_country'        => $row[4],
                        '_candidate_phone'          => $row[3],
                        '_resume_expires'           => '',
                    ];
                    
                    $save = $post->post_insert($user->ID, $postname,$candidatename,$contentresume,$post_type,$metaarray);
                    $save = $save+$save;
                } else {
                    $contexist++;
                }
                break;
            }
        }
    }
    echo $msg = "Total de CV analizados: $contcsv Total CV nuevos: $save Total de usuarios con CV ya en sistema: $contexist";
} else {
    echo $msg = 'Hubo un error al cargar su CSV, intentelo de nuevo';
}
// wp_safe_redirect($_SERVER['HTTP_REFERER']."&message=$msg");