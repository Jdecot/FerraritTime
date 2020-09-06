<article <?php post_class('vlog-lay-f lay-horizontal vlog-post col-lg-4 col-sm-4 col-md-4 col-md-f6 col-xs-12'); ?>>
    <div class="row">

        <div class="col-lg-5 col-md-5 col-xs-5">
            <?php if( $fimg = vlog_get_featured_image('vlog-lay-f') ) : ?>
                <?php $quick_view = vlog_enable_quick_view('lay_f'); ?>
                <div class="entry-image">
                    <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" class="<?php echo esc_attr( $quick_view ? esc_attr('vlog-quick-view') : '' ); ?>"  data-id="<?php echo get_the_ID();?>">
                        <?php echo vlog_wp_kses( $fimg ); ?>
                        <?php if($quick_view): ?>
                            <span class="vlog-format-action x-small"><i class="fa fa-play"></i></span>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-7 col-md-7 col-xs-7 no-left-padding">
            
            <div class="entry-header">

                <?php $taxs = array(); ?>
                <?php if( vlog_get_option( 'lay_f_cat' ) && $cat = vlog_get_category() ) : ?>
                    <?php $taxs[] = $cat; ?>
                <?php endif; ?>

                <?php if( vlog_get_option( 'lay_f_serie' ) && $serie = vlog_get_serie() ) : ?>
                    <?php $taxs[] = $serie; ?>
                <?php endif; ?>

                <?php if( !empty($taxs) ): ?>
                    <span class="entry-category"><?php echo implode(', ', $taxs ); ?></span>
                <?php endif; ?>

                <?php the_title( sprintf( '<h2 class="entry-title h6"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

                <?php if( $meta = vlog_get_meta_data( 'f' ) ) : ?>
                    <div class="entry-meta"><?php echo wp_kses_post( $meta ); ?></div>
                <?php endif; ?>

            </div>

        </div>
    </div>
</article>