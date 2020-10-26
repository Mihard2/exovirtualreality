<?php
/**
 * Template part for displaying single quote post format.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mystery Themes
 * @subpackage Saaya
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php the_content(); ?>
	</div> <!-- .entry-content -->
	
	<?php saaya_post_thumbnail(); ?>

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
