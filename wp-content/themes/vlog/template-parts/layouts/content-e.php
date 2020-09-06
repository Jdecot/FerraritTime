<article <?php post_class('vlog-lay-e vlog-post col-lg-4  col-sm-4 col-md-4  col-xs-12'); ?>>
	
	<?php if( $fimg = vlog_get_featured_image('vlog-lay-e') ) : ?>
    <div class="entry-image">
    <?php $quick_view = vlog_enable_quick_view('lay_e'); ?>
        <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" class="<?php echo esc_attr( $quick_view ? esc_attr('vlog-quick-view') : '' ); ?>"  data-id="<?php echo get_the_ID();?>">
            <?php echo vlog_wp_kses( $fimg ); ?>
            <?php if( $labels = vlog_labels('e', 'small') ) : ?>
                  <?php echo wp_kses_post( $labels ); ?>
            <?php endif; ?>
	        <?php if($quick_view): ?>
		        <?php $icon_class = $section['use_sidebar'] === 'none' ? 'small' : 'x-small'; ?>
                <span class="vlog-format-action <?php echo esc_attr($icon_class); ?>"><i class="fa fa-play"></i></span>
	        <?php endif; ?>
        </a>
    </div>
	<?php endif; ?>

	<div class="entry-header">

		<?php $taxs = array(); ?>
        <?php if( vlog_get_option( 'lay_e_cat' ) && $cat = vlog_get_category() ) : ?>
            <?php $taxs[] = $cat; ?>
        <?php endif; ?>

        <?php if( vlog_get_option( 'lay_e_serie' ) && $serie = vlog_get_serie() ) : ?>
            <?php $taxs[] = $serie; ?>
        <?php endif; ?>

        <?php if( !empty($taxs) ): ?>
            <span class="entry-category"><?php echo implode(', ', $taxs ); ?></span>
        <?php endif; ?>
        
	    <?php the_title( sprintf( '<h2 class="entry-title h5"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	</div>
	    
	<?php if( $meta = vlog_get_meta_data( 'e' ) ) : ?>
	    <div class="entry-meta"><?php echo wp_kses_post( $meta ); ?></div>
	<?php endif; ?>


	<?php if( vlog_get_option('lay_e_excerpt') ) : ?>
	    <div class="entry-content">
	        <?php echo vlog_get_excerpt( 'e' ); ?>
	    </div>
	<?php endif; ?>
    

</article>