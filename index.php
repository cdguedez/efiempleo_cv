<?php

$path = preg_replace('/wp-content.*$/','',__DIR__);
require_once($path.'wp-load.php');
if (!current_user_can('manage_options')) {
    exit();
}
require_once(scriptURI.'Models/Usermeta.php');
require_once(scriptURI.'Controllers/ReadCsv.php');
require_once(scriptURI.'Controllers/PostResume.php');
use Models\Usermeta;
use Controllers\ReadCsv;
use Controllers\PostResume;

// //instanciacion de clases
$user = new Usermeta();
$csv = new ReadCsv();
$post =new PostResume();
$jsonusermeta = $user->wpdbquery();

// array Csv para cargar el post
$csv = $csv->getCsv(scriptURI.'data-test.csv');
$arraycsv = $csv['csv'];
$typepost = "resume";
for($i=0;$i<count($jsonusermeta);$i++) {
    for($a=0;$a<count($arraycsv);$a++) {
        if($arraycsv[$a][2] == $jsonusermeta[$i]->user_email) {
            //concatenamos el contenido del post
            $contentresume = "<h3>Editando tu curriculum, podras añadir la descripcion de tu perfil profesional</h3><br/><p>Para ello dirigete a tu pagina de usuario y edita este curriculum.</p>";
            $postname = $arraycsv[$a][0]."_".$arraycsv[$a][1];
            $candidatename = ucwords($jsonusermeta[$i]->display_name);
            $dataeduone = $post->verifyedu('Bachiller',$arraycsv[$a][6],$arraycsv[$a][7],$arraycsv[$a][8],$arraycsv[$a][9],$arraycsv[$a][10]);
            $dataedutwo = $post->verifyedu('Técnico Profesional',$arraycsv[$a][11],$arraycsv[$a][12],$arraycsv[$a][13],$arraycsv[$a][14],$arraycsv[$a][15]);
            $dataeduthree = $post->verifyedu('Profesional',$arraycsv[$a][16],$arraycsv[$a][17],$arraycsv[$a][18],$arraycsv[$a][19],$arraycsv[$a][20]);
            $dataexpone = $post->verifyexp($arraycsv[$a][21],$arraycsv[$a][22],$arraycsv[$a][23],$arraycsv[$a][24],$arraycsv[$a][25]);
            $dataexptwo = $post->verifyexp($arraycsv[$a][26],$arraycsv[$a][27],$arraycsv[$a][28],$arraycsv[$a][29],$arraycsv[$a][30]);
            //array de datos para el postmeta
            $metaedu = $post->arraymeta([$dataeduone, $dataedutwo, $dataeduthree]);
            print_r($metaedu); exit;
            $metaarray = [
                '_featured'                 => 0,
                //'_resume_name_prefix'       => '',
                '_public_submission'        => 1,
                '_applying_for_job_id'      => 0,
                '_candidate_name'           => $candidatename,
                '_resume_content'           => 'Edita tu perfil profesional',
                '_candidate_education'      => array($dataeduone,$dataedutwo,$dataeduthree),
                '_candidate_experience'     => array($dataexpone, $dataexptwo),
                '_candidate_skill'          => '',
                '_job_listing_languaje'     => ['Español'],
                '_candidate_province'       => $arraycsv[0][5],
                '_candidate_country'        => $arraycsv[0][4],
                '_candidate_phone'          => $arraycsv[0][3],
                '_resume_expires'           => '',
            ];
            $post->post_insert($jsonusermeta[$i]->user_id,$postname,$candidatename,$contentresume, $typepost, $metaarray);
            exit;
        }
    }
}