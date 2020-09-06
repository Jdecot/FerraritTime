<?php $audio = hybrid_media_grabber( array( 'type' => 'audio', 'split_media' => true ) ); ?>

<?php if( (!vlog_get_option('open_audio_inplay') && is_single()) || ( !is_single() ) ):?>

	<a class="vlog-cover" href="javascript: void(0);" data-action="audio" data-id="<?php echo esc_attr( get_the_ID() ); ?>">
			 <?php echo vlog_get_featured_image('vlog-cover-full', false, false, true ); ?>
			 <?php echo vlog_post_format_action( 'large' ); ?>
	</a>
	<?php if ( $audio ): ?>
			<div class="vlog-format-content"></div>
	<?php endif; ?>

<?php else : ?>

	<?php if ( $audio ): ?>
			<div class="vlog-format-content"><?php echo do_shortcode( $audio ); ?></div>
	<?php endif; ?>

<?php endif; ?>
