<?php
/*
Plugin Name: script_efiempleo
Plugin URI:
Description: Inserta post tipo resume en wp_job_manager
Version: 1.2
Author: cguedez@efiempresa.com
Author URI:
License: GPL2
*/
define('scriptURI', plugin_dir_path(__FILE__));
defined('ABSPATH') or die("Bye bye");

function activescript()
{
}
function disablescript()
{
}

register_activation_hook(__FILE__, 'activescript');
register_deactivation_hook(__FILE__, 'disablescript');

add_action("admin_menu", "createscript");
function createscript()
{
    add_menu_page('ejecutando script_efiempleo', 'script Efiempleo', 'manage_options', plugin_dir_path(__FILE__).'index.php', null, '', '5');
}
