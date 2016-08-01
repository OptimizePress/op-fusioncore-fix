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
 * @since             1.0.2
 * @package           Op_FusionCore_Fix
 *
 * @wordpress-plugin
 * Plugin Name:       OptimizePress Fusion Core fix
 * Plugin URI:        http://www.optimizepress.com/
 * Description:       Fix problem with RTE in LiveEditor and forces images/testimonial shortcode from OptimizePress
 * Version:           1.0.2
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

add_action('init', 'op_fusioncore_shortcodeJSFix', 999999999999);

if (!function_exists('op_fusioncore_shortcodes')){
    function op_fusioncore_shortcodes(){
        $checkIfLEPage = get_post_meta( url_to_postid( "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ), '_optimizepress_pagebuilder', true );

        $pageBuilder = false;
        if ( isset($_GET['page']) ) {
            $pageBuilder = ($_GET['page'] == 'optimizepress-page-builder' ) ? true : false;
        }
        $liveEditorAjaxInsert = false;
        if ( isset($_REQUEST['action']) ) {
            $liveEditorAjaxInsert = ($_REQUEST['action'] == 'optimizepress-live-editor-parse' ) ? true : false;
        }

        if ( ($checkIfLEPage == 'Y') || $pageBuilder || $liveEditorAjaxInsert ){
            global $shortcode_tags;
            $shortcode_tags['images'][0] = 'OptimizePress_Default_Assets';
            $shortcode_tags['images'][1] = 'images';

            $shortcode_tags['testimonials'][0] = 'OptimizePress_Default_Assets';
            $shortcode_tags['testimonials'][1] = 'testimonials';
        }
    }
}

if (!function_exists('op_fusioncore_shortcodeJSFix')) {
    function op_fusioncore_shortcodeJSFix()
    {
        $checkIfLEPage = get_post_meta(url_to_postid("http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), '_optimizepress_pagebuilder', true);

        $pageBuilder = false;
        if (isset($_GET['page'])) {
            $pageBuilder = ($_GET['page'] == 'optimizepress-page-builder') ? true : false;
        }
        $liveEditorAjaxInsert = false;
        if (isset($_REQUEST['action'])) {
            $liveEditorAjaxInsert = ($_REQUEST['action'] == 'optimizepress-live-editor-parse') ? true : false;
        }

        if ($pageBuilder || $liveEditorAjaxInsert) {
            remove_filter('mce_external_plugins', array(FusionCore_Plugin::get_instance(), 'add_rich_plugins'), 10);
        }
    }
}