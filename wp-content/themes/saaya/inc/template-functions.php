<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Mystery Themes
 * @subpackage Saaya
 * @since 1.0.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function saaya_body_classes( $classes ) {
	global $post;

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	$saaya_site_layout = get_theme_mod( 'saaya_site_layout', 'site-layout--wide' );
	$classes[] = esc_attr( $saaya_site_layout );

	/**
	 * Add classes about style and sidebar layout for archive, post and page
	 */
	if ( is_archive() || is_home() || is_search()) {
		$archive_sidebar_layout = get_theme_mod( 'saaya_archive_sidebar_layout', 'no-sidebar' );
		$archive_style          = get_theme_mod( 'saaya_archive_style', 'mt-archive--masonry-style' );
		$classes[] = esc_attr( $archive_sidebar_layout );
		$classes[] = esc_attr( $archive_style );
	} elseif( is_single() ) {
		$single_post_sidebar_layout = get_post_meta( $post->ID, 'saaya_post_sidebar_layout', true );
		if ( 'layout--default-sidebar' !== $single_post_sidebar_layout && !empty( $single_post_sidebar_layout ) ) {
			$classes[] = esc_attr( $single_post_sidebar_layout );
		} else {
			$posts_sidebar_layout = get_theme_mod( 'saaya_posts_sidebar_layout', 'right-sidebar' );
			$classes[] = esc_attr( $posts_sidebar_layout );
		}
	} elseif( is_page() ) {
		$single_page_sidebar_layout = get_post_meta( $post->ID, 'saaya_post_sidebar_layout', true );
		if ( 'layout--default-sidebar' !== $single_page_sidebar_layout && !empty( $single_page_sidebar_layout ) ) {
			$classes[] = esc_attr( $single_page_sidebar_layout );
		} else {
			$pages_sidebar_layout = get_theme_mod( 'saaya_pages_sidebar_layout', 'right-sidebar' );
			$classes[] = esc_attr( $pages_sidebar_layout );
		}
	}

	return $classes;
}
add_filter( 'body_class', 'saaya_body_classes' );


/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function saaya_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'saaya_pingback_header' );

/*-----------------------------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'saaya_fonts_url' ) ) :
	/**
	 * Register Google fonts for Saaya.
	 *
	 * @return string Google fonts URL for the theme.
	 * @since 1.0.0
	 */

    function saaya_fonts_url() {

        $fonts_url = '';
        $font_families = array();

        /*
         * Translators: If there are characters in your language that are not supported
         * by Yanone Kaffeesatz translate this to 'off'. Do not translate into your own language.
         */
        if ( 'off' !== _x( 'on', 'Yanone Kaffeesatz font: on or off', 'saaya' ) ) {
            $font_families[] = 'Yanone Kaffeesatz:400,700';
        }

        /*
         * Translators: If there are characters in your language that are not supported
         * by Roboto, translate this to 'off'. Do not translate into your own language.
         */
        if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'saaya' ) ) {
            $font_families[] = 'Roboto:300,400,400i,500,700';
        }   

        if( $font_families ) {
            $query_args = array(
                'family' => urlencode( implode( '|', $font_families ) ),
                'subset' => urlencode( 'latin,latin-ext' ),
            );

            $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
        }

        return $fonts_url;
    }

endif;

/*-----------------------------------------------------------------------------------------------------------------------*/
/**
 * Enqueue scripts and styles for only admin
 *
 * @since 1.0.0
 */
add_action( 'admin_enqueue_scripts', 'saaya_admin_scripts' );

function saaya_admin_scripts( $hook ) {

    global $saaya_theme_version;

    if( 'widgets.php' != $hook && 'customize.php' != $hook && 'edit.php' != $hook && 'post.php' != $hook && 'post-new.php' != $hook ) {
        return;
    }

    wp_enqueue_script( 'jquery-ui-button' );
    
    wp_enqueue_script( 'saaya--admin-script', get_template_directory_uri() .'/assets/js/mt-admin-scripts.js', array( 'jquery' ), esc_attr( $saaya_theme_version ), true );

    wp_enqueue_style( 'saaya--admin-style', get_template_directory_uri() . '/assets/css/mt-admin-styles.css', array(), esc_attr( $saaya_theme_version ) );
}

/*----------------------------------------------------------------------------------------------------------------------------------------*/
/**
 * Enqueue scripts and styles.
 */
