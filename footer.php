<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Water_Press
 */

?>
<?php if( !is_page_template( 'template-home.php' ) ){ ?>
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- #content -->
<?php } ?>

	<footer id="colophon" class="site-footer" role="contentinfo">

    <div class="container">

      <?php do_action( 'water_press_footer' ); ?>

		</div><!-- .container -->

		<a href="#page" class="scrollup"><?php esc_html_e( 'Scroll', 'water-press' ); ?></a>

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

