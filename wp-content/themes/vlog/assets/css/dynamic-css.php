<?php

/* Font styles */

$main_font = vlog_get_font_option( 'main_font' );
$h_font = vlog_get_font_option( 'h_font' );
$nav_font = vlog_get_font_option( 'nav_font' );

/* Font sizes */

$font_size_nav =  number_format( absint(vlog_get_option( 'font_size_nav' ) ) / 10, 1 );
$font_size_p =  number_format( absint(vlog_get_option( 'font_size_p' ) ) / 10, 1 );
$font_size_excerpt_text =  number_format( absint(vlog_get_option( 'font_size_excerpt_text' ) ) / 10, 1 );
$font_size_mfs = number_format( absint(vlog_get_option( 'font_size_mfs' ) ) / 10, 1 );
$font_size_widget_title = number_format( absint(vlog_get_option( 'font_size_widget_title' ) ) / 10, 1 );
$font_size_module_title = number_format( absint(vlog_get_option( 'font_size_module_title' ) ) / 10, 1 );
$font_size_meta_data = number_format( absint(vlog_get_option( 'font_size_meta_data' ) ) / 10, 1 );
$font_size_h1 = number_format( absint(vlog_get_option( 'font_size_h1' ) ) / 10, 1 );
$font_size_h2 = number_format( absint(vlog_get_option( 'font_size_h2' ) ) / 10, 1 );
$font_size_h3 = number_format( absint(vlog_get_option( 'font_size_h3' ) ) / 10, 1 );
$font_size_h4 = number_format( absint(vlog_get_option( 'font_size_h4' ) ) / 10, 1 );
$font_size_h5 = number_format( absint(vlog_get_option( 'font_size_h5' ) ) / 10, 1 );
$font_size_h6 = number_format( absint(vlog_get_option( 'font_size_h6' ) ) / 10, 1 );
$font_size_h7 = number_format( absint(vlog_get_option( 'font_size_h7' ) ) / 10, 1 );

/* Top header styles */

$color_header_top_bg = esc_attr( vlog_get_option( 'color_header_top_bg' ) );
$color_header_top_txt = esc_attr( vlog_get_option( 'color_header_top_txt' ) );
$color_header_top_acc = esc_attr( vlog_get_option( 'color_header_top_acc' ) );


/* Middle header styles */

$color_header_bg = esc_attr( vlog_get_option( 'color_header_main_bg' ) );
$color_header_txt = esc_attr( vlog_get_option( 'color_header_main_txt' ) );
$color_header_acc = esc_attr( vlog_get_option( 'color_header_main_acc' ) );
$header_height = esc_attr( vlog_get_option( 'header_height' ) );


/* Bottom header styles */

$color_header_bottom_bg = esc_attr( vlog_get_option( 'color_header_bottom_bg' ) );
$color_header_bottom_txt = esc_attr( vlog_get_option( 'color_header_bottom_txt' ) );
$color_header_bottom_acc = esc_attr( vlog_get_option( 'color_header_bottom_acc' ) );


/* Sticky header styles */

$sticky_colors_from = vlog_get_option('header_sticky_colors');

$color_header_sticky_bg = esc_attr( vlog_get_option( 'color_header_'.$sticky_colors_from.'_bg' ) );
$color_header_sticky_txt = esc_attr( vlog_get_option( 'color_header_'.$sticky_colors_from.'_txt' ) );
$color_header_sticky_acc = esc_attr( vlog_get_option( 'color_header_'.$sticky_colors_from.'_acc' ) );


/* General styles */

$content_layout = vlog_get_option( 'content_layout' );
$body_background = vlog_get_bg_option( 'body_background' );
$color_content_bg = esc_attr( vlog_get_option( 'color_content_bg' ) );
$color_content_title = esc_attr( vlog_get_option( 'color_content_title' ) );
$color_content_txt = esc_attr( vlog_get_option( 'color_content_txt' ) );
$color_content_acc = esc_attr( vlog_get_option( 'color_content_acc' ) );
$color_content_meta = esc_attr( vlog_get_option( 'color_content_meta' ) );


/* Highlight styles */

$color_highlight_bg = esc_attr( vlog_get_option( 'color_highlight_bg' ) );
$color_highlight_txt = esc_attr( vlog_get_option( 'color_highlight_txt' ) );


/* Footer styles */

$color_footer_bg = esc_attr( vlog_get_option( 'color_footer_bg' ) );
$color_footer_txt = esc_attr( vlog_get_option( 'color_footer_txt' ) );
$color_footer_acc = esc_attr( vlog_get_option( 'color_footer_acc' ) );

/* Cover  styles */
$cover_h = esc_attr( vlog_get_option( 'cover_h' ) );

?>



