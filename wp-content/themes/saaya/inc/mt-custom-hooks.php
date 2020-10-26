<?php
/**
 * Managed the custom functions and hooks for entire theme.
 *
 * @package Mystery Themes
 * @subpackage Saaya
 * @since 1.0.0
 */

/*----------------------------------------------------------------------------------------------------------------------------------*/

if( ! function_exists( 'saaya_main_header_start' ) ) :

	/**
	 * function to start header section
	 */
	function saaya_main_header_start() {
		echo '<header id="masthead" class="site-header">';
		echo '<div class="mt-logo-row-wrapper clearfix">';
		echo '<div class="mt-container">';
	}

endif;

if( ! function_exists( 'saaya_site_branding' ) ) :

	/**
	 * function to display site branding
	 */
	function saaya_site_branding() {
?>
		<div class="site-branding">
			<?php
				the_custom_logo();
				if ( is_front_page() || is_home() ) :
			?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
				endif;
				$saaya_description = get_bloginfo( 'description', 'display' );
				if ( $saaya_description || is_customize_preview() ) :
			?>
				<p class="site-description"><?php echo $saaya_description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->
<?php
	}

endif;

if( ! function_exists( 'saaya_menu_wrapper_start' ) ) :

	/**
	 * function to start menu wrapper
	 */
	function saaya_menu_wrapper_start() {
		echo '<div class="mt-social-menu-wrapper">';
	}

endif;

if( ! function_exists( 'saaya_header_main_menu' ) ) :

	/**
	 * function to display primary menu
	 */
	function saaya_header_main_menu() {
		$saaya_menu_toggle_text = apply_filters( 'saaya_menu_toggle_text', __( 'Menu', 'saaya' ) );
?>
		<div class="menu-toggle"><i class="fa fa-navicon"></i> <?php echo esc_html( $saaya_menu_toggle_text ); ?> </div>
		<nav id="site-navigation" class="main-navigation">
			<?php
				wp_nav_menu( array(
					'theme_location' => 'primary_menu',
					'menu_id'        => 'primary-menu',
				) );
			?>
		</nav><!-- #site-navigation -->
<?php
	}
endif;

if( ! function_exists( 'saaya_menu_icon_wrapper_start' ) ) :

	/**
	 * function to start icon wrapper
	 */
	function saaya_menu_icon_wrapper_start() {
		echo '<div class="mt-social-search-wrapper">';
	}

endif;

if( !function_exists( 'saaya_menu_social_icons' ) ) :

	/**
	 * function to display social icons at menu section
	 */
	function saaya_menu_social_icons() {
		$saaya_enable_header_social_icons = get_theme_mod( 'saaya_enable_header_social_icons', true );
		if( false === $saaya_enable_header_social_icons ) {
			return;
		}
		$saaya_menu_social_icons_label = apply_filters( 'saaya_menu_social_icons_label', __( 'Follow Us: ', 'saaya' ) );
?>
		<div class="mt-social-wrapper">
			<span class="mt-follow-title"><?php echo esc_html( $saaya_menu_social_icons_label ); ?></span>
			<?php saaya_social_media_content(); ?>
		</div>
<?php
	}

endif;

if( ! function_exists( 'saaya_menu_search_icon' ) ) :

	/**
	 * function to display search icon at menu section
	 */
	function saaya_menu_search_icon() {
		$saaya_enable_search_icon = get_theme_mod( 'saaya_enable_search_icon', true );
		if( false === $saaya_enable_search_icon ) {
			return;
		}
		$saaya_menu_search_icon_lable = apply_filters( 'saaya_menu_search_icon_lable', __( 'Search', 'saaya' ) );
?>
		<div class="mt-menu-search">
			<div class="mt-search-icon"><?php echo esc_html( $saaya_menu_search_icon_lable ); ?><i class="fa fa-search"></i></div>
			<div class="mt-form-wrap">
				<div class="mt-form-close"> <i class="fa fa-close"></i></div>
				<?php get_search_form(); ?>
			</div>
		</div>
<?php
	}

endif;

if( ! function_exists( 'saaya_menu_icon_wrapper_end' ) ) :

	/**
	 * function to end icon wrapper
	 */
	function saaya_menu_icon_wrapper_end() {
		echo '</div><!-- .mt-social-search-wrapper -->';
	}

endif;

if( ! function_exists( 'saaya_menu_wrapper_end' ) ) :

	/**
	 * function to end menu wrapper
	 */
	function saaya_menu_wrapper_end() {
		echo '</div><!--.mt-social-menu-wrapper -->';
	}