function saaya_scripts() {

	global $saaya_theme_version;

	wp_enqueue_style( 'saaya-fonts', saaya_fonts_url(), array(), null );

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/library/font-awesome/css/font-awesome.min.css', array(), '4.7.0' );

	wp_enqueue_style( 'animate', get_template_directory_uri(). '/assets/library/animate/animate.min.css', array(), '3.5.1' );
	wp_enqueue_style( 'preloader', get_template_directory_uri() .'/assets/css/mt-preloader.css', array(), esc_attr( $saaya_theme_version ) );

	wp_enqueue_style( 'saaya-style', get_stylesheet_uri(), array(), esc_attr( $saaya_theme_version) );

	wp_enqueue_style( 'saaya-responsive-style', get_template_directory_uri(). '/assets/css/mt-responsive.css', array(), esc_attr( $saaya_theme_version ) );

	wp_enqueue_script( 'saaya-combine-scripts', get_template_directory_uri() .'/assets/js/mt-combine-scripts.js', array('jquery'), esc_attr( $saaya_theme_version ), true );

	wp_enqueue_script( 'saaya-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'saaya-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );
	
	wp_enqueue_script( 'saaya-custom-scripts', get_template_directory_uri() .'/assets/js/mt-custom-scripts.js', array('jquery'), esc_attr( $saaya_theme_version ), true );

	$saaya_enable_sticky_menu = get_theme_mod( 'saaya_enable_sticky_menu', true );
	if( true === $saaya_enable_sticky_menu ) {
		$sticky_value = 'on';
	} else {
		$sticky_value = 'off';
	}

	$saaya_enable_wow_animation = get_theme_mod( 'saaya_enable_wow_animation', true );
	if( true === $saaya_enable_wow_animation ) {
		$wow_value = 'on';
	} else {
		$wow_value = 'off';
	}

	wp_localize_script( 'saaya-custom-scripts', 'saayaObject', array(
        'menu_sticky' => $sticky_value,
        'wow_effect'     => $wow_value
    ) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'saaya_scripts' );

/*----------------------------------------------------------------------------------------------------------------------------------------*/


/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/
if( ! function_exists( 'saaya_preloader' ) ):
    /**
     * preloader function
     * 
     * @since 1.0.0
     */
    function saaya_preloader() {
        $saaya_enable_preloader = get_theme_mod( 'saaya_enable_preloader', true );
        if( false == $saaya_enable_preloader ){
            return;
        }
?>
        <div id="preloader-background">
            <div class="preloader-wrapper">
                <div class="sk-spinner sk-spinner-pulse"></div>
            </div><!-- .preloader-wrapper -->
        </div><!-- #preloader-background -->
<?php
    }
endif;
add_action( 'saaya_before_page', 'saaya_preloader', 5 );


if( ! function_exists( 'saaya_get_fontawesome_social_icons_array' ) ) :

	/**
     * Font Awesome
     *
     * @param string $file_path font awesome css file path
     * @param string $class_prefix change this if the class names does not start with `fa-`
     * @return array
     */

	function saaya_get_fontawesome_social_icons_array() {

		$social_icons_array = array( 'facebook-square', 'facebook', 'facebook-official', 'twitter-square', 'twitter', 'github', 'behance', 'behance-square', 'whatsapp', 'qq', 'wechat', 'weixin', 'tumblr', 'tumblr-square', 'instagram', 'google-plus-circle', 'google-plus-official', 'google-plus-square', 'google-plus', 'dribbble', 'skype', 'snapchat', 'snapchat-ghost', 'snapchat-square', 'pinterest', 'pinterest-square', 'pinterest-p', 'linkedin-square', 'linkedin', 'reddit', 'reddit-square', 'youtube-square', 'youtube', 'youtube-play', 'yelp' );

		foreach ( $social_icons_array as $icon ) {
			$icon_name = ucfirst( str_ireplace( array( '-' ), array( ' ' ), $icon ) );
			$font_awesome_icons[esc_attr( $icon )] = esc_html( $icon_name );
		}
		return $font_awesome_icons;

	}

endif;

/*----------------------------------------------------------------------------------------------------------------------------------------*/

if( ! function_exists( 'saaya_social_media_content' ) ) :

	/**
	 * function to display the social icons
	 */
	
	function saaya_social_media_content() {

		$social_icons = get_theme_mod( 'saaya_social_icons_lists', array(
			array(
				'social_icon' => 'facebook',
				'social_url'  => '#',
			),
			array(
				'social_icon' => 'twitter',
				'social_url'  => '#',
			),
		) );

		if ( ! empty( $social_icons ) && is_array( $social_icons ) ) {
?>

			<ul class="mt-social-icon-wrap">
				<?php
					foreach ( $social_icons as $social_icon ) {
						if ( ! empty( $social_icon['social_url'] ) ) {
				?>

							<li class="mt-social-icon">
								<a href="<?php echo esc_url( $social_icon['social_url'] ); ?>">
									<i class="fa fa-<?php echo esc_attr( $social_icon['social_icon'] ); ?>"></i>
								</a>
							</li>

				<?php
						}
					}
				?>
			</ul>

<?php 
		}
	}

endif;


/*----------------------------------------------------------------------------------------------------------------------------------------*/

if( ! function_exists( 'saaya_select_categories_list' ) ) :

	/**
	 * function to return category lists
	 *
	 * @return $saaya_categories_list in array
	 */
	
	function saaya_select_categories_list() {

		$saaya_get_categories = get_categories( array( 'hide_empty' => 0 ) );
		$saaya_categories_list[''] = __( 'Select Category', 'saaya' );

        foreach ( $saaya_get_categories as $category ) {
            $saaya_categories_list[esc_attr( $category->slug )] = esc_html( $category->cat_name );
        }
        
        return $saaya_categories_list;
	}

endif;


/*----------------------------------------------------------------------------------------------------------------------------------------*/

if( ! function_exists( 'saaya_is_sidebar_layout' ) ) :

	/**
	 * Checks if the current page matches the given layout
	 *
	 * @return string $layout layout of current page.
	 */

	function saaya_is_sidebar_layout() {

		global $post;
		$layout = '';

		if ( is_archive() || is_home() ) {
			$layout = get_theme_mod( 'saaya_archive_sidebar_layout', 'no-sidebar' );
		} elseif ( is_single() ) {
			$single_post_layout = get_post_meta( $post->ID, 'saaya_post_sidebar_layout', true );
			if ( 'layout--default-sidebar' !== $single_post_layout ) {
				$layout = $single_post_layout;
			} else {
				$layout = get_theme_mod( 'saaya_posts_sidebar_layout', 'right-sidebar' );
			}
		} elseif ( is_page() ) {
			$single_page_layout = get_post_meta( $post->ID, 'saaya_post_sidebar_layout', true );
			if ( 'layout--default-sidebar' !== $single_page_layout ) {
				$layout = $single_page_layout;
			} else {
				$layout = get_theme_mod( 'saaya_pages_sidebar_layout', 'right-sidebar' );
			}
		}

		return $layout;
	}

endif;

/*----------------------------------------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'saaya_inner_header_bg_image' ) ) :

    /**
     * Background image for inner page header
     *
     * @since 1.0.0
     */

    function saaya_inner_header_bg_image( $input ) {

        $image_attr = array();

        if ( empty( $image_attr ) ) {

            // Fetch from Custom Header Image.
            $image = get_header_image();
            if ( ! empty( $image ) ) {
                $image_attr['url']    = $image;
                $image_attr['width']  = get_custom_header()->width;
                $image_attr['height'] = get_custom_header()->height;
            }
        }

        if ( ! empty( $image_attr ) ) {
            $input .= 'background-image:url(' . esc_url( $image_attr['url'] ) . ');';
            $input .= 'background-size:cover;';
        }

        return $input;
    }

endif;

add_filter( 'saaya_inner_header_style_attribute', 'saaya_inner_header_bg_image' );

/*-----------------------------------------------------------------------------------------------------------------------*/

if( ! function_exists( 'saaya_css_strip_whitespace' ) ) :
	
	/**
	 * Get minified css and removed space
	 *
	 * @since 1.0.0
	 */

    function saaya_css_strip_whitespace( $css ){
        $replace = array(
            "#/\*.*?\*/#s" => "",  // Strip C style comments.
            "#\s\s+#"      => " ", // Strip excess whitespace.
        );
        $search = array_keys( $replace );
        $css = preg_replace( $search, $replace, $css );

        $replace = array(
            ": "  => ":",
            "; "  => ";",
            " {"  => "{",
            " }"  => "}",
            ", "  => ",",
            "{ "  => "{",
            ";}"  => "}", // Strip optional semicolons.
            ",\n" => ",", // Don't wrap multiple selectors.
            "\n}" => "}", // Don't wrap closing braces.
            "} "  => "}\n", // Put each rule on it's own line.
        );
        $search = array_keys( $replace );
        $css = str_replace( $search, $replace, $css );

        return trim( $css );
    }

endif;