body,
#cancel-comment-reply-link,
.vlog-wl-action .vlog-button,
.vlog-actions-menu .vlog-action-login a {
  <?php if( $content_layout == 'boxed') : ?>
		<?php echo esc_attr( $body_background ); ?>
  <?php endif; ?>
  color: <?php echo esc_attr( $color_content_txt ); ?>;
  font-family: <?php echo wp_kses_post( $main_font['font-family'] ); ?>;
  font-weight: <?php echo esc_attr( $main_font['font-weight'] ); ?>;
  <?php if ( isset( $main_font['font-style'] ) && !empty( $main_font['font-style'] ) ):?>
  	font-style: <?php echo esc_attr( $main_font['font-style'] ); ?>;
  <?php endif; ?>
}

.vlog-body-box{
	background-color:  <?php echo esc_attr( $color_content_bg ); ?>;
}

/* Typography styles */

h1, h2, h3, h4, h5, h6,
.h1, .h2, .h3, .h4, .h5, .h6,
blockquote,
.vlog-comments .url,
.comment-author b,
.vlog-site-header .site-title a,
.entry-content thead td,
#bbpress-forums .bbp-forum-title, #bbpress-forums .bbp-topic-permalink,
.wp-block-cover .wp-block-cover-image-text, .wp-block-cover .wp-block-cover-text, 
.wp-block-cover h2, .wp-block-cover-image .wp-block-cover-image-text, 
.wp-block-cover-image .wp-block-cover-text, .wp-block-cover-image h2 {
  font-family: <?php echo wp_kses_post( $h_font['font-family'] ); ?>;
  font-weight: <?php echo esc_attr( $h_font['font-weight'] ); ?>;
  <?php if ( isset( $h_font['font-style'] ) && !empty( $h_font['font-style'] ) ):?>
  font-style: <?php echo esc_attr( $h_font['font-style'] ); ?>;
  <?php endif; ?>
}

.vlog-site-header a,
.dl-menuwrapper li a{
  font-family: <?php echo wp_kses_post( $nav_font['font-family'] ); ?>;
  font-weight: <?php echo esc_attr( $nav_font['font-weight'] ); ?>;
  <?php if ( isset( $nav_font['font-style'] ) && !empty( $nav_font['font-style'] ) ):?>
  font-style: <?php echo esc_attr( $nav_font['font-style'] ); ?>;
  <?php endif; ?>
}

/* Font Sizes */
body{
    font-size: <?php echo esc_attr( $font_size_p ); ?>rem;
}
.entry-headline.h4{
    font-size: <?php echo esc_attr( $font_size_excerpt_text ); ?>rem;
}
.vlog-site-header .vlog-main-nav li a{
    font-size: <?php echo esc_attr( $font_size_nav ); ?>rem;
}
.vlog-sidebar, .vlog-site-footer p, .vlog-lay-b .entry-content p, .vlog-lay-c .entry-content p, .vlog-lay-d .entry-content p, .vlog-lay-e .entry-content p{
    font-size: <?php echo esc_attr( $font_size_mfs ); ?>rem;
}
.widget .widget-title{
    font-size: <?php echo esc_attr( $font_size_widget_title ); ?>rem;
}
.vlog-mod-head .vlog-mod-title h4{
    font-size: <?php echo esc_attr( $font_size_module_title ); ?>rem;
}
h1, .h1 {
    font-size: <?php echo esc_attr( $font_size_h1 ); ?>rem;
}

h2, .h2 {
    font-size: <?php echo esc_attr( $font_size_h2 ); ?>rem;
}

h3, .h3 {
    font-size: <?php echo esc_attr( $font_size_h3 ); ?>rem;
}

h4, .h4, .vlog-no-sid .vlog-lay-d .h5, .vlog-no-sid .vlog-lay-e .h5, .vlog-no-sid .vlog-lay-f .h5 {
    font-size: <?php echo esc_attr( $font_size_h4 ); ?>rem;
}

h5, .h5, .vlog-no-sid .vlog-lay-g .h6 {
    font-size: <?php echo esc_attr( $font_size_h5 ); ?>rem;
}

h6, .h6 {
    font-size: <?php echo esc_attr( $font_size_h6 ); ?>rem;
}

.h7{
    font-size: <?php echo esc_attr( $font_size_h7 ); ?>rem;
}
.entry-headline h4{
    font-size: <?php echo esc_attr( $font_size_excerpt_text ); ?>rem;
}

.meta-item{
    font-size: <?php echo esc_attr( $font_size_meta_data ); ?>rem;
}

/* Top Header */
.vlog-top-bar,
.vlog-top-bar .sub-menu{
    background-color: <?php echo esc_attr( $color_header_top_bg ); ?>;
}
.vlog-top-bar ul li a,
.vlog-site-date{
    color: <?php echo esc_attr( $color_header_top_txt ); ?>;
}
.vlog-top-bar ul li:hover > a{
    color: <?php echo esc_attr( $color_header_top_acc ); ?>;
}

