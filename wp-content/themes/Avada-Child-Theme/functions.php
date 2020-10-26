<?php
use LicenseKeys\Models\LicenseKey;
use WPMVC\Log as WPMVCLog;


function theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'avada-stylesheet' ));
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function avada_lang_setup() {
    global $avada_woocommerce;
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );

	//customize avada woocommerce

    if ( class_exists( 'WooCommerce' ) ) {
        require_once Avada::$stylesheet_dir_path . '/includes/class-avada-child-woocommerce.php';

        remove_filter( 'woocommerce_show_page_title', [ $avada_woocommerce, 'shop_title' ], 10 );

        remove_action( 'woocommerce_before_main_content', [ $avada_woocommerce, 'before_container' ], 10 );
        remove_action( 'woocommerce_after_main_content', [ $avada_woocommerce, 'after_container' ], 10 );

        remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
        remove_action( 'woocommerce_sidebar', [ $avada_woocommerce, 'add_sidebar' ], 10 );

        remove_filter( 'fusion_responsive_sidebar_order', [ $avada_woocommerce, 'responsive_sidebar_order' ], 10 );

        // Products Loop.
        remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
        remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

        remove_action( 'woocommerce_before_shop_loop_item_title', [ $avada_woocommerce, 'add_product_wrappers_open' ], 30 );
        remove_action( 'woocommerce_shop_loop_item_title', [ $avada_woocommerce, 'product_title' ], 10 );
        remove_action( 'woocommerce_after_shop_loop_item_title', [ $avada_woocommerce, 'add_product_wrappers_close' ], 20 );

        remove_action( 'avada_woocommerce_buttons_on_rollover', [ $avada_woocommerce, 'template_loop_add_to_cart' ], 10 );
        remove_action( 'avada_woocommerce_buttons_on_rollover', [ $avada_woocommerce, 'rollover_buttons_linebreak' ], 15 );
        remove_action( 'avada_woocommerce_buttons_on_rollover', [ $avada_woocommerce, 'show_details_button' ], 20 );

        if ( 'clean' === Avada()->settings->get( 'woocommerce_product_box_design' ) ) {

            add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
            add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
            remove_action( 'woocommerce_after_shop_loop_item', [ $avada_woocommerce, 'before_shop_item_buttons' ], 9 );

        } else {

            add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
            remove_action( 'woocommerce_before_shop_loop_item_title', [ $avada_woocommerce, 'show_product_loop_outofstock_flash' ], 10 );
            remove_action( 'woocommerce_before_shop_loop_item_title', [ $avada_woocommerce, 'before_shop_loop_item_title_open' ], 5 );
            remove_action( 'woocommerce_before_shop_loop_item_title', [ $avada_woocommerce, 'before_shop_loop_item_title_close' ], 20 );
            remove_action( 'woocommerce_after_shop_loop_item', [ $avada_woocommerce, 'before_shop_item_buttons' ], 5 );
            remove_action( 'woocommerce_after_shop_loop_item', [ $avada_woocommerce, 'template_loop_add_to_cart' ], 10 );
            remove_action( 'woocommerce_after_shop_loop_item', [ $avada_woocommerce, 'show_details_button' ], 15 );

        }

        remove_action( 'woocommerce_after_shop_loop_item', [ $avada_woocommerce, 'after_shop_item_buttons' ], 20 );

        // Single Product Page.
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
        remove_action( 'woocommerce_single_product_summary', [ $avada_woocommerce, 'add_product_border' ], 19 );
        remove_action( 'woocommerce_single_product_summary', [ $avada_woocommerce, 'template_single_title' ], 5 );
        remove_action( 'woocommerce_single_product_summary', [ $avada_woocommerce, 'stock_html' ], 10 );
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 11 );

        // Add product-title class to the cart item name link.
        remove_filter( 'woocommerce_cart_item_name', [ $avada_woocommerce, 'cart_item_name' ], 10 );

        add_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
        remove_action( 'woocommerce_proceed_to_checkout', [ $avada_woocommerce, 'proceed_to_checkout' ], 10 );

        remove_action( 'woocommerce_before_account_navigation', [ $avada_woocommerce, 'avada_top_user_container' ], 10 );

        // Add welcome user bar to checkout page.
        remove_action( 'woocommerce_before_checkout_form', [ $avada_woocommerce, 'avada_top_user_container' ], 1 );

        // Filter the pagination.
        remove_filter( 'woocommerce_pagination_args', [ $avada_woocommerce, 'change_pagination' ] );
        remove_filter( 'woocommerce_comment_pagination_args', [ $avada_woocommerce, 'change_pagination' ] );

        remove_action( 'woocommerce_before_single_product_summary', [ $avada_woocommerce, 'before_single_product_summary_open' ], 5 );
        remove_action( 'woocommerce_before_single_product_summary', [ $avada_woocommerce, 'before_single_product_summary_close' ], 30 );

        remove_filter( 'woocommerce_single_product_carousel_options', [ $avada_woocommerce, 'single_product_carousel_options' ], 10 );
        remove_filter( 'woocommerce_product_thumbnails_columns', [ $avada_woocommerce, 'product_thumbnails_columns' ], 10 );

        if ( fusion_get_option( 'disable_woo_gallery' ) ) {
            remove_filter( 'woocommerce_single_product_image_gallery_classes', [ $avada_woocommerce, 'single_product_image_gallery_classes' ], 10 );
            remove_filter( 'woocommerce_single_product_image_thumbnail_html', [ $avada_woocommerce, 'single_product_image_thumbnail_html' ], 10, 2 );
        }

        // Checkout page.
        remove_filter( 'woocommerce_order_button_html', [ $avada_woocommerce, 'order_button_html' ] );

        remove_action( 'woocommerce_checkout_terms_and_conditions', [ $avada_woocommerce, 'change_allowed_post_tags_before_terms' ], 15 );
        remove_action( 'woocommerce_checkout_terms_and_conditions', [ $avada_woocommerce, 'change_allowed_post_tags_after_terms' ], 35 );

        // Account Page.
        remove_action( 'woocommerce_account_dashboard', [ $avada_woocommerce, 'account_dashboard' ], 5 );
        remove_action( 'woocommerce_before_account_orders', [ $avada_woocommerce, 'before_account_content_heading' ] );
        remove_action( 'woocommerce_before_account_downloads', [ $avada_woocommerce, 'before_account_content_heading' ] );
        remove_action( 'woocommerce_before_account_payment_methods', [ $avada_woocommerce, 'before_account_content_heading' ] );
        remove_action( 'woocommerce_edit_account_form_start', [ $avada_woocommerce, 'before_account_content_heading' ] );

        add_action( 'woocommerce_view_order', 'woocommerce_order_details_table', 10 );
        remove_action( 'woocommerce_view_order', [ $avada_woocommerce, 'view_order' ], 10 );
        remove_action( 'woocommerce_thankyou', [ $avada_woocommerce, 'view_order' ] );

        remove_filter( 'woocommerce_account_menu_item_classes', [ $avada_woocommerce, 'account_menu_item_classes' ], 10, 2 );

        remove_action( 'wp_loaded', [ $avada_woocommerce, 'wpml_fix' ], 30 );

        remove_action( 'woocommerce_checkout_after_order_review', [ $avada_woocommerce, 'checkout_after_order_review' ], 20 );
        remove_filter( 'post_class', [ $avada_woocommerce, 'change_product_class' ] );
        add_action( 'woocommerce_thankyou', 'woocommerce_order_details_table', 10 );
        remove_action( 'woocommerce_after_customer_login_form', [ $avada_woocommerce, 'after_customer_login_form' ] );
        remove_action( 'woocommerce_before_customer_login_form', [ $avada_woocommerce, 'before_customer_login_form' ] );
        remove_filter( 'get_product_search_form', [ $avada_woocommerce, 'product_search_form' ] );
        add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
        remove_action( 'pre_get_posts', [ $avada_woocommerce, 'product_ordering' ], 5 );
        remove_filter( 'loop_shop_per_page', [ $avada_woocommerce, 'loop_shop_per_page' ] );

        remove_action( 'woocommerce_before_shop_loop_item_title', [ $avada_woocommerce, 'thumbnail' ], 10 );
        add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

        remove_filter( 'wp_nav_menu_items', [ $avada_woocommerce, 'add_woo_cart_to_widget' ], 20, 2 );
        remove_filter( 'woocommerce_add_to_cart_fragments', [ $avada_woocommerce, 'header_add_to_cart_fragment' ] );

        remove_action( 'woocommerce_single_product_summary', [ $avada_woocommerce, 'single_product_summary_open' ], 1 );
        remove_action( 'woocommerce_single_product_summary', [ $avada_woocommerce, 'single_product_summary_close' ], 100 );

        remove_action( 'woocommerce_after_single_product_summary', [ $avada_woocommerce, 'after_single_product_summary' ], 15 );
        add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
        remove_action( 'woocommerce_after_single_product_summary', [ $avada_woocommerce, 'output_related_products' ], 15 );
        add_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
        remove_action( 'woocommerce_after_single_product_summary', [ $avada_woocommerce, 'upsell_display' ], 10 );

        remove_action( 'woocommerce_before_cart_table', [ $avada_woocommerce, 'before_cart_table' ], 20 );
        remove_action( 'woocommerce_after_cart_table', [ $avada_woocommerce, 'after_cart_table' ], 20 );

        remove_action( 'woocommerce_cart_collaterals', [ $avada_woocommerce, 'cart_collaterals' ], 5 );
        add_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
        remove_action( 'woocommerce_cart_collaterals', [ $avada_woocommerce, 'cross_sell_display' ], 5 );

        add_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
        remove_action( 'woocommerce_before_checkout_form', [ $avada_woocommerce, 'checkout_coupon_form' ], 10 );

        if ( ! Avada()->settings->get( 'woocommerce_one_page_checkout' ) ) {
            remove_action( 'woocommerce_before_checkout_form', [ $avada_woocommerce, 'before_checkout_form' ] );
            remove_action( 'woocommerce_after_checkout_form', [ $avada_woocommerce, 'after_checkout_form' ] );
        } else {
            remove_action( 'woocommerce_checkout_before_customer_details', [ $avada_woocommerce, 'checkout_before_customer_details' ] );
            remove_action( 'woocommerce_checkout_after_customer_details', [ $avada_woocommerce, 'checkout_after_customer_details' ] );
        }
        remove_action( 'woocommerce_checkout_billing', [ $avada_woocommerce, 'checkout_billing' ], 20 );
        remove_action( 'woocommerce_checkout_shipping', [ $avada_woocommerce, 'checkout_shipping' ], 20 );
        remove_filter( 'woocommerce_enable_order_notes_field', [ $avada_woocommerce, 'enable_order_notes_field' ] );

        // Make sure that the single product shortcode does not use default column amount.
        remove_filter( 'shortcode_atts_product', [ $avada_woocommerce, 'change_product_shortcode_atts' ], 20, 4 );

        if ( Avada()->settings->get( 'woocommerce_enable_quick_view' ) ) {
            remove_action( 'avada_after_main_content', [ $avada_woocommerce, 'quick_view_load_container' ] );
            remove_action( 'wp_ajax_fusion_quick_view_load', [ $avada_woocommerce, 'quick_view_load_product' ] );
            remove_action( 'wp_ajax_nopriv_fusion_quick_view_load', [ $avada_woocommerce, 'quick_view_load_product' ] );
            remove_action( 'wp_enqueue_scripts', [ $avada_woocommerce, 'quick_view_enqueue_scripts' ] );
            remove_action( 'fusion_quick_view_summary_content', [ $avada_woocommerce, 'template_single_title' ], 5 );
            remove_action( 'fusion_quick_view_summary_content', [ $avada_woocommerce, 'stock_html' ], 10 );
            remove_action( 'fusion_quick_view_summary_content', 'woocommerce_template_single_price', 10 );
            remove_action( 'fusion_quick_view_summary_content', 'woocommerce_template_single_rating', 11 );
            remove_action( 'fusion_quick_view_summary_content', [ $avada_woocommerce, 'add_product_border' ], 19 );
            remove_action( 'fusion_quick_view_summary_content', 'woocommerce_template_single_excerpt', 20 );
            remove_action( 'fusion_quick_view_summary_content', 'woocommerce_template_single_add_to_cart', 30 );
            /**
             * WIP
            add_action( 'fusion_quick_view_summary_content', 'woocommerce_template_single_meta', 40 );
            add_action( 'fusion_quick_view_summary_content', [ $avada_woocommerce, 'after_single_product_summary' ], 50 );
             */
        }

        // Remove WC customizer options.
        remove_filter( 'loop_shop_columns', [ $avada_woocommerce, 'remove_woo_customizer_columns' ] );

        // Add notice to WC customizer panel.
        remove_action( 'customize_register', [ $avada_woocommerce, 'add_woocommerce_customizer_notice' ] );

        remove_action( 'fusion_woocommerce_after_shop_loop_item', [ $avada_woocommerce, 'woocommerce_after_shop_loop_item' ] );

        remove_filter( 'woocommerce_default_catalog_orderby', [ $avada_woocommerce, 'woocommerce_default_catalog_orderby' ], 99999 );

        $avada_woocommerce = new Avada_Child_Woocommerce();
    }
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

