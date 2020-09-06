<?php

/**
 * Get module defaults
 *
 * @param  string $type Module type
 * @return array Default arguments of a module
 * @since  1.0
 */

if ( !function_exists( 'vlog_get_module_defaults' ) ):
	function vlog_get_module_defaults( $type = false ) {

		$defaults = array(
			'posts' => array(
				'type' => 'posts',
				'type_name' => esc_html__( 'Posts', 'vlog'),
				'title' => '',
				'hide_title' => 0,
				'columns' => 12,
				'layout' => 'b',
				'limit' => 10,
				'starter_layout' => 'none',
				'starter_limit' => 1,
				'css_class' => '',
				'cat' => array(),
				'tag' => array(),
				'manual' => array(),
				'time' => 0,
				'order' => 'date',
				'format' => 0,
				'unique' => 0,
				'slider' => 0,
				'slider_autoplay' => 0,
				'slider_autoplay_time' => 5,
				'more_text' => '',
				'more_url' => '',
				'sort'	=> 'DESC',
				'active' => 1,
                'cat_inc_exc' => 'in',
                'tag_inc_exc' => 'in'
			),

			'cats' => array(
				'type' => 'cats',
				'type_name' => esc_html__( 'Categories', 'vlog'),
				'title' => '',
				'hide_title' => 0,
				'layout' => 'e',
				'cat' => array(),
				'display_count' => 1,
				'display_icon'	=> 0,
				'count_label'	=> esc_html__( 'videos', 'vlog'),
				'css_class' => '',
				'slider' => 0,
				'slider_autoplay' => 0,
				'slider_autoplay_time' => 5,
				'more_text' => '',
				'more_url' => '',
				'active' => 1
			),

			'text' => array(
				'type' => 'text',
				'type_name' => esc_html__( 'Text', 'vlog'),
				'title' => '',
				'hide_title' => 0,
				'columns' => 12,
				'content' => '',
				'autop' => 0,
				'css_class' => '',
				'active' => 1
			)
		);

		if( vlog_is_series_active() ){
				
				$defaults['series'] = array(
					'type' => 'series',
					'type_name' => esc_html__( 'Series', 'vlog'),
					'title' => '',
					'hide_title' => 0,
					'layout' => 'e',
					'series' => array(),
					'display_count' => 1,
					'display_icon'	=> 1,
					'count_label'	=> esc_html__( 'videos', 'vlog'),
					'css_class' => '',
					'slider' => 0,
					'slider_autoplay' => 0,
					'slider_autoplay_time' => 5,
					'more_text' => '',
					'more_url' => '', 
					'active' => 1
				);
		}

		$custom_post_types = vlog_get_custom_post_types();
		if ( !empty( $custom_post_types ) ) {
			foreach ( $custom_post_types as $custom_post_type ) {
				$defaults[$custom_post_type] = array(
					'type' => $custom_post_type,
					'cpt' => true,
					'type_name' => esc_html__( 'CPT', 'vlog' ) . ' '.ucfirst( $custom_post_type ),
					'title' => '',
					'hide_title' => 0,
					'columns' => 12,
					'layout' => 'b',
					'limit' => 10,
					'starter_layout' => 'none',
					'starter_limit' => 1,
					'css_class' => '',
					'tax' => array(),
					'manual' => array(),
					'time' => 0,
					'order' => 'date',
					'unique' => 0,
					'slider' => 0,
					'slider_autoplay' => 0,
					'slider_autoplay_time' => 5,
					'more_text' => '',
					'more_url' => '',
					'sort'	=> 'DESC',
					'active' => 1
				);
                $custom_post_type_taxonomies = vlog_get_taxonomies( $custom_post_type );
                if(!empty($custom_post_type_taxonomies)){
                    foreach ($custom_post_type_taxonomies as $custom_post_type_taxonomy) {
                        $defaults[$custom_post_type][$custom_post_type_taxonomy['id'] . '_inc_exc'] = 'in';
                    }
                }
			}
		}


		if( !empty( $type ) && array_key_exists( $type, $defaults ) ){
			return $defaults[$type];
		}

		return $defaults;
		
	}
endif;

/**
 * Get module options
 *
 * @param  string $type Module type
 * @return array Options for sepcific module
 * @since  1.0
 */