/* Main Header */

.vlog-header-middle{
  height: <?php echo absint( $header_height ); ?>px;
}
.vlog-header-middle .site-title img{
  max-height: <?php echo absint( $header_height ); ?>px;  
}
.vlog-site-header,
.vlog-header-shadow .vlog-header-wrapper,
.vlog-site-header .vlog-main-nav .sub-menu,
.vlog-actions-button .sub-menu,
.vlog-site-header .vlog-main-nav > li:hover > a,
.vlog-actions-button:hover > span,
.vlog-action-search.active.vlog-actions-button > span,
.vlog-actions-search input[type=text]:focus,
.vlog-responsive-header,
.dl-menuwrapper .dl-menu{
    background-color: <?php echo esc_attr( $color_header_bg ); ?>;
}
<?php if( $header_bg = vlog_get_bg_option('background_header') ) : ?>
  .vlog-header-wrapper {
    <?php echo wp_kses_post( $header_bg ); ?>
  }
<?php endif; ?>
.vlog-site-header,
.vlog-site-header .entry-title a,
.vlog-site-header a,
.vlog-custom-cart,
.dl-menuwrapper li a,
.vlog-site-header .vlog-search-form input[type=text],
.vlog-responsive-header,
.vlog-responsive-header a
.vlog-responsive-header .entry-title a,
.dl-menuwrapper button,
.vlog-remove-wl, 
.vlog-remove-ll {
  color: <?php echo esc_attr( $color_header_txt ); ?>;
}
.vlog-main-nav .sub-menu li:hover > a,
.vlog-main-nav > .current_page_item > a,
.vlog-main-nav .current-menu-item > a,
.vlog-main-nav li:not(.menu-item-has-children):hover > a,
.vlog-actions-button.vlog-action-search:hover span,
.vlog-actions-button.vlog-cart-icon:hover a,
.dl-menuwrapper li a:focus,
.dl-menuwrapper li a:hover,
.dl-menuwrapper button:hover,
.vlog-main-nav .vlog-mega-menu .entry-title a:hover,
.vlog-menu-posts .entry-title a:hover,
.vlog-menu-posts .vlog-remove-wl:hover{
  color: <?php echo esc_attr( $color_header_acc ); ?>;
}

.vlog-site-header .vlog-search-form input[type=text]::-webkit-input-placeholder {
   color: <?php echo esc_attr( $color_header_txt ); ?>;
}

.vlog-site-header .vlog-search-form input[type=text]::-moz-placeholder {  /* Firefox 19+ */
    color: <?php echo esc_attr( $color_header_txt ); ?>;
}

.vlog-site-header .vlog-search-form input[type=text]:-ms-input-placeholder {  
    color: <?php echo esc_attr( $color_header_txt ); ?>;
}
.vlog-watch-later-count{
  background-color: <?php echo esc_attr( $color_header_acc ); ?>;
}
.pulse{
    -webkit-box-shadow: 0 0 0 0 #f0f0f0, 0 0 0 0 <?php echo vlog_hex2rgba( $color_header_acc , 0.7); ?>;
    box-shadow: 0 0 0 0 #f0f0f0, 0 0 0 0 <?php echo vlog_hex2rgba( $color_header_acc , 0.7); ?>;
}

/* Bottom Header */
.vlog-header-bottom{
  background: <?php echo esc_attr( $color_header_bottom_bg ); ?>;  
}
.vlog-header-bottom,
.vlog-header-bottom .entry-title a,
.vlog-header-bottom a,
.vlog-header-bottom .vlog-search-form input[type=text]{
  color: <?php echo esc_attr(  $color_header_bottom_txt ); ?>;
}
.vlog-header-bottom .vlog-main-nav .sub-menu li:hover > a, 
.vlog-header-bottom .vlog-main-nav > .current_page_item > a, 
.vlog-header-bottom .vlog-main-nav .current-menu-item > a, 
.vlog-header-bottom .vlog-main-nav li:not(.menu-item-has-children):hover > a, 
.vlog-header-bottom .vlog-actions-button.vlog-action-search:hover span,
.vlog-header-bottom .entry-title a:hover,
.vlog-header-bottom .vlog-remove-wl:hover,
.vlog-header-bottom .vlog-mega-menu .entry-title a:hover{
  color: <?php echo esc_attr(  $color_header_bottom_acc ); ?>;
}
.vlog-header-bottom .vlog-search-form input[type=text]::-webkit-input-placeholder {
   color: <?php echo esc_attr( $color_header_txt ); ?>;
}

.vlog-header-bottom .vlog-search-form input[type=text]::-moz-placeholder {  /* Firefox 19+ */
    color: <?php echo esc_attr( $color_header_txt ); ?>;
}

