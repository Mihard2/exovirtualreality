<?php
/**
 * Template part for displaying related post
 *
 * @package Mystery Themes
 * @subpackage Saaya
 * @since 1.0.0
 */

if( has_post_thumbnail() ) {
    $post_class = 'has-thumbnail wow fadeInUp';
} else {
    $post_class = 'no-thumbnail wow fadeInUp';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1"> <?php saaya_post_thumbnail(); ?> </a>

	<div class="entry-cat">
		<?php 
			saaya_posted_on();
			saaya_article_categories_list();
		?>
	</div>

	<header class="entry-header">

		<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>

	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div>	
	<footer class="entry-footer">

		<?php
			$saaya_archive_read_more = get_theme_mod( 'saaya_archive_read_more', __( 'Discover', 'saaya' ) );
			saaya_entry_footer();
		?>
		<a href="<?php the_permalink(); ?>" class="mt-readmore-btn"><?php echo esc_html( $saaya_archive_read_more ); ?> <i class="fa fa-long-arrow-right"></i></a>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
