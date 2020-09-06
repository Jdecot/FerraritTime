<?php 

/**
 * Load page metaboxes
 * 
 * Callback function for page metaboxes load
 * 
 * @since  1.0
 */

if ( !function_exists( 'vlog_load_page_metaboxes' ) ) :
	function vlog_load_page_metaboxes() {
		

		/* Sidebar metabox */
		add_meta_box(
			'vlog_sidebar',
			esc_html__( 'Sidebar', 'vlog' ),
			'vlog_sidebar_metabox',
			'page',
			'side',
			'default'
		);

		/* Featured area metabox */
		add_meta_box(
			'vlog_fa',
			esc_html__( 'Cover Area', 'vlog' ),
			'vlog_fa_metabox',
			'page',
			'normal',
			'high'
		);

		/* Modules metabox */
		add_meta_box(
			'vlog_modules',
			esc_html__( 'Modules', 'vlog' ),
			'vlog_modules_metabox',
			'page',
			'normal',
			'high'
		);

		/* Pagination metabox */
		add_meta_box(
			'vlog_pagination',
			esc_html__( 'Pagination', 'vlog' ),
			'vlog_pagination_metabox',
			'page',
			'normal',
			'high'
		);
		
		
		/* Blank template metabox */
		add_meta_box(
			'vlog_blank_page_template',
			esc_html__( 'Display Settings', 'vlog' ),
			'vlog_blank_page_template',
			array('page'),
			'side',
			'default'
		);
	}
endif;


/**
 * Save page meta
 * 
 * Callback function to save page meta data
 * 
 * @since  1.0
 */

if ( !function_exists( 'vlog_save_page_metaboxes' ) ) :
	function vlog_save_page_metaboxes( $post_id, $post ) {
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
			return;
		}
			
		if ( ! isset( $_POST['vlog_page_metabox_nonce'] ) || ! wp_verify_nonce( $_POST['vlog_page_metabox_nonce'], 'vlog_page_metabox_save' ) ) {
   			return;
		}

		if ( $post->post_type == 'page' && isset( $_POST['vlog'] ) ) {
			$post_type = get_post_type_object( $post->post_type );
			if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
				return $post_id;

			$vlog_meta = array();

			if( isset( $_POST['vlog']['use_sidebar'] ) &&  $_POST['vlog']['use_sidebar'] != 'inherit' ){
				$vlog_meta['use_sidebar'] = $_POST['vlog']['use_sidebar'];
			}
			
			if( isset( $_POST['vlog']['sidebar'] ) &&  $_POST['vlog']['sidebar'] != 'inherit' ){
				$vlog_meta['sidebar'] = $_POST['vlog']['sidebar'];
			}

			if( isset( $_POST['vlog']['sticky_sidebar'] ) &&  $_POST['vlog']['sticky_sidebar'] != 'inherit' ){
				$vlog_meta['sticky_sidebar'] = $_POST['vlog']['sticky_sidebar'];
			}

			if( isset( $_POST['vlog']['pag'] ) &&  $_POST['vlog']['pag'] != 'none' ){
				$vlog_meta['pag'] = $_POST['vlog']['pag'];
			}

			if( isset( $_POST['vlog']['fa'] ) &&  !empty($_POST['vlog']['fa']) ){
			    $post_data_for_saving = vlog_get_fa_post_data_for_saving($_POST['vlog']['fa']);
			    $post_type_with_taxonomies = vlog_get_post_type_with_taxonomies($_POST['vlog']['fa']['post_type']);
			    
				foreach ($post_data_for_saving as $value ){
					$vlog_meta['fa'][$value] = $_POST['vlog']['fa'][$value];
				}
				
				if(!empty($post_type_with_taxonomies->taxonomies)){
					foreach ( $post_type_with_taxonomies->taxonomies as $taxonomy ) {
						
						$taxonomy_id = vlog_patch_taxonomy_id($taxonomy['id']);
						
						if(!empty($_POST['vlog']['fa'][$taxonomy_id])){
						 
							$vlog_meta['fa'][$taxonomy_id . '_inc_exc'] = $_POST['vlog']['fa'][$taxonomy_id . '_inc_exc'];
       
							if($taxonomy['hierarchical']){
                                $vlog_meta['fa'][$taxonomy_id] = $_POST['vlog']['fa'][$taxonomy_id];
                            }else{
                                $vlog_meta['fa'][$taxonomy_id] = vlog_get_tax_term_slug_by_name( $_POST['vlog']['fa'][$taxonomy_id], $taxonomy['id']);
                            }
						}
					}
				}
				
				if ( isset( $_POST['vlog']['fa']['manual'] ) && !empty( $_POST['vlog']['fa']['manual'] ) ) {
                    $vlog_meta['fa']['manual'] = array_map( 'absint', explode( ",", $_POST['vlog']['fa']['manual'] ) );
				}

			}

			if ( isset( $_POST['vlog']['sections'] ) ) {
				$vlog_meta['sections'] = array_values( $_POST['vlog']['sections'] );
				foreach($vlog_meta['sections'] as $i => $section ){
					if(!empty($section['modules'])){
						
						foreach( $section['modules'] as $j => $module ){
							if ( isset( $module['manual'] ) && !empty( $module['manual'] ) ) {
								$section['modules'][$j]['manual'] = array_map( 'absint', explode( ",", $module['manual'] ) );
							}
							
							if ( isset( $module['tag'] ) && !empty( $module['tag'] ) ) {
								
								$section['modules'][$j]['tag'] = vlog_get_tax_term_slug_by_name( $module['tag'], 'post_tag');
							}

							if( !empty( $module['tax'] ) ) {

								$taxonomies = array();
								foreach( $module['tax'] as $k => $tax ){

									if(!empty($tax)){
										
										if( is_array($tax) ){
											$taxonomies[$k] = $tax;
										} else {
										 $taxonomies[$k] = vlog_get_tax_term_id_by_name( $tax, $k);

										}
									}

								}
								$section['modules'][$j]['tax'] =  $taxonomies;

							}

						}

						$vlog_meta['sections'][$i]['modules'] = array_values($section['modules']);
					}
				}
			}
			
			if( isset( $_POST['vlog']['blank'] ) ){
				foreach ( $_POST['vlog']['blank'] as $blank_meta_key => $blank_meta_value ) {
					$vlog_meta['blank'][$blank_meta_key] = $blank_meta_value;
				}
			}

			if(!empty($vlog_meta)){
				update_post_meta( $post_id, '_vlog_meta', $vlog_meta );
			} else {
				delete_post_meta( $post_id, '_vlog_meta');
			}

		}
	}
endif;



/**
 * Module generator metabox
 * 
 * Callback function to create modules metabox
 * 
 * @since  1.0
 */

if ( !function_exists( 'vlog_modules_metabox' ) ) :
	function vlog_modules_metabox( $object, $box ) {

		wp_nonce_field( 'vlog_page_metabox_save', 'vlog_page_metabox_nonce' );

		$meta = vlog_get_page_meta( $object->ID );

		// print_r($meta);
	
		$default = array(
			'modules' => array(),
			'use_sidebar' => 'right',
			'sidebar' => 'vlog_default_sidebar',
			'sticky_sidebar' => 'vlog_default_sticky_sidebar',
			'bg' => '',
			'css_class' => ''
		);

		$module_defaults = vlog_get_module_defaults();

		$options = array(
			'use_sidebar' => vlog_get_sidebar_layouts(),
			'sidebars' => vlog_get_sidebars_list(),
			'module_options' => vlog_get_module_options()
		);

?>
		
		<div id="vlog-sections">
			<?php if(!empty($meta['sections'])) : ?>
				<?php foreach($meta['sections'] as $i => $section) : $section = vlog_parse_args( $section, $default ); ?>
					<?php vlog_generate_section( $section, $options, $i ); ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		
		<p><a href="javascript:void(0);" class="vlog-add-section button-primary"><?php esc_html_e( 'Create new section', 'vlog' ); ?></a></p>
		
		<div id="vlog-section-clone">
			<?php vlog_generate_section( $default, $options ); ?>
		</div>

		<div id="vlog-module-clone">
			<?php foreach( $module_defaults as $type => $module ): ?>
				<div class="<?php echo esc_attr($type); ?>">
					<?php vlog_generate_module( $module, $options['module_options'][$type]); ?>
				</div>
			<?php endforeach; ?>
		</div>

		<div id="vlog-sections-count" data-count="<?php echo count($meta['sections']); ?>"></div>
				  	
	<?php
	}
endif;


/**
 * Generate section
 * 
 * Generate section field inside modules generator
 * 
 * @param   $section Data array for current section
 * @param   $options An array of section options
 * @param   $i id of a current section, if false then create an empty section
 * @since  1.0
 */