.vlog-header-bottom .vlog-search-form input[type=text]:-ms-input-placeholder {  
    color: <?php echo esc_attr( $color_header_txt ); ?>;
}

.vlog-header-bottom .vlog-watch-later-count{
  background-color: <?php echo esc_attr(  $color_header_bottom_acc ); ?>;
}
.vlog-header-bottom .pulse{
    -webkit-box-shadow: 0 0 0 0 #f0f0f0, 0 0 0 0 <?php echo vlog_hex2rgba( $color_header_bottom_acc , 0.7); ?>;
    box-shadow: 0 0 0 0 #f0f0f0, 0 0 0 0 <?php echo vlog_hex2rgba( $color_header_bottom_acc , 0.7); ?>;
}
/* Sticky Header */

.vlog-sticky-header.vlog-site-header,
.vlog-sticky-header.vlog-site-header .vlog-main-nav .sub-menu,
.vlog-sticky-header .vlog-actions-button .sub-menu,
.vlog-sticky-header.vlog-site-header .vlog-main-nav > li:hover > a,
.vlog-sticky-header .vlog-actions-button:hover > span,
.vlog-sticky-header .vlog-action-search.active.vlog-actions-button > span,
.vlog-sticky-header .vlog-actions-search input[type=text]:focus{
    background-color: <?php echo esc_attr( $color_header_sticky_bg ); ?>;
}
.vlog-sticky-header,
.vlog-sticky-header .entry-title a,
.vlog-sticky-header a,
.vlog-sticky-header .vlog-search-form input[type=text],
.vlog-sticky-header.vlog-site-header a{
  color: <?php echo esc_attr( $color_header_sticky_txt ); ?>;
}
.vlog-sticky-header .vlog-main-nav .sub-menu li:hover > a,
.vlog-sticky-header .vlog-main-nav > .current_page_item > a,
.vlog-sticky-header .vlog-main-nav li:not(.menu-item-has-children):hover > a,
.vlog-sticky-header .vlog-actions-button.vlog-action-search:hover span,
.vlog-sticky-header.vlog-header-bottom .vlog-main-nav .current-menu-item > a,
.vlog-sticky-header.vlog-header-bottom .entry-title a:hover,
.vlog-sticky-header.vlog-header-bottom  .vlog-remove-wl:hover,
.vlog-sticky-header .vlog-main-nav .vlog-mega-menu .entry-title a:hover,
.vlog-sticky-header .vlog-menu-posts .entry-title a:hover,
.vlog-sticky-header .vlog-menu-posts .vlog-remove-wl:hover {
  color: <?php echo esc_attr( $color_header_sticky_acc ); ?>;
}

.vlog-header-bottom .vlog-search-form input[type=text]::-webkit-input-placeholder {
   color: <?php echo esc_attr( $color_header_sticky_txt ); ?>;
}

.vlog-header-bottom .vlog-search-form input[type=text]::-moz-placeholder {  /* Firefox 19+ */
    color: <?php echo esc_attr( $color_header_sticky_txt ); ?>;
}

.vlog-header-bottom .vlog-search-form input[type=text]:-ms-input-placeholder {  
    color: <?php echo esc_attr( $color_header_sticky_txt ); ?>;
}

.vlog-sticky-header .vlog-watch-later-count{
  background-color: <?php echo esc_attr( $color_header_sticky_acc ); ?>;
}
.vlog-sticky-header .pulse{
    -webkit-box-shadow: 0 0 0 0 #f0f0f0, 0 0 0 0 <?php echo vlog_hex2rgba( $color_header_sticky_acc , 0.7); ?>;
    box-shadow: 0 0 0 0 #f0f0f0, 0 0 0 0 <?php echo vlog_hex2rgba( $color_header_sticky_acc , 0.7); ?>;
}

/* General */

a{
  color: <?php echo esc_attr( $color_content_acc ); ?>; 
}
.meta-item,
.meta-icon,
.meta-comments a,
.vlog-prev-next-nav .vlog-pn-ico,
.comment-metadata a,
.widget_calendar table caption,
.widget_archive li,
.widget_recent_comments li,
.rss-date,
.widget_rss cite,
.widget_tag_cloud a:after,
.widget_recent_entries li .post-date,
.meta-tags a:after,
.bbp-forums .bbp-forum-freshness a,
#vlog-video-sticky-close{
    color: <?php echo esc_attr( $color_content_meta ); ?>; 
}

