<?php

/* Load admin scripts and styles */
add_action( 'admin_enqueue_scripts', 'vlog_load_admin_scripts' );


/**
 * Load scripts and styles in admin
 *
 * It just wrapps two other separate functions for loading css and js files in admin
 *
 * @return void
 * @since  1.0
 */

function vlog_load_admin_scripts() {
	vlog_load_admin_css();
	vlog_load_admin_js();
}


/**
 * Load admin css files
 *
 * @return void
 * @since  1.0
 */

function vlog_load_admin_css() {
	
	global $pagenow, $typenow;

	
	if ( $typenow == 'page' && ($pagenow == 'post.php' || $pagenow == 'post-new.php') ) {
		wp_enqueue_style ( 'wp-jquery-ui-dialog' );
	}

	//Load small admin style tweaks
	wp_enqueue_style( 'vlog-admin', get_parent_theme_file_uri( '/assets/css/admin/global.css' ), false, VLOG_THEME_VERSION, 'screen, print' );
}


/**
 * Load admin js files
 *
 * @return void
 * @since  1.0
 */

function vlog_load_admin_js() {

	global $pagenow, $typenow;

	// global js
	wp_enqueue_script( 'vlog-global', get_parent_theme_file_uri( '/assets/js/admin/global.js' ), array( 'jquery' ), VLOG_THEME_VERSION );

	//Load post & page js
	if ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) {
		if ( $typenow == 'post' ) {
			wp_enqueue_script( 'vlog-post', get_parent_theme_file_uri( '/assets/js/admin/metaboxes-post.js' ), array( 'jquery' ), VLOG_THEME_VERSION );
		} elseif ( $typenow == 'page' ) {
			wp_enqueue_script( 'vlog-page', get_parent_theme_file_uri( '/assets/js/admin/metaboxes-page.js' ), array( 'jquery', 'jquery-ui-dialog', 'jquery-ui-sortable', 'jquery-ui-autocomplete' ), VLOG_THEME_VERSION );
			wp_localize_script( 'vlog-page', 'vlog_js_settings', vlog_get_admin_js_settings() );
		}
	}


	//Load category & series JS
	if ( in_array( $pagenow, array('edit-tags.php', 'term.php') ) && isset( $_GET['taxonomy'] ) && in_array( $_GET['taxonomy'], array( 'category', 'series' ) ) ) {
		wp_enqueue_media();
		wp_enqueue_script( 'vlog-category', get_parent_theme_file_uri( '/assets/js/admin/metaboxes-category.js' ), array( 'jquery' ), VLOG_THEME_VERSION );
	}
}


/**
 * Load editor styles
 *
 * @since  1.0
 */

function vlog_load_editor_styles() {

	if ( $fonts_link = vlog_generate_fonts_link() ) {
		add_editor_style( $fonts_link );
	}

	add_editor_style( get_parent_theme_file_uri( '/assets/css/admin/editor-style.css' ) );

}

/**
 * Load dynamic editor styles
 *
 * @since  1.0
 */

add_action( 'enqueue_block_editor_assets', 'vlog_block_editor_styles', 99 );

function vlog_block_editor_styles() {
	
	wp_register_style( 'vlog-editor-styles', false, VLOG_THEME_VERSION );

	wp_enqueue_style( 'vlog-editor-styles');
	wp_add_inline_style( 'vlog-editor-styles', vlog_generate_dynamic_editor_css() );

}

?>