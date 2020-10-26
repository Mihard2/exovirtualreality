<?php
/**
 * Saaya manage the Customizer options of general panel.
 *
 * @package Mystery Themes
 * @subpackage Saaya
 * @since 1.0.0
 */

// Toggle field for Enable/Disable preloader.
Kirki::add_field(
	'saaya_config', array(
		'type'     => 'toggle',
		'settings' => 'saaya_enable_preloader',
		'label'    => esc_html__( 'Enable Preloader', 'saaya' ),
		'section'  => 'saaya_section_site',
		'default'  => '1',
		'priority' => 5,
	)
);

 // Toggle field for Enable/Disable wow animation.
Kirki::add_field(
	'saaya_config', array(
		'type'     => 'toggle',
		'settings' => 'saaya_enable_wow_animation',
		'label'    => esc_html__( 'Enable Wow Animation', 'saaya' ),
		'section'  => 'saaya_section_site',
		'default'  => '1',
		'priority' => 5,
	)
);


// Radio Image field for Site layout
Kirki::add_field(
	'saaya_config', array(
		'type'     => 'radio-image',
		'settings' => 'saaya_site_layout',
		'label'    => esc_html__( 'Site Layout', 'saaya' ),
		'section'  => 'saaya_section_site',
		'default'  => 'site-layout--wide',
		'priority' => 5,
		'choices'  => array(
			'site-layout--wide'   => get_template_directory_uri() . '/assets/images/full-width.png',
			'site-layout--boxed'  => get_template_directory_uri() . '/assets/images/boxed-layout.png'
		),
	)
);

// Color Picker field for Primary Color
Kirki::add_field( 
	'saaya_config', array(
		'type'        => 'color',
		'settings'    => 'saaya_primary_color',
		'label'       => __( 'Primary Color', 'saaya' ),
		'section'     => 'colors',
		'default'     => '#f47e00',
	)
);