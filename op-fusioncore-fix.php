<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.optimizepress.com/
 * @since             1.0.0
 * @package           Op_FusionCore_Fix
 *
 * @wordpress-plugin
 * Plugin Name:       OptimizePress Fusion Core fix
 * Plugin URI:        http://www.optimizepress.com/
 * Description:       Removes "image" shortcode from Fusion Core plugin on Live Editor pages
 * Version:           1.0.0
 * Author:            OptimizePress
 * Author URI:        http://www.optimizepress.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       op-fusioncore-fix
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
add_action('init' , 'op_fusioncore_shortcodes', 99);

function op_fusioncore_shortcodes(){
    $checkIfLEPage = get_post_meta( url_to_postid( "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ), '_optimizepress_pagebuilder', true );

    if ( ($checkIfLEPage == 'Y') || ( $_GET['page'] == 'optimizepress-page-builder' )){
        global $shortcode_tags;
        $shortcode_tags['images'][0] = 'OptimizePress_Default_Assets';
        $shortcode_tags['images'][1] = 'images';
    }
}