.vlog-pagination .dots:hover, 
.vlog-pagination a, 
.vlog-post .entry-category a:hover,
a.meta-icon:hover,
.meta-comments:hover,
.meta-comments:hover a,
.vlog-prev-next-nav a,
.widget_tag_cloud a,
.widget_calendar table tfoot tr td a,
.vlog-button-search,
.meta-tags a,
.vlog-all-link:hover,
.vlog-sl-item:hover,
.entry-content-single .meta-tags a:hover,
#bbpress-forums .bbp-forum-title, #bbpress-forums .bbp-topic-permalink{
    color: <?php echo esc_attr( $color_content_txt ); ?>; 
}
.vlog-count,
.vlog-button,
.vlog-pagination .vlog-button,
.vlog-pagination .vlog-button:hover,
.vlog-listen-later-count,
.vlog-cart-icon a .vlog-cart-count,
a.page-numbers:hover,
.widget_calendar table tbody td a,
.vlog-load-more a,
.vlog-next a,
.vlog-prev a,
.vlog-pagination .next,
.vlog-pagination .prev,
.mks_author_link,
.mks_read_more a,
.vlog-wl-action .vlog-button,
body .mejs-controls .mejs-time-rail .mejs-time-current,
.vlog-link-pages a{
  background-color: <?php echo esc_attr( $color_content_acc ); ?>;
}
.vlog-pagination .uil-ripple-css div:nth-of-type(1),
.vlog-pagination .uil-ripple-css div:nth-of-type(2),
blockquote{
  border-color: <?php echo esc_attr( $color_content_acc ); ?>;
}

.entry-content-single a,
#bbpress-forums .bbp-forum-title:hover, #bbpress-forums .bbp-topic-permalink:hover{
  color: <?php echo esc_attr( $color_content_acc ); ?>;
}
.entry-content-single a:hover{
  color: <?php echo esc_attr( $color_content_txt ); ?>;
}
.vlog-site-content,
.vlog-content .entry-content-single a.vlog-popup-img {
   background: <?php echo esc_attr( $color_content_bg ); ?>;
}
.vlog-content .entry-content-single a.vlog-popup-img  {
  color: <?php echo esc_attr( $color_content_bg ); ?>;
}
h1,h2,h3,h4,h5,h6,
.h1, .h2, .h3, .h4, .h5, .h6,
.entry-title a,
.vlog-comments .url,
.rsswidget:hover,
.vlog-format-inplay .entry-category a:hover,
.vlog-format-inplay .meta-comments a:hover,
.vlog-format-inplay .action-item,
.vlog-format-inplay .entry-title a,
.vlog-format-inplay .entry-title a:hover {
   color: <?php echo esc_attr( $color_content_title ); ?>;
}
.widget ul li a{
  color: <?php echo esc_attr( $color_content_txt ); ?>;
}
.widget ul li a:hover,
.entry-title a:hover,
.widget .vlog-search-form .vlog-button-search:hover,
.bypostauthor .comment-body .fn:before,
.vlog-comments .url:hover,
#cancel-comment-reply-link,
.widget_tag_cloud a:hover,
.meta-tags a:hover,
.vlog-remove-wl:hover{
  color: <?php echo esc_attr( $color_content_acc ); ?>;
}
.entry-content p{
  color: <?php echo esc_attr( $color_content_txt ); ?>;
}
.widget_calendar #today:after{
  background: <?php echo vlog_hex2rgba( esc_attr( $color_content_txt ) , 0.1); ?>
}
.vlog-button,
.vlog-button a,
.vlog-pagination .vlog-button,
.vlog-pagination .next,
.vlog-pagination .prev,
a.page-numbers:hover,
.widget_calendar table tbody td a,
.vlog-featured-info-2 .entry-title a,
.vlog-load-more a,
.vlog-next a,
.vlog-prev a,
.mks_author_link,
.mks_read_more a,
.vlog-wl-action .vlog-button,
.vlog-link-pages a,
.vlog-link-pages a:hover{
    color: #FFF;
}

#cancel-comment-reply-link, .comment-reply-link, .vlog-rm,
.vlog-mod-actions .vlog-all-link,
.vlog-slider-controls .owl-next, .vlog-slider-controls .owl-prev {
  color: <?php echo esc_attr( $color_content_acc ); ?>; 
  border-color: <?php echo vlog_hex2rgba( $color_content_acc , 0.7); ?>
}
.vlog-mod-actions .vlog-all-link:hover,
.vlog-slider-controls .owl-next:hover, .vlog-slider-controls .owl-prev:hover {
  color: <?php echo esc_attr( $color_content_txt ); ?>; 
  border-color: <?php echo vlog_hex2rgba( esc_attr( $color_content_txt ) , 0.7); ?>
}
.comment-reply-link:hover,
.vlog-rm:hover,
#cancel-comment-reply-link:hover{
  color: <?php echo esc_attr( $color_content_txt ); ?>;
  border-color: <?php echo esc_attr( $color_content_txt ); ?>;
}

