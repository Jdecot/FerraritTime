<?php global $vlog_sidebar_opts; ?>
<?php $section_class = $vlog_sidebar_opts['use_sidebar'] == 'none' ? 'vlog-single-no-sid' : '' ?>
<div class="vlog-section <?php echo esc_attr( $section_class ); ?>">
    <div class="container">
        <div class="vlog-content">   
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php the_title( '<h1 class="entry-title vlog-page-title">', '</h1>' ); ?>
                <div class="entry-content entry-content-single">
                    <?php echo get_the_password_form(); ?>
                </div> 
            </article>
        </div>
    </div>
</div>