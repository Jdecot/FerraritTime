<?php if ( vlog_is_woocommerce_active() ): ?>
	<?php $elements = vlog_woocommerce_cart_elements(); ?>
	<li class="vlog-actions-button vlog-cart-icon">
		<a class="vlog-custom-cart" href="<?php echo esc_url( $elements['cart_url'] ); ?>">
			<i class="fv fv-cart" aria-hidden="true"></i>
			<?php if( $elements['products_count'] > 0 ) : ?>
				<span class="vlog-cart-count pulse"><?php echo absint( $elements['products_count'] ); ?></span>
			<?php endif; ?>
		</a>
	</li>
<?php endif; ?>