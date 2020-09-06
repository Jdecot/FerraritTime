<?php if ( $pagination = vlog_numeric_pagination( __vlog( 'previous_posts' ), __vlog( 'next_posts' ) ) ) : ?>
	<nav class="vlog-pagination">
		<?php echo wp_kses_post( $pagination ); ?>
	</nav>
<?php endif; ?>