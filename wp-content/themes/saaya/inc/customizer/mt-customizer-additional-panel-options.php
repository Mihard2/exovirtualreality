<?php
/**
 * Saaya manage the Customizer options of additional panel.
 *
 * @package Mystery Themes
 * @subpackage Saaya
 * @since 1.0.0
 */


// Repeater field for social icons
Kirki::add_field( 
	'saaya_config', array(
		'type'        	=> 'repeater',
		'label'       	=> esc_html__( 'Add Social Icons', 'saaya' ),
		'description' 	=> esc_html__( 'Drag & Drop items to re-arrange the order', 'saaya' ),
		'section'     	=> 'saaya_section_social_icons',
		'priority'		=> 5,
		'choices'		=> array(
			'limit'		=> 5
		),
		'row_label'   	=> array(
			'type'  => 'field',
			'value' => esc_html__( 'Social Icon', 'saaya' ),
			'field' => 'social_icon',
		),
		'settings'    => 'saaya_social_icons_lists',
		'default'     => array(
			array(
				'social_icon' => 'facebook',
				'social_url'  => '#',
			),
			array(
				'social_icon' => 'twitter',
				'social_url'  => '#',
			),
		),
		'fields'      => array(
			'social_icon' => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Social Icon', 'saaya' ),
				'default' => 'facebook',
				'choices' => saaya_get_fontawesome_social_icons_array(),
			),
			'social_url'  => array(
				'type'    => 'link',
				'label'   => esc_html__( 'Social Link URL', 'saaya' ),
				'default' => '',
			),
		),
	)
);


// Toggle field for Enable/Disable breadcrumbs.
Kirki::add_field(
	'saaya_config', array(
		'type'     => 'toggle',
		'settings' => 'saaya_enable_breadcrumb_option',
		'label'    => esc_html__( 'Enable Breadcrumbs', 'saaya' ),
		'section'  => 'saaya_section_breadcrumbs',
		'default'  => '1',
		'priority' => 5,
	)
);