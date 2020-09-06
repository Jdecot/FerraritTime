<article <?php post_class('vlog-lay-c vlog-cat col-lg-6 col-md-6 col-sm-6 col-xs-12'); ?>>
	
	<?php if( $fimg = vlog_get_taxonomy_featured_image('vlog-lay-c', $cat->term_id, $module_type) ) : ?>
    <div class="entry-image">
	    <a href="<?php echo esc_url( get_term_link( $cat->term_id ) ); ?>" title="<?php echo esc_attr( $cat->name ); ?>">
	       	<?php echo wp_kses_post( $fimg ); ?>
	       	<?php if($module['display_icon']): ?>
	       	 <span class="vlog-format-action small"><i class="fa fa-play"></i></span>
	       	<?php endif; ?>
	    </a>
    </div>
	<?php endif; ?>

	<div class="entry-header">
	    <h2 class="entry-title h2"><a href="<?php echo esc_url( get_term_link( $cat->term_id ) ); ?>"><?php echo esc_html($cat->name); ?></a></h2>
	</div>
	
	<?php if($module['display_count']): ?>
	       <div class="entry-meta"><span class="meta-item"><span class="vlog-count"><?php echo esc_html( $cat->count ); ?></span><?php echo esc_html($module['count_label']); ?></span></div>
	<?php endif; ?>

	
    
</article>