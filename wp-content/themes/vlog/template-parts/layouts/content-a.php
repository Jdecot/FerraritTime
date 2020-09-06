<article <?php post_class('vlog-lay-a vlog-post'); ?>>

    <?php if( $fimg = vlog_get_featured_image('vlog-lay-a') ) : ?>
        <?php $quick_view = vlog_enable_quick_view('lay_a'); ?>
        <div class="entry-image">
            <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" class="<?php echo esc_attr( $quick_view ? esc_attr('vlog-quick-view') : '' ); ?>"  data-id="<?php echo get_the_ID();?>">
                <?php echo vlog_wp_kses( $fimg ); ?>
                <?php if( $labels = vlog_labels('a', 'large') ) : ?>
                    <?php echo wp_kses_post( $labels ); ?>
                <?php endif; ?>
                <?php if($quick_view): ?>
                    <span class="vlog-format-action large"><i class="fa fa-play"></i></span>
                <?php endif; ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="col-vlog-offset">
    
        <div class="entry-header">
            <?php $taxs = array(); ?>
            <?php if( vlog_get_option( 'lay_a_cat' ) && $cat = vlog_get_category() ) : ?>
                <?php $taxs[] = $cat; ?>
            <?php endif; ?>

            <?php if( vlog_get_option( 'lay_a_serie' ) && $serie = vlog_get_serie() ) : ?>
                <?php $taxs[] = $serie; ?>
            <?php endif; ?>

            <?php if( !empty($taxs) ): ?>
                <span class="entry-category"><?php echo implode(', ', $taxs ); ?></span>
            <?php endif; ?>

            <?php the_title( sprintf( '<h2 class="entry-title h1"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

        </div>
        
        <?php if( $meta = vlog_get_meta_data( 'a' ) ) : ?>
            <div class="entry-meta"><?php echo wp_kses_post( $meta ); ?></div>
        <?php endif; ?>


        <div class="entry-content">
            <?php if( vlog_get_option('lay_a_content_type') == 'content') : ?>
               <?php echo vlog_get_content(); ?>
            <?php else: ?>
                <?php echo vlog_get_excerpt( 'a' ); ?>
            <?php endif; ?>
        </div>
        
        <?php if( vlog_get_option('lay_a_rm') ) : ?>
                    <a class="vlog-rm" href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php echo __vlog('read_more'); ?></a>
        <?php endif; ?>

    </div>

</article>