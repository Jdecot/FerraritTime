<?php


add_action( 'in_widget_form', 'vlog_add_widget_form_options', 10, 3 );

/**
 * Add widget form options
 *
 * Add custom options to each widget
 *
 * @return void
 * @since  1.0
 */

if ( !function_exists( 'vlog_add_widget_form_options' ) ) :

	function vlog_add_widget_form_options(  $widget, $return, $instance) {

	if(!isset($instance['vlog-highlight'])){
		$instance['vlog-highlight'] = 0;
	}

	if(!isset($instance['vlog-full-width'])){
		$instance['vlog-full-width'] = 0;
	}

	$exclude_full_option =  array( 
			'pages', 
			'categories', 
			'archives',
			'recent-comments',
			'recent-posts',
			'nav_menu',
			'calendar',
			'meta',
			'rss',
			'search',
			'tag_cloud',
			'vlog_video_widget',  
			'vlog_posts_widget',
			'vlog_adsense_widget',  
			'mks_ads_widget', 
			'mks_author_widget', 
			'mks_flickr_widget', 
			'mks_social_widget', 
			'mks_themeforest_widget',
	);

?>
	
	<p class="vlog-opt-highlight">
		<label for="<?php echo esc_attr( $widget->get_field_id( 'vlog-highlight' )); ?>">
			<input type="checkbox" id="<?php echo esc_attr($widget->get_field_id( 'vlog-highlight' )); ?>" name="<?php echo esc_attr($widget->get_field_name( 'vlog-highlight' )); ?>" value="1" <?php checked($instance['vlog-highlight'], 1); ?> />
			<?php esc_html_e( 'Highlight this widget', 'vlog');?>
		</label>
		<small class="howto"><?php  echo wp_kses( sprintf( __( 'Display widget in <a href="%s">highlight styling</a>.', 'vlog' ), admin_url( 'admin.php?page=vlog_options&tab=7' ) ), wp_kses_allowed_html( 'post' ));?></small>
	</p>

		
	<?php if(!in_array( $widget->id_base , $exclude_full_option ) ) : ?>	
		
			<p class="vlog-opt-full-width">
				<label for="<?php echo esc_attr( $widget->get_field_id( 'vlog-padding' )); ?>">
					<input type="checkbox" id="<?php echo esc_attr($widget->get_field_id( 'vlog-full-width' )); ?>" name="<?php echo esc_attr($widget->get_field_name( 'vlog-full-width' )); ?>" value="1" <?php checked($instance['vlog-full-width'], 1); ?> />
					<?php esc_html_e( 'Make widget content full-width', 'vlog');?>
					<small class="howto"><?php esc_html_e( 'Check this option if you want to expand your widget content to 300px', 'vlog');?></small>
				</label>
			</p>

	<?php endif; ?>

<?php
	
	}

endif;






add_filter( 'widget_update_callback', 'vlog_save_widget_form_options', 20, 2 );

/**
 * Save widget form options
 *
 * Save custom options to each widget
 *
 * @return void
 * @since  1.0
 */

if ( !function_exists( 'vlog_save_widget_form_options' ) ) :

	function vlog_save_widget_form_options( $instance, $new_instance ) {
		
		$instance['vlog-highlight'] = isset( $new_instance['vlog-highlight'] ) ? 1 : 0;
		$instance['vlog-full-width'] = isset( $new_instance['vlog-full-width'] ) ? 1 : 0;
		return $instance;

	}

endif;


/* Store registered sidebars so we can get them before wp_registered_sidebars is initialized to use them in theme options */

add_action( 'admin_init', 'vlog_check_sidebars' );

if ( !function_exists( 'vlog_check_sidebars' ) ):
	function vlog_check_sidebars() {
		global $wp_registered_sidebars;
		if ( !empty( $wp_registered_sidebars ) ) {
			update_option( 'vlog_registered_sidebars', $wp_registered_sidebars );
		}
	}
endif;


/* Change customize link to lead to theme options instead of live customizer */

add_filter( 'wp_prepare_themes_for_js', 'vlog_change_customize_link' );

if ( !function_exists( 'vlog_change_customize_link' ) ):
	function vlog_change_customize_link( $themes ) {
		if ( array_key_exists( 'vlog', $themes ) ) {
			$themes['vlog']['actions']['customize'] = admin_url( 'admin.php?page=vlog_options' );
		}
		return $themes;
	}
endif;


/* Change default arguments of flickr widget plugin */

