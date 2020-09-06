<?php $shadow_class = vlog_get_option('header_shadow') ? 'vlog-header-shadow' : ''; ?>

<div id="vlog-sticky-header" class="vlog-sticky-header vlog-site-header <?php echo esc_attr( $shadow_class ); ?> vlog-header-bottom hidden-xs hidden-sm">
	
		<div class="container">
				<div class="vlog-slot-l">
					<?php $logo = vlog_get_option('logo_mini') && vlog_get_option('header_sticky_logo') == 'mini' ? 'logo-mini' : 'logo';  ?>
					<?php get_template_part('template-parts/header/elements/'.$logo); ?>
				</div>
				<div class="vlog-slot-c">
					<?php if ( vlog_get_option( 'header_sticky_customize' ) ): ?>

						<?php $menu = vlog_get_option('header_sticky_menu'); ?>

						<?php if ( has_nav_menu( $menu ) ) : ?>
							<nav class="vlog-main-navigation">				
								<?php wp_nav_menu( array( 'theme_location' => $menu, 'container'=> '', 'menu_class' => 'vlog-main-nav vlog-menu', 'walker' => new vlog_Menu_Walker) ); ?>
							</nav>
						<?php endif; ?>  

					<?php else: ?>
						<?php get_template_part('template-parts/header/elements/main-menu'); ?>
					<?php endif; ?>   

				</div> 	
				<div class="vlog-slot-r">
					<?php if ( vlog_get_option( 'header_sticky_customize' ) ): ?>
						<?php get_template_part('template-parts/header/elements/sticky-actions'); ?>
					<?php else: ?>
						<?php get_template_part('template-parts/header/elements/actions'); ?>
					<?php endif; ?> 
				</div>
		</div>

</div>