<?php
/**
 * Saaya manage the Customizer panels
 *
 * @package Mystery Themes
 * @subpackage Saaya
 * @since 1.0.0
 */

/**
 * General Settings Panel
 */
Kirki::add_panel( 'saaya_general_panel', array(
	'priority' => 10,
	'title'    => esc_html__( 'General Settings', 'saaya' ),
) );


/**
 * Header Settings Panel
 */
Kirki::add_panel( 'saaya_header_panel', array(
	'priority' => 15,
	'title'    => esc_html__( 'Header Settings', 'saaya' ),
) );

/**
 * Banner Settings Section
 */
Kirki::add_section( 'saaya_banner_section', array(
	'priority' => 20,
	'title'    => esc_html__( 'Banner Settings', 'saaya' ),
) );

/**
 * Design Settings Panel
 */
Kirki::add_panel( 'saaya_design_panel', array(
	'priority' => 35,
	'title'    => esc_html__( 'Design Settings', 'saaya' ),
) );


/**
 * Additional Features Panel
 */
Kirki::add_panel( 'saaya_additional_panel', array(
	'priority' => 40,
	'title'    => esc_html__( 'Additional Features', 'saaya' ),
) );

/**
 * Footer Settings Panel
 */
Kirki::add_panel( 'saaya_footer_panel', array(
	'priority' => 45,
	'title'    => esc_html__( 'Footer Settings', 'saaya' ),
) );