if ( !function_exists( 'vlog_generate_section' ) ) :
	function vlog_generate_section( $section, $options, $i = false ) {
		extract( $options );
		$name_prefix = ( $i === false ) ? '' :  'vlog[sections]['.$i.']';
		$edit = ( $i === false ) ? '' :  'edit';
		$section_class = ( $i === false ) ? '' :  'vlog-section-'.$i;
		$section_num = ( $i === false ) ? '' : $i ;
		//print_r($section);
		?>
		<div class="vlog-section <?php echo esc_attr($section_class); ?>" data-section="<?php echo esc_attr($section_num); ?>">
			
			<div class="vlog-modules">
				<?php if(!empty( $section['modules'] ) ): ?>
					<?php foreach($section['modules'] as $j => $module ) : $module = vlog_parse_args( $module, vlog_get_module_defaults( $module['type'] ) ); ?>
						<?php vlog_generate_module( $module, $module_options[$module['type']], $i, $j ); ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
			
			<div class="vlog-modules-count" data-count="<?php echo esc_attr(count($section['modules'])); ?>"></div>


			<div class="section-bottom">
				<div class="left">
					<?php $module_data = vlog_get_module_defaults(); ?>
					<?php foreach( $module_data as $mod ) : ?>
						<a href="javascript:void(0);" class="vlog-add-module button-secondary" data-type="<?php echo esc_attr($mod['type']); ?>"><?php echo '+ '.$mod['type_name']. ' ' .esc_html__( 'Module', 'vlog'); ?></a>
					<?php endforeach; ?>
				</div>
				<div class="right">
					<span><?php esc_html_e( 'Sidebar', 'vlog' ); ?> (<span class="vlog-sidebar"><?php echo esc_html( $section['use_sidebar'] ); ?></span>)</span>
					<a href="javascript:void(0);" class="vlog-edit-section button-secondary"><?php esc_html_e( 'Edit', 'vlog' ); ?></a>
					<a href="javascript:void(0);" class="vlog-remove-section button-secondary"><?php esc_html_e( 'Remove', 'vlog' ); ?></a>
				</div>
			</div>

			
			<div class="vlog-section-form <?php echo esc_attr($edit); ?>">

				<div class="vlog-opt">
					<div class="vlog-opt-title">
						<?php esc_html_e( 'Display sidebar', 'vlog' ); ?>:
					</div>
				    <div class="vlog-opt-content">
					    <ul class="vlog-img-select-wrap">
					  	<?php foreach ( $use_sidebar as $id => $layout ): ?>
					  		<li>
					  			<?php $selected_class = vlog_compare( $id, $section['use_sidebar'] ) ? ' selected': ''; ?>
					  			<img src="<?php echo esc_url($layout['img']); ?>" title="<?php echo esc_attr($layout['title']); ?>" class="vlog-img-select<?php echo esc_attr($selected_class); ?>">
					  			<br/><span><?php echo esc_html( $layout['title'] ); ?></span>
					  			<input type="radio" class="vlog-hidden vlog-count-me sec-sidebar" name="<?php echo esc_attr($name_prefix); ?>[use_sidebar]" value="<?php echo esc_attr($id); ?>" <?php checked( $id, $section['use_sidebar'] );?>/>
					  		</li>
					  	<?php endforeach; ?>
					    </ul>
					    <small class="howto"><?php esc_html_e( 'Choose a sidebar layout', 'vlog' ); ?></small>
					</div>
				</div>

			    <div class="vlog-opt">
			    	<div class="vlog-opt-title">
			    		<?php esc_html_e( 'Standard sidebar', 'vlog' ); ?>:
			    	</div>
				    <div class="vlog-opt-content">
					    <select name="<?php echo esc_attr($name_prefix); ?>[sidebar]" class="vlog-count-me vlog-opt-select">
					  	<?php foreach ( $sidebars as $id => $name ): ?>
					  		<option class="vlog-count-me" value="<?php echo esc_attr($id); ?>" <?php selected( $id, $section['sidebar'] );?>><?php echo esc_html( $name ); ?></option>
					  	<?php endforeach; ?>
					  	</select>
				 		<small class="howto"><?php esc_html_e( 'Choose a standard sidebar', 'vlog' ); ?></small>
				 	</div>
				</div>

				<div class="vlog-opt">
				 	<div class="vlog-opt-title">
				 		<?php esc_html_e( 'Sticky sidebar', 'vlog' ); ?>:
				 	</div>
				  	<div class="vlog-opt-content">
					  	<select name="<?php echo esc_attr($name_prefix); ?>[sticky_sidebar]" class="vlog-count-me vlog-opt-select">
					  	<?php foreach ( $sidebars as $id => $name ): ?>
					  		<option class="vlog-count-me" value="<?php echo esc_attr($id); ?>" <?php selected( $id, $section['sticky_sidebar'] );?>><?php echo esc_html( $name ); ?></option>
					  	<?php endforeach; ?>
					  	</select>
					 	<small class="howto"><?php esc_html_e( 'Choose a sticky sidebar', 'vlog' ); ?></small>
					 </div>
				</div>

				<div class="vlog-opt">
				 	<div class="vlog-opt-title">
				 		<?php esc_html_e( 'Background', 'vlog' ); ?>:
				 	</div>
				  	<div class="vlog-opt-content">
					  	<label><input type="radio" name="<?php echo esc_attr($name_prefix); ?>[bg]" class="vlog-count-me" value=""  <?php checked( '', $section['bg'] );?> > <?php esc_html_e( 'Transparent', 'vlog' ); ?> </label> <br/>
					  	<label><input type="radio" name="<?php echo esc_attr($name_prefix); ?>[bg]" class="vlog-count-me" value="vlog-bg" <?php checked( 'vlog-bg', $section['bg'] );?> > <?php esc_html_e( 'Shaded color', 'vlog' ); ?> </label><br/>
					 	<small class="howto"><?php esc_html_e( 'Choose section background type', 'vlog' ); ?></small>
					</div>
				</div>

				<div class="vlog-opt">
				 	<div class="vlog-opt-title">
				 		<?php esc_html_e( 'Custom CSS class', 'vlog' ); ?>:
				 	</div>
				  	<div class="vlog-opt-content">
					  	<input type="text" name="<?php echo esc_attr($name_prefix); ?>[css_class]" class="vlog-count-me" value="<?php echo esc_attr(esc_html($section['css_class'])); ?>"> 
						<small class="howto"><?php esc_html_e( 'Optionally, specify a class name for a possibility to apply custom styling to this section using CSS (i.e. my-custom-section)', 'vlog' ); ?></small>

					</div>
				</div>

			</div>

		</div>
		<?php
	}
endif;


/**
 * Generate module field
 * 
 * @param   $module Data array for current module
 * @param   $options An array of module options
 * @param   $i id of a current section
 * @param   $j id of a current module
 * @since  1.0
 */

if ( !function_exists( 'vlog_generate_module' ) ) :
	function vlog_generate_module( $module, $options, $i = false, $j = false ) {
		
		$name_prefix = ( $i === false ) ? '' :  'vlog[sections]['.$i.'][modules]['.$j.']';
		$edit = ( $j === false ) ? '' :  'edit';
		$module_class = ( $j === false ) ? '' :  'vlog-module-'.$j;
		$module_num = ( $j === false ) ? '' : $j;

		$deactivate_class = $module['active'] ? '' : 'vlog-hidden';
		$activate_class = $module['active'] ? 'vlog-hidden' : '';

		if( $module['active'] == 0 ) {
			$module_class .= ' vlog-module-disabled';
		}
?>
		<div class="vlog-module <?php echo esc_attr($module_class); ?>" data-module="<?php echo esc_attr($module_num); ?>">
			
			<div class="left">
				<span class="vlog-module-type">
					<?php echo esc_html( $module['type_name'] ); ?>
					<?php if(isset($module['columns']) && $module['type'] != 'woocommerce'){
							$columns = vlog_get_module_columns();
							echo '(<span class="vlog-module-columns">'.$columns[$module['columns']]['title'].'</span>)';
						}
					?>
				</span>
				<span class="vlog-module-title"><?php echo esc_html( $module['title'] ); ?></span>
			</div>

			<div class="right">
				<a href="javascript:void(0);" class="vlog-edit-module"><?php esc_html_e( 'Edit', 'vlog' ); ?></a> | 
				<a href="javascript:void(0);" class="vlog-deactivate-module">
					<span class="<?php echo esc_attr($activate_class); ?>"><?php esc_html_e( 'Activate', 'vlog' ); ?></span>
					<span class="<?php echo esc_attr($deactivate_class); ?>"><?php esc_html_e( 'Deactivate', 'vlog' ); ?></span>
				</a> | 
				<a href="javascript:void(0);" class="vlog-remove-module"><?php esc_html_e( 'Remove', 'vlog' ); ?></a>
			</div>

			<div class="vlog-module-form <?php echo esc_attr($edit); ?>">
				
				<input class="vlog-module-deactivate vlog-count-me" type="hidden" name="<?php echo esc_attr($name_prefix); ?>[active]" value="<?php echo esc_attr($module['active']); ?>"/>
				<input class="vlog-count-me" type="hidden" name="<?php echo esc_attr($name_prefix); ?>[type]" value="<?php echo esc_attr($module['type']); ?>"/>
				<?php $module_type = isset($module['cpt']) ? 'cpt' : $module['type']; ?>
				<?php call_user_func( 'vlog_generate_module_'.$module_type, $module, $options, $name_prefix ); ?>

		   	</div>

		</div>
		
	<?php
	}
endif;


/**
 * Generate posts module
 * 
 * @param   $module Data array for current module
 * @param   $options An array of module options
 * @param   $name_prefix id of a current module
 * @since  1.0
 */

