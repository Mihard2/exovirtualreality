<?php
/**
 * Saaya manage the Customizer sections
 *
 * @package Mystery Themes
 * @subpackage Saaya
 * @since 1.0.0
 */

/**
 * Site Settings
 */
Kirki::add_section( 'saaya_section_site', array(
	'title'    => esc_html__( 'Site Settings', 'saaya' ),
	'panel'    => 'saaya_general_panel',
	'priority' => 40,
) );


/**
 * Header Extra Options
 */
Kirki::add_section( 'saaya_section_header_extra', array(
	'title'    => esc_html__( 'Extra Options', 'saaya' ),
	'panel'    => 'saaya_header_panel',
	'priority' => 15,
) );


/**
 * Slider Settings
 */
Kirki::add_section( 'saaya_section_slider', array(
	'title'    => esc_html__( 'Slider Settings', 'saaya' ),
	'priority' => 20,
) );


/**
 * Archive Settings
 */
Kirki::add_section( 'saaya_section_archive_settings', array(
	'title'    => esc_html__( 'Archive Settings', 'saaya' ),
	'panel'    => 'saaya_design_panel',
	'priority' => 5,
) );


/**
 * Post Settings
 */
Kirki::add_section( 'saaya_section_post_settings', array(
	'title'    => esc_html__( 'Post Settings', 'saaya' ),
	'panel'    => 'saaya_design_panel',
	'priority' => 10,
) );


/**
 * Page Settings
 */
Kirki::add_section( 'saaya_section_page_settings', array(
	'title'    => esc_html__( 'Page Settings', 'saaya' ),
	'panel'    => 'saaya_design_panel',
	'priority' => 15,
) );


/**
 * Social Icons
 */
Kirki::add_section( 'saaya_section_social_icons', array(
	'title'    => esc_html__( 'Social Icons', 'saaya' ),
	'panel'    => 'saaya_additional_panel',
	'priority' => 5,
) );


/**
 * Breadcrumbs
 */
Kirki::add_section( 'saaya_section_breadcrumbs', array(
	'title'    => esc_html__( 'Breadcrumbs', 'saaya' ),
	'panel'    => 'saaya_additional_panel',
	'priority' => 10,
) );


/**
 * Footer Widget Area
 */
Kirki::add_section( 'saaya_section_footer_widget_area', array(
	'title'    => esc_html__( 'Footer Widget Area', 'saaya' ),
	'panel'    => 'saaya_footer_panel',
	'priority' => 5,
) );


/**
 * Bottom footer
 */
Kirki::add_section( 'saaya_section_bottom_footer', array(
	'title'    => esc_html__( 'Bottom Footer', 'saaya' ),
	'panel'    => 'saaya_footer_panel',
	'priority' => 10,
) );