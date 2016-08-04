<?php
/**
 * Template part for displaying Hero Section
 *
 * @package water_press
 */

$hero_section_page       = get_theme_mod( 'water_press_hero_section_page' );

    if( $hero_section_page ){

        $hero_qry = new WP_Query( array( 'page_id' => $hero_section_page ) );

        if( $hero_qry->have_posts() ){
            while( $hero_qry->have_posts() ){
                $hero_qry->the_post();
                $hero_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
            ?>
            <?php if( has_post_thumbnail() ){?>
                <img src="<?php echo esc_url( $hero_image[0] );?>" height="auto" width="100%" alt="<?php the_title_attribute(); ?>" />
            <?php } ?>
              <h1><?php the_title(); ?></h1>
              <div><?php the_content(); ?></div>
            <?php
            }
        }
        wp_reset_postdata();
    }
