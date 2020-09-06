<li class="vlog-actions-button vlog-listen-later">
	
	<?php if( vlog_get_option('listen_later_ajax') ) : ?>
		<span>
			<i class="fv fv-listen-later"></i>
		</span>
	<?php else: ?>
		<?php vlog_load_listen_later(); ?>
	<?php endif;?>
</li>