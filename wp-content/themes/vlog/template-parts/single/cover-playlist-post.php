<article <?php post_class('vlog-lay-b lay-horizontal vlog-post'); ?>>
    <div class="row">

        <?php if( $fimg = vlog_get_featured_image('vlog-lay-h-full') ) : ?>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 vlog-playlist-img-wrap">
                <div class="entry-image">
                    <a href="<?php echo esc_url( vlog_add_parameters_to_permalink('playlist', 1)); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
                        <?php echo vlog_wp_kses( $fimg ); ?>
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 no-left-padding">

            <div class="entry-header"><?php the_title( sprintf( '<h3 class="entry-title h7"><a href="%s">', esc_url( vlog_add_parameters_to_permalink('playlist', 1) ) ), '</a></h3>' ); ?></div>

        </div>
    </div>
</article>