endif;

if( ! function_exists( 'saaya_main_header_end' ) ) :

	/**
	 * function to end header section
	 */
	function saaya_main_header_end() {
		echo '</header><!-- #masthead -->';
		echo '</div><!--.mt-logo-row-wrapper -->';
		echo '</div><!-- .mt-container -->';
	}

endif;

/**
 * manage functions at saaya_main_header hook
 */
add_action( 'saaya_main_header', 'saaya_main_header_start', 5 );
add_action( 'saaya_main_header', 'saaya_site_branding', 10 );
add_action( 'saaya_main_header', 'saaya_menu_wrapper_start', 15 );
add_action( 'saaya_main_header', 'saaya_header_main_menu', 20 );
add_action( 'saaya_main_header', 'saaya_menu_icon_wrapper_start', 25 );
add_action( 'saaya_main_header', 'saaya_menu_social_icons', 30 );
add_action( 'saaya_main_header', 'saaya_menu_search_icon', 35 );
add_action( 'saaya_main_header', 'saaya_menu_icon_wrapper_end', 40 );
add_action( 'saaya_main_header', 'saaya_menu_wrapper_end', 45 );
add_action( 'saaya_main_header', 'saaya_main_header_end', 50 );

/*----------------------------------------------------------------------------------------------------------------------------------*/

if( ! function_exists( 'saaya_header_categories_lists_content' ) ) :
	
	/**
	 * function to display categories lists
	 */

	function saaya_header_categories_lists_content() {
		
		$get_categories = get_categories( array( 'orderby' => 'name', 'order'   => 'ASC' ) );
?>
			<div class="mt-header-cat-list-wrapper">
				<ul class="sticky-header-sidebar-menu mt-slide-cat-lists">
					<?php
						$count = 1;
						$cat_list_items = apply_filters( 'saaya_menu_cat_list_items', 5 );
						foreach( $get_categories as $category ) {
							$cat_link  = get_category_link( $category->term_id );
							$cat_name  = $category->name;
							$cat_count = $category->count;
							if( $count <= $cat_list_items ) {
					?>
								<li class="cat-item">
									<a href="<?php echo esc_url( $cat_link ); ?>">
										<?php
											echo esc_html( $cat_name );
											echo '<span>'. esc_html( $cat_count ) .'</span>';
										?>
									</a>
								</li>
					<?php
							}
						}
					?>
				</ul><!-- .mt-slide-cat-lists -->
			</div><!-- .mt-header-cat-list-wrapper -->
<?php
	}

endif;

add_action( 'saaya_header_categories_lists', 'saaya_header_categories_lists_content', 10 );


/*----------------------------------------------------------------------------------------------------------------------------------*/

if( ! function_exists( 'saaya_header_author_box_content' ) ) :
	
	/**
	 * function to display author info
	 */

	function saaya_header_author_box_content() {

		$saaya_user_id = apply_filters( 'saaya_header_user_id', 1 );
?>
		<div class="sticky-header-sidebar-author author-bio-wrap">
            <div class="author-avatar"><?php echo get_avatar( $saaya_user_id, '150' ); ?></div>
            <h3 class="author-name"><?php echo esc_html( get_the_author_meta( 'nicename', $saaya_user_id ) ); ?></h3>
            <div class="author-description"><?php echo wp_kses_post( wpautop( get_the_author_meta( 'description', $saaya_user_id ) ) ); ?></div>
            <div class="author-social">
                <?php saaya_social_media_content(); ?>
            </div><!-- .author-social -->
        </div><!-- .author-bio-wrap -->
<?php
	}

endif;

add_action( 'saaya_header_author_box', 'saaya_header_author_box_content', 10 );

/*----------------------------------------------------------------------------------------------------------------------------------*/

add_action( 'saaya_scroll_top', 'saaya_scroll_top_content', 10 );

if( ! function_exists( 'saaya_scroll_top_content' ) ) :

	/**
	 * Function for scroll top
	 *
	 * @since 1.0.0
	 */

	function saaya_scroll_top_content() {
		$saaya_scroll_top_text = apply_filters( 'saaya_scroll_top_text', __( 'Back To Top', 'saaya' ) );
        echo '<div id="mt-scrollup" class="animated arrow-hide">'. esc_html( $saaya_scroll_top_text ) .'</div>';
	}

endif;

/*----------------------------------------------------------------------------------------------------------------------------------*/
add_action( 'saaya_main_banner_content', 'saaya_main_banner_content_sec', 10 );