if ( !function_exists( 'vlog_get_module_options' ) ):
	function vlog_get_module_options( $type = false ) {

		$options = array(
			'posts' => array(
				'layouts' => vlog_get_main_layouts(),
				'starter_layouts' => vlog_get_main_layouts( false, true ),
				'columns' => vlog_get_module_columns(),
				'cats' => get_categories( array( 'hide_empty' => false, 'number' => 0 ) ),
				'time' => vlog_get_time_diff_opts(),
				'order' => vlog_get_post_order_opts(),
				'formats' => vlog_get_post_format_opts(),
			),

			'cats' => array(
				'layouts' => vlog_get_cat_layouts(),
				'cats' => get_categories( array( 'hide_empty' => false, 'number' => 0 ) )
			),

			

			'text' => array(
				'columns' => vlog_get_module_columns(),
			)
		);

		if( vlog_is_series_active() ){
			$options['series'] = array(
				'layouts' => vlog_get_cat_layouts(),
				'series' => get_terms( array('taxonomy' => 'series', 'hide_empty' => false, 'number' => 0 ) )
			);
		}

		$custom_post_types = vlog_get_custom_post_types();

		if ( !empty( $custom_post_types ) ) {
			foreach ( $custom_post_types as $custom_post_type ) {
				$options[$custom_post_type] = array(
					'layouts' => vlog_get_main_layouts(),
					'starter_layouts' => vlog_get_main_layouts( false, true ),
					'columns' => vlog_get_module_columns(),
					'cats' => get_categories( array( 'hide_empty' => false, 'number' => 0 ) ),
					'time' => vlog_get_time_diff_opts(),
					'order' => vlog_get_post_order_opts(),
					'formats' => vlog_get_post_format_opts(),
					'taxonomies' => vlog_get_taxonomies( $custom_post_type )
				);
			}
		}


		if( !empty( $type ) && array_key_exists( $type, $options ) ){
			return $options[$type];
		}

		return $options;
		
	}
endif;

				

/**
 * Get module layout
 *
 * Functions gets current post layout for specific module
 *
 * @param array   $module Module data
 * @param int     $i      index of current post
 * @return string id of current layout
 * @since  1.0
 */

if ( !function_exists( 'vlog_get_module_layout' ) ):
	function vlog_get_module_layout( $module, $i ) {

		if( vlog_module_is_slider( $module ) ){
			
			return $module['layout'];

		} else if ( isset($module['starter_layout']) && $module['starter_layout'] != 'none' &&  $i < absint( $module['starter_limit'] ) ) {
			
			return $module['starter_layout'];
		}

		return $module['layout'];
	}
endif;

/**
 * Is module slider
 *
 * Check if slider is applied to module
 *
 * @param array   $module Module data
 * @return bool
 * @since  1.0
 */

