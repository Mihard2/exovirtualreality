<?php
/**
 * Saaya manage the Customizer options of footer settings panel.
 *
 * @package Mystery Themes
 * @subpackage Saaya
 * @since 1.0.0
 */


// Toggle field for Enable/Disable footer widget area.
Kirki::add_field(
	'saaya_config', array(
		'type'     => 'toggle',
		'settings' => 'saaya_enable_footer_widget_area',
		'label'    => esc_html__( 'Enable Footer Widget Area', 'saaya' ),
		'section'  => 'saaya_section_footer_widget_area',
		'default'  => '1',
		'priority' => 5,
	)
);

// Radio Image field for Widget Area layout
Kirki::add_field(
	'saaya_config', array(
		'type'     => 'radio-image',
		'settings' => 'saaya_widget_area_layout',
		'label'    => esc_html__( 'Widget Area Layout', 'saaya' ),
		'section'  => 'saaya_section_footer_widget_area',
		'default'  => 'column-three',
		'priority' => 10,
		'choices'  => array(
			'column-four'  	 => get_template_directory_uri() . '/assets/images/footer-4.png',
			'column-three' 	 => get_template_directory_uri() . '/assets/images/footer-3.png',
			'column-two'     => get_template_directory_uri() . '/assets/images/footer-2.png',
			'column-one'  	 => get_template_directory_uri() . '/assets/images/footer-1.png'
		),
	)
);

// Toggle field for Enable/Disable footer menu.
Kirki::add_field(
	'saaya_config', array(
		'type'     => 'toggle',
		'settings' => 'saaya_enable_footer_menu',
		'label'    => esc_html__( 'Enable Footer Menu', 'saaya' ),
		'section'  => 'saaya_section_bottom_footer',
		'default'  => '1',
		'priority' => 5,
	)
);


// Text filed for copyright
Kirki::add_field(
	'saaya_config', array(
		'type'     => 'text',
		'settings' => 'saaya_footer_copyright',
		'label'    => esc_html__( 'Copyright Text', 'saaya' ),
		'section'  => 'saaya_section_bottom_footer',
		'default'  => esc_html__( 'Saaya', 'saaya' ),
		'priority' => 10,
	)
);