<?php

/**
 * Register widgets
 *
 * Callback function which includes widget classes and initializes theme specific widgets
 *
 * @return void
 * @since  1.0
 */

add_action( 'widgets_init', 'vlog_register_widgets' );

function vlog_register_widgets() {

	include_once VLOG_BUDDY_DIR .'inc/widgets/posts.php';
	include_once VLOG_BUDDY_DIR .'inc/widgets/adsense.php';
	include_once VLOG_BUDDY_DIR .'inc/widgets/categories.php';
	
	register_widget( 'VLOG_Posts_Widget' );
	register_widget( 'VLOG_Adsense_Widget' );
	register_widget( 'VLOG_Category_Widget' );

	if( vlog_buddy_is_series_active() ){
		include_once VLOG_BUDDY_DIR .'inc/widgets/series.php';
		register_widget( 'VLOG_Series_Widget' );
	}
}


?>