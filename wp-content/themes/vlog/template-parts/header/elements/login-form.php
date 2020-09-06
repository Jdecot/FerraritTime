<li class="vlog-actions-button vlog-action-search vlog-action-login">
	<span><i class="fv fv-author"></i></span>
	<ul class="sub-menu">
		<?php 
			if ( !is_user_logged_in() ) : 
				$args = array(
					'label_username' => __vlog( 'username_email_label' ),
					'label_password' => __vlog( 'password_label' ),
					'label_remember' => __vlog( 'remember_me' ),
					'label_log_in'   => __vlog( 'log_in' ),
				);
			wp_login_form($args); 
		?>	
	
			<?php if ( get_option( 'users_can_register' ) ): ?>
				<a class="vlog-registration-link" href="<?php echo wp_registration_url(); ?>"><?php echo __vlog( 'registration_link' )?></a>
			<?php endif; ?>
			<a class="vlog-lost-password-link" href="<?php echo wp_lostpassword_url(); ?>"><?php echo __vlog( 'lost_password' )?></a>
		
		<?php else: ?>
			<?php 
			    
			    $current_user = wp_get_current_user();
				printf( '<div class="vlog-avatar-logout"><a href="%s">%s</a></div>', get_edit_profile_url($current_user->ID), get_avatar( $current_user->ID, 64 ));				
			 	printf( '<p class="vlog-username"><a href="%s">%s</a></p>', get_edit_profile_url($current_user->ID), esc_html( $current_user->user_login ));
				printf( '<a class="btn-logout vlog-button" href="%s">' . __vlog( 'log_out' ) . '</a>', wp_logout_url(home_url()));

			?>
		<?php endif; ?>
	</ul>
</li>