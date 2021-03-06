<?php
/**
 * Welcome page of Saaya Theme
 *
 * @package Mystery Themes
 * @subpackage Saaya
 * @since 1.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Saaya_Welcome' ) ) :

class Saaya_Welcome {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'load-themes.php', array( $this, 'admin_notice' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'about_theme_styles' ) );
		add_filter( 'admin_footer_text', array( $this, 'saaya_admin_footer_text' ) );

		add_action( 'wp_ajax_saaya_notice_dissmiss', array( $this, 'saaya_hide_notices' ) );
        add_action( 'wp_ajax_nopriv_saaya_notice_dissmiss', array( $this, 'saaya_hide_notices' ) );
	}

	/**
	 * Add admin menu.
	 */
	public function admin_menu() {
		$theme = wp_get_theme( get_template() );

		$page = add_theme_page( esc_html__( 'Welcome', 'saaya' ), esc_html__( 'Welcome', 'saaya' ), 'activate_plugins', 'saaya-welcome', array( $this, 'welcome_screen' ) );
	}

	/**
	 * Enqueue styles.
	 */
	public function about_theme_styles( $hook ) {
		if( 'appearance_page_saaya-welcome' != $hook && 'themes.php' != $hook ) {
			return;
		}
		global $saaya_theme_version;

		wp_enqueue_style( 'welcome-theme-style', get_template_directory_uri() . '/inc/welcome/welcome.css', array(), $saaya_theme_version );

		wp_enqueue_script( 'welcome-theme-script', get_template_directory_uri() . '/inc/welcome/welcome.js', array('jquery'), esc_attr( $saaya_theme_version ), true );
	}

	/**
	 * Add admin notice.
	 */
	public function admin_notice() {
		global $pagenow;

		// Let's bail on theme activation.
		if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );

		// No option? Let run the notice wizard again..
		} elseif( ! get_option( 'saaya_admin_notice_welcome' ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
		}
	}

	/**
	 * Hide a notice if the GET variable is set.
	 */
	public function saaya_hide_notices() {
		$output = array();
        $output['status'] = false;

        $wpnonce = ( isset( $_GET['_wpnonce'] ) ) ? esc_attr( wp_unslash( $_GET['_wpnonce'] ) ) : '';

        if ( ! wp_verify_nonce( $wpnonce, 'saaya_dismiss_welcome_nonce' ) ) {
        	wp_send_json( $output );
        }

        update_option( 'saaya_admin_notice_welcome', 1 );

        $output['status'] = true;

        wp_send_json( $output );
	}

	/**
	 * Show welcome notice.
	 */
	public function welcome_notice() {
		$theme 		= wp_get_theme( get_template() );
		$theme_name = $theme->get( 'Name' );
?>
		<div id="mt-theme-message" class="updated saaya-message notice is-dismissible" data-nonce="<?php echo esc_attr( wp_create_nonce( 'saaya_dismiss_welcome_nonce' ) ); ?>">
			<h2 class="welcome-title"><?php printf( esc_html__( 'Welcome to %s', 'saaya' ), $theme_name ); ?></h2>
			<p><?php printf( esc_html__( 'Welcome! Thank you for choosing %1$s! To fully take advantage of the best our theme can offer please make sure you visit our %2$s welcome page %3$s.', 'saaya' ), esc_html( $theme_name ), '<a href="' . esc_url( admin_url( 'themes.php?page=saaya-welcome' ) ) . '">', '</a>' ); ?></p>
			<p><a class="button button-primary button-hero" href="<?php echo esc_url( admin_url( 'themes.php?page=saaya-welcome' ) ); ?>"><?php printf( esc_html__( 'Get started with %1$s', 'saaya' ), esc_html( $theme_name ) ); ?></a></p>
		</div>
<?php
	}

	/**
	 * Intro text/links shown to all about pages.
	 *
	 * @access private
	 */
	private function intro() {
		global $saaya_theme_version;
		$theme = wp_get_theme( get_template() );

		$theme_name = $theme->get( 'Name' );
		$theme_description = $theme->get( 'Description' );
		$theme_uri = $theme->get( 'ThemeURI' );
		$author_uri = $theme->get( 'AuthorURI' );
		$author_name = $theme->get( 'Author' );
?>
		<div class="theme-info-wrapper">
			<div class="saaya-theme-info">
				<h1> <?php printf( esc_html__( 'About %1$s', 'saaya' ), $theme_name ); ?> </h1>
				<div class="author-credit">
					<span class="theme-version"><?php printf( esc_html__( 'Version: %1$s', 'saaya' ), $saaya_theme_version ); ?></span>
					<span class="author-link"><?php printf( wp_kses_post( 'By <a href="%1$s" target="_blank">%2$s</a>', 'saaya' ), $author_uri, $author_name ); ?></span>
				</div>
				<div class="welcome-description-wrap">
					<div class="about-text"><?php echo wp_kses_post( $theme_description ); ?></div>

					<div class="saaya-screenshot">
						<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.png'; ?>" />
					</div>
				</div>
			</div><!-- .saaya-theme-info -->

			<p class="saaya-actions">
				<a href="<?php echo esc_url( $theme_uri ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'saaya' ); ?></a>

				<a href="<?php echo esc_url( apply_filters( 'saaya_demo_url', 'https://demo.mysterythemes.com/saaya-landing/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View Demo', 'saaya' ); ?></a>

				<a href="<?php echo esc_url( apply_filters( 'saaya_pro_theme_url', 'https://mysterythemes.com/wp-themes/saaya-pro/' ) ); ?>" class="button button-primary docs" target="_blank"><?php esc_html_e( 'View PRO version', 'saaya' ); ?></a>

				<a href="<?php echo esc_url( apply_filters( 'saaya_rating_url', 'https://wordpress.org/support/theme/saaya/reviews/?filter=5' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'Rate this theme', 'saaya' ); ?></a>

				<a href="<?php echo esc_url( apply_filters( 'saaya_wp_tutorials', 'https://wpallresources.com/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'More Tutorials', 'saaya' ); ?></a>
			</p>

			<div class="nav-tab-wrapper">
				<a class="nav-tab <?php if ( empty( $_GET['tab'] ) && $_GET['page'] == 'saaya-welcome' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'saaya-welcome' ), 'themes.php' ) ) ); ?>">
					<?php echo esc_html( $theme->display( 'Name' ) ); ?>
				</a>
				
				<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'free_vs_pro' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'saaya-welcome', 'tab' => 'free_vs_pro' ), 'themes.php' ) ) ); ?>">
					<?php esc_html_e( 'Free Vs Pro', 'saaya' ); ?>
				</a>

				<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'more_themes' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'saaya-welcome', 'tab' => 'more_themes' ), 'themes.php' ) ) ); ?>">
					<?php esc_html_e( 'More Themes', 'saaya' ); ?>
				</a>

				<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'changelog' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'saaya-welcome', 'tab' => 'changelog' ), 'themes.php' ) ) ); ?>">
					<?php esc_html_e( 'Changelog', 'saaya' ); ?>
				</a>
			</div>
		</div><!-- .theme-info-wrapper -->
