<?php namespace Models;

// require_once(scriptURI.'Models/ConexionDB.php');
// use Models\ConexionDB;

$path = preg_replace('/wp-content.*$/','',__DIR__);
require_once($path.'wp-load.php');
if (!current_user_can('manage_options')) {
    exit();
}

class Usermeta {

    public function wpdbquery() {
        global $wpdb;
        $userscandidate = $wpdb->get_results("SELECT wp_usermeta.user_id, wp_users.user_email, wp_users.display_name, wp_users.user_nicename FROM wp_usermeta INNER JOIN wp_users ON wp_usermeta.user_id=wp_users.ID WHERE wp_usermeta.meta_value LIKE '%candidate%' ORDER BY wp_users.user_email desc");
        return $userscandidate;
    }

}