if ( !function_exists( 'vlog_generate_module_posts' ) ) :
function vlog_generate_module_posts( $module, $options, $name_prefix ){
	
	extract( $options ); ?>

	<div class="vlog-opt-tabs">
		<a href="javascript:void(0);" class="active"><?php esc_html_e( 'Appearance', 'vlog' ); ?></a>
		<a href="javascript:void(0);"><?php esc_html_e( 'Selection', 'vlog' ); ?></a>
		<a href="javascript:void(0);"><?php esc_html_e( 'Actions', 'vlog' ); ?></a>
	</div>

	<div class="vlog-tab first">

		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Title', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input class="vlog-count-me mod-title" type="text" name="<?php echo esc_attr($name_prefix); ?>[title]" value="<?php echo esc_attr($module['title']);?>"/>
				<input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[hide_title]" value="1" <?php checked( $module['hide_title'], 1 ); ?> class="vlog-count-me" />
				<?php esc_html_e( 'Do not display publicly', 'vlog' ); ?>
				<small class="howto"><?php esc_html_e( 'Enter your module title', 'vlog' ); ?></small>

			</div>
		</div>

		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Width', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
			    <ul class="vlog-img-select-wrap vlog-col-dep-control">
			  	<?php foreach ( $columns as $id => $column ): ?>
			  		<li>
			  			<?php $selected_class = vlog_compare( $id, $module['columns'] ) ? ' selected': ''; ?>
			  			<img src="<?php echo esc_url($column['img']); ?>" title="<?php echo esc_attr($column['title']); ?>" class="vlog-img-select<?php echo esc_attr($selected_class); ?>">
			  			<br/><span><?php echo esc_attr($column['title']); ?></span>
			  			<input type="radio" class="vlog-hidden vlog-count-me mod-columns" name="<?php echo esc_attr($name_prefix); ?>[columns]" value="<?php echo esc_attr($id); ?>" <?php checked( $id, $module['columns'] );?>/>
			  		</li>
			  	<?php endforeach; ?>
			    </ul>
		    	<small class="howto"><?php esc_html_e( 'Choose module width', 'vlog' ); ?></small>
		    </div>
	    </div>

		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Layout', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
			    <ul class="vlog-img-select-wrap vlog-col-dep">
			  	<?php foreach ( $layouts as $id => $layout ): ?>
			  		<?php $disabled_class = ( $module['columns'] % $layout['col'] ) ? 'vlog-disabled' : ''; ?>
			  		<li class="<?php echo esc_attr($disabled_class); ?>">
			  			<?php $selected_class = vlog_compare( $id, $module['layout'] ) ? ' selected': ''; ?>
			  			<img src="<?php echo esc_url($layout['img']); ?>" title="<?php echo esc_attr($layout['title']); ?>" class="vlog-img-select<?php echo esc_attr($selected_class); ?>" data-col="<?php echo esc_attr($layout['col']); ?>">
			  			<br/><span><?php echo esc_attr($layout['title']); ?></span>
			  			<input type="radio" class="vlog-hidden vlog-count-me" name="<?php echo esc_attr($name_prefix); ?>[layout]" value="<?php echo esc_attr($id); ?>" <?php checked( $id, $module['layout'] );?>/>
			  		</li>
			  	<?php endforeach; ?>
			    </ul>
		    	<small class="howto"><?php esc_html_e( 'Choose your main posts layout', 'vlog' ); ?></small>
		    </div>
	    </div>

	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Number of posts', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input class="vlog-count-me" type="text" name="<?php echo esc_attr($name_prefix); ?>[limit]" value="<?php echo esc_attr($module['limit']);?>"/><br/>
				<small class="howto"><?php esc_html_e( 'Max number of posts to display', 'vlog' ); ?></small>
			</div>
		</div>

		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Starter Layout', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
			    <ul class="vlog-img-select-wrap vlog-col-dep">
			  	<?php foreach ( $starter_layouts as $id => $layout ): ?>
			  		<?php $disabled_class = $layout['col'] && $module['columns'] % $layout['col']  ? 'vlog-disabled' : ''; ?>
			  		<li class="<?php echo esc_attr($disabled_class); ?>">
			  			<?php $selected_class = vlog_compare( $id, $module['starter_layout'] ) ? ' selected': ''; ?>
			  			<img src="<?php echo esc_url($layout['img']); ?>" title="<?php echo esc_attr($layout['title']); ?>" class="vlog-img-select<?php echo esc_attr($selected_class); ?>" data-col="<?php echo esc_attr($layout['col']); ?>">
			  			<br/><span><?php echo esc_html( $layout['title'] ); ?></span>
			  			<input type="radio" class="vlog-hidden vlog-count-me" name="<?php echo esc_attr($name_prefix); ?>[starter_layout]" value="<?php echo esc_attr($id); ?>" <?php checked( $id, $module['starter_layout'] );?>/>
			  		</li>
			  	<?php endforeach; ?>
			    </ul>
		    	<small class="howto"><?php esc_html_e( 'Choose your starter posts layout', 'vlog' ); ?></small>
		    </div>
	    </div>

	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Number of starter posts', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input class="vlog-count-me" type="text" name="<?php echo esc_attr($name_prefix); ?>[starter_limit]" value="<?php echo esc_attr($module['starter_limit']);?>"/><br/>
				<small class="howto"><?php esc_html_e( 'Number of posts to display in starter layout', 'vlog' ); ?></small>
			</div>
		</div>

		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Custom CSS class', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input class="vlog-count-me" type="text" name="<?php echo esc_attr($name_prefix); ?>[css_class]" value="<?php echo esc_attr(esc_html($module['css_class']));?>"/><br/>
				<small class="howto"><?php esc_html_e( 'Specify class name for a possibility to apply custom styling to this module using CSS (i.e. my-custom-module)', 'vlog' ); ?></small>
			</div>
		</div>

	</div>

	<div class="vlog-tab">
		
		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Order by', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<?php foreach ( $order as $id => $title ) : ?>
		   		<label><input type="radio" name="<?php echo esc_attr($name_prefix); ?>[order]" value="<?php echo esc_attr($id); ?>" <?php checked( $module['order'], $id ); ?> class="vlog-count-me" /><?php echo esc_html( $title );?></label><br/>
		   		<?php endforeach; ?>
					
		   		<div class="vlog-live-search-opt">

					<br/><?php esc_html_e( 'Or choose manually', 'vlog' ); ?>:<br/>
		   			<input type="text" class="vlog-live-search" placeholder="<?php esc_html_e( 'Type to search...', 'vlog' ); ?>" /><br/>
		   			<?php $manualy_selected_posts = vlog_get_manually_selected_posts($module['manual'], 'cover'); ?>
		   			<?php $manual = !empty( $manualy_selected_posts ) ? implode( ",", $module['manual'] ) : ''; ?>
		   			<input type="hidden" class="vlog-count-me vlog-live-search-hidden" data-type="<?php echo esc_attr($module['type']); ?>" name="<?php echo esc_attr($name_prefix); ?>[manual]" value="<?php echo esc_attr($manual); ?>" />
		   			<div class="vlog-live-search-items tagchecklist">
		   				<?php vlog_display_manually_selected_posts($manualy_selected_posts); ?>
		   			</div>

		   		</div>

		   	</div>
	    </div>

	     <div class="vlog-opt-inline">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Sort', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<label><input type="radio" name="<?php echo esc_attr($name_prefix); ?>[sort]" value="DESC" <?php checked( $module['sort'], 'DESC' ); ?> class="vlog-count-me" /><?php esc_html_e('Descending', 'vlog') ?></label><br/>
		   		<label><input type="radio" name="<?php echo esc_attr($name_prefix); ?>[sort]" value="ASC" <?php checked( $module['sort'], 'ASC' ); ?> class="vlog-count-me" /><?php esc_html_e('Ascending', 'vlog') ?></label><br/>
		   	</div>
	    </div>

		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'In category', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<div class="vlog-fit-height">
		   		<?php foreach ( $cats as $cat ) : ?>
		   			<?php $checked = in_array( $cat->term_id, $module['cat'] ) ? 'checked="checked"' : ''; ?>
		   			<label><input class="vlog-count-me" type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[cat][]" value="<?php echo esc_attr($cat->term_id); ?>" <?php echo esc_attr($checked); ?> /><?php echo esc_html( $cat->name );?></label><br/>
		   		<?php endforeach; ?>
		   		</div>
		   		<small class="howto"><?php esc_html_e( 'Check whether you want to display posts from specific categories only', 'vlog' ); ?></small>
                <br>
                <label><input type="radio" name="<?php echo esc_attr( $name_prefix ); ?>[cat_inc_exc]" value="in" <?php checked( $module['cat_inc_exc'], 'in' ); ?> class="vlog-count-me" /><?php esc_html_e('Include', 'vlog') ?></label><br/>
                <label><input type="radio" name="<?php echo esc_attr( $name_prefix ); ?>[cat_inc_exc]" value="not_in" <?php checked( $module['cat_inc_exc'], 'not_in' ); ?> class="vlog-count-me" /><?php esc_html_e('Exclude', 'vlog') ?></label><br/>
                <small class="howto"><?php esc_html_e( 'Whether to include or exclude posts from selected categories', 'vlog' ); ?></small>
		   	</div>
	   	</div>

	   	<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Tagged with', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<input type="text" name="<?php echo esc_attr($name_prefix); ?>[tag]" value="<?php echo esc_attr(vlog_get_tax_term_name_by_slug($module['tag'])); ?>" class="vlog-count-me"/><br/>
		   		<small class="howto"><?php esc_html_e( 'Specify one or more tags separated by comma. i.e. life, cooking, funny moments', 'vlog' ); ?></small>
                <br>
                <label><input type="radio" name="<?php echo esc_attr( $name_prefix ); ?>[tag_inc_exc]" value="in" <?php checked( $module['tag_inc_exc'], 'in' ); ?> class="vlog-count-me" /><?php esc_html_e('Include', 'vlog') ?></label><br/>
                <label><input type="radio" name="<?php echo esc_attr( $name_prefix ); ?>[tag_inc_exc]" value="not_in" <?php checked( $module['tag_inc_exc'], 'not_in' ); ?> class="vlog-count-me" /><?php esc_html_e('Exclude', 'vlog') ?></label><br/>
                <small class="howto"><?php esc_html_e( 'Whether to include or exclude posts from selected tags', 'vlog' ); ?></small>
		   	</div>
	   	</div>

	   	<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Format', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<?php foreach ( $formats as $id => $title ) : ?>
		   		<label><input type="radio" name="<?php echo esc_attr($name_prefix); ?>[format]" value="<?php echo esc_attr($id); ?>" <?php checked( $module['format'], $id ); ?> class="vlog-count-me" /><?php echo esc_html( $title );?></label><br/>
		   		<?php endforeach; ?>
		   		<small class="howto"><?php esc_html_e( 'Display posts that have a specific format', 'vlog' ); ?></small>
	   		</div>
	   	</div>

		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Not older than', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<?php foreach ( $time as $id => $title ) : ?>
		   		<label><input type="radio" name="<?php echo esc_attr($name_prefix); ?>[time]" value="<?php echo esc_attr($id); ?>" <?php checked( $module['time'], $id ); ?> class="vlog-count-me" /><?php echo esc_html( $title );?></label><br/>
		   		<?php endforeach; ?>
		   		<small class="howto"><?php esc_html_e( 'Display posts that are not older than specific time range', 'vlog' ); ?></small>
	   		</div>
	   	</div>

	   	<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Unique posts (do not duplicate)', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<label><input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[unique]" value="1" <?php checked( $module['unique'], 1 ); ?> class="vlog-count-me" /></label>
		   		<small class="howto"><?php esc_html_e( 'If you check this option, posts in this module will be excluded from other modules below.', 'vlog' ); ?></small>
		   	</div>
	    </div>

	</div>

	<div class="vlog-tab">

	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Slider options', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<label><input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[slider]" value="1" <?php checked( $module['slider'], 1 ); ?> class="vlog-count-me" /> <?php esc_html_e( 'Display module as slider', 'vlog' ); ?></label> <br/>
		   		<label><input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[slider_autoplay]" value="1" <?php checked( $module['slider_autoplay'], 1 ); ?> class="vlog-count-me" /></label> 
		   		<?php esc_html_e( 'Autoplay (rotate) slider every', 'vlog' ); ?> <input type="number" name="<?php echo esc_attr($name_prefix); ?>[slider_autoplay_time]" value="<?php echo esc_attr(absint( $module['slider_autoplay_time'] )); ?>"  class="small-text vlog-count-me" /> <?php esc_html_e( 'seconds', 'vlog' ); ?>
		   		<small class="howto"><?php esc_html_e( 'Note: if slider is apllied to a module, "starter" layout will be ignored', 'vlog' ); ?></small>
		   	</div>
	    </div>


	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Display "view all" link', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<label><?php esc_html_e( 'Text', 'vlog' ); ?></label>: <input type="text" name="<?php echo esc_attr($name_prefix); ?>[more_text]" value="<?php echo esc_attr($module['more_text']);?>" class="vlog-count-me" />
		   		<br/>
		   		<label><?php esc_html_e( 'URL', 'vlog' ); ?></label>: <input type="text" name="<?php echo esc_attr($name_prefix); ?>[more_url]" value="<?php echo esc_attr($module['more_url']);?>" class="vlog-count-me" /><br/>
		   		<small class="howto"><?php esc_html_e( 'Specify text and URL if you want to display "view all" button in this module', 'vlog' ); ?></small>
		   	</div>
	    </div>

	</div>
<?php }
endif;



