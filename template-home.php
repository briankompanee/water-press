<?php
/**
 * Template Name: Home Page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package water_press
 */

get_header();

  $enabled_sections = water_press_get_sections();

  if( is_array( $enabled_sections ) ){
      foreach( $enabled_sections as $section ){

        if( ( $section['id'] == 'cta1' ) || ( $section['id'] == 'cta2' ) ){
    ?>

              <section id="<?php echo esc_attr( $section['id'] ); ?>" class="cta-block">
          		<div class="container">
                      <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                  </div>
              </section>

    <?php }elseif( $section['id'] == 'about' ) { ?>

              <section id="<?php echo esc_attr( $section['id'] ); ?>" class="about">
          		<div class="container">
                      <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                  </div>
              </section>

    <?php }elseif( $section['id'] == 'blog' ){ ?>

              <section id="<?php echo esc_attr( $section['id'] ); ?>" class="skills">
          		<div class="container">
                      <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                  </div>
              </section>

    <?php }else{ ?>

              <section id="<?php echo esc_attr( $section['id'] ); ?>">
          		<div class="container">
                      <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                  </div>
              </section>

    <?php }
      }
  }
get_footer();