<?php
	}

	/**
	 * Welcome screen page.
	 */
	public function welcome_screen() {
		$current_tab = empty( $_GET['tab'] ) ? 'about' : sanitize_title( $_GET['tab'] );

		// Look for a {$current_tab}_screen method.
		if ( is_callable( array( $this, $current_tab . '_screen' ) ) ) {
			return $this->{ $current_tab . '_screen' }();
		}

		// Fallback to about screen.
		return $this->about_screen();
	}

	/**
	 * Output the about screen.
	 */
	public function about_screen() {
		$theme 		= wp_get_theme( get_template() );
		$theme_name = $theme->get( 'Name' );
	?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<div class="changelog">
				<div class="under-the-hood two-col">
					<div class="col">
						<h3><?php esc_html_e( 'Theme Customizer', 'saaya' ); ?></h3>
						<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'saaya' ) ?></p>
						<p><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-secondary"><?php esc_html_e( 'Customize', 'saaya' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Documentation', 'saaya' ); ?></h3>
						<p><?php esc_html_e( 'Please view our documentation page to setup the theme.', 'saaya' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://docs.mysterythemes.com/saaya' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Documentation', 'saaya' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Got theme support question?', 'saaya' ); ?></h3>
						<p><?php esc_html_e( 'Please put it in our dedicated support forum.', 'saaya' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://mysterythemes.com/support/forum/themes/free-themes/' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Support', 'saaya' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Need more features?', 'saaya' ); ?></h3>
						<p><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'saaya' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://mysterythemes.com/wp-themes/saaya-pro/' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'View PRO version', 'saaya' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Have you need customization?', 'saaya' ); ?></h3>
						<p><?php esc_html_e( 'Please send message with your requirement.', 'saaya' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://mysterythemes.com/customization/' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Customization', 'saaya' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php printf( esc_html( 'Translate %1$s', 'saaya' ), esc_html( $theme_name ) ); ?></h3>
						<p><?php esc_html_e( 'Click below to translate this theme into your own language.', 'saaya' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://translate.wordpress.org/projects/wp-themes/saaya' ); ?>" class="button button-secondary" target="_blank"><?php printf( esc_html( 'Translate %1$s', 'saaya' ), esc_html( $theme_name ) ); ?></a></p>
					</div>
				</div>
			</div><!-- .changelog -->

			<div class="return-to-dashboard saaya">
				<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
					<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
						<?php is_multisite() ? esc_html_e( 'Return to Updates', 'saaya' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'saaya' ); ?>
					</a> |
				<?php endif; ?>
				<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'saaya' ) : esc_html_e( 'Go to Dashboard', 'saaya' ); ?></a>
			</div><!-- .return-to-dashboard -->
		</div><!-- .about-wrap -->
	<?php
	}

	/**
	 * Output the more themes screen
	 */
	public function more_themes_screen() {
?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>
			<div class="theme-browser rendered">
				<div class="themes wp-clearfix">
					<?php
						// Set the argument array with author name.
						$args = array(
							'author' => 'mysterythemes',
							'per_page' => 100
						);
						// Set the $request array.
						$request = array(
							'body' => array(
								'action'  => 'query_themes',
								'request' => serialize( (object)$args )
							)
						);
						$themes = $this->saaya_get_themes( $request );
						if( !is_wp_error( $themes ) ) {
							$active_theme = wp_get_theme()->get( 'Name' );
							$counter = 1;

							// For currently active theme.
							foreach ( $themes->themes as $theme ) {
								if( $active_theme == $theme->name ) {
					?>

									<div id="<?php echo esc_attr( $theme->slug ); ?>" class="theme active">
										<div class="theme-screenshot">
											<img src="<?php echo esc_url( $theme->screenshot_url ); ?>"/>
										</div>
										<h3 class="theme-name" id="saaya-name"><strong><?php esc_html_e( 'Active', 'saaya' ); ?></strong>: <?php echo esc_html( $theme->name ); ?></h3>
										<div class="theme-actions">
											<a class="button button-primary customize load-customize hide-if-no-customize" href="<?php echo esc_url( get_site_url(). '/wp-admin/customize.php' ); ?>"><?php esc_html_e( 'Customize', 'saaya' ); ?></a>
										</div>
									</div><!-- .theme active -->
					<?php
								$counter++;
								break;
								}
							}

							// For all other themes.
							foreach ( $themes->themes as $theme ) {
								if( $active_theme != $theme->name ) {
									// Set the argument array with author name.
									$args = array(
										'slug' => esc_attr( $theme->slug ),
									);
									// Set the $request array.
									$request = array(
										'body' => array(
											'action'  => 'theme_information',
											'request' => serialize( (object)$args )
										)
									);
									$theme_details = $this->saaya_get_themes( $request );
									if( empty( $theme_details->template ) ) {
							?>
										<div id="<?php echo esc_attr( $theme->slug ); ?>" class="theme">
											<div class="theme-screenshot">
												<img src="<?php echo esc_url( $theme->screenshot_url ); ?>"/>
											</div>

											<h3 class="theme-name"><?php echo esc_html( $theme->name ); ?></h3>

											<div class="theme-actions">
												<?php if( wp_get_theme( $theme->slug )->exists() ) { ?>											
													<!-- Activate Button -->
													<a  class="button button-secondary activate"
														href="<?php echo esc_url( wp_nonce_url( admin_url( 'themes.php?action=activate&amp;stylesheet=' . urlencode( $theme->slug ) ), 'switch-theme_' . esc_attr( $theme->slug ) ) ); ?>" ><?php esc_html_e( 'Activate', 'saaya' ) ?></a>
												<?php } else {
													// Set the install url for the theme.
													$install_url = add_query_arg( array(
															'action' => 'install-theme',
															'theme'  => esc_attr( $theme->slug ),
														), self_admin_url( 'update.php' ) );
												?>
													<!-- Install Button -->
													<a data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_attr( 'Downloaded ', 'saaya' ). number_format( $theme_details->downloaded ).' '.esc_attr( 'times', 'saaya' ); ?>" class="button button-secondary activate" href="<?php echo esc_url( wp_nonce_url( $install_url, 'install-theme_' . $theme->slug ) ); ?>" ><?php esc_html_e( 'Install Now', 'saaya' ); ?></a>
												<?php } ?>

												<a class="button button-primary load-customize hide-if-no-customize" target="_blank" href="<?php echo esc_url( $theme->preview_url ); ?>"><?php esc_html_e( 'Live Preview', 'saaya' ); ?></a>
											</div>
										</div><!-- .theme -->
					<?php
									}
								}
							}
						}
					?>
				</div>
			</div><!-- .mt-theme-holder -->
		</div><!-- .wrap.about-wrap -->
<?php
	}

	/** 
	 * Get all our themes by using API.
	 */
	private function saaya_get_themes( $request ) {

		// Generate a cache key that would hold the response for this request:
		$key = 'saaya_' . md5( serialize( $request ) );

		// Check transient. If it's there - use that, if not re fetch the theme
		if ( false === ( $themes = get_transient( $key ) ) ) {

			// Transient expired/does not exist. Send request to the API.
			$response = wp_remote_post( 'http://api.wordpress.org/themes/info/1.0/', $request );

			// Check for the error.
			if ( !is_wp_error( $response ) ) {

				$themes = unserialize( wp_remote_retrieve_body( $response ) );

				if ( !is_object( $themes ) && !is_array( $themes ) ) {

					// Response body does not contain an object/array
					return new WP_Error( 'theme_api_error', 'An unexpected error has occurred' );
				}

				// Set transient for next time... keep it for 24 hours should be good
				set_transient( $key, $themes, 60 * 60 * 24 );
			}
			else {
				// Error object returned
				return $response;
			}
		}
		return $themes;
	}
	
	/**
	 * Output the changelog screen.
	 */
	public function changelog_screen() {
		global $wp_filesystem;

	?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<h4><?php esc_html_e( 'View changelog below:', 'saaya' ); ?></h4>

			<?php
				$changelog_file = apply_filters( 'saaya_changelog_file', get_template_directory() . '/readme.txt' );

				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = $this->parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
			?>
		</div>
	<?php
	}

	/**
	 * Parse changelog from readme file.
	 * @param  string $content
	 * @return string
	 */
	private function parse_changelog( $content ) {
		$matches   = null;
		$regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
		$changelog = '';

		if ( preg_match( $regexp, $content, $matches ) ) {
			$changes = explode( '\r\n', trim( $matches[1] ) );

			$changelog .= '<pre class="changelog">';

			foreach ( $changes as $index => $line ) {
				$changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
			}

			$changelog .= '</pre>';
		}

		return wp_kses_post( $changelog );
	}

	/**
	 * Output the free vs pro screen.
	 */
	public function free_vs_pro_screen() {
?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<h4><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'saaya' ); ?></h4>

			<table>
				<thead>
					<tr>
						<th class="table-feature-title"><h3><?php esc_html_e( 'Features', 'saaya' ); ?></h3></th>
						<th><h3><?php esc_html_e( 'Saaya', 'saaya' ); ?></h3></th>
						<th><h3><?php esc_html_e( 'Saaya Pro', 'saaya' ); ?></h3></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><h3><?php esc_html_e( 'Price', 'saaya' ); ?></h3></td>
						<td><?php esc_html_e( 'Free', 'saaya' ); ?></td>
						<td><?php esc_html_e( '$55', 'saaya' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Import Demo Data', 'saaya' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Pre Loaders Layouts', 'saaya' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Header Layouts', 'saaya' ); ?></h3></td>
						<td><?php esc_html_e( '1', 'saaya' ); ?></td>
						<td><?php esc_html_e( '4', 'saaya' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Multiple Layouts', 'saaya' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Google Fonts', 'saaya' ); ?></h3></td>
						<td><?php esc_html_e( '2', 'saaya' );?></td>
						<td><?php esc_html_e( '600+', 'saaya' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'WordPress Page Builder Compatible', 'saaya' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Custom 404 Page', 'saaya' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Typography Options', 'saaya' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Footer Layout Options', 'saaya' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'WooCommerce Plugin Compatible', 'saaya' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'GDPR Compatible', 'saaya' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td class="btn-wrapper">
							<a href="<?php echo esc_url( apply_filters( 'saaya_pro_theme_url', 'https://mysterythemes.com/wp-themes/saaya-pro/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'Buy Pro', 'saaya' ); ?></a>
						</td>
					</tr>
				</tbody>
			</table>

		</div>
<?php
	}
	/**
     * Display custom text on theme welcome page
     *
     * @param string $text
     */
    public function saaya_admin_footer_text( $text ) {
        $screen = get_current_screen();

        if ( 'appearance_page_saaya-welcome' == $screen->id ) {

        	$theme = wp_get_theme( get_template() );
			$theme_name = $theme->get( 'Name' );

            $text = sprintf( __( 'If you like <strong>%1$s</strong> please leave us a %2$s rating. A huge thank you from <strong>Mystery Themes</strong> in advance!', 'saaya' ), esc_html( $theme_name ), '<a href="https://wordpress.org/support/theme/saaya/reviews/?filter=5" class="theme-rating" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a>' );

        }

        return $text;
    }
}

endif;

return new Saaya_Welcome();