<?php 
/* Get format content of a specific post */

add_action('wp_ajax_vlog_format_content', 'vlog_get_format_content');
add_action('wp_ajax_nopriv_vlog_format_content', 'vlog_get_format_content');

if(!function_exists('vlog_get_format_content')):
function vlog_get_format_content(){
	
	$post_id = absint( $_POST['id'] );
	$format = $_POST['format'];
	$display_playlist = $_POST['display_playlist'] === 'true' ? true : false;
	
	if ( isset( $_GET[ 'wpml_lang' ] ) ) {
    	do_action( 'wpml_switch_language',  $_GET[ 'wpml_lang' ] ); // switch the content language
	}

	$p = new WP_Query( array( 'post_type' => any, 'p' => $post_id ));

	if($p->have_posts()):

		while( $p->have_posts() ) : $p->the_post();

            if(vlog_get_option('display_playlist_mode') && $display_playlist):
               ?>
                <div class="vlog-cover-playlist-active">
                    <div class="row">
                        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 vlog-playlist-video">
                <?php
            endif;

            echo hybrid_media_grabber( array( 'type' => $format, 'split_media' => true ) );

            if(vlog_get_option('display_playlist_mode') && $display_playlist):
                ?>
                        </div>
                        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 vlog-playlist">
                            <?php get_template_part( 'template-parts/single/cover','playlist'); ?>
                        </div>
                    </div>
                </div>
                <?php
            endif;

		endwhile;

	endif;

	wp_reset_postdata();

	die();
}
endif;

/* Watch later handlers */

//Prints the wath later
add_action('wp_ajax_vlog_watch_later', 'vlog_watch_later_posts');
add_action('wp_ajax_nopriv_vlog_watch_later', 'vlog_watch_later_posts');

add_action('wp_ajax_vlog_load_watch_later', 'vlog_load_watch_later');
add_action('wp_ajax_nopriv_vlog_load_watch_later', 'vlog_load_watch_later');

if(!function_exists('vlog_watch_later_posts')):
function vlog_watch_later_posts(){
	
	$post_id = absint( $_POST['id'] );
	$what = $_POST['what'];

	if ( isset( $_GET[ 'wpml_lang' ] ) ) {
    	do_action( 'wpml_switch_language',  $_GET[ 'wpml_lang' ] ); // switch the content language
	}

	$ids = vlog_get_watch_later_posts();
	
	if($what == 'add'){
		$ids[] = $post_id;	
	} else {
		$ids = array_diff( $ids , array( $post_id ));
	}
	
	if(!isset($_COOKIE['vlog_watch_later'])){
		setcookie('vlog_watch_later', implode( "_", array( $post_id ) ), time() + 30 * 86400, COOKIEPATH, COOKIE_DOMAIN);
	} else {
		$ids = array_values($ids);
		setcookie('vlog_watch_later', implode( "_", $ids ), time() + 30 * 86400, COOKIEPATH, COOKIE_DOMAIN);
	}

	if(!empty($ids)){
		$args = array('post__in' => $ids );
		vlog_print_watch_later_posts( $args );
	}

	die();
}
endif;

/* Listen later handlers */

//Prints the listen later
add_action('wp_ajax_vlog_listen_later', 'vlog_listen_later_posts');
add_action('wp_ajax_nopriv_vlog_listen_later', 'vlog_listen_later_posts');

add_action('wp_ajax_vlog_load_listen_later', 'vlog_load_listen_later');
add_action('wp_ajax_nopriv_vlog_load_listen_later', 'vlog_load_listen_later');

if(!function_exists('vlog_listen_later_posts')):
function vlog_listen_later_posts(){
	
	$post_id = absint( $_POST['id'] );
	$what = $_POST['what'];

	if ( isset( $_GET[ 'wpml_lang' ] ) ) {
    	do_action( 'wpml_switch_language',  $_GET[ 'wpml_lang' ] ); // switch the content language
	}

	$ids = vlog_get_listen_later_posts();
	
	if($what == 'add'){
		$ids[] = $post_id;	
	} else {
		$ids = array_diff( $ids , array( $post_id ));
	}
	
	if(!isset($_COOKIE['vlog_listen_later'])){
		setcookie('vlog_listen_later', implode( "_", array( $post_id ) ), time() + 30 * 86400, COOKIEPATH, COOKIE_DOMAIN);
	} else {
		$ids = array_values($ids);
		setcookie('vlog_listen_later', implode( "_", $ids ), time() + 30 * 86400, COOKIEPATH, COOKIE_DOMAIN);
	}

	if(!empty($ids)){
		$args = array('post__in' => $ids );
		vlog_print_listen_later_posts( $args );
	}

	die();
}
endif;


/* Update latest theme version (we use internally for new version introduction text) */

add_action('wp_ajax_vlog_update_version', 'vlog_update_version');

if(!function_exists('vlog_update_version')):
function vlog_update_version(){
	update_option('vlog_theme_version',VLOG_THEME_VERSION);
	die();
}
endif;


/* Hide welcome screen */

add_action('wp_ajax_vlog_hide_welcome', 'vlog_hide_welcome');

if(!function_exists('vlog_hide_welcome')):
function vlog_hide_welcome(){
	update_option('vlog_welcome_box_displayed', true);
	die();
}
endif;

/**
 * Get searched posts or pages on ajax call for auto-complete functionality
 * 
 */
add_action( 'wp_ajax_vlog_ajax_search', 'vlog_ajax_search' );

if ( !function_exists( 'vlog_ajax_search' ) ):
	function vlog_ajax_search() {
		
		$post_type = in_array($_GET['type'], array('posts', 'cover')) ? array_keys( get_post_types( array( 'public' => true ) ) ) : $_GET['type'];
		
		$posts = get_posts( array(
				's' => $_GET['term'],
				'post_type' => $post_type,
				'posts_per_page' => -1
			) );

		$suggestions = array();

		global $post;
		
		foreach ( $posts as $post ) {
			setup_postdata( $post );
			$suggestion = array();
			$suggestion['label'] = esc_html( $post->post_title );
			$suggestion['id'] = $post->ID;
			$suggestions[]= $suggestion;
		}

		$response = $_GET["callback"] . "(" . json_encode( $suggestions ) . ")";

		echo wp_kses_post( $response );

		die();
	}
endif;

/**
 * This function is used only for dismissing admin notice for new Meks Video Importer Plugin
 */
add_action('wp_ajax_vlog_remove_meks_video_importer_admin_notice', 'vlog_remove_meks_video_importer_admin_notice');
if(!function_exists('vlog_remove_meks_video_importer_admin_notice')):
    function vlog_remove_meks_video_importer_admin_notice(){
        update_option('vlog_meks_video_importer_admin_notice_dismiss', true);
        die();
    }
endif;
?>