.wp-block-button__link,
.wp-block-search__button{
  background: <?php echo esc_attr( $color_content_acc ); ?>; 
  color: <?php echo esc_attr( $color_content_bg ); ?>;
}
.wp-block-button__link:hover,
.wp-block-search__button:hover{
  color: <?php echo esc_attr( $color_content_bg ); ?>;  
}
.wp-block-separator{
	border-color: <?php echo vlog_hex2rgba($color_content_txt, 0.2); ?>;
	border-bottom-width: 1px;	
}
.wp-block-calendar tfoot a{
  color: <?php echo esc_attr( $color_content_acc ); ?>; 
}
/* Highlight */

.vlog-highlight .entry-category,
.vlog-highlight .entry-category a,
.vlog-highlight .meta-item a,
.vlog-highlight .meta-item span,
.vlog-highlight .meta-item,
.vlog-highlight  .widget_tag_cloud a:hover{
    color: <?php echo vlog_hex2rgba( $color_highlight_txt , 0.5); ?>;
}

.vlog-highlight {
    background: <?php echo esc_attr( $color_highlight_bg ); ?>;
    color: <?php echo esc_attr( $color_highlight_txt ); ?>;
    border: none;
}

.vlog-highlight .widget-title{
    border-bottom-color: <?php echo vlog_hex2rgba( $color_highlight_txt , 0.1); ?>;
}
.vlog-highlight .entry-title,
.vlog-highlight .entry-category a:hover,
.vlog-highlight .action-item,
.vlog-highlight .meta-item a:hover,
.vlog-highlight .widget-title span,
.vlog-highlight .entry-title a,
.widget.vlog-highlight ul li a,
.vlog-highlight.widget_calendar table tfoot tr td a,
.vlog-highlight .widget_tag_cloud a{
  color: <?php echo esc_attr( $color_highlight_txt ); ?>;
}
.vlog-highlight .widget_calendar #today:after{
   background: <?php echo vlog_hex2rgba( $color_highlight_txt , 0.1); ?>;  
}
.widget.vlog-highlight  input[type=number], 
.widget.vlog-highlight input[type=text], 
.widget.vlog-highlight input[type=email], 
.widget.vlog-highlight input[type=url], 
.widget.vlog-highlight input[type=tel], 
.widget.vlog-highlight input[type=date], 
.widget.vlog-highlight input[type=password], 
.widget.vlog-highlight select, 
.widget.vlog-highlight textarea{
  background: #FFF;  
  color: #111;
  border-color: <?php echo vlog_hex2rgba( $color_highlight_txt , 0.1); ?>;
}
.vlog-highlight .vlog-button-search{
  color:#111;
}

/* Gray areas */

.vlog-bg-box,
.author .vlog-mod-desc,
.vlog-bg{
    background: <?php echo vlog_hex2rgba( esc_attr( $color_content_txt ) , 0.05); ?>;  
}

.vlog-pagination .current{
    background: <?php echo vlog_hex2rgba( esc_attr( $color_content_txt ) , 0.1); ?>;
}

/* Footer */
.vlog-site-footer{
    background: <?php echo esc_attr( $color_footer_bg ); ?>;
    color: <?php echo esc_attr( $color_footer_txt ); ?>;
}
.vlog-site-footer .widget-title,
.vlog-site-footer .widget_calendar table tbody td a,
.vlog-site-footer .widget_calendar table tfoot tr td a,
.vlog-site-footer .widget.mks_author_widget h3,
.vlog-site-footer  .mks_author_link,
.vlog-site-footer .vlog-button:hover,
.vlog-site-footer .meta-item a:hover,
.vlog-site-footer .entry-category a:hover {
  color: <?php echo esc_attr( $color_footer_txt ); ?>;
}
.vlog-site-footer a,
.vlog-site-footer ul li a,
.vlog-site-footer .widget_calendar table tbody td a:hover,
.vlog-site-footer .widget_calendar table tfoot tr td a:hover{
  color: <?php echo vlog_hex2rgba( $color_footer_txt , 0.8); ?>;
}
.vlog-site-footer .meta-item a,
.vlog-site-footer .meta-item .meta-icon,
.vlog-site-footer .widget_recent_entries li .post-date,
.vlog-site-footer .meta-item{
  color: <?php echo vlog_hex2rgba( $color_footer_txt , 0.5); ?>;
}
.vlog-site-footer .meta-comments:hover,
.vlog-site-footer ul li a:hover,
.vlog-site-footer a:hover{
  color: <?php echo esc_attr( $color_footer_acc ); ?>;
}
.vlog-site-footer .widget .vlog-count,
.vlog-site-footer .widget_calendar table tbody td a,
.vlog-site-footer a.mks_author_link,
.vlog-site-footer a.mks_author_link:hover,
.vlog-site-footer .widget_calendar table tbody td a:hover{
  color: <?php echo esc_attr( $color_footer_bg ); ?>;
  background: <?php echo esc_attr( $color_footer_acc ); ?>;
}
.vlog-site-footer .widget .vlog-search-form input[type=text],
.vlog-site-footer select{
   background: #FFF;
   color: #111;
   border:<?php echo esc_attr( $color_footer_txt ); ?>;
}
.vlog-site-footer .widget .vlog-search-form .vlog-button-search{
  color: #111;
}
.vlog-site-footer .vlog-mod-actions .vlog-all-link, .vlog-site-footer .vlog-slider-controls .owl-next, .vlog-site-footer .vlog-slider-controls .owl-prev{
   color: <?php echo vlog_hex2rgba( $color_footer_txt , 0.8); ?>;
   border-color:  <?php echo vlog_hex2rgba( $color_footer_txt , 0.8); ?>;
}
.vlog-site-footer .vlog-mod-actions .vlog-all-link:hover, .vlog-site-footer .vlog-slider-controls .owl-next:hover, .vlog-site-footer .vlog-slider-controls .owl-prev:hover{
   color: <?php echo vlog_hex2rgba( $color_footer_txt , 1); ?>;
   border-color:  <?php echo vlog_hex2rgba( $color_footer_txt , 1); ?>;
}
.entry-content-single ul > li:before,
.vlog-comments .comment-content ul > li:before{
  color: <?php echo esc_attr( $color_content_acc ); ?>;
}


