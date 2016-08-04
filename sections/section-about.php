<?php
/**
 * Template part for displaying About Section
 *
 * @package water_press
 */

$about_section_page       = get_theme_mod( 'water_press_about_section_page' );

    if( $about_section_page ){

        $about_qry = new WP_Query( array( 'page_id' => $about_section_page ) );

        if( $about_qry->have_posts() ){
            while( $about_qry->have_posts() ){
                $about_qry->the_post();
            ?>
                <header class="heading">
                	<h1><?php the_title(); ?></h1>
                	<?php the_content(); ?>
                </header>
            <?php
            }
        }
        wp_reset_postdata();
    }
