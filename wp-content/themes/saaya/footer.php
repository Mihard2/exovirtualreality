<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mystery Themes
 * @subpackage Saaya
 * @since 1.0.0
 */

?>
	</div> <!-- mt-container -->
	</div><!-- #content -->

    <?php
        /**
         * saaya before footer
         * 
         * @since 1.0.0
         */
        do_action( 'saaya_before_footer' );

        /**
         * saaya footer
         * 
         * @hooked - saaya_footer_start - 5
         * @hooked - saaya_footer_sidebar - 10
         * @hooked - saaya_bottom_footer - 15
         * @hooked - saaya_footer_end - 20
         *
         * @since 1.0.0
         */
        do_action( 'saaya_footer' );


		/**
		 * saaya_scroll_top hook
		 *
		 * @hooked - saaya_scroll_top_content - 10
		 *
		 * @since 1.0.0
		 */
		do_action( 'saaya_scroll_top' );
	?>
	
</div><!-- #page -->

<?php
	/**
     * saaya_after_page hook
     *
     * @since 1.0.0
     */
    do_action( 'saaya_after_page' );

    wp_footer();
?>
</body>
</html>