input[type=number], input[type=text], input[type=email],input[type=search], input[type=url], input[type=tel], input[type=date], input[type=password], select, textarea,
.widget,
.vlog-comments,
.comment-list,
.comment .comment-respond,
.widget .vlog-search-form input[type=text],
.vlog-content .vlog-prev-next-nav,
.vlog-wl-action,
.vlog-mod-desc .vlog-search-form,
.entry-content table,
.entry-content td, .entry-content th,
.entry-content-single table,
.entry-content-single td, .entry-content-single th,
.vlog-comments table,
.vlog-comments td, .vlog-comments th,
.wp-block-calendar tfoot{
  border-color: <?php echo vlog_hex2rgba( esc_attr( $color_content_txt ) , 0.1); ?>;
}
input[type=number]:focus, input[type=text]:focus, input[type=email]:focus, input[type=url]:focus, input[type=tel]:focus, input[type=date]:focus, input[type=password]:focus, select:focus, textarea:focus{
  border-color: <?php echo vlog_hex2rgba( esc_attr( $color_content_txt ) , 0.3); ?>;  
}
input[type=number], input[type=text], input[type=email], input[type=url], input[type=tel], input[type=date], input[type=password], select, textarea{
  background-color: <?php echo vlog_hex2rgba( esc_attr( $color_content_txt ) , 0.03); ?>;  
}
body div.wpforms-container-full .wpforms-form input, body div.wpforms-container-full .wpforms-form select, body div.wpforms-container-full .wpforms-form textarea {
  background-color: <?php echo vlog_hex2rgba( esc_attr( $color_content_txt ) , 0.03);?> !important; 
  border-color: <?php echo vlog_hex2rgba( esc_attr( $color_content_txt ) , 0.1); ?> !important;
}
.vlog-button,
input[type="submit"],
.wpcf7-submit,
input[type="button"],
body div.wpforms-container-full .wpforms-form input[type=submit], 
body div.wpforms-container-full .wpforms-form button[type=submit], 
body div.wpforms-container-full .wpforms-form .wpforms-page-button,
body div.wpforms-container-full .wpforms-form input[type=submit]:hover, 
body div.wpforms-container-full .wpforms-form button[type=submit]:hover, 
body div.wpforms-container-full .wpforms-form .wpforms-page-button:hover {
  background-color: <?php echo esc_attr( $color_content_acc ); ?>;
}
.vlog-comments .comment-content{
  color: <?php echo vlog_hex2rgba( esc_attr( $color_content_txt ) , 0.8); ?>;  
}

li.bypostauthor > .comment-body,
.vlog-rm {
  border-color: <?php echo esc_attr( $color_content_acc ); ?>;
}
.vlog-ripple-circle{
  stroke: <?php echo esc_attr( $color_content_acc ); ?>;
}

.vlog-cover-bg,
.vlog-featured-2 .vlog-featured-item,
.vlog-featured-3 .vlog-featured-item,
.vlog-featured-4 .owl-item,
.vlog-featured-5{
    height: <?php echo absint( $cover_h ); ?>px;
}
.vlog-fa-5-wrapper{
  height: <?php echo absint( $cover_h - 72 ); ?>px;
}
.vlog-fa-5-wrapper .fa-item{
  height: <?php echo absint( ( $cover_h - 144 ) / 2 ); ?>px;
}

<?php if(!vlog_get_option( 'cover_shadow_enabled' )): ?>
    .vlog-cover:before, .vlog-cover:after{ display:none; }
    .vlog-featured-3 .vlog-cover img { opacity: 1; }
<?php endif; ?>