if( !function_exists( 'saaya_main_banner_content_sec' ) ):
	/**
	 * Banner Section
	 * 
	 */
	function saaya_main_banner_content_sec(){
		$saaya_enable_banner_section = get_theme_mod( 'saaya_enable_banner_section', '1' );
		$banner_section_image = get_theme_mod( 'banner_section_image', '' );
		if( false == $saaya_enable_banner_section || empty( $banner_section_image ) ){
			return;
		}
		$banner_main_title = get_theme_mod( 'banner_main_title', '' );
		$banner_sub_title = get_theme_mod( 'banner_sub_title', '' );
		$banner_btn_label = get_theme_mod( 'banner_btn_label', '' ); 
		$banner_btn_url = get_theme_mod( 'banner_btn_url', '' ); ?>
		<div id="section-banner" class="header-banner-section">
			<div class="mt-container">
				<div class="banner-content-wrapper" style="background-image: url('<?php echo esc_url( $banner_section_image ); ?>'); background-size: cover; background-repeat: no-repeat; background-position: center top">
					<div class="banner-title-btn-wrapper">
						<div class="banner-title-btn-block">
							<div class="banner-title-wrapper">
								<?php
								if( !empty( $banner_main_title ) ){ ?>
									<div class="banner-sub-title"><?php echo esc_html( $banner_sub_title ); ?></div>
								<?php 
								} 
								if( !empty( $banner_main_title ) ){ ?>
									<h2 class="banner-title"><?php echo esc_html( $banner_main_title ); ?></h2>
								<?php 
								} ?>
							</div>
							<?php 
							if( !empty( $banner_btn_url ) ){ ?>
								<div class="btn-wrapper">
									<a href="<?php echo esc_url( $banner_btn_url ); ?>"><?php echo esc_html( $banner_btn_label ); ?> <i class="fa fa-long-arrow-right"> </i></a>		
								</div>
							<?php 
							} ?>
						</div> <!-- banner-title-btn-block -->
					</div> <!-- banner-title-btn-wrapper -->
				</div><!-- .banner-content-wrapper -->
			</div>
		</div><!-- #section-banner -->
<?php
	}	
endif;	
/*----------------------------------------------------------------------------------------------------------------------------------*/

if( ! function_exists( 'saaya_innerpage_header_start' ) ) :

	/**
	 * function to manage starting div of section
	 */
	function saaya_innerpage_header_start() {
		$inner_header_attribute = '';
		$inner_header_attribute = apply_filters( 'saaya_inner_header_style_attribute', $inner_header_attribute );
		if( !empty( $inner_header_attribute ) ) {
			$header_class = 'has-bg-img';
		} else {
			$header_class = 'no-bg-img';
		}
?>
		<div class="custom-header <?php echo esc_attr( $header_class ); ?>" <?php echo ( ! empty( $inner_header_attribute ) ) ? ' style="' . esc_attr( $inner_header_attribute ) . '" ' : ''; ?>>
            <div class="mt-container">
<?php
	}

endif;

if( ! function_exists( 'saaya_innerpage_header_title' ) ) :

	/**
	 * function to display the page title
	 */

	function saaya_innerpage_header_title() {
		if( is_single() || is_page() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} elseif( is_archive() ) {
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );
		} elseif( is_search() ) {
	?>
			<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'saaya' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
	<?php
		} elseif( is_404() ) {
			echo '<h1 class="entry-title">'. esc_html( '404 Error', 'saaya' ) .'</h1>';
		} elseif( is_home() ) {
			$page_for_posts_id = get_option( 'page_for_posts' );
			$page_title = get_the_title( $page_for_posts_id );
	?>
			<h1 class="entry-title"><?php echo esc_html( $page_title ); ?></h1>
	<?php
		}
	}

endif;

if( !function_exists( 'saaya_breadcrumb_content' ) ) :

	/**
	 * function to manage the breadcrumbs content
	 */

	function saaya_breadcrumb_content() {

		$saaya_breadcrumb_option = get_theme_mod( 'saaya_enable_breadcrumb_option', true );

		if ( false === $saaya_breadcrumb_option ) {
			return;
		}
?>
		<nav id="breadcrumb" class="mt-breadcrumb">
			<?php
			breadcrumb_trail( array(
				'container'   => 'div',
				'before'      => '<div class="mt-container">',
				'after'       => '</div>',
				'show_browse' => false,
			) );
			?>
		</nav>
<?php
	}

