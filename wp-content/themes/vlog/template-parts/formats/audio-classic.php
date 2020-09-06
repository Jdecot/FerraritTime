<?php $fimg =  vlog_get_featured_image('vlog-lay-a', false, true, true ); ?>

<?php if($fimg): ?>
	<div class="entry-image audio-format vlog-single-entry-image">
	
	<?php echo vlog_wp_kses( $fimg ); ?>

	<?php endif; ?>

<?php if ( $audio = hybrid_media_grabber( array( 'type' => 'audio', 'split_media' => true ) ) ): ?>
		<div class="entry-media"><?php echo do_shortcode( $audio ); ?></div>
<?php endif; ?>

<?php if( $fimg ): ?>
	</div>
<?php endif; ?>
