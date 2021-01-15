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
            //array de datos para el postmeta
            $metaarray = [
                '_featured'                 => 0,
                //'_resume_name_prefix'       => '',
                '_public_submission'        => 1,
                '_applying_for_job_id'      => 0,
                '_candidate_name'           => $candidatename,
                '_resume_content'           => 'Edita tu perfil profesional',
                '_candidate_education'      => array(['levelAcademic' => 'Bachiller',
                                                    'location'      => $arraycsv[$a][6],
                                                    'qualification' => $arraycsv[$a][7],
                                                    'dateStart'     => $arraycsv[$a][8],
                                                    'dateEnd'       => $arraycsv[$a][9],
                                                    'notes'         => $arraycsv[$a][10]
                                                    ],
                                                    ['levelAcademic' => 'Técnico Profesional',
                                                    'location'      => $arraycsv[$a][11],
                                                    'qualification' => $arraycsv[$a][12],
                                                    'dateStart'     => $arraycsv[$a][13],
                                                    'dateEnd'       => $arraycsv[$a][14],
                                                    'notes'         => $arraycsv[$a][15]
                                                    ],
                                                    ['levelAcademic' => 'Profesional',
                                                    'location'      => $arraycsv[$a][16],
                                                    'qualification' => $arraycsv[$a][17],
                                                    'dateStart'     => $arraycsv[$a][18],
                                                    'dateEnd'       => $arraycsv[$a][19],
                                                    'notes'         => $arraycsv[$a][20]
                                                    ],
                ),
                '_candidate_experience'     => array(['employer'    => $arraycsv[$a][21],
                                                    'job_title'     => $arraycsv[$a][22],
                                                    'dateStart'     => $arraycsv[$a][23],
                                                    'dateEnd'       => $arraycsv[$a][24],
                                                    'notes'         => $arraycsv[$a][25]
                                                    ],
                                                    ['employer'     => $arraycsv[$a][26],
                                                    'job_title'     => $arraycsv[$a][27],
                                                    'dateStart'     => $arraycsv[$a][28],
                                                    'dateEnd'       => $arraycsv[$a][29],
                                                    'notes'         => $arraycsv[$a][30]
                                                    ]
                ),
                '_candidate_skill'          => '',
                '_job_listing_languaje'     => ['Español'],
                '_candidate_province'       => $arraycsv[0][5],
                '_candidate_country'        => $arraycsv[0][4],
                '_candidate_phone'          => $arraycsv[0][3],
                '_resume_expires'           => '',
            ];
            $post->post_insert($jsonusermeta[$i]->user_id,$postname,$candidatename,$contentresume, $typepost, $metaarray);
        }
    }
}