endif;

if( ! function_exists( 'saaya_innerpage_header_end' ) ) :

	/**
	 * function to manage ending div of section
	 */

	function saaya_innerpage_header_end() {
?>
			</div><!-- .mt-container -->
		</div><!-- .custom-header -->
<?php
	}
	
endif;

add_action( 'saaya_innerpage_header', 'saaya_innerpage_header_start', 5 );
add_action( 'saaya_innerpage_header', 'saaya_innerpage_header_title', 10 );
add_action( 'saaya_innerpage_header', 'saaya_breadcrumb_content', 15 );
add_action( 'saaya_innerpage_header', 'saaya_innerpage_header_end', 20 );

/*----------------------------------------------------------------------------------------------------------------------------------*/

if( ! function_exists( 'saaya_footer_start' ) ) :

	/**
	 * function to start footer wrapper
	 */
	function saaya_footer_start() {
		echo '<footer id="colophon" class="site-footer">';
	}

endif;

if( ! function_exists( 'saaya_footer_sidebar' ) ) :

	/**
	 * function to display footer widget area
	 */
	function saaya_footer_sidebar() {
		$saaya_footer_widget_option = get_theme_mod( 'saaya_enable_footer_widget_area', true );
		if( true === $saaya_footer_widget_option ) {
			get_sidebar( 'footer' );
		}
	}

endif;

if( ! function_exists( 'saaya_bottom_footer' ) ) :
	/**
	 * function to display bottom footer section
	 */
	function saaya_bottom_footer() {
?>
		<div id="bottom-footer">
            <div class="mt-container">
        		<?php
        			$saaya_enable_footer_menu = get_theme_mod( 'saaya_enable_footer_menu', true );
        			if( true === $saaya_enable_footer_menu ) {
        		?>
        				<nav id="footer-navigation" class="footer-navigation">
    						<?php
    							wp_nav_menu( array(
    								'theme_location' => 'footer_menu',
    								'menu_id'        => 'footer-menu',
    								'fallback_cb' 	 => false,
    								'depth'			 => 1
    							) );
    						?>
        				</nav><!-- #footer-navigation -->
        		<?php
        			}
        		?>
        
        		<div class="site-info">
        			<span class="mt-copyright-text">
        				<?php 
        					$saaya_footer_copyright = get_theme_mod( 'saaya_footer_copyright', __( 'Saaya', 'saaya' ) );
        					echo esc_html( $saaya_footer_copyright );
        				?>
        			</span>
        			<span class="sep"> | </span>
        				<?php
        				/* translators: 1: Theme name, 2: Theme author. */
        				printf( esc_html__( 'Theme: %1$s by %2$s.', 'saaya' ), 'saaya', '<a href="https://mysterythemes.com">Mystery Themes</a>' );
        				?>
        		</div><!-- .site-info -->
            </div><!-- .mt-container -->
        </div><!-- #bottom-footer -->
<?php
	}

endif;

if( ! function_exists( 'saaya_footer_end' ) ) :

	/**
	 * function to end footer wrapper
	 */
	function saaya_footer_end() {
		echo '</footer><!-- #colophon -->';
	}

endif;

/**
 * manage the function at saaya_footer hook
 */
add_action( 'saaya_footer', 'saaya_footer_start', 5 );
add_action( 'saaya_footer', 'saaya_footer_sidebar', 10 );
add_action( 'saaya_footer', 'saaya_bottom_footer', 15 );
add_action( 'saaya_footer', 'saaya_footer_end', 20 );

/*----------------------------------------------------------------------------------------------------------------------------------------------*/
/**
 * Manage hooks for single.php.
 */
if( !function_exists( 'saaya_single_related_post_fnc' ) ):
	/**
	 * Related posts section.
	 */
	function saaya_single_related_post_fnc(){
		$related_posts_option = get_theme_mod( 'saaya_enable_related_posts', true );
		if ( true != $related_posts_option || !is_single() ) {
			return;
		}
		get_template_part( 'template-parts/related/related', 'posts' );
	}
endif;
add_action( 'saaya_single_related_post_sec', 'saaya_single_related_post_fnc', 10 );

/**
 * Manage hooks for single.php.
 */
if( !function_exists( 'saaya_single_author_fnc' ) ):
	/**
	 * Related posts section.
	 */
	function saaya_single_author_fnc(){
		get_template_part( 'template-parts/author/author', 'box' );
	}
endif;
add_action( 'saaya_single_author_sec', 'saaya_single_author_fnc', 10 );