add_filter('woocommerce_account_menu_items','avada_child_account_menu_items',100,2);

function avada_child_account_menu_items($items, $endpoints)
{
    unset($items['orders']);
    //unset($items['license-keys']);
    if (isset($items['license-keys'])) $items['license-keys']='Subscription';
    unset($items['edit-address']);
    unset($items['payment-methods']);
    unset($items['downloads']);

    $new_items=[];

    foreach ($items as $key=>$value){
        $new_items[$key]=$value;
        if ($key=='edit-account'){
            $new_items['support']='Get support';
        }
    }
    return $new_items;
}

function avada_child_scripts()
{
    wp_enqueue_style('exovirt-css',get_stylesheet_directory_uri().'/assets/css/style.css',[],'1.0.2');

    if (function_exists('is_account_page') && is_account_page()){
        wp_enqueue_script('exovirtual-account',get_stylesheet_directory_uri().'/assets/js/exovirtual-account.js',
            ['jquery'],'1.0.2',true);

        wp_localize_script('exovirtual-account','exovirtual_account',
            [
                'account_id'=>get_current_user_id(),
                'subscription'=>wc_get_account_endpoint_url('license-keys')
            ]
        );
    }
    //avada-child-main
    wp_enqueue_script('exovirt-js',get_stylesheet_directory_uri().'/assets/js/exovirtual-main.js',
        ['jquery'],'1.0.1',true);

}

