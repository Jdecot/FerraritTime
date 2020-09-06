<div class="vlog-module module-cats col-lg-12 col-md-12 col-sm-12 <?php echo esc_attr( $module['css_class'] ); ?>" id="vlog-module-<?php echo esc_attr($s_ind.'-'.$m_ind); ?>" data-col="12">
 
     <?php echo vlog_get_module_heading( $module ); ?>
  
    <?php $mod_cats = get_categories( array( 'include' => implode(",", $module['cat']) ) ); ?>

    <?php 

        $new_mod_cats = array();
        
        foreach( $mod_cats as $cat){
            if(!empty($module['cat'])){
                $new_mod_cats[array_search( $cat->term_id, $module['cat'])] = $cat;
             } else {
                $new_mod_cats[$cat->term_id] = $cat;
             }
        }
        
        ksort($new_mod_cats);
    ?>

    <?php $slider_class = vlog_module_is_slider( $module ) && ( count($new_mod_cats) > 1 )  ? 'vlog-slider' : ''; ?>

    <div class="row vlog-cats row-eq-height <?php echo esc_attr( $slider_class ); ?>">
        
        <?php if( !empty( $new_mod_cats ) ): ?> 
           
            <?php foreach( $new_mod_cats as $cat ): ?>
            
                <?php $layout = vlog_get_module_layout( $module, 0 ); ?>
                <?php include( locate_template('template-parts/cat-layouts/content-' . $layout . '.php') ); ?>

            <?php endforeach; ?>
        <?php endif; ?>

    </div>

</div>