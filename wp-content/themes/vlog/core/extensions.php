<?php

/* Allow shortcodes in widgets */
add_filter( 'widget_text', 'do_shortcode' );


/* Add classes to body tag */

add_filter( 'body_class', 'vlog_body_class' );

if ( !function_exists( 'vlog_body_class' ) ):
	function vlog_body_class( $classes ) {

		if ( vlog_get_option( 'content_layout' ) == 'boxed' ) {
			$classes[] = 'vlog-boxed';
		}

		$classes[] = 'vlog-v_' . str_replace('.', '_', VLOG_THEME_VERSION);

		if ( is_child_theme() ) {
			$classes[] = 'vlog-child';
		}

		return $classes;
	}
endif;


/**
 * Widget display callback
 *
 * Check if highlight option is selected and add vlog highlight class to widget
 *
 * @return void
 * @since  1.0
 */

add_filter( 'dynamic_sidebar_params', 'vlog_modify_widget_display' );

if ( !function_exists( 'vlog_modify_widget_display' ) ) :

	function vlog_modify_widget_display( $params ) {

		if ( strpos( $params[0]['id'], 'vlog_footer_sidebar' ) !== false ) {
			return $params; //do not apply highlight styling for footer widgets
		}

		global $wp_registered_widgets;

		$widget_id              = $params[0]['widget_id'];
		$widget_obj             = $wp_registered_widgets[$widget_id];
		$widget_num             = $widget_obj['params'][0]['number'];
		$widget_opt = get_option( $widget_obj['callback'][0]->option_name );

		if ( isset( $widget_opt[$widget_num]['vlog-highlight'] ) && $widget_opt[$widget_num]['vlog-highlight'] == 1 ) {
			$params[0]['before_widget'] = preg_replace_callback( '/class="/', function($m) { return $m[0] . "vlog-highlight " ; }, $params[0]['before_widget'] );
		}

		if ( isset( $widget_opt[$widget_num]['vlog-full-width'] ) && $widget_opt[$widget_num]['vlog-full-width'] == 1 ) {
			$params[0]['before_widget'] = preg_replace_callback( '/class="/', function($m) { return $m[0] . "vlog-no-padding " ; }, $params[0]['before_widget'] );
		}

		return $params;

	}

endif;


/* Add media grabber features */

add_action( 'init', 'vlog_add_media_grabber' );

if ( !function_exists( 'vlog_add_media_grabber' ) ):
	function vlog_add_media_grabber() {
		if ( !class_exists( 'Hybrid_Media_Grabber' ) ) {

			include_once get_parent_theme_file_path( '/inc/media-grabber/class-hybrid-media-grabber.php' );			
		}
	}
endif;

/* Add class to gallery images to run our pop-up and change sizes */

add_filter( 'shortcode_atts_gallery', 'vlog_gallery_atts', 10, 3 );

if ( !function_exists( 'vlog_gallery_atts' ) ):
	function vlog_gallery_atts( $output, $pairs, $atts ) {


		$atts['link'] = 'file';
		$output['link'] = 'file';


		if ( !isset( $output['columns'] ) ) {
			$output['columns'] = 1;
		}

		if ( vlog_get_option( 'auto_gallery_img_sizes' ) ) {
			switch ( $output['columns'] ) {
			case '1' : $output['size'] = 'vlog-lay-a-full'; break;
			case '2' : $output['size'] = 'vlog-lay-b-full'; break;
			case '3' : $output['size'] = 'vlog-lay-e-full'; break;
			case '4' :
			case '5' :
			case '6' :
			case '7' :
			case '8' :
			case '9' : $output['size'] = 'vlog-lay-g-full'; break;
			default: $output['size'] = 'vlog-lay-a-full'; break;
			}

			//Check if has a matched image size
			global $vlog_image_matches;

			if ( !empty( $vlog_image_matches ) && array_key_exists( $output['size'], $vlog_image_matches ) ) {
				$output['size'] = $vlog_image_matches[$output['size']];
			}
		}

		return $output;
	}
endif;

if ( !function_exists( 'vlog_add_class_attachment_link' ) ):
	function vlog_add_class_attachment_link( $link ) {
		$link = str_replace( '<a', '<a class="vlog-popup"', $link );
		return $link;
	}
endif;



/* Unregister Widgets */
add_action( 'widgets_init', 'vlog_unregister_widgets', 99 );

