<?php
/**
 * Template part for displaying About Section
 *
 * @package water_press
 */

$about_section_page       = get_theme_mod( 'water_press_about_section_page' );
$about_section_post_one   = get_theme_mod( 'water_press_about_section_post_one' );
$about_section_post_two   = get_theme_mod( 'water_press_about_section_post_two' );
$about_section_post_three = get_theme_mod( 'water_press_about_section_post_three' );

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

    if( $about_section_post_one){
    ?>
    <div class="three-cols">
    	<div class="row">

            <?php
                $about_posts    = array( $about_section_post_one);
                $about_posts    = array_diff( array_unique( $about_posts ), array('') );
                $about_post_qry = new WP_Query( array( 'post__in' => $about_posts, 'orderby' => 'post__in', 'posts_per_page' => -1, 'ignore_sticky_posts' => true ) );
                if( $about_post_qry->have_posts() ){
                    while( $about_post_qry->have_posts() ){
                        $about_post_qry->the_post();
                        $about_post_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                    ?>
                    <div class="col">
            			<?php if( has_post_thumbnail() ){?>
                        <div class="icon-holder">
                            <img src="<?php echo esc_url( $about_post_image[0] );?>" height="100" width="100" alt="<?php the_title_attribute(); ?>" />
                        </div>
            			<?php } ?>
                        <div class="text-holder">
            				<h2 class="title"><?php the_title(); ?></h2>
            				<?php the_content(); ?>
            			</div>
            		</div>
                    <?php
                    }
                }
                wp_reset_postdata();
            ?>
    	</div>
    </div>
    <?php
    }