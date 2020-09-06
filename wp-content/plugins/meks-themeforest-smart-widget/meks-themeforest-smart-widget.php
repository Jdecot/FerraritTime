<?php
/*
Plugin Name: Meks ThemeForest Smart Widget
Plugin URI: https://mekshq.com
Description: A simple and powerful WordPress plugin with which you can display ThemeForest items as a WordPress widget. Several smart options are provided for selecting and ordering. You can select ThemeForest latest items, popular items or items from one or more specific users. Optionally, you can connect items with your affiliate links as well.
Author: Meks
Version: 1.3
Author URI: https://mekshq.com
Text Domain: meks-themeforest-smart-widget
Domain Path: /languages
License: GPL3
*/

define( 'MTW_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'MTW_PLUGIN_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'MKS_TF_WIDGET_VER', '1.3' );

/* Initialize Widget */
if ( !function_exists( 'mtw_widget_init' ) ):
    function mtw_widget_init() {
        require_once MTW_PLUGIN_DIR.'inc/class-themeforest-widget.php';
        register_widget( 'MKS_ThemeForest_Widget' );
    }
endif;

add_action( 'widgets_init', 'mtw_widget_init' );

/* Load text domain */
function mks_load_tf_widget_text_domain() {
    load_plugin_textdomain( 'meks-themeforest-smart-widget', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'mks_load_tf_widget_text_domain' );

?>