add_filter( 'mks_flickr_widget_modify_defaults', 'vlog_flickr_widget_defaults' );

if ( !function_exists( 'vlog_flickr_widget_defaults' ) ):
	function vlog_flickr_widget_defaults( $defaults ) {

		$defaults['count'] = 9;
		$defaults['t_width'] = 79;
		$defaults['t_height'] = 79;
		
		return $defaults;
	}
endif;


/* Change default arguments of author widget plugin */

add_filter( 'mks_author_widget_modify_defaults', 'vlog_author_widget_defaults' );

if ( !function_exists( 'vlog_author_widget_defaults' ) ):
	function vlog_author_widget_defaults( $defaults ) {
		$defaults['title'] = '';
		$defaults['avatar_size'] = 80;
		return $defaults;
	}
endif;


/* Change default arguments of social widget plugin */

add_filter( 'mks_social_widget_modify_defaults', 'vlog_social_widget_defaults' );

if ( !function_exists( 'vlog_social_widget_defaults' ) ):
	function vlog_social_widget_defaults( $defaults ) {
		$defaults['size'] = 44;
		$defaults['style'] = 'circle';
		return $defaults;
	}
endif;


/* Show admin notices */

add_action( 'admin_init', 'vlog_check_installation' );

if ( !function_exists( 'vlog_check_installation' ) ):
	function vlog_check_installation() {
		add_action( 'admin_notices', 'vlog_welcome_msg', 1 );
		add_action( 'admin_notices', 'vlog_update_msg', 1 );
		add_action( 'admin_notices', 'vlog_required_plugins_msg', 1 );
	}
endif;


/* Show welcome message and quick tips after theme activation */
if ( !function_exists( 'vlog_welcome_msg' ) ):
	function vlog_welcome_msg() {
		
		if ( get_option( 'vlog_welcome_box_displayed' ) || get_option( 'merlin_vlog_completed' ) ) {
			return false;
		}
			
		update_option( 'vlog_theme_version', VLOG_THEME_VERSION );
		include_once get_parent_theme_file_path( '/core/admin/welcome-panel.php' );
	}
endif;


/* Show message box after theme update */
if ( !function_exists( 'vlog_update_msg' ) ):
	function vlog_update_msg() {

		if ( !get_option( 'vlog_welcome_box_displayed' ) && !get_option( 'merlin_vlog_completed' ) ) {
			return false;
		}
			
		$prev_version = get_option( 'vlog_theme_version' );
		$cur_version = VLOG_THEME_VERSION;
		if ( $prev_version === false ) { $prev_version = '0.0.0'; }
		
		if ( version_compare( $cur_version, $prev_version, '>' ) ) {
				
			include_once get_parent_theme_file_path( '/core/admin/update-panel.php' );

			// Print new video importer plugin message
            $is_dismissed = get_option('vlog_meks_video_importer_admin_notice_dismiss');
			if( !$is_dismissed & version_compare( $cur_version, '1.9.1', '<' ) > '' && 
			!vlog_is_meks_video_importer_active() ){
                include_once get_parent_theme_file_path( '/core/admin/new-video-importer-plugin.php' );
            }
		}
		
	}
endif;

/**
 * Display message if required plugins are not installed and activated
 *
 * @since  1.0
 */

if ( !function_exists( 'vlog_required_plugins_msg' ) ):
	function vlog_required_plugins_msg() {

		if ( !get_option( 'vlog_welcome_box_displayed' ) && !get_option( 'merlin_vlog_completed' ) ) {
			return false;
		}

		if ( !vlog_is_redux_active() ) {
			$class = 'notice notice-error';
			$message = wp_kses_post( sprintf( __( 'Important: Redux Framework plugin is required to run your theme options panel. Please visit <a href="%s">recommended plugins page</a> to install it.', 'vlog' ), admin_url( 'admin.php?page=install-required-plugins' ) ) );
			printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
		}

	}
endif;


/**
 * Remove common scripts from some plugins
 * which are not loaded properly and may break admin stuff
 *
 * @since  1.8
 */

add_action('admin_enqueue_scripts', 'vlog_exclude_admin_scripts', 99 );

if ( !function_exists( 'vlog_exclude_admin_scripts' ) ):
    function vlog_exclude_admin_scripts() {

        if( vlog_is_wp_review_active() ) {
            wp_dequeue_style( 'plugin_name-admin-ui-css' );
            wp_dequeue_style( 'wp-review-admin-ui-css' );
        }

        if( vlog_is_wp_pagefrog_active() ) {
            wp_dequeue_style( 'jquery_ui' );
        }

        wp_dequeue_style( 'jquery-ui.js' );

    }