add_action('wp_enqueue_scripts','avada_child_scripts');

function avada_child_woo_support_accaunt_tab()
{
    $additional_user_area_block='
        [fusion_builder_container hundred_percent="no" hundred_percent_height="no" hundred_percent_height_scroll="no" hundred_percent_height_center_content="yes" equal_height_columns="no" menu_anchor="" hide_on_mobile="small-visibility,medium-visibility,large-visibility" status="published" publish_date="" class="" id="" link_color="" link_hover_color="" border_size="" border_color="" border_style="solid" margin_top="" margin_bottom="" padding_top="" padding_right="" padding_bottom="" padding_left="" gradient_start_color="" gradient_end_color="" gradient_start_position="0" gradient_end_position="100" gradient_type="linear" radial_direction="center center" linear_angle="180" background_color="" background_image="" background_position="center center" background_repeat="no-repeat" fade="no" background_parallax="none" enable_mobile="no" parallax_speed="0.3" background_blend_mode="none" video_mp4="" video_webm="" video_ogv="" video_url="" video_aspect_ratio="16:9" video_loop="yes" video_mute="yes" video_preview_image="" filter_hue="0" filter_saturation="100" filter_brightness="100" filter_contrast="100" filter_invert="0" filter_sepia="0" filter_opacity="100" filter_blur="0" filter_hue_hover="0" filter_saturation_hover="100" filter_brightness_hover="100" filter_contrast_hover="100" filter_invert_hover="0" filter_sepia_hover="0" filter_opacity_hover="100" filter_blur_hover="0"]
        [fusion_builder_row]
        [fusion_builder_column type="1_1" layout="1_1" spacing="" center_content="no" link="" target="_self" min_height="" hide_on_mobile="small-visibility,medium-visibility,large-visibility" class="" id="" hover_type="none" border_size="0" border_color="" border_style="solid" border_position="all" border_radius="" box_shadow="no" dimension_box_shadow="" box_shadow_blur="0" box_shadow_spread="0" box_shadow_color="" box_shadow_style="" padding_top="" padding_right="" padding_bottom="" padding_left="" margin_top="" margin_bottom="" background_type="single" gradient_start_color="" gradient_end_color="" gradient_start_position="0" gradient_end_position="100" gradient_type="linear" radial_direction="center center" linear_angle="180" background_color="" background_image="" background_image_id="" background_position="left top" background_repeat="no-repeat" background_blend_mode="none" animation_type="" animation_direction="left" animation_speed="0.3" animation_offset="" filter_type="regular" filter_hue="0" filter_saturation="100" filter_brightness="100" filter_contrast="100" filter_invert="0" filter_sepia="0" filter_opacity="100" filter_blur="0" filter_hue_hover="0" filter_saturation_hover="100" filter_brightness_hover="100" filter_contrast_hover="100" filter_invert_hover="0" filter_sepia_hover="0" filter_opacity_hover="100" filter_blur_hover="0" last="no"]
        [fusion_menu_anchor name="user-area-contact-form" class="" /]
        
        [fusion_title title_type="text" rotation_effect="bounceIn" display_time="1200" highlight_effect="circle" loop_animation="off" highlight_width="9" highlight_top_margin="0" before_text="" rotation_text="" highlight_text="" after_text="" hide_on_mobile="small-visibility,medium-visibility,large-visibility" class="" id="" content_align="center" size="1" font_size="" animated_font_size="" fusion_font_family_title_font="" fusion_font_subset_title_font="" fusion_font_variant_title_font="" line_height="" letter_spacing="" margin_top="10px" margin_bottom="10px" margin_top_mobile="" margin_bottom_mobile="" text_color="" animated_text_color="" highlight_color="" style_type="default" sep_color="" animation_type="" animation_direction="left" animation_speed="0.3" animation_offset=""]
        Feedback
        [/fusion_title]
        [contact-form-7 title="user area feedback form" /]
        [/fusion_builder_column]
        [/fusion_builder_row]
        [/fusion_builder_container]';

    echo do_shortcode($additional_user_area_block);
}

