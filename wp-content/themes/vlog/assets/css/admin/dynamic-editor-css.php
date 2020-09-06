<?php

/* Font styles */

$main_font = vlog_get_font_option( 'main_font' );
$h_font = vlog_get_font_option( 'h_font' );

/* Font sizes */

$font_size_nav =  absint(vlog_get_option( 'font_size_nav' ) );
$font_size_p =  absint(vlog_get_option( 'font_size_p' ) );
$font_size_excerpt_text =  absint(vlog_get_option( 'font_size_excerpt_text' ) );
$font_size_mfs = absint(vlog_get_option( 'font_size_mfs' ) );
$font_size_widget_title = absint(vlog_get_option( 'font_size_widget_title' ) );
$font_size_module_title = absint(vlog_get_option( 'font_size_module_title' ) );
$font_size_meta_data = absint(vlog_get_option( 'font_size_meta_data' ) );
$font_size_h1 = absint(vlog_get_option( 'font_size_h1' ) );
$font_size_h2 = absint(vlog_get_option( 'font_size_h2' ) );
$font_size_h3 = absint(vlog_get_option( 'font_size_h3' ) );
$font_size_h4 = absint(vlog_get_option( 'font_size_h4' ) );
$font_size_h5 = absint(vlog_get_option( 'font_size_h5' ) );
$font_size_h6 = absint(vlog_get_option( 'font_size_h6' ) );

/* General styles */

$content_layout = vlog_get_option( 'content_layout' );

$color_content_bg = esc_attr( vlog_get_option( 'color_content_bg' ) );
$color_content_title = esc_attr( vlog_get_option( 'color_content_title' ) );
$color_content_txt = esc_attr( vlog_get_option( 'color_content_txt' ) );
$color_content_acc = esc_attr( vlog_get_option( 'color_content_acc' ) );
$color_content_meta = esc_attr( vlog_get_option( 'color_content_meta' ) );



?>



.edit-post-visual-editor.editor-styles-wrapper{
  color: <?php echo esc_attr( $color_content_txt ); ?>;
  font-family: <?php echo wp_kses_post( $main_font['font-family'] ); ?>;
  font-weight: <?php echo esc_attr( $main_font['font-weight'] ); ?>;
  <?php if ( isset( $main_font['font-style'] ) && !empty( $main_font['font-style'] ) ):?>
  	font-style: <?php echo esc_attr( $main_font['font-style'] ); ?>;
  <?php endif; ?>
}


/* Typography styles */

.editor-styles-wrapper h1, 
.editor-styles-wrapper.edit-post-visual-editor .editor-post-title__block .editor-post-title__input,
.editor-styles-wrapper h2, 
.editor-styles-wrapper h3, 
.editor-styles-wrapper h4,
.editor-styles-wrapper h5,
.editor-styles-wrapper h6,
blockquote,
.wp-block-cover .wp-block-cover-image-text, .wp-block-cover .wp-block-cover-text, 
.wp-block-cover h2, .wp-block-cover-image .wp-block-cover-image-text, 
.wp-block-cover-image .wp-block-cover-text, .wp-block-cover-image h2 {
  font-family: <?php echo wp_kses_post( $h_font['font-family'] ); ?>;
  font-weight: <?php echo esc_attr( $h_font['font-weight'] ); ?>;
  <?php if ( isset( $h_font['font-style'] ) && !empty( $h_font['font-style'] ) ):?>
  font-style: <?php echo esc_attr( $h_font['font-style'] ); ?>;
  <?php endif; ?>
}

/* Font Sizes */
.edit-post-visual-editor.editor-styles-wrapper{
    font-size: <?php echo esc_attr( $font_size_p ); ?>px;
}

.editor-styles-wrapper h1,
.editor-styles-wrapper.edit-post-visual-editor .editor-post-title__block .editor-post-title__input{
    font-size: <?php echo esc_attr( $font_size_h1 ); ?>px;
}

.editor-styles-wrapper h2{
    font-size: <?php echo esc_attr( $font_size_h2 ); ?>px;
}

.editor-styles-wrapper h3{
    font-size: <?php echo esc_attr( $font_size_h3 ); ?>px;
}

