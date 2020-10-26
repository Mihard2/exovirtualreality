<?php
/**
 * Dynamic styles
 *
 * @package Mystery Themes
 * @subpackage Saaya
 * @since 1.0.0
 *
 */

add_action( 'wp_enqueue_scripts', 'saaya_dynamic_styles' );

if( ! function_exists( 'saaya_dynamic_styles' ) ) :
    
    function saaya_dynamic_styles() {

    	$saaya_primary_color = get_theme_mod( 'saaya_primary_color', '#f47e00' );

    	$output_css = '';

        $output_css .= ".edit-link .post-edit-link,.reply .comment-reply-link,.widget_search .search-submit,.mt-menu-search .mt-form-wrap .search-form .search-submit:hover,article.sticky::before,.post-format-media--quote,.saaya_social_media a:hover,.sk-spinner-pulse{ background: ". esc_attr( $saaya_primary_color ) ."}\n";

        $output_css .= "a,a:hover,a:focus,a:active,.entry-cat .cat-links a:hover,.entry-cat a:hover,.entry-footer a:hover,.comment-author .fn .url:hover,.commentmetadata .comment-edit-link,#cancel-comment-reply-link,#cancel-comment-reply-link:before,.logged-in-as a,.widget a:hover,.widget a:hover::before,.widget li:hover::before,.mt-social-icon-wrap li a:hover,#site-navigation ul li:hover > a,#site-navigation ul li.current-menu-item > a,#site-navigation ul li.current_page_ancestor > a,#site-navigation ul li.current_page_item > a,.banner-sub-title,.entry-title a:hover,.cat-links a:hover,.entry-footer .mt-readmore-btn:hover,.btn-wrapper a:hover,.mt-readmore-btn:hover,.navigation.pagination .nav-links .page-numbers.current, .navigation.pagination .nav-links a.page-numbers:hover,#footer-menu li a:hover,.saaya_latest_posts .mt-post-title a:hover,#mt-scrollup:hover,.menu-toggle:hover{ color: ". esc_attr( $saaya_primary_color ) ."}\n";
        
        $output_css .= ".widget_search .search-submit,.widget_search .search-submit:hover,.navigation.pagination .nav-links .page-numbers.current, .navigation.pagination .nav-links a.page-numbers:hover,.error-404.not-found,.saaya_social_media a:hover{ border-color: ". esc_attr( $saaya_primary_color ) ."}\n";

        $refine_output_css = saaya_css_strip_whitespace( $output_css );

        wp_add_inline_style( 'saaya-style', $refine_output_css );

    }

endif;