add_action('woocommerce_account_support_endpoint','avada_child_woo_support_accaunt_tab');

function avada_account_support_tab_rewrire()
{
    add_rewrite_endpoint( 'support', EP_ROOT | EP_PAGES );
}

add_action('init','avada_account_support_tab_rewrire');

function avada_account_support_tab_query_vars($vars)
{
    $vars[] = 'support';
    return $vars;
}

add_filter('query_vars','avada_account_support_tab_query_vars');

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' => 'Custom Theme Settings',
        'menu_title' => 'Custom Theme Settings',
        'menu_slug' => 'theme-custom-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}

add_action('wp_footer','footer_custom_term_and_privacy_modal',10,99);

function footer_custom_term_and_privacy_modal()
{
    if (function_exists('get_field')) {
        $content = get_field('terms_of_service','options');
        $modal='[fusion_modal name="tems_of_service" title="Terms of Service" size="large" background="#ffffff" border_color="#000000" show_footer="no" class="" id=""]
        '.$content.'
        [/fusion_modal]';
        echo do_shortcode($modal);

        $content = get_field('privacy','options');
        $modal='[fusion_modal name="privacy" title="Privacy" size="large" background="#ffffff" border_color="#000000" show_footer="no" class="" id=""]
        '.$content.'
        [/fusion_modal]';
        echo do_shortcode($modal);

        }
}


