<?php if( vlog_can_display_ads() && $ad = vlog_get_option('ad_above_footer') ): ?>
	<div class="vlog-ad vlog-above-footer-ad"><?php echo do_shortcode( $ad ); ?></div>
<?php endif; ?>