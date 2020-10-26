<?php
/**
 * Template
 *
 * @package Fusion-White-Label-Branding
 */

?>
<div class="wrap about-wrap fusion-white-label-branding-wrap">

	<?php Fusion_White_Label_Branding_Admin::header(); ?>
	<div class="fusion-white-label-branding-support-content">
		<?php
		$theme_fusion_url = 'https://theme-fusion.com/';
		?>
		<div class="fusion-white-label-branding-important-notice">
			<?php /* translators: %1$s: Avada, %2$s: link, %3%s: link */ ?>
			<p class="about-description"><?php printf( __( 'Fusion White Label Branding is bundled with %1$s and is therefore covered by the 6 months of free support for every theme license you purchase. Theme support can be <a %2$s>extended through subscriptions</a> via ThemeForest. All support for Fusion White Label Branding is handled via the the support center on our company site. To access it, you must first setup an account by <a %3$s>following these steps</a>. If you purchased using Envato\'s guest checkout <a href="%4$s" target="_blank">please view this link</a> to create an Envato account before receiving item support. Below are all the resources we offer in our support center and community.', 'fusion-white-label-branding' ), 'Avada', 'a href="https://help.market.envato.com/hc/en-us/articles/207886473-Extending-and-Renewing-Item-Support" target="_blank"', 'href="https://theme-fusion.com/avada-doc/getting-started/avada-theme-support/" target="_blank"', 'https://help.market.envato.com/hc/en-us/articles/217397206-A-Guide-to-Using-Guest-Checkout' ); // WPCS: XSS ok. ?></p>
			<p><a href="<?php echo esc_url( $theme_fusion_url ); ?>avada-doc/getting-started/avada-theme-support/" class="button button-large button-primary fusion-white-label-branding-large-button" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Create A Support Account', 'fusion-white-label-branding' ); ?></a></p>
		</div>

		<div class="fusion-white-label-branding-registration-steps">

			<div class="col three-col">
				<div class="col">
					<h3 class="title"><span class="dashicons dashicons-lightbulb"></span><?php esc_attr_e( 'Starter Guide', 'Avada' ); ?></h3>
					<p><?php esc_attr_e( 'We understand that it can be a daunting process getting started with WordPress. In light of this, we have prepared a starter pack for you, which includes all you need to know.', 'Avada' ); ?></p>
					<a href="<?php echo esc_url_raw( $theme_fusion_url ) . 'support/starter-guide/'; ?>" class="button button-large button-primary avada-large-button" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Starter Guide', 'Avada' ); ?></a>
				</div>
				<div class="col">
					<h3 class="title"><span class="dashicons dashicons-book"></span><?php esc_attr_e( 'Documentation', 'Avada' ); ?></h3>
					<p><?php esc_attr_e( 'This is the place to go to reference different aspects of the theme. Our online documentaiton is an incredible resource for learning the ins and outs of using Avada.', 'Avada' ); ?></p>
					<a href="<?php echo esc_url_raw( $theme_fusion_url ) . 'support/'; ?>" class="button button-large button-primary avada-large-button" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Documentation', 'Avada' ); ?></a>
				</div>
				<div class="col last-feature">
					<h3 class="title"><span class="dashicons dashicons-sos"></span><?php esc_attr_e( 'Submit A Ticket', 'Avada' ); ?></h3>
					<p><?php esc_attr_e( 'We offer excellent support through our advanced ticket system. Make sure to register your purchase first to access our support services and other resources.', 'Avada' ); ?></p>
					<a href="<?php echo esc_url_raw( $theme_fusion_url ) . 'support/submit-a-ticket/'; ?>" class="button button-large button-primary avada-large-button" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Submit a ticket', 'Avada' ); ?></a>
				</div>
				<div class="col">
					<h3 class="title"><span class="dashicons dashicons-format-video"></span><?php esc_attr_e( 'Video Tutorials', 'Avada' ); ?></h3>
					<p><?php esc_attr_e( 'Nothing is better than watching a video to learn. We have a growing library of narrated HD video tutorials to help teach you the different aspects of using Avada.', 'Avada' ); ?></p>
					<a href="<?php echo esc_url_raw( $theme_fusion_url ) . 'documentation/avada/videos/'; ?>" class="button button-large button-primary avada-large-button" target="_blank"><?php esc_html_e( 'Watch Videos', 'Avada' ); ?></a>
				</div>
				<div class="col">
					<h3 class="title"><span class="dashicons dashicons-groups"></span><?php esc_attr_e( 'Community Forum', 'Avada' ); ?></h3>
					<p><?php esc_attr_e( 'We also have a community forum for user to user interactions. Ask another Avada user! Please note that ThemeFusion does not provide product support here.', 'Avada' ); ?></p>
					<a href="<?php echo esc_url_raw( $theme_fusion_url ) . 'community/forum/'; ?>" class="button button-large button-primary avada-large-button" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Community Forum', 'Avada' ); ?></a>
				</div>
				<div class="col last-feature">
					<h3 class="title"><span class="dashicons dashicons-facebook"></span><?php esc_attr_e( 'Facebook Group', 'Avada' ); ?></h3>
					<p><?php esc_attr_e( 'We have an amazing Facebook Group! Share with other Avada users and help grow our community. Please note, ThemeFusion does not provide support here.', 'Avada' ); ?></p>
					<a href="https://www.facebook.com/groups/AvadaUsers/" class="button button-large button-primary avada-large-button" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Facebook Group', 'Avada' ); ?></a>
				</div>
			</div>
		</div>

		<div class="fusion-white-label-branding-faq-content">
			<div class="fusion-white-label-branding-admin-toggle">
				<div class="fusion-white-label-branding-admin-toggle-heading">
					<h3><?php esc_html_e( 'What Is The Fusion White Label Branding?', 'fusion-white-label-branding' ); ?></h3>
					<span class="fusion-white-label-branding-admin-toggle-icon fusion-plus"></span>
				</div>
				<div class="fusion-white-label-branding-admin-toggle-content">
					<?php /* translators: %1$s: Avada, %2$s: Fusion Builder */ ?>
					<?php printf( esc_html__( 'Fusion White Label Branding is an add-on for %1$s that allows you to alter the default %1$s branding, WordPress menus, user access, %2$s settings and the default WordPress login screen, to make it your own.', 'fusion-white-label-branding' ), 'Avada', 'Fusion Builder' ); ?><br/><br/>
				</div>
			</div>

			<div class="fusion-white-label-branding-admin-toggle">
				<div class="fusion-white-label-branding-admin-toggle-heading">
					<h3><?php esc_html_e( 'How Do I Get Support For The Fusion White Label Branding?', 'fusion-white-label-branding' ); ?></h3>
					<span class="fusion-white-label-branding-admin-toggle-icon fusion-plus"></span>
				</div>
				<div class="fusion-white-label-branding-admin-toggle-content">
					<?php /* translators: %1$s: Avada, %2$s: URL, %3$s: _blank. */ ?>
					<?php printf( __( 'Fusion White Label Branding is an add-on that is purpose-built for the %1$s WordPress theme, version 5.4 and newer. For detailed documentation please <a href="%2$s" target="%3$s">click here</a> or if you require support please visit our online support center.', 'fusion-white-label-branding' ), 'Avada', 'https://theme-fusion.com/avada-doc/getting-started/avada-theme-support/', '_blank' ); // WPCS: XSS ok. ?>
				</div>
			</div>

			<div class="fusion-white-label-branding-admin-toggle">
				<div class="fusion-white-label-branding-admin-toggle-heading">
					<h3><?php esc_html_e( 'Can I Use Fusion White Label Branding To Re-brand Other Themes?', 'fusion-white-label-branding' ); ?></h3>
					<span class="fusion-white-label-branding-admin-toggle-icon fusion-plus"></span>
				</div>
				<div class="fusion-white-label-branding-admin-toggle-content">
					<?php /* translators: Avada */ ?>
					<?php printf( esc_html__( 'Unfortunately, that is not possible. The Fusion White Label Branding add-on is purpose-built for the %s WordPress theme only.', 'fusion-white-label-branding' ), 'Avada' ); ?>
				</div>
			</div>

			<div class="fusion-white-label-branding-admin-toggle">
				<div class="fusion-white-label-branding-admin-toggle-heading">
					<?php /* translators: Avada */ ?>
					<h3><?php printf( esc_html__( 'I Am Running An Old Version of %s, Can I Use The Fusion White Label Branding?', 'fusion-white-label-branding' ), 'Avada' ); ?></h3>
					<span class="fusion-white-label-branding-admin-toggle-icon fusion-plus"></span>
				</div>
				<div class="fusion-white-label-branding-admin-toggle-content">
					<?php /* translators: Avada */ ?>
					<?php printf( esc_html__( 'The Fusion White Label Branding add-on compatibility is %2$s guaranteed for %1$s 5.4 and newer only. Various facets of the add-on will not work as expected with older versions of %1$s.', 'fusion-white-label-branding' ), 'Avada', '100%' ); ?>
				</div>
			</div>
		</div>		
	</div>
	<?php Fusion_White_Label_Branding_Admin::footer(); ?>
</div>
