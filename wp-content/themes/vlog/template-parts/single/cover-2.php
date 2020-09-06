<div class="vlog-featured-2 vlog-featured vlog-single-cover <?php echo vlog_is_video_inplay_mode() ? esc_attr('inplay-mode-acitve') : ''; ?>  <?php echo vlog_get_option('display_playlist_mode') ? esc_attr('vlog-playlist-mode-acitve') : ''; ?>">


			<div class="vlog-featured-item">
			
				<?php $format = vlog_get_post_format( true ); ?>
				
				<div class="vlog-cover-bg <?php echo esc_attr($format); ?>">
					<?php get_template_part( 'template-parts/formats/' . $format . '-cover' ); ?>
					<?php get_template_part( 'template-parts/single/prev-next-cover'); ?>
				</div>

				<?php if( vlog_display_cover_info( $format ) ): ?>
						
					<div class="vlog-featured-info-2 container vlog-pe-n vlog-active-hover vlog-f-hide">						

						<div class="vlog-fa-item">
							<div class="entry-header vlog-pe-a">
				                
				                <?php $taxs = array(); ?>
								<?php if( vlog_get_option( 'single_cat' ) && $cat = vlog_get_category() ) : ?>
								    <?php $taxs[] = $cat; ?>
								<?php endif; ?>

								<?php if( vlog_get_option( 'single_serie' ) && $serie = vlog_get_serie() ) : ?>
								    <?php $taxs[] = $serie; ?>
								<?php endif; ?>

								<?php if( !empty($taxs) ): ?>
								    <span class="entry-category"><?php echo implode(', ', $taxs ); ?></span>
								<?php endif; ?>

				                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
							                
					            <?php if( $meta = vlog_get_meta_data( 'single' ) ) : ?>
		    						<div class="entry-meta"><?php echo wp_kses_post( $meta ); ?></div>
						  		<?php endif; ?>

				             </div>	
			             </div>

			            
			             <?php if( $actions = vlog_get_meta_actions('single') ) : ?>
			             	<div class="vlog-fa-item">
							   <div class="entry-actions vlog-pe-a"><?php echo $actions; ?></div>
							</div>  
						 <?php endif; ?> 

					</div>

				<?php endif ?>

				<?php get_template_part( 'template-parts/single/cover-inplay'); ?>

			</div>


</div>