if ( !function_exists( 'vlog_unregister_widgets' ) ):
	function vlog_unregister_widgets() {

		$widgets = array( 'EV_Widget_Entry_Views', 'Series_Widget_List_Posts', 'Series_Widget_List_Related' );

		//Allow child themes or plugins to add/remove widgets they want to unregister
		$widgets = apply_filters( 'vlog_modify_unregister_widgets', $widgets );

		if ( !empty( $widgets ) ) {
			foreach ( $widgets as $widget ) {
				unregister_widget( $widget );
			}
		}

	}
endif;


/* Remove entry views support for other post types, we need post support only */

add_action( 'init', 'vlog_remove_entry_views_support', 99 );

if ( !function_exists( 'vlog_remove_entry_views_support' ) ):
	function vlog_remove_entry_views_support() {

		$types = array( 'page', 'attachment', 'literature', 'portfolio_item', 'recipe', 'restaurant_item' );

		//Allow child themes or plugins to modify entry views support
		$widgets = apply_filters( 'vlog_modify_entry_views_support', $types );

		if ( !empty( $types ) ) {
			foreach ( $types as $type ) {
				remove_post_type_support( $type, 'entry-views' );
			}
		}

	}
endif;


/* Prevent redirect issue that may brake home page pagination caused by some plugins */
add_filter( 'redirect_canonical', 'vlog_disable_redirect_canonical' );

function vlog_disable_redirect_canonical( $redirect_url ) {
	if ( is_page_template( 'template-modules.php' ) && is_paged() ) {
		$redirect_url = false;
	}
	return $redirect_url;
}



/* Add span elements to post count number in category widget */

add_filter( 'wp_list_categories', 'vlog_add_span_cat_count', 10, 2 );

if ( !function_exists( 'vlog_add_span_cat_count' ) ):
	function vlog_add_span_cat_count( $links, $args ) {

		if ( isset( $args['taxonomy'] ) && $args['taxonomy'] != 'category' ) {
			return $links;
		}

		$links = preg_replace( '/(<a[^>]*>)/', '$1<span class="category-text">', $links );
		$links = str_replace( '</a>', '</span></a>', $links );
		$links = str_replace( '</a> (', '<span class="vlog-count">', $links );
		$links = str_replace( ')', '</span></a>', $links );

		return $links;
	}
endif;

/* Pre get posts */
add_action( 'pre_get_posts', 'vlog_pre_get_posts' );

if ( !function_exists( 'vlog_pre_get_posts' ) ):
	function vlog_pre_get_posts( $query ) {

		if ( !is_admin() && $query->is_main_query() && $query->is_archive() && !$query->is_feed() ) {

			$template = vlog_detect_template();

			/* Check whether to change number of posts per page for specific archive template */
			$obj = get_queried_object();

			$ppp = vlog_get_option( $template.'_ppp' );

			if ( $ppp == 'custom' ) {
				$ppp_num = absint( vlog_get_option( $template.'_ppp_num' ) );
				$query->set( 'posts_per_page', $ppp_num );
			}

			/* Serie  */
			if ( $template == 'serie' ) {

				$meta = vlog_get_series_meta( $obj->term_id );

				if ( $meta['layout']['type'] == 'custom' ) {

					$query->set( 'posts_per_page', absint( $meta['layout']['ppp'] ) );
				}

				$ascending = ( $meta['layout']['type'] == 'custom' ) ? $meta['layout']['serie_order_asc'] : vlog_get_option( $template.'_order_asc' );

				if ( $ascending ) {
					$query->set( 'order', 'ASC' );
				}

				$fa = vlog_get_featured_area();

				if ( isset( $fa['query'] ) && !empty( $fa['query'] ) ) {

					$exclude_ids = array();
					
					foreach ( $fa['query']->posts as $p ) {
						$exclude_ids[] = $p->ID;
					}

					$query->set( 'post__not_in', $exclude_ids );

				}

				wp_reset_postdata();

			}

			/* Category */
			if ( $template == 'category' ) {

				$meta = vlog_get_category_meta( $obj->term_id );

				if ( $meta['layout']['type'] == 'custom' ) {

					$query->set( 'posts_per_page', absint( $meta['layout']['ppp'] ) );
				}

				$is_unique_cat = ( $meta['layout']['type'] == 'inherit' ) ? vlog_get_option( $template.'_fa_unique' ) : $meta['layout']['cover_unique'];

				if ( $is_unique_cat ) {

					$fa = vlog_get_featured_area();

					if ( isset( $fa['query'] ) && !empty( $fa['query'] ) ) {

						$exclude_ids = array();
						
						foreach ( $fa['query']->posts as $p ) {
							$exclude_ids[] = $p->ID;
						}

						$query->set( 'post__not_in', $exclude_ids );

					}

					wp_reset_postdata();
				}
			}
		}

	}
endif;