if ( !function_exists( 'vlog_module_is_slider' ) ):
	function vlog_module_is_slider( $module ) {

		if ( isset($module['slider']) && !empty( $module['slider'] ) ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Is module combined
 *
 * Check if module has starter posts
 *
 * @param array   $module Module data
 * @return bool
 * @since  1.0
 */

if ( !function_exists( 'vlog_module_is_combined' ) ):
	function vlog_module_is_combined( $module ) {

		if ( isset($module['starter_layout']) && $module['starter_layout'] != 'none' && !empty( $module['starter_limit']) ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Is module paginated
 *
 * Check if current module has a pagination
 * 
 * @param   $i current section index
 * @param   $j current module index
 * @return bool
 * @since  1.0
 */

if ( !function_exists( 'vlog_module_is_paginated' ) ):
	function vlog_module_is_paginated( $i, $j ) {
		global $vlog_module_pag_index;
		
		if(!empty($vlog_module_pag_index) && $vlog_module_pag_index['s_ind'] == $i && $vlog_module_pag_index['m_ind'] == $j ){
			return true;
		}

		return false;
	}
endif;

/**
 * Set paginated module index
 *
 * Get last posts module index so we know to which module we should apply pagination
 * and set indexes to $vlog_module_pag_index global var
 *
 * @param array   $sections Sections data array
 * @return void
 * @since  1.0
 */

if ( !function_exists( 'vlog_set_paginated_module_index' ) ):
	function vlog_set_paginated_module_index( $sections, $paged = false ) {
		
		global $vlog_module_pag_index;

		//If we are on paginated modules page it shows only one section and module so index is set to "0"
		if( $paged ){

			$vlog_module_pag_index = array( 's_ind' => 0, 'm_ind' => 0 );
		
		} else {

			$last_section_index = false;
			$last_module_index = false;
			foreach( $sections as $m => $section ){
				if(!empty($section['modules'])){
					foreach( $section['modules'] as $n => $module ){
						if($module['type'] == 'posts'){
							$last_section_index = $m;
							$last_module_index = $n;
						}
					}
				}
			}

			if( $last_section_index !== false && $last_module_index !== false ){
				$vlog_module_pag_index = array( 's_ind' => $last_section_index, 'm_ind' => $last_module_index );
			}
		}
	}
endif;

/**
 * Module template is paged
 *
 * Check if we are on paginated modules page
 *
 * @return int|false
 * @since  1.0
 */

if ( !function_exists( 'vlog_module_template_is_paged' ) ):
	function vlog_module_template_is_paged() {
		$curr_page = is_front_page() ? absint( get_query_var('page') ) : absint( get_query_var('paged') );
		return $curr_page > 1 ? $curr_page : false;
	}
endif;


/**
 * Parse paged module template
 *
 * When we are on paginated module page
 * pull only the last posts module and its section 
 * but check queries for other modules in other sections
 *
 * @param  array $sections existing sections data
 * @return array parsed new section data
 * @since  1.0
 */

if ( !function_exists( 'vlog_parse_paged_module_template' ) ):
	function vlog_parse_paged_module_template( $sections ) {

		foreach( $sections as $s_ind => $section ){
			if(!empty($section['modules'])){
				foreach( $section['modules'] as $m_ind => $module ){
					
					$module = vlog_parse_args( $module, vlog_get_module_defaults( $module['type'] ) );

					if($module['type'] == 'posts'){
						
						if( vlog_module_is_paginated( $s_ind, $m_ind ) ) {
						
							$new_sections = array( 0 => $section );
							$module['starter_layout'] = 'none';
							$new_sections[0]['modules'] = array( 0 => $module );
							return $new_sections;
						
						} else {
						
							if( $module['unique'] && $module['active'] ){
								vlog_get_module_query( $module );
							}
						}

					}
				}
			}
		}

	}
endif;




/**
 * Get module heading
 *
 * Function gets heading/title html for current module
 *
 * @param array   $module Module data
 * @return string HTML output
 * @since  1.0
 */

if ( !function_exists( 'vlog_get_module_heading' ) ):
	function vlog_get_module_heading( $module ) {

		$args = array();

		if ( !empty( $module['title'] ) && empty( $module['hide_title'] ) ) {

			$args['title'] = '<h4>'.$module['title'].'</h4>';
		}

		$args['actions'] = '';

		if ( isset( $module['more_text'] ) && !empty( $module['more_text'] ) && !empty( $module['more_url'] ) ) {
			$args['actions'].= '<a class="vlog-all-link" href="'.esc_url( $module['more_url'] ).'">'.$module['more_text'].'</a>';
		}

		if ( vlog_module_is_slider( $module ) ) {
			$args['actions'].= '<div class="vlog-slider-controls" data-col="'.esc_attr( vlog_layout_columns( $module['layout']) ).'" data-autoplay="'.esc_attr($module['slider_autoplay']).'" data-autoplay-time="'.esc_attr(absint($module['slider_autoplay_time'])).'"></div>';
		}

		return !empty( $args ) ? vlog_module_heading( $args ) : '';

	}
endif;

/**
 * Get module query
 *
 * @param array   $module Module data
 * @return object WP_query
 * @since  1.0
 */

if ( !function_exists( 'vlog_get_module_query' ) ):
	function vlog_get_module_query( $module, $paged = false ) {
		
		global $vlog_unique_module_posts;

		$module = wp_parse_args( $module, vlog_get_module_defaults($module['type']) );

		$args['ignore_sticky_posts'] = 1;

		if ( !empty( $module['manual'] ) ) {

			$args['posts_per_page'] = absint( count( $module['manual'] ) );
			$args['orderby'] =  'post__in';
			$args['post__in'] =  $module['manual'];
			$args['post_type'] = array_keys( get_post_types( array( 'public' => true ) ) ); //support all existing public post types

		} else {

			$args['post_type'] = 'post';
			$args['posts_per_page'] = absint( $module['limit'] );

			if ( !empty( $module['cat'] ) ) {
                $args['category__' . $module['cat_inc_exc']] = $module['cat'];
			}

			if ( !empty( $module['tag'] ) ) {
                $args['tag__' . $module['tag_inc_exc']] = vlog_get_tax_term_id_by_slug($module['tag']);
			}

			if ( !empty( $module['format'] ) ) {
				
				if( $module['format'] == 'standard'){
					
					$terms = array();
					$formats = get_theme_support('post-formats');
					if(!empty($formats) && is_array($formats[0])){
						foreach($formats[0] as $format){
							$terms[] = 'post-format-'.$format;
						}
					}
					$operator = 'NOT IN';

				} else {
					$terms = array('post-format-'.$module['format']);
					$operator = 'IN';
				}
				
				$args['tax_query'] = array(
					array(
					'taxonomy' => 'post_format',
					'field'    => 'slug',
					'terms'    => $terms,
					'operator' => $operator
					)
				);
			}
			

			$args['orderby'] = $module['order'];
			$args['order'] = $module['sort'];

			if ( $args['orderby'] == 'views' && function_exists( 'ev_get_meta_key' ) ) {

				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = ev_get_meta_key();

			}

			if ( $time_diff = $module['time'] ) {
				$args['date_query'] = array( 'after' => date( 'Y-m-d', vlog_calculate_time_diff( $time_diff ) ) );
			}

			if( !empty( $vlog_unique_module_posts ) ){
				$args['post__not_in'] = $vlog_unique_module_posts;
			}
		}

		if( $paged ){
			$args['paged'] = $paged;
		}

		$args = apply_filters( 'vlog_modify_module_query_args', $args );

		$query = new WP_Query( $args );

		if ( $module['unique'] && !is_wp_error( $query ) && !empty( $query ) ) {

			foreach ( $query->posts as $p ) {
				$vlog_unique_module_posts[] = $p->ID;
			}
		}

		return $query;

	}
endif;

/**
 * Get featured area query
 *
 * @param array  $fa Featured area settings to parse the query
 * @return object WP_query
 * @since  1.0
 */

if ( !function_exists( 'vlog_get_featured_area_query' ) ):
	function vlog_get_featured_area_query( $fa ) {
		
		global $vlog_unique_module_posts;

		$args['ignore_sticky_posts'] = 1;

		if ( !empty( $fa['manual'] ) ) {

			$args['orderby'] =  'post__in';
			$args['post__in'] =  $fa['manual'];
			$args['posts_per_page'] = absint( count( $fa['manual'] ) );
			$args['post_type'] = array_keys( get_post_types( array( 'public' => true ) ) ); //support all existing public post types

		} else {

			$args['post_type'] = $fa['post_type'];
			$post_type_with_taxonomies = vlog_get_post_type_with_taxonomies($fa['post_type']);
			$args['posts_per_page'] = absint( $fa['limit'] ) ;

			if(!empty($post_type_with_taxonomies->taxonomies)){
				foreach ( $post_type_with_taxonomies->taxonomies as $taxonomy ) {
					$taxonomy_id = vlog_patch_taxonomy_id($taxonomy['id']);
					
					if(empty($fa[$taxonomy_id . '_inc_exc']) || empty($fa[$taxonomy_id])){
					   continue;
					}
					
					$operator = $fa[$taxonomy_id . '_inc_exc'] === 'not_in' ? 'NOT IN' : 'IN';
					
					if($taxonomy['hierarchical']){
						$args['tax_query'][] = array(
							'taxonomy' => $taxonomy['id'],
							'field'    => 'id',
							'terms'    => $fa[$taxonomy_id],
							'operator' => $operator
						);
					}else{
						$args['tax_query'][] = array(
							'taxonomy' => $taxonomy['id'],
							'field'    => 'id',
							'terms'    => vlog_get_tax_term_id_by_slug($fa[$taxonomy_id], $taxonomy['id']),
							'operator' => $operator
						);
					}
			    }
			}

			if ( !empty( $fa['format'] ) ) {
				
				if( $fa['format'] == 'standard'){
					
					$terms = array();
					$formats = get_theme_support('post-formats');
					if(!empty($formats) && is_array($formats[0])){
						foreach($formats[0] as $format){
							$terms[] = 'post-format-'.$format;
						}
					}
					$operator = 'NOT IN';

				} else {
					$terms = array('post-format-'.$fa['format']);
					$operator = 'IN';
				}
				
				$args['tax_query'][] = array(
					'taxonomy' => 'post_format',
					'field'    => 'slug',
					'terms'    => $terms,
					'operator' => $operator
				);
			}

			$args['orderby'] = $fa['order'];
			$args['order'] = $fa['sort'];

			if ( $args['orderby'] == 'views' && function_exists( 'ev_get_meta_key' ) ) {
				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = ev_get_meta_key();
			}

			if($args['orderby'] == 'title'){
				$args['order'] = 'ASC';
			}

			if ( $time_diff = $fa['time'] ) {
				$args['date_query'] = array( 'after' => date( 'Y-m-d', vlog_calculate_time_diff( $time_diff ) ) );
			}

			if( !empty( $vlog_unique_module_posts ) ){
				$args['post__not_in'] = $vlog_unique_module_posts;
			}
		}

		$args = apply_filters( 'vlog_modify_featured_query_args', $args );

		$query = new WP_Query( $args );
		
		if ( $fa['unique'] && !is_wp_error( $query ) && !empty( $query ) ) {

			foreach ( $query->posts as $p ) {
				$vlog_unique_module_posts[] = $p->ID;
			}
		}

		return $query;

	}
endif;

/**
 * Get module cpt query
 *
 * @param array   $module Module data
 * @return object WP_query
 * @since  1.5.1
 */

if ( !function_exists( 'vlog_get_module_cpt_query' ) ):
	function vlog_get_module_cpt_query( $module, $paged = false ) {

		global $vlog_unique_module_posts;

		$module = wp_parse_args( $module, vlog_get_module_defaults( $module['type'] ) );

		$args['ignore_sticky_posts'] = 1;

		if ( !empty( $module['manual'] ) ) {
			$args['posts_per_page'] = absint( count( $module['manual'] ) );
			$args['orderby'] =  'post__in';
			$args['post__in'] =  $module['manual'];
			$args['post_type'] = array_keys( get_post_types( array( 'public' => true ) ) ); //support all existing public post types

		} else {

			$args['post_type'] = $module['type'];
			$args['posts_per_page'] = absint( $module['limit'] );

			$args['orderby'] = $module['order'];

			if ( $args['orderby'] == 'views' && function_exists( 'ev_get_meta_key' ) ) {

				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = ev_get_meta_key();

			} 


			$args['order'] = $module['sort'];

			if ( $time_diff = $module['time'] ) {
				$args['date_query'] = array( 'after' => date( 'Y-m-d', vlog_calculate_time_diff( $time_diff ) ) );
			}

			if ( !empty( $vlog_unique_module_posts ) ) {
				$args['post__not_in'] = $vlog_unique_module_posts;
			}


			if ( !empty( $module['tax'] ) ) {
				$taxonomies = array();
				foreach ( $module['tax'] as $k => $v ) {
					$temp = array();
					$temp['fields'] = 'id';
					$temp['taxonomy'] = $k;
					$temp['terms'] = $v;
                    $temp['operator'] = $module[$k . '_inc_exc'] == 'not_in' ? 'NOT IN' : 'IN';
					$taxonomies[] = $temp;
				}

				$args['tax_query'] = $taxonomies;
			}
		}

		if ( $paged ) {
			$args['paged'] = $paged;
		}

		$args = apply_filters( 'vlog_modify_cpt_query_args', $args );

		$query = new WP_Query( $args );

		if ( $module['unique'] && !is_wp_error( $query ) && !empty( $query ) ) {

			foreach ( $query->posts as $p ) {
				$vlog_unique_module_posts[] = $p->ID;
			}
		}

		return $query;

	}
endif;

/**
 * Get layout columns
 *
 * @param  string $layout Layout ID
 * @return int Bootsrap col-lg ID
 * @since  1.0
 */

if ( !function_exists( 'vlog_layout_columns' ) ):
	function vlog_layout_columns( $layout ) {

		$layouts = array( 
			'a' => 12,
			'b' => 12,
			'c' => 6,
			'd' =>  6,
			'e' =>  4,
			'f' =>  4,
			'g' =>  3,
			'h' =>  3
		);

		$layouts = apply_filters( 'vlog_modify_layout_columns', $layouts );
		return $layouts[$layout];
	}
endif;

/**
 * Check if we need to apply eq height class to specific posts module
 *
 * @param  array $module
 * @return bool
 * @since  1.0
 */

if ( !function_exists( 'vlog_module_is_eq_height' ) ):
	function vlog_module_is_eq_height( $module ) {

		if( !vlog_module_is_combined($module) ) {
			return true;
		}

		if( ( vlog_layout_columns($module['starter_layout']) * $module['starter_limit'] ) % $module['columns'] ){
			return false;
		}

		return true;
		
	}
endif;


/**
 * Get all public custom post types 
 *
 * @return array List of slugs
 * @since  1.5.1 
 */

if ( !function_exists( 'vlog_get_custom_post_types' ) ):
	function vlog_get_custom_post_types( $raw = false ) {

		$custom_post_types =  get_post_types( array( 'public' => true, '_builtin' => false ), 'object' );
		
		if(!empty( $custom_post_types )){
			
			$exclude = array( 'topic', 'forum', 'guest-author', 'reply' );
			
			foreach( $custom_post_types as $i => $obj ){
				if( in_array($obj->name, $exclude) ){
					unset( $custom_post_types[$i] );
				}
			}
			
			if(!$raw) {
				$custom_post_types = array_keys( $custom_post_types );
			}
		}

		$custom_post_types =  apply_filters('vlog_modify_custom_post_types_list', $custom_post_types );
		
		return $custom_post_types;
	}
endif;

/**
 * Get all taxonomies for custom post type
 *
 * @param  $cpt Custom post type ID
 * @return array List of custom post types and taxonomies
 * @since  1.5.1 
 */
if ( !function_exists( 'vlog_get_taxonomies' ) ) :
function vlog_get_taxonomies( $cpt ) {

    $taxonomies = get_taxonomies( array(
        'object_type' => array($cpt),
        'public' => true,
        'show_ui' => true
    ), 'object');

    $output = array();

    if(!empty($taxonomies)){
        foreach ( $taxonomies as $taxonomy ) {

            $tax = array();
            $tax['id'] = $taxonomy->name;
            $tax['name'] = $taxonomy->label;
            $tax['hierarchical'] = $taxonomy->hierarchical;
            if( $tax['hierarchical'] ){
                $tax['terms'] = get_terms( $taxonomy->name, array('hide_empty' => false) );
            }

            $output[] = $tax;
        }
    }

	return $output;
}
endif;

/**
 * Get term IDs by term names for specific taxonomy
 *
 * @param array   $names List of term names
 * @param string  $tax   Taxonomy name
 * @return array List of term IDs
 * @since  1.5.1 
 */

if ( !function_exists( 'vlog_get_tax_term_id_by_name' ) ):
	function vlog_get_tax_term_id_by_name( $names, $tax = 'post_tag' ) {

		if ( empty( $names ) ) {
			return '';
		}

		if(!is_array($names)){
			$names = explode(",", $names );
		}

		$ids = array();

		foreach ( $names as $name ) {
			$tag = get_term_by( 'name', trim( $name ), $tax);
			if ( !empty( $tag ) && isset( $tag->term_id ) ) {
				$ids[] = $tag->term_id;
			}
		}
		return $ids;

	}
endif;

/**
 * Get term names by term id for specific taxonomy
 *
 * @param array   $names List of term ids
 * @param string  $tax   Taxonomy name
 * @return array List of term names
 * @since  1.5.1 
 */

if ( !function_exists( 'vlog_get_tax_term_name_by_id' ) ):
	function vlog_get_tax_term_name_by_id( $ids, $tax = 'post_tag' ) {

		if ( empty( $ids ) ) {
			return '';
		}

		$names = array();

		foreach ( $ids as $id ) {
			$tag = get_term_by( 'id', trim( $id ), $tax);
			if ( !empty( $tag ) && isset( $tag->name ) ) {
				$names[] = $tag->name;
			}
		}

		$names = implode(',', $names);

		return $names;

	}
endif;

/**
 * Get posts from manually selected field in modules  
 *
 * @since  1.8 
 *
 * @param srting $post_ids - Selected posts ids from choose manually meta field
 * @return array - List of selected posts or empty list
 */
if ( !function_exists( 'vlog_get_manually_selected_posts' ) ):
	function vlog_get_manually_selected_posts( $post_ids, $module_type = 'posts' ) {
		
		if ( empty($post_ids) ) {
			return array();
		}

		$post_type = in_array($module_type, array('posts', 'cover')) ? array_keys( get_post_types( array( 'public' => true ) ) ) : $module_type;

		$get_selected_posts = get_posts( 
			array(
				'post__in' => $post_ids, 
				'orderby' => 'post__in', 
				'post_type' => $post_type, 
				'posts_per_page' => '-1'
			) 
		);

		return wp_list_pluck( $get_selected_posts, 'post_title', 'ID' );
	}
endif;


/**
 * Display manualy selected posts  
 *
 * @since  1.8 
 *
 * @param array $posts - Array of manualy selected posts
 * @return HTML - Title of manualy selected post
 */
if ( !function_exists( 'vlog_display_manually_selected_posts' ) ):
	function vlog_display_manually_selected_posts($posts) {
		
		if ( empty($posts) ) {
			return;
		}

		$output = '';
	 	foreach ( $posts as $id => $title ){
			$output .= '<span><button type="button" class="ntdelbutton" data-id="'. esc_attr($id) .'"><span class="remove-tag-icon"></span></button><span class="vlog-searched-title">'. esc_html( $title ). '</span></span>';
		} 

		echo wp_kses_post( $output );
	}
endif;

/**
 * Used for getting post types with all taxonomies
 *
 * @return array
 * @since    1.9.1
 */
if (!function_exists('vlog_get_posts_types_with_taxonomies')):
	function vlog_get_posts_types_with_taxonomies( $exclude = array() ) {
		
		$post_types_with_taxonomies = array();
		
		$post_types = vlog_get_custom_post_types( true );
		$post_types[] = get_post_type_object('post');
		
		if (empty($post_types))
			return null;
		
		foreach ($post_types as $post_type) {
			if(in_array($post_type->name, $exclude)){
				continue;
			}
			
			$post_taxonomies = vlog_get_taxonomies($post_type->name);
			
			$post_type->taxonomies = $post_taxonomies;
			$post_types_with_taxonomies[] = $post_type;
		}
		
		return apply_filters('vlog_modify_posts_types_with_taxonomies', $post_types_with_taxonomies);
	}
endif;

/**
 * Get default fa data
 *
 * @return array
 * @since    1.9.1
 */
if(!function_exists('vlog_get_fa_post_data_for_saving')):
	function vlog_get_fa_post_data_for_saving($append = array()){
		$default =  array(
			'layout',
			'limit',
			'manual',
			'time',
			'order',
			'format',
			'sort',
			'content',
			'bg_image',
			'post_type',
			'unique'
		);
		
		$data = vlog_parse_args($append, $default);
		
		return apply_filters('vlog_modify_fa_post_data',$data);
	}
endif;

/**
 * Now when taxonomies are dynamical in featrued area depanding on post type we have to overwrite old settings.
 * For Category to cat and for post_tag to tag
 *
 * @string $taxonomy_id
 * @since 1.9.1
 * @return $taxonomy_id
 */
if(!function_exists('vlog_patch_category_and_tags')):
    function vlog_patch_taxonomy_id($taxonomy_id){
	
	    if ( in_array( $taxonomy_id, array( 'category', 'post_tag' ) ) ) {
		    if ( $taxonomy_id === 'category' ) {
			    $taxonomy_id = 'cat';
		    }
		    if ( $taxonomy_id === 'post_tag' ) {
			    $taxonomy_id = 'tag';
		    }
	    }
	    
	    return $taxonomy_id;
    }
endif;
?>