add_action('wp_enqueue_scripts', 'exovirt_override_wc_passwd_strength_meter',100);

function exovirt_override_wc_passwd_strength_meter()
{
    if (function_exists('WC')) {
        wp_deregister_script('wc-password-strength-meter');
        wp_register_script('wc-password-strength-meter',
            get_stylesheet_directory_uri().'/assets/js/exovirtual-password-strength-meter.js',
            ['jquery','password-strength-meter'],'1.0.1',true);
        wp_enqueue_script('wc-password-strength-meter');
    }
}

add_filter( 'woocommerce_get_script_data', 'exovirt_strength_meter_settings', 20, 2 );

function exovirt_strength_meter_settings( $params, $handle  ) {

    if( $handle === 'wc-password-strength-meter' ) {
        $params = array_merge( $params, array(
            'min_password_strength' => 2,
            'i18n_password_error' => 'Please enter a stronger password.',
            'i18n_password_hint' => 'Password must contain at least eight characters and contain uppercase and lowercase letters and numbers.'
        ) );
    }
    return $params;

}

add_action('init','exovirt_custom_send_email_new_register');

function exovirt_custom_send_email_new_register()
{
    if (!function_exists('is_plugin_active')) {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    if (is_plugin_active('woo-confirmation-email/woocommerc-confirmation-email.php')){
        if ( class_exists( 'WC_Emails' ) && method_exists( 'WC_Emails', 'instance' ) ) {
            $wc_emails = WC_Emails::instance();
            remove_action( 'woocommerce_created_customer_notification', [$wc_emails, 'customer_new_account'], 10, 3 );
            add_action('xlwuev_on_email_verification',[$wc_emails, 'customer_new_account'],10,3);
        }
    }
}

add_filter( 'woocommerce_return_to_shop_redirect', function($link){
    return wc_get_page_permalink('myaccount');
});

add_filter( 'woocommerce_checkout_fields' , 'exovirtual_override_checkout_fields' );

function exovirtual_override_checkout_fields($fields ){

    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    //unset($fields['billing']['billing_email']);
    unset($fields['billing']['billing_phone']);
    return $fields;
}

add_filter('woocommerce_enable_order_notes_field','__return_false',999,1);

add_action('template_redirect','exovirtual_single_product_redirec');

function exovirtual_single_product_redirec()
{
    if (function_exists('is_product') && function_exists('wc_get_page_permalink')
        && function_exists('is_shop')) {
        if ((is_single() & is_product()) || is_shop()) {
            wp_redirect(wc_get_page_permalink('myaccount'));
        }
    }
}

add_filter('woocommerce_view_license_key_show_activations','__return_false',99);
add_filter('woocommerce_view_license_key_show_activation_stats','__return_false',99);

add_filter('woocommerce_add_notice','exovirtual_override_resend_verification_mail');

function exovirtual_override_resend_verification_mail($message)
{
    if (class_exists('XlWUEV_Common')){
        $link                        = add_query_arg( array(
            'wc_confirmation_resend' => base64_encode( XlWUEV_Common::$wuev_user_id ),
        ), get_the_permalink( XlWUEV_Common::$wuev_myaccount_page_id ) );
        $resend_confirmation_message = XlWUEV_Common::get_setting_value( 'wuev-messages', 'xlwuev_email_resend_confirmation' );
        $xlwuev_resend_link          = '<a href="' . $link . '">' . $resend_confirmation_message . '</a>';
        $new_xlwuev_resend_link      = '<a class ="custom-verify-link fusion-button button-flat fusion-button-default-size button-default button-3 fusion-button-span-no fusion-button-default-type" href="' .
            $link . '">' . $resend_confirmation_message . '</a>';
        if (strpos($message, $xlwuev_resend_link)!==false){
            $message=str_replace($xlwuev_resend_link,$new_xlwuev_resend_link,$message);
        }
    }
    return $message;
}

function render_product_subscription_block()
{
    $like_answer_positive_block='[fusion_builder_container hundred_percent="no" hundred_percent_height="no" hundred_percent_height_scroll="no" hundred_percent_height_center_content="yes" equal_height_columns="no" menu_anchor="" hide_on_mobile="small-visibility,medium-visibility,large-visibility" status="published" publish_date="" class="'.$container_like_positive_class.'" id="container-like-y" link_color="" link_hover_color="" border_size="" border_color="" border_style="solid" margin_top="" margin_bottom="" padding_top="" padding_right="" padding_bottom="" padding_left="" gradient_start_color="" gradient_end_color="" gradient_start_position="0" gradient_end_position="100" gradient_type="linear" radial_direction="center center" linear_angle="180" background_color="" background_image="" background_position="center center" background_repeat="no-repeat" fade="no" background_parallax="none" enable_mobile="no" parallax_speed="0.3" background_blend_mode="none" video_mp4="" video_webm="" video_ogv="" video_url="" video_aspect_ratio="16:9" video_loop="yes" video_mute="yes" video_preview_image="" filter_hue="0" filter_saturation="100" filter_brightness="100" filter_contrast="100" filter_invert="0" filter_sepia="0" filter_opacity="100" filter_blur="0" filter_hue_hover="0" filter_saturation_hover="100" filter_brightness_hover="100" filter_contrast_hover="100" filter_invert_hover="0" filter_sepia_hover="0" filter_opacity_hover="100" filter_blur_hover="0"]
            [fusion_builder_row]
            [fusion_builder_column type="1_1" layout="1_1" spacing="" center_content="no" link="" target="_self" min_height="" hide_on_mobile="small-visibility,medium-visibility,large-visibility" class="" id="" hover_type="none" border_size="0" border_color="" border_style="solid" border_position="all" border_radius="" box_shadow="no" dimension_box_shadow="" box_shadow_blur="0" box_shadow_spread="0" box_shadow_color="" box_shadow_style="" padding_top="" padding_right="" padding_bottom="" padding_left="" margin_top="" margin_bottom="" background_type="single" gradient_start_color="" gradient_end_color="" gradient_start_position="0" gradient_end_position="100" gradient_type="linear" radial_direction="center center" linear_angle="180" background_color="" background_image="" background_image_id="" background_position="left top" background_repeat="no-repeat" background_blend_mode="none" animation_type="" animation_direction="left" animation_speed="0.3" animation_offset="" filter_type="regular" filter_hue="0" filter_saturation="100" filter_brightness="100" filter_contrast="100" filter_invert="0" filter_sepia="0" filter_opacity="100" filter_blur="0" filter_hue_hover="0" filter_saturation_hover="100" filter_brightness_hover="100" filter_contrast_hover="100" filter_invert_hover="0" filter_sepia_hover="0" filter_opacity_hover="100" filter_blur_hover="0" last="no"]
            [fusion_separator style_type="none" hide_on_mobile="small-visibility,medium-visibility,large-visibility" class="" id="" sep_color="" top_margin="" bottom_margin="" border_size="" icon="" icon_size="" icon_circle="" icon_circle_color="" width="" alignment="center" /]
            ';

    $products=new WP_Query([
        'post_type'=>'product',
        'posts_per_page'=>-1,
        'meta_query' => [
            [
                'key' => 'show_in_user_area',
                'value' => true
            ]
        ]
    ]);

    $like_answer_positive_block.='[fusion_title title_type="text" rotation_effect="bounceIn" display_time="1200" highlight_effect="circle" loop_animation="off" highlight_width="9" highlight_top_margin="0" before_text="" rotation_text="" highlight_text="" after_text="" hide_on_mobile="small-visibility,medium-visibility,large-visibility" class="" id="" content_align="center" size="1" font_size="" animated_font_size="" fusion_font_family_title_font="" fusion_font_subset_title_font="" fusion_font_variant_title_font="" line_height="" letter_spacing="" margin_top="10px" margin_bottom="10px" margin_top_mobile="" margin_bottom_mobile="" text_color="" animated_text_color="" highlight_color="" style_type="default" sep_color="" animation_type="" animation_direction="left" animation_speed="0.3" animation_offset=""]
            Product subscription
            [/fusion_title]';

    $like_answer_positive_block.='[/fusion_builder_column]';
    $like_answer_positive_block.='[/fusion_builder_row]';


    $like_answer_positive_block.='[fusion_builder_row]';
    $like_answer_positive_block.='[fusion_builder_column type="1_1" layout="1_1" spacing="" center_content="no" link="" target="_self" min_height="" hide_on_mobile="small-visibility,medium-visibility,large-visibility" class="" id="" hover_type="none" border_size="0" border_color="" border_style="solid" border_position="all" border_radius="" box_shadow="no" dimension_box_shadow="" box_shadow_blur="0" box_shadow_spread="0" box_shadow_color="" box_shadow_style="" padding_top="" padding_right="" padding_bottom="" padding_left="" margin_top="" margin_bottom="" background_type="single" gradient_start_color="" gradient_end_color="" gradient_start_position="0" gradient_end_position="100" gradient_type="linear" radial_direction="center center" linear_angle="180" background_color="" background_image="" background_image_id="" background_position="left top" background_repeat="no-repeat" background_blend_mode="none" animation_type="" animation_direction="left" animation_speed="0.3" animation_offset="" filter_type="regular" filter_hue="0" filter_saturation="100" filter_brightness="100" filter_contrast="100" filter_invert="0" filter_sepia="0" filter_opacity="100" filter_blur="0" filter_hue_hover="0" filter_saturation_hover="100" filter_brightness_hover="100" filter_contrast_hover="100" filter_invert_hover="0" filter_sepia_hover="0" filter_opacity_hover="100" filter_blur_hover="0" last="no"]';

    $i=1;
    foreach ($products->posts as $product){

        if ($i==1 || ($i%2==1 && $i!=count($products->posts))){
            $like_answer_positive_block.='[fusion_builder_row_inner]';
        }

        $product_obj=wc_get_product($product);
        if ($product_obj instanceof WC_Product){
            $like_answer_positive_block.='[fusion_builder_column_inner type="1_2" layout="1_2" spacing="" center_content="no" hover_type="none" 
                link="'.$product_obj->add_to_cart_url().'" target="_self" min_height="" hide_on_mobile="small-visibility,medium-visibility,large-visibility" class="" id="" 
                border_size="0" border_color="" border_style="solid" border_position="all" border_radius="" box_shadow="no" dimension_box_shadow=""
                box_shadow_blur="0" box_shadow_spread="0" box_shadow_color="" box_shadow_style="" padding_top="" padding_right="" padding_bottom=""
                padding_left="" dimension_margin="" background_type="single" background_color="" gradient_start_color="" gradient_end_color=""
                gradient_start_position="0" gradient_end_position="100" gradient_type="linear" radial_direction="center center" linear_angle="180"
                background_image="" background_position="left top" background_repeat="no-repeat" background_blend_mode="none" animation_type=""
                animation_direction="left" animation_speed="0.3" animation_offset="" filter_type="regular" filter_hue="0" filter_saturation="100"
                filter_brightness="100" filter_contrast="100" filter_invert="0" filter_sepia="0" filter_opacity="100" filter_blur="0"
                filter_hue_hover="0" filter_saturation_hover="100" filter_brightness_hover="100" filter_contrast_hover="100" filter_invert_hover="0"
                filter_sepia_hover="0" filter_opacity_hover="100" filter_blur_hover="0" last="no"]';

            $like_answer_positive_block.='[fusion_content_boxes layout="clean-vertical" columns="1" link_type="" button_span="" link_area="" link_target="" icon_align="left" animation_type="" animation_direction="left" animation_speed="0.3" animation_delay="" animation_offset="" hide_on_mobile="small-visibility,medium-visibility,large-visibility" class="" id="" title_size="" heading_size="2" title_color="" body_color="" backgroundcolor="" icon="" iconflip="" iconrotate="" iconspin="no" iconcolor="" icon_circle="" icon_circle_radius="" circlecolor="" circlebordersize="" circlebordercolor="" outercirclebordersize="" outercirclebordercolor="" icon_size="" icon_hover_type="" hover_accent_color="" image="" image_id="" image_max_width="" margin_top="" margin_bottom="0px"]';

            $like_answer_positive_block.=
                '<div style="border-color:#619e85;" 
                class="fusion-column content-box-column content-box-column content-box-column-1 col-lg-12 col-md-12 col-sm-12 fusion-content-box-hover content-box-column-last content-box-column-last-in-row">
                <div class="col content-box-wrapper content-wrapper link-area-box icon-hover-animation-slide" style="background-color: rgba(255, 255, 255, 0); min-height: 369px; height: auto; overflow: visible;" data-animationoffset="100%">
                <div class="heading icon-left">
                <h2 class="content-box-heading fusion-responsive-typography-calculated" style="font-size: 18px; font-weight: 300; line-height: 1.28; --fontSize:18; --minFontSize:18;" data-fontsize="18" data-lineheight="23.04px">
                '.$product_obj->get_title().' &#8212 <strong>'.$product_obj->get_price_html().'</strong>'.'
                </h2>
                </div>
                <div class="fusion-clearfix"></div>
                <div class="content-container" style="color:#619e85;">
                '.$product_obj->get_short_description().'</div></div></div>';




            $like_answer_positive_block.='[/fusion_content_boxes]';
            $like_answer_positive_block.='[/fusion_builder_column_inner]';

        }

        if ($i%2==0 && $i!=1){
            $like_answer_positive_block.='[/fusion_builder_row_inner]';
        }

        $i++;
    }

    $like_answer_positive_block.='[/fusion_builder_column]';
    $like_answer_positive_block.='[/fusion_builder_row]';

    $like_answer_positive_block.='[/fusion_builder_container]';

    echo do_shortcode($like_answer_positive_block);
}