/**
 * Generate cpt module
 * 
 * @param   $module Data array for current module
 * @param   $options An array of module options
 * @param   $name_prefix id of a current module
 * @since  1.0
 */

if ( !function_exists( 'vlog_generate_module_cpt' ) ) :
function vlog_generate_module_cpt( $module, $options, $name_prefix ){
	
	extract( $options ); ?>

	<div class="vlog-opt-tabs">
		<a href="javascript:void(0);" class="active"><?php esc_html_e( 'Appearance', 'vlog' ); ?></a>
		<a href="javascript:void(0);"><?php esc_html_e( 'Selection', 'vlog' ); ?></a>
		<a href="javascript:void(0);"><?php esc_html_e( 'Actions', 'vlog' ); ?></a>
	</div>

	<div class="vlog-tab first">

		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Title', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input class="vlog-count-me mod-title" type="text" name="<?php echo esc_attr($name_prefix); ?>[title]" value="<?php echo esc_attr($module['title']);?>"/>
				<input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[hide_title]" value="1" <?php checked( $module['hide_title'], 1 ); ?> class="vlog-count-me" />
				<?php esc_html_e( 'Do not display publicly', 'vlog' ); ?>
				<small class="howto"><?php esc_html_e( 'Enter your module title', 'vlog' ); ?></small>

			</div>
		</div>

		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Width', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
			    <ul class="vlog-img-select-wrap vlog-col-dep-control">
			  	<?php foreach ( $columns as $id => $column ): ?>
			  		<li>
			  			<?php $selected_class = vlog_compare( $id, $module['columns'] ) ? ' selected': ''; ?>
			  			<img src="<?php echo esc_url($column['img']); ?>" title="<?php echo esc_attr($column['title']); ?>" class="vlog-img-select<?php echo esc_attr($selected_class); ?>">
			  			<br/><span><?php echo esc_attr($column['title']); ?></span>
			  			<input type="radio" class="vlog-hidden vlog-count-me mod-columns" name="<?php echo esc_attr($name_prefix); ?>[columns]" value="<?php echo esc_attr($id); ?>" <?php checked( $id, $module['columns'] );?>/>
			  		</li>
			  	<?php endforeach; ?>
			    </ul>
		    	<small class="howto"><?php esc_html_e( 'Choose module width', 'vlog' ); ?></small>
		    </div>
	    </div>

		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Layout', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
			    <ul class="vlog-img-select-wrap vlog-col-dep">
			  	<?php foreach ( $layouts as $id => $layout ): ?>
			  		<?php $disabled_class = ( $module['columns'] % $layout['col'] ) ? 'vlog-disabled' : ''; ?>
			  		<li class="<?php echo esc_attr($disabled_class); ?>">
			  			<?php $selected_class = vlog_compare( $id, $module['layout'] ) ? ' selected': ''; ?>
			  			<img src="<?php echo esc_url($layout['img']); ?>" title="<?php echo esc_attr($layout['title']); ?>" class="vlog-img-select<?php echo esc_attr($selected_class); ?>" data-col="<?php echo esc_attr($layout['col']); ?>">
			  			<br/><span><?php echo esc_attr($layout['title']); ?></span>
			  			<input type="radio" class="vlog-hidden vlog-count-me" name="<?php echo esc_attr($name_prefix); ?>[layout]" value="<?php echo esc_attr($id); ?>" <?php checked( $id, $module['layout'] );?>/>
			  		</li>
			  	<?php endforeach; ?>
			    </ul>
		    	<small class="howto"><?php esc_html_e( 'Choose your main posts layout', 'vlog' ); ?></small>
		    </div>
	    </div>

	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Number of posts', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input class="vlog-count-me" type="text" name="<?php echo esc_attr($name_prefix); ?>[limit]" value="<?php echo esc_attr($module['limit']);?>"/><br/>
				<small class="howto"><?php esc_html_e( 'Max number of posts to display', 'vlog' ); ?></small>
			</div>
		</div>

		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Starter Layout', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
			    <ul class="vlog-img-select-wrap vlog-col-dep">
			  	<?php foreach ( $starter_layouts as $id => $layout ): ?>
			  		<?php $disabled_class = $layout['col'] && $module['columns'] % $layout['col']  ? 'vlog-disabled' : ''; ?>
			  		<li class="<?php echo esc_attr($disabled_class); ?>">
			  			<?php $selected_class = vlog_compare( $id, $module['starter_layout'] ) ? ' selected': ''; ?>
			  			<img src="<?php echo esc_url($layout['img']); ?>" title="<?php echo esc_attr($layout['title']); ?>" class="vlog-img-select<?php echo esc_attr($selected_class); ?>" data-col="<?php echo esc_attr($layout['col']); ?>">
			  			<br/><span><?php echo esc_html( $layout['title'] ); ?></span>
			  			<input type="radio" class="vlog-hidden vlog-count-me" name="<?php echo esc_attr($name_prefix); ?>[starter_layout]" value="<?php echo esc_attr($id); ?>" <?php checked( $id, $module['starter_layout'] );?>/>
			  		</li>
			  	<?php endforeach; ?>
			    </ul>
		    	<small class="howto"><?php esc_html_e( 'Choose your starter posts layout', 'vlog' ); ?></small>
		    </div>
	    </div>

	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Number of starter posts', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input class="vlog-count-me" type="text" name="<?php echo esc_attr($name_prefix); ?>[starter_limit]" value="<?php echo esc_attr($module['starter_limit']);?>"/><br/>
				<small class="howto"><?php esc_html_e( 'Number of posts to display in starter layout', 'vlog' ); ?></small>
			</div>
		</div>

		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Custom CSS class', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input class="vlog-count-me" type="text" name="<?php echo esc_attr($name_prefix); ?>[css_class]" value="<?php echo esc_attr(esc_html($module['css_class']));?>"/><br/>
				<small class="howto"><?php esc_html_e( 'Specify class name for a possibility to apply custom styling to this module using CSS (i.e. my-custom-module)', 'vlog' ); ?></small>
			</div>
		</div>

	</div>

	<div class="vlog-tab">
		
		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Order by', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<?php foreach ( $order as $id => $title ) : ?>
		   		<label><input type="radio" name="<?php echo esc_attr($name_prefix); ?>[order]" value="<?php echo esc_attr($id); ?>" <?php checked( $module['order'], $id ); ?> class="vlog-count-me" /><?php echo esc_html( $title );?></label><br/>
		   		<?php endforeach; ?>
				
				<div class="vlog-live-search-opt">

					<br/><?php esc_html_e( 'Or choose manually', 'vlog' ); ?>:<br/>
		   			<input type="text" class="vlog-live-search" placeholder="<?php esc_html_e( 'Type to search...', 'vlog' ); ?>" /><br/>
		   			<?php $manualy_selected_posts = vlog_get_manually_selected_posts($module['manual'], 'cover'); ?>
		   			<?php $manual = !empty( $manualy_selected_posts ) ? implode( ",", $module['manual'] ) : ''; ?>
		   			<input type="hidden" class="vlog-count-me vlog-live-search-hidden" data-type="<?php echo esc_attr($module['type']); ?>" name="<?php echo esc_attr($name_prefix); ?>[manual]" value="<?php echo esc_attr($manual); ?>" />
		   			<div class="vlog-live-search-items tagchecklist">
		   				<?php vlog_display_manually_selected_posts($manualy_selected_posts); ?>
		   			</div>

		   		</div>
		   	</div>
	    </div>

	     <div class="vlog-opt-inline">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Sort', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<label><input type="radio" name="<?php echo esc_attr($name_prefix); ?>[sort]" value="DESC" <?php checked( $module['sort'], 'DESC' ); ?> class="vlog-count-me" /><?php esc_html_e('Descending', 'vlog') ?></label><br/>
		   		<label><input type="radio" name="<?php echo esc_attr($name_prefix); ?>[sort]" value="ASC" <?php checked( $module['sort'], 'ASC' ); ?> class="vlog-count-me" /><?php esc_html_e('Ascending', 'vlog') ?></label><br/>
		   	</div>
	    </div>

		<?php foreach ( $taxonomies as $taxonomy ) : ?>
		    <div class="vlog-opt">
				<div class="vlog-opt-title">
					<?php esc_html_e( 'In ', 'vlog' ); ?><?php echo esc_html( $taxonomy['name'] ); ?>:
				</div>
				<div class="vlog-opt-content">

					<?php if($taxonomy['hierarchical']) : ?>

						<div class="vlog-fit-height">
				   			<?php foreach ($taxonomy['terms'] as $term) : ?>
				   			<?php $tax = !empty( $module['tax'][$taxonomy['id']] ) ? $module['tax'][$taxonomy['id']] : array(); ?>
				   			<?php $checked = in_array( $term->term_id, $tax ) ? 'checked="checked"' : ''; ?>
				   			<label><input class="vlog-count-me" type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[tax][<?php echo esc_attr($taxonomy['id']); ?>][]" value="<?php echo esc_attr($term->term_id); ?>" <?php echo esc_attr( $checked ); ?> /><?php echo esc_html( $term->name );?></label><br/>
					   		<?php endforeach; ?>
				   		</div>
			   			<small class="howto"><?php esc_html_e( 'Check whether you want to display posts from specific', 'vlog' ); ?> <?php echo esc_html( $taxonomy['name'] ); ?></small>

				   	<?php else: ?>
							<?php $tax = !empty( $module['tax'][$taxonomy['id']] ) ? vlog_get_tax_term_name_by_id($module['tax'][$taxonomy['id']], $taxonomy['id'] ) : '' ?>
					   		<input type="text" name="<?php echo esc_attr($name_prefix); ?>[tax][<?php echo esc_attr($taxonomy['id']); ?>]" value="<?php echo esc_attr( $tax ); ?>" class="vlog-count-me"/><br/>
					   		<small class="howto"><?php esc_html_e( 'Specify one or more terms separated by comma. i.e. life, cooking, funny moments', 'vlog' ); ?></small>

					<?php endif; ?>

                    <br>
                    <label><input type="radio" name="<?php echo esc_attr( $name_prefix ) . '[' . $taxonomy["id"] . '_inc_exc]'; ?>" value="in" <?php checked( $module[$taxonomy["id"] . '_inc_exc'], 'in' ); ?> class="vlog-count-me" /><?php esc_html_e('Include', 'vlog') ?></label><br/>
                    <label><input type="radio" name="<?php echo esc_attr( $name_prefix ) . '[' . $taxonomy["id"] . '_inc_exc]'; ?>" value="not_in" <?php checked( $module[$taxonomy["id"] . '_inc_exc'], 'not_in' ); ?> class="vlog-count-me" /><?php esc_html_e('Exclude', 'vlog') ?></label><br/>
                    <small class="howto"><?php esc_html_e( 'Whether to include or exclude cpt from selected taxonomies', 'vlog' ); ?></small>

                </div>
		   	</div>
		<?php endforeach; ?>

		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Not older than', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<?php foreach ( $time as $id => $title ) : ?>
		   		<label><input type="radio" name="<?php echo esc_attr($name_prefix); ?>[time]" value="<?php echo esc_attr($id); ?>" <?php checked( $module['time'], $id ); ?> class="vlog-count-me" /><?php echo esc_html( $title );?></label><br/>
		   		<?php endforeach; ?>
		   		<small class="howto"><?php esc_html_e( 'Display posts that are not older than specific time range', 'vlog' ); ?></small>
	   		</div>
	   	</div>

	   	<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Unique posts (do not duplicate)', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<label><input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[unique]" value="1" <?php checked( $module['unique'], 1 ); ?> class="vlog-count-me" /></label>
		   		<small class="howto"><?php esc_html_e( 'If you check this option, posts in this module will be excluded from other modules below.', 'vlog' ); ?></small>
		   	</div>
	    </div>

	</div>

	<div class="vlog-tab">

	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Slider options', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<label><input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[slider]" value="1" <?php checked( $module['slider'], 1 ); ?> class="vlog-count-me" /> <?php esc_html_e( 'Display module as slider', 'vlog' ); ?></label> <br/>
		   		<label><input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[slider_autoplay]" value="1" <?php checked( $module['slider_autoplay'], 1 ); ?> class="vlog-count-me" /></label> 
		   		<?php esc_html_e( 'Autoplay (rotate) slider every', 'vlog' ); ?> <input type="number" name="<?php echo esc_attr($name_prefix); ?>[slider_autoplay_time]" value="<?php echo esc_attr(absint( $module['slider_autoplay_time'] )); ?>"  class="small-text vlog-count-me" /> <?php esc_html_e( 'seconds', 'vlog' ); ?>
		   		<small class="howto"><?php esc_html_e( 'Note: if slider is apllied to a module, "starter" layout will be ignored', 'vlog' ); ?></small>
		   	</div>
	    </div>


	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Display "view all" link', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<label><?php esc_html_e( 'Text', 'vlog' ); ?></label>: <input type="text" name="<?php echo esc_attr($name_prefix); ?>[more_text]" value="<?php echo esc_attr($module['more_text']);?>" class="vlog-count-me" />
		   		<br/>
		   		<label><?php esc_html_e( 'URL', 'vlog' ); ?></label>: <input type="text" name="<?php echo esc_attr($name_prefix); ?>[more_url]" value="<?php echo esc_attr($module['more_url']);?>" class="vlog-count-me" /><br/>
		   		<small class="howto"><?php esc_html_e( 'Specify text and URL if you want to display "view all" button in this module', 'vlog' ); ?></small>
		   	</div>
	    </div>

	</div>
<?php }
endif;