/**
 * Filter function to add class to linked media image for popup
 *
 * @return   $content
 */

add_filter( 'the_content', 'vlog_popup_media_in_content', 100, 1 );

if ( !function_exists( 'vlog_popup_media_in_content' ) ):
	function vlog_popup_media_in_content( $content ) {

		if ( vlog_get_option( 'on_single_img_popup' ) ) {

			$pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")>/i";
			$replacement = '<a$1class="vlog-popup-img" href=$2$3.$4$5>';
			$content = preg_replace( $pattern, $replacement, $content );
			return $content;
		}

		return  $content;
	}
endif;

/**
 * Modify WooCommerce wrappers
 *
 * Provide support for WooCommerce pages to match theme HTML markup
 *
 * @return HTML output
 * @since  1.5
 */

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', 'vlog_woocommerce_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'vlog_woocommerce_wrapper_end', 10 );

if ( !function_exists( 'vlog_woocommerce_wrapper_start' ) ):
	function vlog_woocommerce_wrapper_start() {
		global $vlog_sidebar_opts; 
		$sidebar_class = $vlog_sidebar_opts['use_sidebar'] == 'none' ? 'vlog-single-no-sid' : '';
		echo '<div class="vlog-section '.esc_attr( $sidebar_class ).'"><div class="container"><div class="vlog-content vlog-single-content">';
	}
endif;

if ( !function_exists( 'vlog_woocommerce_wrapper_end' ) ):
	function vlog_woocommerce_wrapper_end() {
		echo '</div>';
	}
endif;

add_action( 'vlog_before_end_content', 'vlog_woocommerce_close_wrap' );

if ( !function_exists( 'vlog_woocommerce_close_wrap' ) ):
	function vlog_woocommerce_close_wrap() {
		if ( vlog_is_woocommerce_active() && vlog_is_woocommerce_page() ) {
			echo '</div></div>';
		}
	}
endif;



add_filter('media_embedded_in_content_allowed_types', 'vlog_extend_embed_types', 10, 2 );

/**
 * Extend embed types
 *
 * We use it to extend embed types for various video sources which are loaded via script tags
 *
 * @since  1.7
 */

if ( !function_exists( 'vlog_extend_embed_types' ) ):
function vlog_extend_embed_types( $types ){

	global $post;
	
	if( isset($post->post_content) && preg_match('/cdn.playwire.com/', $post->post_content) ){
		$types[] = 'script';
	}
	
	return $types;
}
endif;

/**
 * Add three dots to end of main menu
 *
 * @since  2.0
 */
if(!function_exists('vlog_add_last_three_dots_to_menu')):
	function vlog_add_last_three_dots_to_menu($items, $args) {
		if($args->theme_location != 'vlog_main_menu' || strpos($args->menu_class, 'vlog-mob-nav') !== false){
			return $items;
		}
		
		$items .= '<li id="vlog-menu-item-more" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children"><a href="javascript:void(0)">&middot;&middot;&middot;</a><ul class="sub-menu"></ul></li>';
		
		return $items;
	}
endif;

add_filter('wp_nav_menu_items','vlog_add_last_three_dots_to_menu', 10, 2);

/**
 * Modify series plugin taxonomy args 
 *
 * @param array $args
 * @return array
 * @since  1.8
 */
add_filter( 'series/series_taxonomy_args', 'vlog_modify_series_taxonomy_args' );

if ( !function_exists('vlog_modify_series_taxonomy_args') ) :	
	function vlog_modify_series_taxonomy_args($args) {
		$args['show_in_rest'] = true;
		return $args;
	}
endif;

/**
 * Filter for social share options on frontend in the_content filter
 *
 * @param array $options - Array of options 
 * @return array
 * @since  1.9
 */
add_filter( 'meks_ess_modify_options', 'vlog_social_share_modify_options' );

if ( !function_exists( 'vlog_social_share_modify_options' ) ):
	function vlog_social_share_modify_options( $options ) {

		// $options['style'] = '6';
		// $options['variant'] = '1';
		// $options['color']['type'] = 'brand';
		$options['location'] = 'custom';
		$options['post_type'] = array('post');
		$options['label_share']['active'] = '0';

		return $options;
	}
endif;

/**
 * Filter for social share default options
 *
 * @param array $options - Array of options 
 * @return array
 * @since  1.2
 */
add_filter( 'meks_ess_modify_defaults', 'opinion_social_share_modify_defaults' );

if ( !function_exists( 'opinion_social_share_modify_defaults' ) ):
	function opinion_social_share_modify_defaults( $defaults ) {

		$defaults['style'] = '6';

		return $defaults;
	}
endif;