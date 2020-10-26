<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mystery Themes
 * @subpackage Saaya
 * @since 1.0.0
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'saaya' ); ?></a>
<?php 
	/**
	 * saaya before page hook 
	 * 
	 * @since 1.0.0
	 */
	do_action( 'saaya_before_page' );
?>

<div id="page" class="site">

	<?php
		/**
		 * saaya before header
		 * 
		 * @since 1.0.0
		 */
		do_action( 'saaya_before_header' );

		/**
		 * saaya main header
		 * 
		 * @hooked - saaya_main_header_start - 5
		 * @hooked - saaya_site_branding - 10
		 * @hooked - saaya_menu_wrapper_start - 15
		 * @hooked - saaya_header_main_menu - 20
		 * @hooked - saaya_menu_icon_wrapper_start - 25
		 * @hooked - saaya_menu_social_icons - 30
		 * @hooked - saaya_menu_search_icon - 35
		 * @hooked - saaya_menu_icon_wrapper_end - 40
		 * @hooked - saaya_menu_wrapper_end - 45
		 * @hooked - saaya_main_header_end - 50
		 * 
		 * @since 1.0.0
		 */
		do_action( 'saaya_main_header' );

		if( is_front_page() ){
			/**
			 * saaya_main_banner_content
			 * 
			 * @hooked - saaya_main_banner_content_sec - 10
			 *
			 * @since 1.0.0
			 */
			do_action( 'saaya_main_banner_content' );	
		}

		if( ! is_front_page() ) {
            /**
    		 * saaya_innerpage_header hook
    		 *
    		 * @hooked - saaya_innerpage_header_start - 5
    		 * @hooked - saaya_innerpage_header_title - 10
    		 * @hooked - saaya_breadcrumb_content - 15
    		 * @hooked - saaya_innerpage_header_end - 20
    		 *
    		 * @since 1.0.0
    		 */
    		do_action( 'saaya_innerpage_header' );
        }
	?>

	<div id="content" class="site-content">
		<div class="mt-container">
		