/**
 * Generate category module
 * 
 * @param   $module Data array for current module
 * @param   $options An array of module options
 * @param   $name_prefix id of a current module
 * @since  1.0
 */

if ( !function_exists( 'vlog_generate_module_cats' ) ) :
function vlog_generate_module_cats( $module, $options, $name_prefix ){
	
	extract( $options ); ?>

	<div class="vlog-opt-tabs">
		<a href="javascript:void(0);" class="active"><?php esc_html_e( 'Appearance', 'vlog' ); ?></a>
		<a href="javascript:void(0);"><?php esc_html_e( 'Selection', 'vlog' ); ?></a>
		<a href="javascript:void(0);"><?php esc_html_e( 'Actions', 'vlog' ); ?></a>
	</div>

	<div class="vlog-tab first">

		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Title', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input class="vlog-count-me mod-title" type="text" name="<?php echo esc_attr($name_prefix); ?>[title]" value="<?php echo esc_attr($module['title']);?>"/>
				<input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[hide_title]" value="1" <?php checked( $module['hide_title'], 1 ); ?> class="vlog-count-me" />
				<?php esc_html_e( 'Do not display publicly', 'vlog' ); ?>
				<small class="howto"><?php esc_html_e( 'Enter your module title', 'vlog' ); ?></small>

			</div>
		</div>


		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Layout', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
			    <ul class="vlog-img-select-wrap vlog-col-dep">
			  	<?php foreach ( $layouts as $id => $layout ): ?>
			  		<li>
			  			<?php $selected_class = vlog_compare( $id, $module['layout'] ) ? ' selected': ''; ?>
			  			<img src="<?php echo esc_url($layout['img']); ?>" title="<?php echo esc_attr($layout['title']); ?>" class="vlog-img-select<?php echo esc_attr($selected_class); ?>">
			  			<br/><span><?php echo esc_attr($layout['title']); ?></span>
			  			<input type="radio" class="vlog-hidden vlog-count-me" name="<?php echo esc_attr($name_prefix); ?>[layout]" value="<?php echo esc_attr($id); ?>" <?php checked( $id, $module['layout'] );?>/>
			  		</li>
			  	<?php endforeach; ?>
			    </ul>
		    	<small class="howto"><?php esc_html_e( 'Choose a layout', 'vlog' ); ?></small>
		    </div>
	    </div>

	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Display play icon', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input type="hidden" name="<?php echo esc_attr($name_prefix); ?>[display_icon]" value="0" class="vlog-count-me" />
		   		<input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[display_icon]" value="1" <?php checked( $module['display_icon'], 1 ); ?> class="vlog-count-me" />
		   	</div>
	    </div>

	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Display posts count', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input type="hidden" name="<?php echo esc_attr($name_prefix); ?>[display_count]" value="0" class="vlog-count-me" />
		   		<input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[display_count]" value="1" <?php checked( $module['display_count'], 1 ); ?> class="vlog-count-me vlog-next-hide" />
		   	</div>
	    </div>


	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Count label', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<input type="text" name="<?php echo esc_attr($name_prefix); ?>[count_label]" value="<?php echo esc_attr($module['count_label']);?>" class="vlog-count-me" />
		   	</div>
	    </div>

	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Custom CSS class', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input class="vlog-count-me" type="text" name="<?php echo esc_attr($name_prefix); ?>[css_class]" value="<?php echo esc_attr(esc_html($module['css_class']));?>"/><br/>
				<small class="howto"><?php esc_html_e( 'Specify class name for a possibility to apply custom styling to this module using CSS (i.e. my-custom-module)', 'vlog' ); ?></small>
			</div>
		</div>		

	</div>

	<div class="vlog-tab">
		
		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Categories', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<ul class="sortable">
					<?php $cats = vlog_sort_option_items( $cats,  $module['cat']); ?>
					<?php foreach ( $cats as $cat ) : ?>
						<?php $checked = in_array( $cat->term_id, $module['cat'] ) ? 'checked="checked"' : ''; ?>
						<li><input class="vlog-count-me" type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[cat][]" value="<?php echo esc_attr($cat->term_id); ?>" <?php echo esc_attr($checked); ?> /><label><?php echo esc_html( $cat->name );?></label></li>
					<?php endforeach; ?>
				</ul>
				<small class="howto"><?php esc_html_e( 'Select and re-order categories you would like to display, or leave empty for "all categories"', 'vlog' ); ?></small>
		   	</div>
	   	</div>

	</div>

	<div class="vlog-tab">

	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Slider options', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<label><input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[slider]" value="1" <?php checked( $module['slider'], 1 ); ?> class="vlog-count-me" /> <?php esc_html_e( 'Display module as slider', 'vlog' ); ?></label> <br/>
		   		<label><input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[slider_autoplay]" value="1" <?php checked( $module['slider_autoplay'], 1 ); ?> class="vlog-count-me" /></label> 
		   		<?php esc_html_e( 'Autoplay (rotate) slider every', 'vlog' ); ?> <input type="number" name="<?php echo esc_attr($name_prefix); ?>[slider_autoplay_time]" value="<?php echo esc_attr(absint( $module['slider_autoplay_time'] )); ?>"  class="small-text vlog-count-me" /> <?php esc_html_e( 'seconds', 'vlog' ); ?>
		   		<small class="howto"><?php esc_html_e( 'Note: if slider is apllied to a module, "starter" layout will be ignored', 'vlog' ); ?></small>
		   	</div>
	    </div>


	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Display "view all" link', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<label><?php esc_html_e( 'Text', 'vlog' ); ?></label>: <input type="text" name="<?php echo esc_attr($name_prefix); ?>[more_text]" value="<?php echo esc_attr($module['more_text']);?>" class="vlog-count-me" />
		   		<br/>
		   		<label><?php esc_html_e( 'URL', 'vlog' ); ?></label>: <input type="text" name="<?php echo esc_attr($name_prefix); ?>[more_url]" value="<?php echo esc_attr($module['more_url']);?>" class="vlog-count-me" /><br/>
		   		<small class="howto"><?php esc_html_e( 'Specify text and URL if you want to display "view all" button in this module', 'vlog' ); ?></small>
		   	</div>
	    </div>

	</div>
<?php }
endif;

