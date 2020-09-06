<?php if( vlog_can_display_ads() && $ad = vlog_get_option('ad_header') ): ?>
	<div class="vlog-ad hidden-xs"><?php echo do_shortcode( $ad ); ?></div>
<?php endif; ?>