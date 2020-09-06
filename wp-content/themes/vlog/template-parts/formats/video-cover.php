<?php if ((!vlog_is_video_inplay_mode() && is_single()) || (!is_single())): ?>
    <a class="vlog-cover" href="javascript: void(0);" data-action="video"
       data-id="<?php echo esc_attr(get_the_ID()); ?>">
        <?php echo vlog_get_featured_image('vlog-cover-full', false, false, true); ?>
        <?php echo vlog_post_format_action('large'); ?>
    </a>
<?php endif; ?>

<?php if ($video = hybrid_media_grabber(array('type' => 'video', 'split_media' => true))): ?>
    <div class="vlog-format-content video">

    <?php if (vlog_is_video_inplay_mode() && is_single()) : ?>

        <?php if (vlog_get_option('display_playlist_mode')): ?>
        <div class="vlog-cover-playlist-active">
            <div class="row">
                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 vlog-playlist-video">
        <?php endif;?>

        <?php echo '<div class="vlog-popup-wrapper">'. do_shortcode($video).'</div>';  ?>

        <?php if(vlog_get_option('display_playlist_mode')): ?>
                </div>
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 vlog-playlist">
                        <?php get_template_part( 'template-parts/single/cover','playlist'); ?>
                    </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>
    </div>
<?php endif; ?>