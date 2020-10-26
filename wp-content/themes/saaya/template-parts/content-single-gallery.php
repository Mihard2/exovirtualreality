<?php
/**
 * Template part for displaying single link post format
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mystery Themes
 * @subpackage Saaya
 * @since 1.0.0
 */

$gallery                = get_post_gallery( get_the_ID(), false );
$gallery_attachment_ids = explode( ',', $gallery['ids'] );
$layout_style           = saaya_is_sidebar_layout();
$thumbnail_size         = 'post-thumbnail';

if ( ( 'no-sidebar' === $layout_style || 'no-sidebar-center' === $layout_style ) ) {
	$thumbnail_size = 'saaya-full-width';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( ! empty( $gallery_attachment_ids ) ) { ?>

		<div class="post-format-media post-format-gallery post-format-media--gallery">
			<div class="mt-gallery-slider">
				<?php foreach ( $gallery_attachment_ids as $gallery_attachment_id ) { ?>
					<li>
						<?php echo wp_get_attachment_image( $gallery_attachment_id, $thumbnail_size ); // WPCS xss ok. ?>
					</li>
				<?php } ?>
			</div><!-- .mt-gallery-slider -->
		</div><!-- .post-format-gallery -->

	<?php } else { saaya_post_thumbnail(); } ?>

	<div class="entry-cat">
		<?php 
			saaya_posted_on();
			saaya_article_categories_list();
			saaya_posted_by();
			saaya_posted_comments();
		?>
	</div>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div> <!-- .entry-content -->

	<footer class="entry-footer">
		<?php saaya_entry_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php
		/**
		 * hook - saaya_single_author_sec
		 * 
		 * @hooked - saaya_single_author_fnc 
		 */
		do_action( 'saaya_single_author_sec' );
	?>
</article><!-- #post-<?php the_ID(); ?> -->
