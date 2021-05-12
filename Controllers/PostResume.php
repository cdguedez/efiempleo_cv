<?php namespace Controllers;

$path = preg_replace('/wp-content.*$/','',__DIR__);
require_once($path.'wp-load.php');
if (!current_user_can('manage_options')) {
    exit();
}

class PostResume{

    public function post_insert($post_author, $post_name, $post_title, $post_content, $type, $postmeta) {
        $args = array(
            'comment_status'    => "open",
            'ping_status'       => "closed",
            'post_author'       => $post_author,
            'post_name'         => $post_name,
            'post_title'        => $post_title,
            'post_content'      => $post_content,
            'ping_status'       => "closed",
            'post_status'       => "publish",
            'post_type'         => "$type",
            'meta_input'        => $postmeta
        );
        $post_insert = wp_insert_post($args, true);
        return 1;
    }

    public function verifyedu($levaca, $val1, $val2, $val3, $val4, $val5) {
        $data = [];
        if(!$val1 == "") {
            $data = [
                'levelAcademic' => $levaca,
                'location'      => $val1,
                'qualification' => $val2,
                'dateStart'     => $val3,
                'dateEnd'       => $val4,
                'notes'         => $val5
            ];
            return $data;
        } else {
            return $data;
        }
    }

    public function verifyexp($emp, $val1, $val2, $val3, $val4) {
        $data = [];
        if(!$val1 == "") {
            $data = ['employer'      => $emp,
                     'job_title'     => $val1,
                     'dateStart'     => $val2,
                     'dateEnd'       => $val3,
                     'notes'         => $val4
            ];
            return $data;
        } else {
            return $data;
        }
    }

    public function arraymeta($metaparam) {
        $data = [];
        foreach ($metaparam as $value) {
            if(count($value) > 0) {
                array_push($data, $value);
            }         
        }
        return $data;
    }

}