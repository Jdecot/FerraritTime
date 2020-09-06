<?php
/**
 * Template Name: Blank
 */
?>

<?php get_header(); ?>

<?php get_template_part('template-parts/ads/below-header'); ?>

<div class="vlog-section vlog-single-no-sid">

	<div class="container">

        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <?php $meta = vlog_get_page_meta(); ?>
                <?php if($meta['blank']['page_title']): ?>
                    <?php the_title( '<h1 class="entry-title vlog-page-title">', '</h1>' ); ?>
                <?php endif; ?>

                <div class="entry-content entry-content-single">
                    <?php the_content(); ?>
                </div>

            </article>

        <?php endwhile; ?>

	</div>

</div>

<?php get_footer(); ?>