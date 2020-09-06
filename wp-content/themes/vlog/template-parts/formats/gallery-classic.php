<?php if ( $gallery = hybrid_media_grabber( array( 'type' => 'gallery', 'split_media' => true ) ) ): ?>
		<div class="entry-media vlog-cover-clasic"><?php echo wp_kses_post( $gallery ); ?></div>
<?php endif; ?>