<?php $meta = vlog_get_page_meta( get_the_ID(), 'fa' ); ?>
<?php $bg_image = !empty( $meta['bg_image'] ) ? $meta['bg_image'] : '' ?>
<?php $img_id = !empty( $bg_image ) ? vlog_get_image_id_by_url($bg_image) : '' ?>

<div class="vlog-featured-3 vlog-featured-custom">

	<div class="vlog-featured-item">
	
		<div class="vlog-cover-bg">
				<?php if( $bg_image ) : ?>
                	<div class="vlog-cover"><?php echo wp_get_attachment_image($img_id, 'vlog-cover-full'); ?></div>
                <?php endif; ?>  
		</div>
	
		<div class="vlog-featured-info-3 vlog-featured-info-custom vlog-active-hover vlog-f-hide container">				
			
			<div class="entry-header">

                 <?php if( !empty($meta['content']) ) : ?>
                    <?php echo do_shortcode( $meta['content'] ); ?>
                <?php endif; ?>

             </div>	

		</div>

	</div>

</div>