add_action('woocommerce_after_license_keys','render_product_subscription_block');

add_filter('woocommerce_account_menu_item_classes','exovirtual_wc_account_menu_item_classes_filter',10,2);

function exovirtual_wc_account_menu_item_classes_filter($classes, $endpoint)
{
    if ($endpoint=='license-keys'){
        $check_cookie=(isset($_COOKIE['like_answer']) && $_COOKIE['like_answer']=='y'
            && isset($_COOKIE['account']) && $_COOKIE['account']==get_current_user_id()
            && get_current_user_id()!=0);
        try {
            $license_keys = LicenseKey::from_user( get_current_user_id() );
        } catch ( Exception $e ) {
            WPMVCLog::error( $e );
        }

        if (!($check_cookie || $license_keys))
           $classes[]='hidden';
    }
    return $classes;
}

add_action('template_redirect','exovirtual_hide_subscription_block_on_direct_access',10,4);

function exovirtual_hide_subscription_block_on_direct_access()
{
    global $wp;

    if (!is_account_page()) return;
    if (empty( $wp->query_vars ) )  return;
    if (!isset($wp->query_vars['license-keys'])) return;
    $check_cookie=(isset($_COOKIE['like_answer']) && $_COOKIE['like_answer']=='y'
        && isset($_COOKIE['account']) && $_COOKIE['account']==get_current_user_id()
        && get_current_user_id()!=0);
    try {
        $license_keys = LicenseKey::from_user( get_current_user_id() );
    } catch ( Exception $e ) {
        WPMVCLog::error( $e );
    }

    if ($check_cookie || $license_keys) return;
    wp_redirect(wc_get_page_permalink('myaccount'));
    exit;
}

add_filter('woocommerce_gateway_icon','exovirtual_icon_html_checkout',10,2);

function exovirtual_icon_html_checkout($icon_html, $id )
{
    if ($id=='paypal' && is_checkout()) return '';
    return $icon_html;
}

add_filter('woocommerce_gateway_title','exovirtual_gateway_title_checkout',10,2);

function exovirtual_gateway_title_checkout($title,$id)
{
    if ($id=='paypal' && is_checkout()) return '';
    return $title;
}