<?php

/**
 * Load admin js files
 *
 * @since  1.0
 */

add_action( 'admin_enqueue_scripts', 'vlog_buddy_load_admin_js' );

function vlog_buddy_load_admin_js() {

	global $pagenow;	

	if( $pagenow == 'widgets.php' ){
		wp_enqueue_script( 'vlog-widgets', VLOG_BUDDY_URL . 'assets/js/admin/widgets.js', array( 'jquery', 'jquery-ui-sortable'), VLOG_BUDDY_VER );
	}

}

?>