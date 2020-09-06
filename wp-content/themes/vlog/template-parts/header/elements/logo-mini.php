<div class="vlog-site-branding mini">
	<?php
		$logo_mini = vlog_get_option('logo_mini');
		$logo_custom_url = vlog_get_option('logo_custom_url');
		$logo_url = !empty( $logo_custom_url ) ? $logo_custom_url : home_url( '/' );
		$brand = !empty($logo_mini) ? '<img class="vlog-logo-mini" src="'.esc_url( $logo_mini ).'" alt="'.esc_attr(get_bloginfo( 'name' )).'" >' : get_bloginfo( 'name' );
	?>
	<span class="site-title h1"><a href="<?php echo esc_url( $logo_url ); ?>" rel="home"><?php echo wp_kses_post( $brand ); ?></a></span>
</div>