endif;


/**
 * Check for Additional CSS in Theme Options and transfer it to Customize -> Additional CSS
 *
 * @return void
 * @since  1.0.5
 */
add_action('admin_init','vlog_patch_additional_css');

if ( !function_exists( 'vlog_patch_additional_css' ) ) :
	function vlog_patch_additional_css() {

		$additional_css = vlog_get_option( 'additional_css' );

		if ( empty( $additional_css ) ) {
			return false;
		}
		
		global $vlog_settings;

		$vlog_settings = get_option( 'vlog_settings' ); 

		$vlog_settings['additional_css'] = '';

		update_option( 'vlog_settings', $vlog_settings ) ;

		$customize_css = wp_get_custom_css_post();
		
		if ( !empty( $customize_css ) && !is_wp_error( $customize_css ) ) {
			$additional_css .= $customize_css->post_content;
		}

		wp_update_custom_css_post($additional_css);
	}
endif;


/**
 * Filter for social share option fields
 *
 * @param array $args - Array of default fields
 * @return array
 * @since  1.9
 */
add_filter( 'meks_ess_modify_options_fields', 'vlog_social_share_option_fields_filter' );

if ( !function_exists( 'vlog_social_share_option_fields_filter' ) ):
	function vlog_social_share_option_fields_filter( $args ) {
		
		unset( $args['location'] );
		unset( $args['post_type'] );
		unset( $args['label_share'] );

		return $args;
	}
endif;

/**
 * Patching for social share platforms for meks easy share plugin
 *
 * @return void
 * @since  2.2
 */
add_action('admin_init','vlog_patch_social_share_platforms');

if ( !function_exists( 'vlog_patch_social_share_platforms' ) ) :
	function vlog_patch_social_share_platforms() {

		$social_platforms = vlog_get_option( 'social_share' );

		if ( empty( $social_platforms ) ) {
			return false;
		}
		
		global $vlog_settings;
		$vlog_settings = get_option( 'vlog_settings' ); 

		$vlog_settings['social_share'] = '';
		update_option( 'vlog_settings', $vlog_settings ) ;
		
		$new_platforms = array();

		foreach ( $social_platforms as $platform => $value ) {
			if ( $value == '1' ) {
				$new_platforms['platforms'][] = $platform;
			}
		}

		update_option( 'meks_ess_settings', $new_platforms );

	}
endif;

/**
 * Add Meks dashboard widget
 *
 * @since  1.0
 */

add_action( 'wp_dashboard_setup', 'vlog_add_dashboard_widgets' );

if ( !function_exists( 'vlog_add_dashboard_widgets' ) ):
	function vlog_add_dashboard_widgets() {
		add_meta_box( 'vlog_dashboard_widget', 'Meks - WordPress Themes & Plugins', 'vlog_dashboard_widget_cb', 'dashboard', 'side', 'high' );
	}
endif;


/**
 * Meks dashboard widget
 *
 * @since  1.0
 */
if ( !function_exists( 'vlog_dashboard_widget_cb' ) ):
	function vlog_dashboard_widget_cb() {

		$transient = 'vlog_mksaw';
		$hide = '<style>#vlog_dashboard_widget{display:none;}</style>';

		$data = get_transient( $transient );
	
		if ( $data == 'error' ) {
			echo $hide;
			return;
		}

		if ( !empty( $data ) ) {
			echo $data;
			return;
		}

		$url = 'https://demo.mekshq.com/mksaw.php';
		$args = array( 'body' => array( 'key' => md5( 'meks' ), 'theme' => 'vlog' ) );
		$response = wp_remote_post( $url, $args );

		if ( is_wp_error( $response ) ) {
			set_transient( $transient, 'error', DAY_IN_SECONDS );
			echo $hide;
			return;
		}

		$json = wp_remote_retrieve_body( $response );

		if ( empty( $json ) ) {
			set_transient( $transient, 'error', DAY_IN_SECONDS );
			echo $hide;
			return;
		}

		$json = json_decode( $json );

		if ( !isset( $json->data ) ) {
			set_transient( $transient, 'error', DAY_IN_SECONDS );
			echo $hide;
			return;
		} 

		set_transient( $transient, $json->data, DAY_IN_SECONDS );
		echo $json->data;
		
	}
endif;
?>