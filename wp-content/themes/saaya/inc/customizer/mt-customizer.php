<?php
/**
 * Saaya Theme Customizer
 *
 * @package Mystery Themes
 * @subpackage Saaya
 * @since 1.0.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function saaya_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->get_section( 'title_tagline' )->panel        = 'saaya_general_panel';
    $wp_customize->get_section( 'title_tagline' )->priority     = '5';
    $wp_customize->get_section( 'colors' )->panel               = 'saaya_general_panel';
    $wp_customize->get_section( 'colors' )->priority            = '10';
    $wp_customize->get_section( 'background_image' )->panel     = 'saaya_general_panel';
    $wp_customize->get_section( 'background_image' )->priority  = '15';
    $wp_customize->get_section( 'static_front_page' )->panel    = 'saaya_general_panel';
    $wp_customize->get_section( 'static_front_page' )->priority = '20';

    $wp_customize->get_section( 'header_image' )->panel        = 'saaya_header_panel';
    $wp_customize->get_section( 'header_image' )->priority     = '5';
    $wp_customize->get_section( 'header_image' )->description  = __( 'Header Image for only Innerpages', 'saaya' );

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'saaya_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'saaya_customize_partial_blogdescription',
		) );
	}

	// Require upsell customizer section class.
	require get_template_directory() . '/inc/customizer/mt-customizer-upsell-class.php';

	/**
     * Register custom section types.
     *
     * @since 1.0.3
     */
	$wp_customize->register_section_type( 'Saaya_Customize_Section_Upsell' );

	/**
     * Register theme upsell sections.
     *
     * @since 1.0.3
     */
    $wp_customize->add_section( new Saaya_Customize_Section_Upsell(
        $wp_customize,
            'theme_upsell',
            array(
                'title'    => esc_html__( 'Buy Saaya Pro', 'saaya' ),
                'pro_url'  => 'https://mysterythemes.com/wp-themes/saaya-pro/',
                'priority'  => 1,
            )
        )
    );

}
add_action( 'customize_register', 'saaya_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function saaya_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function saaya_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function saaya_customize_preview_js() {
	wp_enqueue_script( 'saaya-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'saaya_customize_preview_js' );

/*----------------------------------------------------------------------------------------------------------------------------------------*/
/**
 * Enqueue required scripts/styles for customizer panel
 *
 * @since 1.0.0
 */
function saaya_customize_backend_scripts() {

	global $saaya_theme_version;

	wp_enqueue_style( 'saaya--admin-customizer-style', get_template_directory_uri() . '/assets/css/mt-customizer-styles.css', array(), esc_attr( esc_attr( $saaya_theme_version ) ) );

	wp_enqueue_script( 'saaya--admin-customizer-script', get_template_directory_uri() . '/assets/js/mt-customizer-controls.js', array( 'jquery', 'customize-controls' ), esc_attr( $saaya_theme_version ), true );

}
add_action( 'customize_controls_enqueue_scripts', 'saaya_customize_backend_scripts', 10 );

/**
 * Add Kirki customizer library file
 */
require get_template_directory() . '/inc/kirki/kirki.php';

/**
 * Configuration for Kirki Framework
 */
function saaya_kirki_configuration() {
	return array(
		'url_path' => get_template_directory_uri() . '/inc/kirki/',
	);
}

add_filter( 'kirki/config', 'saaya_kirki_configuration' );


/**
 * Saaya Kirki Config
 */
Kirki::add_config( 'saaya_config', array(
	'capability'  => 'edit_theme_options',
	'option_type' => 'theme_mod',
) );

/**
 * Add Kirki required file for custom fields
 */
require get_template_directory() . '/inc/customizer/mt-customizer-panels.php';
require get_template_directory() . '/inc/customizer/mt-customizer-sections.php';

require get_template_directory() . '/inc/customizer/mt-banner-section.php';
require get_template_directory() . '/inc/customizer/mt-customizer-general-panel-options.php';
require get_template_directory() . '/inc/customizer/mt-customizer-header-panel-options.php';
require get_template_directory() . '/inc/customizer/mt-customizer-additional-panel-options.php';
require get_template_directory() . '/inc/customizer/mt-customizer-design-panel-options.php';
require get_template_directory() . '/inc/customizer/mt-customizer-footer-panel-options.php';
