<?php

require_once get_parent_theme_file_path( '/inc/merlin/vendor/autoload.php' );
require_once get_parent_theme_file_path( '/inc/merlin/class-merlin.php' );

/**
 * Merlin WP configuration file.
 */

if ( ! class_exists( 'Merlin' ) ) {
	return;
}

$strings = array(
	'admin-menu'               => esc_html__( 'Vlog Setup Wizard', 'vlog' ),
	'title%s%s%s%s'            => esc_html__( '%s%s Themes &lsaquo; Theme Setup: %s%s', 'vlog' ),
	'return-to-dashboard' 	   => esc_html__( 'Return to the dashboard', 'vlog' ),
	'ignore'                   => esc_html__( 'Disable this wizard', 'vlog' ),
	
	'btn-skip'                  => esc_html__( 'Skip', 'vlog' ),
	'btn-next'                  => esc_html__( 'Next', 'vlog' ),
	'btn-start'                 => esc_html__( 'Start', 'vlog' ),
	'btn-no'                    => esc_html__( 'Cancel', 'vlog' ),
	'btn-plugins-install'       => esc_html__( 'Install', 'vlog' ),

	'btn-child-install'         => esc_html__( 'Install', 'vlog' ),
	'btn-content-install'       => esc_html__( 'Install', 'vlog' ),
	'btn-import'                => esc_html__( 'Import', 'vlog' ),
	'btn-license-activate'     => esc_html__( 'Activate', 'vlog' ),
	'btn-license-skip'         => esc_html__( 'Later', 'vlog' ),
	
	'welcome-header%s'         => esc_html__( 'Welcome to %s', 'vlog' ),
	'welcome-header-success%s' => esc_html__( 'Hi. Welcome back', 'vlog' ),
	'welcome%s'                => esc_html__( 'This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'vlog' ),
	'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'vlog' ),
	
	'license-header%s'         => esc_html__( 'Activate %s', 'vlog' ),
	'license-header-success%s' => esc_html__( '%s is Activated', 'vlog' ),
	'license%s'                => esc_html__( 'Enter your license key to enable remote updates and theme support.', 'vlog' ),
	'license-label'            => esc_html__( 'License key', 'vlog' ),
	'license-success%s'        => esc_html__( 'The theme is already registered, so you can go to the next step!', 'vlog' ),
	'license-json-success%s'   => esc_html__( 'Your theme is activated! Remote updates and theme support are enabled.', 'vlog' ),
	'license-tooltip'          => esc_html__( 'Need help?', 'vlog' ),
	
	'child-header'         => esc_html__( 'Install Child Theme', 'vlog' ),
	'child-header-success' => esc_html__( 'You\'re good to go!', 'vlog' ),
	'child'                => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.', 'vlog' ),
	'child-success%s'      => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.', 'vlog' ),
	'child-action-link'    => esc_html__( 'Learn about child themes', 'vlog' ),
	'child-json-success%s' => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.', 'vlog' ),
	'child-json-already%s' => esc_html__( 'Awesome. Your child theme has been created and is now activated.', 'vlog' ),
	
	'plugins-header'         => esc_html__( 'Install Plugins', 'vlog' ),
	'plugins-header-success' => esc_html__( 'You\'re up to speed!', 'vlog' ),
	'plugins'                => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.', 'vlog' ),
	'plugins-success%s'      => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'vlog' ),
	'plugins-action-link'    => esc_html__( 'Plugins', 'vlog' ),
	
	'import-header'      => esc_html__( 'Import Content', 'vlog' ),
	'import'             => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme.', 'vlog' ),
	'import-action-link' => esc_html__( 'Details', 'vlog' ),
	
	'ready-header'      => esc_html__( 'All done. Have fun!', 'vlog' ),
	'ready%s'           => esc_html__( 'Your theme has been all set up. Enjoy your new theme by %s.', 'vlog' ),
	'ready-action-link' => esc_html__( 'Extras', 'vlog' ),
	'ready-big-button'  => esc_html__( 'View your website', 'vlog' ),
	
	'ready-link-3' => '',
	'ready-link-2' => wp_kses( sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://mekshq.com/documentation/vlog/', esc_html__( 'Theme Documentation', 'vlog' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
);

if(vlog_is_redux_active()){
	$strings['ready-link-1'] = wp_kses( sprintf( '<a href="'.admin_url( 'admin.php?page=vlog_options' ).'" target="_blank">%s</a>', esc_html__( 'Start Customizing', 'vlog' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) );
}

/**
 * Set directory locations, text strings, and other settings for Merlin WP.
 *
 * @since 1.0
 */
$vlog_wizard = new Merlin(

	// Configure Merlin with custom settings.
	$config = array(
		'directory'            => 'inc/merlin', // Location / directory where Merlin WP is placed in your theme.
		'merlin_url'           => 'vlog-importer', // The wp-admin page slug where Merlin WP loads.
		'parent_slug'          => 'themes.php', // The wp-admin parent page slug for the admin menu item.
		'capability'           => 'manage_options', // The capability required for this menu to be displayed to the user.
		'child_action_btn_url' => 'https://codex.wordpress.org/child_themes', // URL for the 'child-action-link'.
		'dev_mode'             => false, // Enable development mode for testing.
		'license_step'         => false, // EDD license activation step.
		'license_required'     => false, // Require the license activation step.
		'license_help_url'     => '', // URL for the 'license-tooltip'.
		'edd_remote_api_url'   => '', // EDD_Theme_Updater_Admin remote_api_url.
		'edd_item_name'        => '', // EDD_Theme_Updater_Admin item_name.
		'edd_theme_slug'       => '', // EDD_Theme_Updater_Admin item_slug.
		'ready_big_button_url' => get_home_url(), // Link for the big button on the ready step.
	),

	// Text strings.
	$strings

);


/**
 * Prepare files to import
 *
 * @since 1.0
 */
add_filter( 'merlin_import_files', 'vlog_demo_import_files' );

if(!function_exists('vlog_demo_import_files')):
	function vlog_demo_import_files() {
			return array(
				array(
					'import_file_name'         => 'Vlog default',
					'local_import_file'        => get_parent_theme_file_path( '/inc/demos/01_default/content.xml' ),
					'local_import_widget_file' => get_parent_theme_file_path( '/inc/demos/01_default/widgets.json' ),
					'local_import_redux' => array(
						array(
							'file_path'    => get_parent_theme_file_path( '/inc/demos/01_default/options.json' ),
							'option_name' => 'vlog_settings',
						)
					),
					'import_preview_image_url' => get_parent_theme_file_uri( '/screenshot.png' ),
					'import_notice'            => '',
					'preview_url'              => 'https://demo.mekshq.com/vlog/',
                ),
                array(
					'import_file_name'         => 'Vlog personal',
					'local_import_file'        => get_parent_theme_file_path( '/inc/demos/02_personal/content.xml' ),
					'local_import_widget_file' => get_parent_theme_file_path( '/inc/demos/02_personal/widgets.json' ),
					'local_import_redux' => array(
						array(
							'file_path'    => get_parent_theme_file_path( '/inc/demos/02_personal/options.json' ),
							'option_name' => 'vlog_settings',
						)
					),
					'import_preview_image_url' => get_parent_theme_file_uri( '/screenshot.png' ),
					'import_notice'            => '',
					'preview_url'              => 'https://demo.mekshq.com/vlog/',
                ),
                array(
					'import_file_name'         => 'Vlog magazine',
					'local_import_file'        => get_parent_theme_file_path( '/inc/demos/03_magazine/content.xml' ),
					'local_import_widget_file' => get_parent_theme_file_path( '/inc/demos/03_magazine/widgets.json' ),
					'local_import_redux' => array(
						array(
							'file_path'    => get_parent_theme_file_path( '/inc/demos/03_magazine/options.json' ),
							'option_name' => 'vlog_settings',
						)
					),
					'import_preview_image_url' => get_parent_theme_file_uri( '/screenshot.png' ),
					'import_notice'            => '',
					'preview_url'              => 'https://demo.mekshq.com/vlog/',
                ),
                array(
					'import_file_name'         => 'Vlog podcast',
					'local_import_file'        => get_parent_theme_file_path( '/inc/demos/04_podcast/content.xml' ),
					'local_import_widget_file' => get_parent_theme_file_path( '/inc/demos/04_podcast/widgets.json' ),
					'local_import_redux' => array(
						array(
							'file_path'    => get_parent_theme_file_path( '/inc/demos/04_podcast/options.json' ),
							'option_name' => 'vlog_settings',
						)
					),
					'import_preview_image_url' => get_parent_theme_file_uri( '/screenshot.png' ),
					'import_notice'            => '',
					'preview_url'              => 'https://demo.mekshq.com/vlog/',
                ),

			);
	}
endif;

/**
 * Execute custom code after the whole import has finished.
 *
 * @since 1.0
 */
add_action( 'merlin_after_all_import', 'vlog_merlin_after_import_setup' );

if( !function_exists('vlog_merlin_after_import_setup') ):
	function vlog_merlin_after_import_setup( ) {
		
        /* Set Menus */

        $menus = array();

        $main_menu = get_term_by( 'name', 'Main', 'nav_menu' );
        if ( isset( $main_menu->term_id ) ) {
            $menus['vlog_main_menu'] = $main_menu->term_id;
        }

        $social_menu = get_term_by( 'name', 'Social', 'nav_menu' );
        if ( isset( $social_menu->term_id ) ) {
            $menus['vlog_social_menu'] = $social_menu->term_id;
        }

        $secondary_menu = get_term_by( 'name', 'Secondary', 'nav_menu' );
        if ( isset( $secondary_menu->term_id ) ) {
            $menus['vlog_secondary_menu_1'] = $secondary_menu->term_id;
        }

        if ( !empty( $menus ) ) {
            set_theme_mod( 'nav_menu_locations', $menus );
        }


        /* Set Home Page */

        $home_page_title = 'Home';

        $page = get_page_by_title( $home_page_title );

        if ( isset( $page->ID ) ) {
            update_option( 'page_on_front', $page->ID );
            update_option( 'show_on_front', 'page' );
		}
		
		/* Import contact form */
		vlog_import_contact_form();

	}

endif;


/**
 * Insert WPForms contact form
 *
 * @return void
 * @since 1.3.4
 */

if ( !function_exists( 'vlog_import_contact_form' ) ):
	function vlog_import_contact_form( ) {
		
		if ( !function_exists( 'WP_Filesystem' ) || !WP_Filesystem() ) {
			return false;
		}

		global $wp_filesystem;
		$forms = json_decode( $wp_filesystem->get_contents(  get_parent_theme_file_path( '/inc/demos/01_default/wpforms.json' ) ), true );

		if ( ! empty( $forms ) ) {

			foreach ( $forms as $form ) {

				$title  = ! empty( $form['settings']['form_title'] ) ? $form['settings']['form_title'] : '';
				$desc   = ! empty( $form['settings']['form_desc'] ) ? $form['settings']['form_desc'] : '';
				$new_id = wp_insert_post( array(
					'post_title'   => $title,
					'post_status'  => 'publish',
					'post_type'    => 'wpforms',
					'post_excerpt' => $desc,
				) );
				if ( $new_id ) {
					$form['id'] = $new_id;
					wp_update_post(
						array(
							'ID'           => $new_id,
							'post_content' =>  wp_slash( wp_json_encode( $form ) ),
						)
					);
				}
			}
		}

	}
endif;


/**
 * Unset the default widgets
 *
 * @return array
 * @since 1.0
 */

add_action('merlin_widget_importer_before_widgets_import', 'vlog_remove_widgets_before_import');

if(!function_exists('vlog_remove_widgets_before_import')):
	function vlog_remove_widgets_before_import() {
		delete_option( 'sidebars_widgets' );	
	}
endif;

/**
 * Unset the child theme generator step in merlin welcome panel
 *
 * @param $steps
 * @return mixed
 * @since 1.0
 */

add_filter('vlog_merlin_steps', 'vlog_remove_child_theme_generator_from_merlin');

if(!function_exists('vlog_remove_child_theme_generator_from_merlin')):
    function vlog_remove_child_theme_generator_from_merlin($steps){
        unset($steps['child']);
        return $steps;
    }
endif;


/**
 * Stop initial redirect after theme is activated
 *
 * @since 1.0
 */

remove_action( 'after_switch_theme', array( $vlog_wizard, 'switch_theme' ) );
?>