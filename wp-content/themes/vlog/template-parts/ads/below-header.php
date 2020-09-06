<?php if( vlog_can_display_ads() && $ad = vlog_get_option('ad_below_header') ): ?>
	<div class="vlog-ad"><?php echo do_shortcode( $ad ); ?></div>
<?php endif; ?>