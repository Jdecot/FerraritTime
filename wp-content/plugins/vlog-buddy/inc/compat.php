<?php

add_action( 'admin_init', 'vlog_buddy_compatibility' );

function vlog_buddy_compatibility() {

	if ( is_admin() && current_user_can( 'activate_plugins' ) && !vlog_buddy_is_theme_active() ) {

		add_action( 'admin_notices', 'vlog_buddy_compatibility_notice' );

		deactivate_plugins( VLOG_BUDDY_BASENAME );

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}
}

function vlog_buddy_compatibility_notice() {
	echo '<div class="notice notice-warning"><p><strong>Note:</strong> Vlog Buddy plugin has been deactivated as it requires Vlog Theme to be active.</p></div>';
}

function vlog_buddy_is_theme_active() {
	return defined( 'VLOG_THEME_VERSION' );
}


function vlog_buddy_is_series_active() {

	if ( in_array( 'series/series.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		return true;
	}

	return false;
}


?>