<div class="vlog-module module-series col-lg-12 col-md-12 col-sm-12 <?php echo esc_attr( $module['css_class'] ); ?>" id="vlog-module-<?php echo esc_attr($s_ind.'-'.$m_ind); ?>" data-col="12">
 
     <?php echo vlog_get_module_heading( $module ); ?>

    <?php $mod_series = get_terms( array( 'taxonomy' => 'series', 'include' => implode(",", $module['series']) ) ); ?>

    <?php if( !is_wp_error($mod_series) ): ?>

        <?php 

            $new_mod_series = array();

            foreach( $mod_series as $cat){
                
                 if(!empty($module['series'])){
                    $new_mod_series[array_search( $cat->term_id, $module['series'])] = $cat;
                 } else {
                    $new_mod_series[$cat->term_id] = $cat;
                 }
            }
            
            ksort($new_mod_series);
        ?>

        <?php $slider_class = vlog_module_is_slider( $module ) && ( count($new_mod_series) > 1 )   ? 'vlog-slider' : ''; ?>

        <div class="row vlog-cats row-eq-height <?php echo esc_attr( $slider_class ); ?>">
            
            <?php if( !empty( $mod_series ) ): ?> 
                
                <?php foreach( $new_mod_series as $cat ): ?>
                
                    <?php $layout = vlog_get_module_layout( $module, 0 ); ?>
                    <?php include( locate_template('template-parts/cat-layouts/content-' . $layout . '.php') ); ?>
                
                <?php endforeach; ?>
            <?php endif; ?>

        </div>

    <?php endif; ?>

</div>