/**
 * Generate series module
 * 
 * @param   $module Data array for current module
 * @param   $options An array of module options
 * @param   $name_prefix id of a current module
 * @since  1.0
 */

if ( !function_exists( 'vlog_generate_module_series' ) ) :
function vlog_generate_module_series( $module, $options, $name_prefix ){
	
	extract( $options ); ?>

	<div class="vlog-opt-tabs">
		<a href="javascript:void(0);" class="active"><?php esc_html_e( 'Appearance', 'vlog' ); ?></a>
		<a href="javascript:void(0);"><?php esc_html_e( 'Selection', 'vlog' ); ?></a>
		<a href="javascript:void(0);"><?php esc_html_e( 'Actions', 'vlog' ); ?></a>
	</div>

	<div class="vlog-tab first">

		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Title', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input class="vlog-count-me mod-title" type="text" name="<?php echo esc_attr($name_prefix); ?>[title]" value="<?php echo esc_attr($module['title']);?>"/>
				<input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[hide_title]" value="1" <?php checked( $module['hide_title'], 1 ); ?> class="vlog-count-me" />
				<?php esc_html_e( 'Do not display publicly', 'vlog' ); ?>
				<small class="howto"><?php esc_html_e( 'Enter your module title', 'vlog' ); ?></small>

			</div>
		</div>


		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Layout', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
			    <ul class="vlog-img-select-wrap vlog-col-dep">
			  	<?php foreach ( $layouts as $id => $layout ): ?>
			  		<li>
			  			<?php $selected_class = vlog_compare( $id, $module['layout'] ) ? ' selected': ''; ?>
			  			<img src="<?php echo esc_url($layout['img']); ?>" title="<?php echo esc_attr($layout['title']); ?>" class="vlog-img-select<?php echo esc_attr($selected_class); ?>">
			  			<br/><span><?php echo esc_attr($layout['title']); ?></span>
			  			<input type="radio" class="vlog-hidden vlog-count-me" name="<?php echo esc_attr($name_prefix); ?>[layout]" value="<?php echo esc_attr($id); ?>" <?php checked( $id, $module['layout'] );?>/>
			  		</li>
			  	<?php endforeach; ?>
			    </ul>
		    	<small class="howto"><?php esc_html_e( 'Choose a layout', 'vlog' ); ?></small>
		    </div>
	    </div>

	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Display play icon', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input type="hidden" name="<?php echo esc_attr($name_prefix); ?>[display_icon]" value="0" class="vlog-count-me" />
		   		<input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[display_icon]" value="1" <?php checked( $module['display_icon'], 1 ); ?> class="vlog-count-me" />
		   	</div>
	    </div>

	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Display posts count', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input type="hidden" name="<?php echo esc_attr($name_prefix); ?>[display_count]" value="0" class="vlog-count-me" />
		   		<input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[display_count]" value="1" <?php checked( $module['display_count'], 1 ); ?> class="vlog-count-me vlog-next-hide" />
		   	</div>
	    </div>


	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Count label', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<input type="text" name="<?php echo esc_attr($name_prefix); ?>[count_label]" value="<?php echo esc_attr($module['count_label']);?>" class="vlog-count-me" />
		   	</div>
	    </div>

	     <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Custom CSS class', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input class="vlog-count-me" type="text" name="<?php echo esc_attr($name_prefix); ?>[css_class]" value="<?php echo esc_attr(esc_html($module['css_class']));?>"/><br/>
				<small class="howto"><?php esc_html_e( 'Specify class name for a possibility to apply custom styling to this module using CSS (i.e. my-custom-module)', 'vlog' ); ?></small>
			</div>
		</div>	

	</div>

	<div class="vlog-tab">
		
		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Series (palylists)', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<ul class="sortable">
					<?php $series = vlog_sort_option_items( $series,  $module['series']); ?>
					<?php foreach ( $series as $serie ) : ?>
						<?php $checked = in_array( $serie->term_id, $module['series'] ) ? 'checked="checked"' : ''; ?>
						<li><input class="vlog-count-me" type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[series][]" value="<?php echo esc_attr($serie->term_id); ?>" <?php echo esc_attr($checked); ?> /><label><?php echo esc_html( $serie->name );?></label></li>
					<?php endforeach; ?>
				</ul>
				<small class="howto"><?php esc_html_e( 'Select and re-order categories you would like to display, or leave empty for "all categories"', 'vlog' ); ?></small>
		   	</div>
	   	</div>

	</div>

	<div class="vlog-tab">

	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Slider options', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<label><input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[slider]" value="1" <?php checked( $module['slider'], 1 ); ?> class="vlog-count-me" /> <?php esc_html_e( 'Display module as slider', 'vlog' ); ?></label> <br/>
		   		<label><input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[slider_autoplay]" value="1" <?php checked( $module['slider_autoplay'], 1 ); ?> class="vlog-count-me" /></label> 
		   		<?php esc_html_e( 'Autoplay (rotate) slider every', 'vlog' ); ?> <input type="number" name="<?php echo esc_attr($name_prefix); ?>[slider_autoplay_time]" value="<?php echo esc_attr(absint( $module['slider_autoplay_time'] )); ?>"  class="small-text vlog-count-me" /> <?php esc_html_e( 'seconds', 'vlog' ); ?>
		   		<small class="howto"><?php esc_html_e( 'Note: if slider is apllied to a module, "starter" layout will be ignored', 'vlog' ); ?></small>
		   	</div>
	    </div>


	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Display "view all" link', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<label><?php esc_html_e( 'Text', 'vlog' ); ?></label>: <input type="text" name="<?php echo esc_attr($name_prefix); ?>[more_text]" value="<?php echo esc_attr($module['more_text']);?>" class="vlog-count-me" />
		   		<br/>
		   		<label><?php esc_html_e( 'URL', 'vlog' ); ?></label>: <input type="text" name="<?php echo esc_attr($name_prefix); ?>[more_url]" value="<?php echo esc_attr($module['more_url']);?>" class="vlog-count-me" /><br/>
		   		<small class="howto"><?php esc_html_e( 'Specify text and URL if you want to display "view all" button in this module', 'vlog' ); ?></small>
		   	</div>
	    </div>

	</div>
<?php }
endif;


