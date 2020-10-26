<?php
/**
 * Saaya manage the Customizer options of header panel.
 *
 * @package Mystery Themes
 * @subpackage Saaya
 * @since 1.0.0
 */

// Toggle field for Enable/Disable sticky menu.
Kirki::add_field(
	'saaya_config', array(
		'type'     => 'toggle',
		'settings' => 'saaya_enable_sticky_menu',
		'label'    => esc_html__( 'Enable Sticky Menu', 'saaya' ),
		'section'  => 'saaya_section_header_extra',
		'default'  => '1',
		'priority' => 5,
	)
);

// Toggle field for Enable/Disable social icons.
Kirki::add_field(
	'saaya_config', array(
		'type'     => 'toggle',
		'settings' => 'saaya_enable_header_social_icons',
		'label'    => esc_html__( 'Enable Social Icons', 'saaya' ),
		'section'  => 'saaya_section_header_extra',
		'default'  => '1',
		'priority' => 10,
	)
);

// Toggle field for Enable/Disable search icon.
Kirki::add_field(
	'saaya_config', array(
		'type'     => 'toggle',
		'settings' => 'saaya_enable_search_icon',
		'label'    => esc_html__( 'Enable Search Icon', 'saaya' ),
		'section'  => 'saaya_section_header_extra',
		'default'  => '1',
		'priority' => 15,
	)
);