<?php $slider_class = isset($fa->post_count) && $fa->post_count > 1 ? 'vlog-featured-slider' : ''; ?>
<div class="vlog-featured vlog-featured-1 <?php echo esc_attr($slider_class); ?>">

	<?php if( $fa->have_posts() ): ?>

		<?php while( $fa->have_posts()): $fa->the_post(); ?>

			<?php $format = vlog_get_post_format( true ); ?>

			<div class="vlog-featured-item <?php echo esc_attr($format); ?>">

				<div class="vlog-cover-bg">
					<?php get_template_part( 'template-parts/formats/' . vlog_get_post_format( true ) . '-cover' ); ?>
				</div>
		
				<div class="vlog-featured-info container vlog-f-hide">

					<div class="row">
							
							<div class="col-lg-12">

								<div class="vlog-featured-info-bg vlog-highlight">
						
									<div class="entry-header">

	                    				<?php $taxs = array(); ?>
					                    <?php if( vlog_get_option( 'lay_fa1_cat' ) && $cat = vlog_get_category() ) : ?>
					                        <?php $taxs[] = $cat; ?>
					                    <?php endif; ?>

					                    <?php if( vlog_get_option( 'lay_fa1_serie' ) && $serie = vlog_get_serie() ) : ?>
					                        <?php $taxs[] = $serie; ?>
					                    <?php endif; ?>

					                    <?php if( !empty($taxs) ): ?>
					                        <span class="entry-category"><?php echo implode(', ', $taxs ); ?></span>
					                    <?php endif; ?>

						        		<?php the_title( sprintf( '<h2 class="entry-title h1"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
						                
							            <?php if( $meta = vlog_get_meta_data( 'fa1' ) ) : ?>
	                						<div class="entry-meta"><?php echo wp_kses_post( $meta ); ?></div>
	            				  		<?php endif; ?>

						             </div>	

						             <?php if( $actions = vlog_get_meta_actions('fa1') ) : ?>
							             <div class="entry-actions vlog-vcenter-actions"><?php echo $actions; ?></div>
						         	 <?php endif; ?>

					             </div>

					        </div>

					</div>

				</div>

				<div class="vlog-format-inplay vlog-bg">
					<div class="container">
						
					</div>
				</div>

			</div>

		<?php endwhile; ?>

	<?php endif; ?>

</div>