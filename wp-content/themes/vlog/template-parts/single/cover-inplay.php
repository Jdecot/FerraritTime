<div class="vlog-format-inplay vlog-bg">
	<div class="container">

		<?php if( ( vlog_is_video_inplay_mode() && vlog_get_post_format() == 'video') || (vlog_get_option('open_audio_inplay') && vlog_get_post_format() == 'audio' ) ) : ?>
			
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

         <?php if( $actions = vlog_get_meta_actions( 'single' ) ) : ?>
             <div class="entry-actions vlog-vcenter-actions">
             	<?php echo $actions; ?>
             </div>
         <?php endif; ?>

 	   <?php endif; ?>


	</div>
</div>