/**
 * Generate text module
 * 
 * @param   $module Data array for current module
 * @param   $options An array of module options
 * @param   $name_prefix id of a current module
 * @since  1.0
 */

if ( !function_exists( 'vlog_generate_module_text' ) ) :
	function vlog_generate_module_text( $module, $options, $name_prefix ){
		
		extract( $options ); ?>

		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Title', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input class="vlog-count-me mod-title" type="text" name="<?php echo esc_attr($name_prefix); ?>[title]" value="<?php echo esc_attr($module['title']);?>"/>
				<input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[hide_title]" value="1" <?php checked( $module['hide_title'], 1 ); ?> class="vlog-count-me" />
				<?php esc_html_e( 'Do not display publicly', 'vlog' ); ?>
				<small class="howto"><?php esc_html_e( 'Enter your module title', 'vlog' ); ?></small>				
			</div>
		</div>

		<div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Width', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
			    <ul class="vlog-img-select-wrap">
			  	<?php foreach ( $columns as $id => $column ): ?>
			  		<li>
			  			<?php $selected_class = vlog_compare( $id, $module['columns'] ) ? ' selected': ''; ?>
			  			<img src="<?php echo esc_url($column['img']); ?>" title="<?php echo esc_attr($column['title']); ?>" class="vlog-img-select<?php echo esc_attr($selected_class); ?>">
			  			<br/><span><?php echo esc_html( $column['title'] ); ?></span>
			  			<input type="radio" class="vlog-hidden vlog-count-me mod-columns" name="<?php echo esc_attr($name_prefix); ?>[columns]" value="<?php echo esc_attr($id); ?>" <?php checked( $id, $module['columns'] );?>/>
			  		</li>
			  	<?php endforeach; ?>
			    </ul>
		    	<small class="howto"><?php esc_html_e( 'Choose module width', 'vlog' ); ?></small>
		    </div>
	    </div>

	    <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Content', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<textarea class="vlog-count-me" name="<?php echo esc_attr($name_prefix); ?>[content]"><?php echo esc_textarea( $module['content'] ); ?></textarea>
				<small class="howto"><?php esc_html_e( 'Paste any text, HTML, script or shortcodes here', 'vlog' ); ?></small>

				<label>
					<input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[autop]" value="1" <?php checked( $module['autop'], 1 ); ?> class="vlog-count-me" />
					<?php esc_html_e( 'Automatically add paragraphs', 'vlog' ); ?>
				</label>
			</div>
		</div>

		 <div class="vlog-opt">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Custom CSS class', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input class="vlog-count-me" type="text" name="<?php echo esc_attr($name_prefix); ?>[css_class]" value="<?php echo esc_attr(esc_html($module['css_class']));?>"/><br/>
				<small class="howto"><?php esc_html_e( 'Specify class name for a possibility to apply custom styling to this module using CSS (i.e. my-custom-module)', 'vlog' ); ?></small>
			</div>
		</div>	

	<?php }
endif;

/**
 * Featured area metabox
 * 
 * @since  1.0
 */