.editor-styles-wrapper h4 {
    font-size: <?php echo esc_attr( $font_size_h4 ); ?>px;
}

.editor-styles-wrapper h5{
    font-size: <?php echo esc_attr( $font_size_h5 ); ?>px;
}

.editor-styles-wrapper h6{
    font-size: <?php echo esc_attr( $font_size_h6 ); ?>px;
}


/* General */

.editor-styles-wrapper a{
  color: <?php echo esc_attr( $color_content_acc ); ?>; 
}
.editor-styles-wrapper h1, 
.editor-styles-wrapper.edit-post-visual-editor .editor-post-title__block .editor-post-title__input,
.editor-styles-wrapper h2, 
.editor-styles-wrapper h3, 
.editor-styles-wrapper h4,
.editor-styles-wrapper h5,
.editor-styles-wrapper h6 {
   color: <?php echo esc_attr( $color_content_title ); ?>;
}

.editor-styles-wrapper p{
  color: <?php echo esc_attr( $color_content_txt ); ?>;
  font-size: <?php echo esc_attr( $font_size_p ); ?>px;
}

.wp-block-image figcaption,
.wp-block-audio figcaption{
  color: <?php echo esc_attr($color_content_txt); ?>;  
}

.wp-block-button__link,
.editor-styles-wrapper .wp-block-search__button{
  background: <?php echo esc_attr( $color_content_acc ); ?>; 
}
.editor-styles-wrapper .wp-block-search__button,
.editor-styles-wrapper .wp-block-search__button:hover{
  color: <?php echo esc_attr($color_content_bg); ?>; 
}


.edit-post-visual-editor .block-library-list ul > li:before{
  background-color: <?php echo esc_attr( $color_content_acc ); ?>;
}

/* Code and preformated*/

.wp-block-code,
.editor-styles-wrapper code,
.editor-styles-wrapper pre,
.editor-styles-wrapper pre h2{
	color: <?php echo esc_attr( $color_content_txt ); ?>;
}
.wp-block-code .editor-plain-text{
  background: transparent;
}
.wp-block-separator{
	border-color: <?php echo vlog_hex2rgba($color_content_txt, 0.3); ?>;
	border-bottom-width: 1px;	
}

/* Table */

.editor-styles-wrapper .wp-block table.wp-block-table{
	border-color: <?php echo vlog_hex2rgba($color_content_txt, 0.1); ?>;
}
.editor-styles-wrapper .wp-block-table:not(.is-style-stripes) td, 
.editor-styles-wrapper .wp-block-table:not(.is-style-stripes) th{
	border: 1px solid <?php echo vlog_hex2rgba($color_content_txt, 0.1); ?>;
}

/* Blockquote */

.wp-block-quote:not(.is-large):not(.is-style-large),
.wp-block-quote.is-style-large{
  border-left: 3px solid <?php echo esc_attr( $color_content_acc ); ?>;
}
/* Separator */
.wp-block-separator{
	border-color: <?php echo vlog_hex2rgba($color_content_txt, 0.2); ?>;
	border-bottom-width: 1px;	
}


/* Content width*/

.edit-post-visual-editor .wp-block{
	max-width: 798px;
}
.post-type-page .edit-post-visual-editor .wp-block{
	max-width: 798px;
}
.edit-post-visual-editor .wp-block[data-align="wide"],
.post-type-page .edit-post-visual-editor .wp-block[data-align="wide"]{
	max-width: 860px;
}
.edit-post-visual-editor .wp-block[data-align="full"],
.post-type-page .edit-post-visual-editor .wp-block[data-align="full"]{
	max-width: none;
}

.editor-styles-wrapper .wp-block .wp-block-search__input{
  border:1px solid <?php echo vlog_hex2rgba( esc_attr( $color_content_txt ) , 0.1); ?>;
}


<?php

/* Apply uppercase options */
$uppercase = vlog_get_option( 'uppercase' );
if ( !empty( $uppercase ) ) {
  foreach ( $uppercase as $text_class => $val ) {
    if ( $val ){
      echo '.editor-styles-wrapper .'.$text_class.'{text-transform: uppercase;}';
    } else {
      echo '.editor-styles-wrapper .'.$text_class.'{text-transform: none;}';
    }
  }
}

?>