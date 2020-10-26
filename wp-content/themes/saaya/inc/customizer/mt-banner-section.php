<?php
/**
 *  Banner section options
 */

// Toggle field for Enable/Disable banner section.
Kirki::add_field(
	'saaya_config', array(
		'type'     => 'toggle',
		'settings' => 'saaya_enable_banner_section',
		'label'    => esc_html__( 'Enable banner section', 'saaya' ),
		'section'  => 'saaya_banner_section',
		'default'  => '1',
		'priority' => 5,
	)
);

/**
 * Image field for banner image.
 */
Kirki::add_field( 'saaya_config', array(
	'type'        => 'image',
	'settings'    => 'banner_section_image',
	'label'       => esc_html__( 'Banner Image', 'saaya' ),
	'description' => esc_html__( 'Add image for banner section.', 'saaya' ),
	'section'     => 'saaya_banner_section',
    'default'     => '',
    'priority'    => 5,
    'active_callback' => array(
        array(
            'setting'  => 'saaya_enable_banner_section',
            'operator' => '==',
            'value'    => true,
        )),
) );

// Text field for banner title
Kirki::add_field( 'saaya_config', array(
	'type'     => 'text',
	'settings' => 'banner_main_title',
	'label'    => esc_html__( 'Main Title', 'saaya' ),
	'section'  => 'saaya_banner_section',
    'priority' => 10,
    'active_callback' => array(
        array(
            'setting'  => 'saaya_enable_banner_section',
            'operator' => '==',
            'value'    => true,
        )),
) );

// Text field for banner sub title
Kirki::add_field( 'saaya_config', array(
	'type'     => 'text',
	'settings' => 'banner_sub_title',
	'label'    => esc_html__( 'Sub Title', 'saaya' ),
	'section'  => 'saaya_banner_section',
    'priority' => 15,
    'active_callback' => array(
        array(
            'setting'  => 'saaya_enable_banner_section',
            'operator' => '==',
            'value'    => true,
        )),
) );

// Text field for banner button Label
Kirki::add_field( 'saaya_config', array(
	'type'     => 'text',
	'settings' => 'banner_btn_label',
	'label'    => esc_html__( 'Button Label', 'saaya' ),
	'section'  => 'saaya_banner_section',
    'priority' => 20,
    'active_callback' => array(
        array(
            'setting'  => 'saaya_enable_banner_section',
            'operator' => '==',
            'value'    => true,
        )),
) );

// Text field for banner button url
Kirki::add_field( 'saaya_config', array(
	'type'     => 'text',
	'settings' => 'banner_btn_url',
	'label'    => esc_html__( 'Button Link', 'saaya' ),
	'section'  => 'saaya_banner_section',
    'priority' => 25,
    'active_callback' => array(
        array(
            'setting'  => 'saaya_enable_banner_section',
            'operator' => '==',
            'value'    => true,
        )),
) );