if ( !function_exists( 'vlog_fa_metabox' ) ) :
function vlog_fa_metabox( $object, $box ){
	
	$meta = vlog_get_page_meta( $object->ID, 'fa' );

	$layouts = vlog_get_featured_layouts( false, true );
	$order = vlog_get_post_order_opts();
	$time = vlog_get_time_diff_opts();
	$formats = vlog_get_post_format_opts();
	$post_types = vlog_get_posts_types_with_taxonomies(array('page'));

	$name_prefix = 'vlog[fa]';
	$meta_layout = $meta['layout'];
	$show_hide_class = $meta_layout == 'none' || $meta_layout == 'custom' ? 'vlog-hidden-custom' : ''; 
	$show_class = $meta_layout == 'custom' ? 'vlog-show-custom' : 'vlog-hidden-custom';
	
	$show_hide_class_post_type = $show_hide_class;
	if(count($post_types) < 2){
		$show_hide_class_post_type = 'vlog-hidden-custom';
    }

	?>

	<div class="vlog-opt-box">

		<div class="vlog-opt-inline">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Layout', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
			    <ul class="vlog-img-select-wrap">
			  	<?php foreach ( $layouts as $id => $layout ): ?>
			  		<li>
			  			<?php $selected_class = vlog_compare( $id, $meta['layout'] ) ? ' selected': ''; ?>
			  			<img src="<?php echo esc_url($layout['img']); ?>" title="<?php echo esc_attr($layout['title']); ?>" class="vlog-img-select<?php echo esc_attr($selected_class); ?>">
			  			<br/><span><?php echo esc_attr($layout['title']); ?></span>
			  			<input type="radio" class="vlog-hidden vlog-count-me" name="<?php echo esc_attr($name_prefix); ?>[layout]" value="<?php echo esc_attr($id); ?>" <?php checked( $id, $meta['layout'] );?>/>
			  		</li>
			  	<?php endforeach; ?>
			    </ul>
		    	<small class="howto"><?php esc_html_e( 'Choose your cover area layout', 'vlog' ); ?></small>
		    </div>
	    </div>

	    <div class="vlog-opt-inline vlog-show-hide <?php echo esc_attr($show_hide_class_post_type); ?>">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Post type', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
                <label>
                    <select class="vlog-fa-post-type" name="<?php echo esc_attr( $name_prefix ); ?>[post_type]">
                        <?php foreach ($post_types as $post_type) :?>
                            <?php
                            if( empty($post_type) ){
                                continue;
                            }
                            ?>
                            <option value="<?php echo esc_attr($post_type->name)?>" <?php selected($meta['post_type'], $post_type->name); ?>><?php echo esc_attr($post_type->labels->singular_name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
			</div>
		</div>


	    <div class="vlog-opt-inline vlog-show-hide <?php echo esc_attr($show_hide_class); ?>">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Number of posts', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
				<input class="vlog-count-me" type="text" name="<?php echo esc_attr($name_prefix); ?>[limit]" value="<?php echo esc_attr($meta['limit']);?>"/><br/>
				<small class="howto"><?php esc_html_e( 'Max number of posts to display', 'vlog' ); ?></small>
			</div>
		</div>

		<div class="vlog-opt-inline vlog-show-hide <?php echo esc_attr($show_hide_class); ?>">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Order by', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<?php foreach ( $order as $id => $title ) : ?>
		   		<label><input type="radio" name="<?php echo esc_attr($name_prefix); ?>[order]" value="<?php echo esc_attr($id); ?>" <?php checked( $meta['order'], $id ); ?> class="vlog-count-me" /><?php echo esc_html( $title );?></label><br/>
		   		<?php endforeach; ?>
				
				<div class="vlog-live-search-opt">
					
					<br/><?php esc_html_e( 'Or choose manually', 'vlog' ); ?>:<br/>
		   			<input type="text" class="vlog-live-search vlog-live-search-with-cpts " placeholder="<?php esc_html_e( 'Type to search...', 'vlog' ); ?>" /><br/>
		   			<?php $manualy_selected_posts = vlog_get_manually_selected_posts($meta['manual'], 'cover'); ?>
		   			<?php $manual = !empty( $manualy_selected_posts ) ? implode( ",", $meta['manual'] ) : ''; ?>
		   			<input type="hidden" class="vlog-count-me vlog-live-search-hidden" data-type="cover" name="<?php echo esc_attr($name_prefix); ?>[manual]" value="<?php echo esc_attr($manual); ?>" />
		   			<div class="vlog-live-search-items tagchecklist">
		   				<?php vlog_display_manually_selected_posts($manualy_selected_posts); ?>
		   			</div>

		   		</div>

		   	</div>
	    </div>

	    <div class="vlog-opt-inline vlog-show-hide <?php echo esc_attr($show_hide_class); ?>">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Sort', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<label><input type="radio" name="<?php echo esc_attr($name_prefix); ?>[sort]" value="DESC" <?php checked( $meta['sort'], 'DESC' ); ?> class="vlog-count-me" /><?php esc_html_e('Descending', 'vlog') ?></label><br/>
		   		<label><input type="radio" name="<?php echo esc_attr($name_prefix); ?>[sort]" value="ASC" <?php checked( $meta['sort'], 'ASC' ); ?> class="vlog-count-me" /><?php esc_html_e('Ascending', 'vlog') ?></label><br/>
		   	</div>
	    </div>

	    <div class="vlog-opt-inline vlog-show-hide <?php echo esc_attr($show_hide_class); ?>">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Unique posts (do not duplicate)', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<label><input type="checkbox" name="<?php echo esc_attr($name_prefix); ?>[unique]" value="1" <?php checked( $meta['unique'], 1 ); ?> class="vlog-count-me" /></label>
		   		<small class="howto"><?php esc_html_e( 'If you check this option, selected posts will be excluded from modules.', 'vlog' ); ?></small>
		   	</div>
	    </div>

	</div>

	<div class="vlog-opt-box vlog-show-hide <?php echo esc_attr($show_hide_class); ?>">
        <?php foreach ( $post_types as $post_type ) :
	
	        if ( empty( $post_type->taxonomies ) ) {
		        continue;
	        }
	
	        foreach ( $post_type->taxonomies as $taxonomy ) :
		
		        if ( ! isset( $taxonomy['hierarchical'] ) ) {
			        continue;
		        }
		        
		        if( $taxonomy['hierarchical'] && empty( $taxonomy['terms'] ) ){
                    continue;
                }
		
		        ?>

                <div class="vlog-opt vlog-watch-for-changes" data-watch="vlog-fa-post-type" data-show-on-value="<?php echo esc_attr($post_type->name);?>">
                    <div class="vlog-opt-title">
				        <?php echo esc_attr( $taxonomy['name'] ); ?>:
                    </div>
                    <div class="vlog-opt-content">
				        <?php

				        $taxonomy_id = vlog_patch_taxonomy_id($taxonomy['id']);
            
				        if ( $taxonomy['hierarchical'] ):
					        if ( empty( $taxonomy['terms'] ) ) {
						        continue;
					        }
					        ?>
                            <div class="vlog-fit-height">
						        <?php foreach ( $taxonomy['terms'] as $term ) : ?>
                                    <?php $checked = !empty($meta[$taxonomy_id]) && in_array( $term->term_id, $meta[$taxonomy_id] ) ? 'checked="checked"' : ''; ?>
                                    <label><input class="vlog-count-me" type="checkbox" name="<?php echo esc_attr( $name_prefix . '[' . $taxonomy_id . ']' ); ?>[]" value="<?php echo esc_attr( $term->term_id ); ?>" <?php echo esc_attr( $checked ); ?> /><?php echo esc_html( $term->name ); ?>
                                    </label>
                                    <br/>
						        <?php endforeach; ?>
                            </div>
                            <small class="howto"><?php printf(esc_html__( 'Check whether you want to display posts from specific %s only', 'vlog' ), strtolower($taxonomy['name'])); ?></small>
				        <?php else: ?>
                            <?php $value = empty($meta[$taxonomy_id]) ? '' : vlog_get_tax_term_name_by_slug( $meta[$taxonomy_id], $taxonomy['id'] ); ?>
                            <input type="text" name="<?php echo esc_attr( $name_prefix . '[' . $taxonomy_id . ']' ); ?>" value="<?php echo esc_attr( $value ); ?>" class="vlog-count-me"/><br/>
                            <small class="howto"><?php printf(esc_html__( 'Specify one or more %s separated by comma. i.e. life, cooking, funny moments', 'vlog' ), strtolower($taxonomy['name'])); ?></small>
				        <?php endif;
				
				        $taxonomy_inc_exc = empty($meta[ $taxonomy_id . '_inc_exc' ]) ? 'in' : $meta[ $taxonomy_id . '_inc_exc' ];
				        ?>
                        <br/>
                        <label><input type="radio" name="<?php echo esc_attr( $name_prefix . '[' . $taxonomy_id . '_inc_exc]' ); ?>" value="in" <?php checked( $taxonomy_inc_exc, 'in' ); ?> class="vlog-count-me"/><?php esc_html_e( 'Include', 'vlog' ) ?>
                        </label><br/>
                        <label><input type="radio" name="<?php echo esc_attr( $name_prefix ) . '[' . $taxonomy_id . '_inc_exc]'; ?>" value="not_in" <?php checked( $taxonomy_inc_exc, 'not_in' ); ?> class="vlog-count-me"/><?php esc_html_e( 'Exclude', 'vlog' ) ?>
                        </label><br/>
                        <small class="howto"><?php printf(esc_html__( 'Whether to include or exclude posts from selected %s', 'vlog' ), strtolower($taxonomy['name'])); ?></small>
                    </div>
                    <br>
                </div>
	        <?php endforeach; ?><?php endforeach; ?>

	   	<div class="vlog-opt-inline vlog-watch-for-changes" data-watch="vlog-fa-post-type" data-show-on-value="post">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Format', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<?php foreach ( $formats as $id => $title ) : ?>
		   		<label><input type="radio" name="<?php echo esc_attr($name_prefix); ?>[format]" value="<?php echo esc_attr($id); ?>" <?php checked( $meta['format'], $id ); ?> class="vlog-count-me" /><?php echo esc_html( $title );?></label><br/>
		   		<?php endforeach; ?>
		   		<small class="howto"><?php esc_html_e( 'Display posts that have a specific format', 'vlog' ); ?></small>
	   		</div>
	   	</div>

		<div class="vlog-opt-inline">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Not older than', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">
		   		<?php foreach ( $time as $id => $title ) : ?>
		   		<label><input type="radio" name="<?php echo esc_attr($name_prefix); ?>[time]" value="<?php echo esc_attr($id); ?>" <?php checked( $meta['time'], $id ); ?> class="vlog-count-me" /><?php echo esc_html( $title );?></label><br/>
		   		<?php endforeach; ?>
		   		<small class="howto"><?php esc_html_e( 'Display posts that are not older than specific time range', 'vlog' ); ?></small>
	   		</div>
	   	</div>

	   	

	</div>

	<div class="vlog-opt-box vlog-show-hide vlog-show-hide-custom <?php echo esc_attr($show_hide_class); ?> <?php echo esc_attr($show_class); ?> ">
	   	
	   	<div class="vlog-opt-inline">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Custom Content', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">

				<div class="vlog-content-row">
					<?php 
						$text_name = esc_attr($name_prefix). '[content]';
						$settings = array(
							'textarea_name' => $text_name,
							'editor_class' => 'vlog-count-me',
							'wpautop' => false
						); 
					?>
					<?php wp_editor( $meta['content'], 'cover-area-custom-content', $settings ); ?>
				</div>
			</div>
		</div>

		<div class="vlog-opt-inline">
			<div class="vlog-opt-title">
				<?php esc_html_e( 'Background Image', 'vlog' ); ?>:
			</div>
			<div class="vlog-opt-content">

				<div class="vlog-content-row">
					<input type="text" name="<?php echo esc_attr($name_prefix); ?>[bg_image]" value="<?php echo esc_url($meta['bg_image']); ?>" class="vlog-custom-content-bg"/>
					<a href="#" class="vlog-select-bg-image button"><?php esc_html_e('Upload', 'vlog'); ?></a>
				</div>
			</div>
		</div>
	</div>


<?php }
endif;


/**
 * Pagination metabox
 * 
 * Callback function to create pagination metabox
 * 
 * @since  1.0
 */

if ( !function_exists( 'vlog_pagination_metabox' ) ) :
	function vlog_pagination_metabox( $object, $box ) {
		
		$meta = vlog_get_page_meta( $object->ID );
		$layouts = vlog_get_pagination_layouts( false, true );
?>
	  	<ul class="vlog-img-select-wrap">
	  	<?php foreach ( $layouts as $id => $layout ): ?>
	  		<li>
	  			<?php $selected_class = $id == $meta['pag'] ? ' selected': ''; ?>
	  			<img src="<?php echo esc_url($layout['img']); ?>" title="<?php echo esc_attr($layout['title']); ?>" class="vlog-img-select<?php echo esc_attr($selected_class); ?>">
	  			<span><?php echo esc_html( $layout['title'] ); ?></span>
	  			<input type="radio" class="vlog-hidden" name="vlog[pag]" value="<?php echo esc_attr($id); ?>" <?php checked( $id, $meta['pag'] );?>/> </label>
	  		</li>
	  	<?php endforeach; ?>
	   </ul>

	   <p class="description"><?php esc_html_e( 'Note: Pagination will be applied to the last post module on the page', 'vlog' ); ?></p>

	  <?php
	}
endif;



/**
 * Blank template settings
 *
 * @since 1.1
 */
if(!function_exists('vlog_blank_page_template')):
	function vlog_blank_page_template( $object ){
		
		$vlog_meta = vlog_get_page_meta( $object->ID );
		?>

        <label>
            <input type="hidden" class="vlog-blank-page-title" name="vlog[blank][page_title]" value="0">
            <input type="checkbox" class="vlog-blank-page-title" name="vlog[blank][page_title]" value="1" <?php checked( $vlog_meta['blank']['page_title'], 1 ); ?>>
			<?php esc_html_e( 'Page title', 'vlog' ); ?>
        </label>
        <br>
        <label>
            <input type="hidden" class="vlog-blank-header" name="vlog[blank][header]" value="0">
            <input type="checkbox" class="vlog-blank-header" name="vlog[blank][header]" value="1" <?php checked( $vlog_meta['blank']['header'], 1 ); ?>>
			<?php esc_html_e( 'Header', 'vlog' ); ?>
        </label>
        <br>
        <label>
            <input type="hidden" class="vlog-blank-footer" name="vlog[blank][footer]" value="0">
            <input type="checkbox" class="vlog-blank-footer" name="vlog[blank][footer]" value="1" <?php checked( $vlog_meta['blank']['footer'], 1 ); ?>>
			<?php esc_html_e( 'Footer', 'vlog' ); ?>
        </label>
		<?php
	}
endif;
?>