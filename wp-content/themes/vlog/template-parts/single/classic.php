<div class="entry-header">

	<?php $taxs = array(); ?>
	<?php if( vlog_get_option( 'single_cat' ) && $cat = vlog_get_category() ) : ?>
	    <?php $taxs[] = $cat; ?>
	<?php endif; ?>

	<?php if( vlog_get_option( 'single_serie' ) && $serie = vlog_get_serie() ) : ?>
	    <?php $taxs[] = $serie; ?>
	<?php endif; ?>

	<?php if( !empty($taxs) ): ?>
	    <span class="entry-category"><?php echo implode(', ', $taxs ); ?></span>
	<?php endif; ?>

    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    
  <?php if( $meta = vlog_get_meta_data( 'single' ) ) : ?>
	<div class="entry-meta"><?php echo wp_kses_post( $meta ); ?></div>
  <?php endif; ?>

</div>

<?php get_template_part( 'template-parts/formats/' . vlog_get_post_format( true ) . '-classic' ); ?>