/* WooCommerce classes */
<?php if ( vlog_is_woocommerce_active() ) { ?>
.woocommerce ul.products li.product .button,
.woocommerce ul.products li.product .added_to_cart,
body.woocommerce .button,
body.woocommerce-page .button,
.woocommerce .widget_shopping_cart_content .buttons .button,
.woocommerce div.product div.summary .single_add_to_cart_button,
.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,
.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover,
.woocommerce-page #payment #place_order,
.woocommerce #review_form #respond .form-submit input,
body div.wpforms-container-full .wpforms-form input[type=submit]:hover, 
body div.wpforms-container-full .wpforms-form button[type=submit]:hover, 
body div.wpforms-container-full .wpforms-form .wpforms-page-button:hover {
  color:#FFF;
  background-color: <?php echo esc_attr( $color_content_acc ); ?>;    
}
.woocommerce div.product .woocommerce-tabs ul.tabs li.active a{
  border-bottom: 3px solid <?php echo esc_attr( $color_content_acc ); ?>;
}
.product-categories li,
.product-categories .children li {
  color:<?php echo esc_attr( $color_content_meta ); ?>;
}
.product-categories .children li {
  border-top: 1px solid <?php echo vlog_hex2rgba( esc_attr( $color_content_txt ), 0.1); ?>; 
}
.product-categories li{
   border-bottom: 1px solid <?php echo vlog_hex2rgba( esc_attr( $color_content_txt ), 0.1); ?>; 
}
.woocommerce .woocommerce-breadcrumb a{
  color: <?php echo esc_attr( $color_content_acc ); ?>;
}
.woocommerce .woocommerce-breadcrumb a:hover{
  color: <?php echo esc_attr( $color_content_txt ); ?>;
}
<?php } ?>

div.bbp-submit-wrapper button, #bbpress-forums #bbp-your-profile fieldset.submit button{
  color:#FFF;
  background-color: <?php echo esc_attr( $color_content_acc ); ?>;    
}
.vlog-breadcrumbs a:hover{
  color: <?php echo esc_attr( $color_content_txt ); ?>;
}
.vlog-breadcrumbs{
   border-bottom: 1px solid <?php echo vlog_hex2rgba( esc_attr( $color_content_txt ), 0.1); ?>;
}
.vlog-special-tag-label{
  background-color: <?php echo vlog_hex2rgba( $color_content_acc, 0.5); ?>;  
}
.vlog-special-tag-label{
  background-color: <?php echo vlog_hex2rgba( $color_content_acc, 0.5); ?>;  
}
.entry-image:hover .vlog-special-tag-label{
  background-color: <?php echo vlog_hex2rgba( $color_content_acc, 0.8); ?>;    
}

/* In play warpper colors */
.vlog-format-inplay .entry-category a,
.vlog-format-inplay .action-item:hover,
.vlog-featured .vlog-format-inplay .meta-icon,
.vlog-featured .vlog-format-inplay .meta-item,
.vlog-format-inplay .meta-comments a,
.vlog-featured-2 .vlog-format-inplay .entry-category a,
.vlog-featured-2 .vlog-format-inplay .action-item:hover,
.vlog-featured-2 .vlog-format-inplay .meta-icon,
.vlog-featured-2 .vlog-format-inplay .meta-item,
.vlog-featured-2 .vlog-format-inplay .meta-comments a{
    color: <?php echo vlog_hex2rgba( $color_content_title, 0.7); ?>;
}

<?php

/* Apply uppercase options */
$uppercase = vlog_get_option( 'uppercase' );
if ( !empty( $uppercase ) ) {
  foreach ( $uppercase as $text_class => $val ) {
    if ( $val ){
      echo '.'.$text_class.'{text-transform: uppercase;}';
    } else {
      echo '.'.$text_class.'{text-transform: none;}';
    }
  }
}

/* Editor font sizes */
$font_sizes = vlog_get_editor_font_sizes();

if ( !empty( $font_sizes ) ) {

  foreach ( $font_sizes as $id => $item ) {  
    if( isset( $item['size-mobile'] ) ){
          echo '.has-'. $item['slug'] .'-font-size{ font-size: '.number_format( $item['size-mobile'] / 10,  1 ) .'rem;}';
    }
  }

  echo '@media(min-width: 768px){'; 
    foreach ( $font_sizes as $id => $item ) {  
          echo '.has-'. $item['slug'] .'-font-size{ font-size: '. number_format( absint($item['size']) / 10, 1 ).'rem;}';
    }
  echo '}';
}

/* Editor colors */
$colors = vlog_get_editor_colors();

if ( !empty( $colors ) ) {
    foreach ( $colors as $id => $item ) {  
          echo '.has-'. $item['slug'] .'-background-color{ background-color: ' . esc_attr( $item['color'] ) .';}';
          echo '.has-'. $item['slug'] .'-color{ color: ' . esc_attr( $item['color'] ) .';}';
    }
}
?>