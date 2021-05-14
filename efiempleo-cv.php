<?php
/*
Plugin Name:        EFIEMPLEO CV
Plugin URI:
Description:        Cargar resume post type de wp job manager para efiempleo
Version:            1.1
Author:             Carlos David Guedez
Author URI:         
License:            GPL v2 or later
License URI:        https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:        efiempleo-cv
*/
defined('ABSPATH') or die;

define('EFI_CV_PATH', plugin_dir_path(__FILE__));
define('EFI_PLUGIN_DIR', plugin_dir_url(__FILE__));
define('EFI_UPLOADS_TMP', plugin_dir_path(__FILE__).'uploads/');

function efi_activate() {
}
register_activation_hook(__FILE__, 'efi_activate');

function efi_deactivate() {
    
}
register_deactivation_hook(__FILE__, 'efi_deactivate');

function efi_create_menu()
{
    add_menu_page(
        'Efiempleo - Carga de CV',
        'script Efiempleo',
        'manage_options',
        EFI_CV_PATH.'index.php',
        null,
        'dashicons-welcome-add-page',
        '5'
    );
}
add_action("admin_menu", "efi_create_menu");