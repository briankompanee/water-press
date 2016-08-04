<?php
/**
 * Water Press Theme Customizer.
 *
 * https://github.com/WPTRT/code-examples/blob/master/customizer/add-controls-core-basic.php
 *
 * @package Water_Press
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function water_press_customize_register( $wp_customize ) {

  /* Option list of all categories */
  $args = array(
   'type'         => 'post',
   'orderby'      => 'name',
   'order'        => 'ASC',
   'hide_empty'   => 1,
   'hierarchical' => 1,
   'taxonomy'     => 'category'
  );
  $option_categories = array();
  $category_lists = get_categories( $args );
  $option_categories[''] = __( 'Choose Category', 'water-press' );
  foreach( $category_lists as $category ){
      $option_categories[$category->term_id] = $category->name;
  }

  /* Option list of all post */
  $options_posts = array();
  $options_posts_obj = get_posts('posts_per_page=-1');
  $options_posts[''] = __( 'Choose Post', 'water-press' );
  foreach ( $options_posts_obj as $posts ) {
  	$options_posts[$posts->ID] = $posts->post_title;
  }

  /* Option list of all pages */
  $options_pages = array();
  $options_pages_obj = get_posts('posts_per_page=-1&post_type=page');
  $options_pages[''] = __( 'Choose Page', 'water-press' );
  foreach ( $options_pages_obj as $pages ) {
  	$options_pages[$pages->ID] = $pages->post_title;
  }

  /** Default Settings */
  $wp_customize->add_panel(
      'wp_default_panel',
       array(
          'priority'      => 10,
          'capability'    => 'edit_theme_options',
          'theme_supports'=> '',
          'title'         => __( 'Default Settings', 'water-press' ),
          'description'   => __( 'Default section provided by WordPress customizer.', 'water-press' ),
      )
  );

  $wp_customize->get_section( 'title_tagline' )->panel     = 'wp_default_panel';
  $wp_customize->get_section( 'colors' )->panel            = 'wp_default_panel';
  $wp_customize->get_section( 'background_image' )->panel  = 'wp_default_panel';
  $wp_customize->get_section( 'static_front_page' )->panel = 'wp_default_panel';


  $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
  $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
  $wp_customize->get_setting( 'background_color' )->transport = 'refresh';
  $wp_customize->get_setting( 'background_image' )->transport = 'refresh';


/** Home Page Settings */
  $wp_customize->add_panel(
      'water_press_home_page_settings',
       array(
          'priority' => 30,
          'capability' => 'edit_theme_options',
          'title' => __( 'Home Page Settings', 'water-press' ),
          'description' => __( 'Customize Home Page Settings', 'water-press' ),
      )
  );

/** About Section */
  $wp_customize->add_section(
      'water_press_about_section',
      array(
          'title' => __( 'About Section', 'water-press' ),
          'priority' => 20,
          'panel' => 'water_press_home_page_settings',
      )
  );

  /** Enable/Disable About Section */
  $wp_customize->add_setting(
      'water_press_ed_about_section',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_checkbox',
      )
  );

  $wp_customize->add_control(
      'water_press_ed_about_section',
      array(
          'label' => __( 'Enable About Section', 'water-press' ),
          'section' => 'water_press_about_section',
          'type' => 'checkbox',
      )
  );

  /** About Section Menu Title */
  $wp_customize->add_setting(
      'water_press_about_section_menu_title',
      array(
          'default' => '',
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_about_section_menu_title',
      array(
          'label' => __( 'About Section Menu Title', 'water-press' ),
          'section' => 'water_press_about_section',
          'type' => 'text',
      )
  );

  /** Select Page */
  $wp_customize->add_setting(
      'water_press_about_section_page',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_select',
      )
  );

  $wp_customize->add_control(
      'water_press_about_section_page',
      array(
          'label' => __( 'Select Page', 'water-press' ),
          'section' => 'water_press_about_section',
          'type' => 'select',
          'choices' => $options_pages,
      )
  );

  /** Select Post One */
  $wp_customize->add_setting(
      'water_press_about_section_post_one',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_select',
      )
  );

  $wp_customize->add_control(
      'water_press_about_section_post_one',
      array(
          'label' => __( 'Select Post One', 'water-press' ),
          'section' => 'water_press_about_section',
          'type' => 'select',
          'choices' => $options_posts,
      )
  );
/** End Of About Section Settings */

/** First Promotional Block */
  $wp_customize->add_section(
      'water_press_cta1_section',
      array(
          'title' => __( 'First Promotional Block Section', 'water-press' ),
          'priority' => 40,
          'panel' => 'water_press_home_page_settings',
      )
  );

  /** Enable/Disable First Promotional Block Section */
  $wp_customize->add_setting(
      'water_press_ed_cta1_section',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_checkbox',
      )
  );

  $wp_customize->add_control(
      'water_press_ed_cta1_section',
      array(
          'label' => __( 'Enable Promotional Block Section', 'water-press' ),
          'section' => 'water_press_cta1_section',
          'type' => 'checkbox',
      )
  );

  /** Promotional Block Section Title */
  $wp_customize->add_setting(
      'water_press_cta1_section_title',
      array(
          'default' => '',
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_cta1_section_title',
      array(
          'label' => __( 'Promotional Block Section Title', 'water-press' ),
          'section' => 'water_press_cta1_section',
          'type' => 'text',
      )
  );

  /** Promotional Block Section Content */
  $wp_customize->add_setting(
      'water_press_cta1_section_content',
      array(
          'default' => '',
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_cta1_section_content',
      array(
          'label' => __( 'Promotional Block Section Content', 'water-press' ),
          'section' => 'water_press_cta1_section',
          'type' => 'textarea',
      )
  );

  /** Promotional Block Section Button */
  $wp_customize->add_setting(
      'water_press_cta1_section_button',
      array(
          'default' => '',
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_cta1_section_button',
      array(
          'label' => __( 'Promotional Block Section Button', 'water-press' ),
          'section' => 'water_press_cta1_section',
          'type' => 'text',
      )
  );

  /** Promotional Block Section Button Url */
  $wp_customize->add_setting(
      'water_press_cta1_section_button_url',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_url',
      )
  );

  $wp_customize->add_control(
      'water_press_cta1_section_button_url',
      array(
          'label' => __( 'Promotional Block Section Button Url', 'water-press' ),
          'section' => 'water_press_cta1_section',
          'type' => 'text',
      )
  );
/** End Of First Promotional Block Section Settings */

/** Blog Section */
  $wp_customize->add_section(
      'water_press_blog_section',
      array(
          'title' => __( 'Blog Section', 'water-press' ),
          'priority' => 80,
          'panel' => 'water_press_home_page_settings',
      )
  );

  /** Enable/Disable Blog Section */
  $wp_customize->add_setting(
      'water_press_ed_blog_section',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_checkbox',
      )
  );

  $wp_customize->add_control(
      'water_press_ed_blog_section',
      array(
          'label' => __( 'Enable Blog Section', 'water-press' ),
          'section' => 'water_press_blog_section',
          'type' => 'checkbox',
      )
  );

  /** Blog Section Menu Title */
  $wp_customize->add_setting(
      'water_press_blog_section_menu_title',
      array(
          'default' => '',
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_blog_section_menu_title',
      array(
          'label' => __( 'Blog Section Menu Title', 'water-press' ),
          'section' => 'water_press_blog_section',
          'type' => 'text',
      )
  );

  /** Blog Section Title */
  $wp_customize->add_setting(
      'water_press_blog_section_title',
      array(
          'default' => '',
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_blog_section_title',
      array(
          'label' => __( 'Blog Section Title', 'water-press' ),
          'section' => 'water_press_blog_section',
          'type' => 'text'
      )
  );

  /** Blog Section Content */
  $wp_customize->add_setting(
      'water_press_blog_section_content',
      array(
          'default' => '',
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_blog_section_content',
      array(
          'label' => __( 'Blog Section Content', 'water-press' ),
          'section' => 'water_press_blog_section',
          'type' => 'textarea'
      )
  );

  /** Blog View All Text */
  $wp_customize->add_setting(
      'water_press_blog_section_view_all',
      array(
          'default' => __( 'View All Blogs', 'water-press' ),
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_blog_section_view_all',
      array(
          'label' => __( 'Blog View All Text', 'water-press' ),
          'section' => 'water_press_blog_section',
          'type' => 'text',
      )
  );
/** End Of Blog Section Settings */

/** Experience Section */
  $wp_customize->add_section(
      'water_press_team_section',
      array(
          'title' => __( 'Team Section', 'water-press' ),
          'priority' => 60,
          'panel' => 'water_press_home_page_settings',
      )
  );

  /** Enable/Disable Team Section */
  $wp_customize->add_setting(
      'water_press_ed_team_section',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_checkbox',
      )
  );

  $wp_customize->add_control(
      'water_press_ed_team_section',
      array(
          'label' => __( 'Enable Team Section', 'water-press' ),
          'section' => 'water_press_team_section',
          'type' => 'checkbox',
      )
  );

  /** Team Section Menu Title */
  $wp_customize->add_setting(
      'water_press_team_section_menu_title',
      array(
          'default' => '',
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_team_section_menu_title',
      array(
          'label' => __( 'Team Section Menu Title', 'water-press' ),
          'section' => 'water_press_team_section',
          'type' => 'text',
      )
  );

  /** Select Page */
  $wp_customize->add_setting(
      'water_press_team_section_page',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_select',
      )
  );

  $wp_customize->add_control(
      'water_press_team_section_page',
      array(
          'label' => __( 'Select Page', 'water-press' ),
          'section' => 'water_press_team_section',
          'type' => 'select',
          'choices' => $options_pages,
      )
  );

  /** Select Category */
  $wp_customize->add_setting(
      'water_press_team_section_cat',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_select',
      )
  );

  $wp_customize->add_control(
      'water_press_team_section_cat',
      array(
          'label' => __( 'Select Category', 'water-press' ),
          'section' => 'water_press_team_section',
          'type' => 'select',
          'choices' => $option_categories,
      )
  );
/** End Of Experience Section Settings */

/** Portfolio Section */
  $wp_customize->add_section(
      'water_press_portfolio_section',
      array(
          'title' => __( 'Portfolio Section', 'water-press' ),
          'priority' => 50,
          'panel' => 'water_press_home_page_settings',
      )
  );

  /** Enable/Disable Portfolio Section */
  $wp_customize->add_setting(
      'water_press_ed_portfolio_section',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_checkbox',
      )
  );

  $wp_customize->add_control(
      'water_press_ed_portfolio_section',
      array(
          'label' => __( 'Enable Portfolio Section', 'water-press' ),
          'section' => 'water_press_portfolio_section',
          'type' => 'checkbox',
      )
  );

  /** Portfolio Section Menu Title */
  $wp_customize->add_setting(
      'water_press_portfolio_section_menu_title',
      array(
          'default' => '',
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_portfolio_section_menu_title',
      array(
          'label' => __( 'Portfolio Section Menu Title', 'water-press' ),
          'section' => 'water_press_portfolio_section',
          'type' => 'text',
      )
  );

  /** Select Page */
  $wp_customize->add_setting(
      'water_press_portfolio_section_page',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_select',
      )
  );

  $wp_customize->add_control(
      'water_press_portfolio_section_page',
      array(
          'label' => __( 'Select Page', 'water-press' ),
          'section' => 'water_press_portfolio_section',
          'type' => 'select',
          'choices' => $options_pages,
      )
  );

  /** Select Post One */
  $wp_customize->add_setting(
      'water_press_portfolio_section_post_one',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_select',
      )
  );

  $wp_customize->add_control(
      'water_press_portfolio_section_post_one',
      array(
          'label' => __( 'Select Post One', 'water-press' ),
          'section' => 'water_press_portfolio_section',
          'type' => 'select',
          'choices' => $options_posts,
      )
  );

  /** Select Post Two */
  $wp_customize->add_setting(
      'water_press_portfolio_section_post_two',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_select',
      )
  );

  $wp_customize->add_control(
      'water_press_portfolio_section_post_two',
      array(
          'label' => __( 'Select Post Two', 'water-press' ),
          'section' => 'water_press_portfolio_section',
          'type' => 'select',
          'choices' => $options_posts,
      )
  );

  /** Select Post Three */
  $wp_customize->add_setting(
      'water_press_portfolio_section_post_three',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_select',
      )
  );

  $wp_customize->add_control(
      'water_press_portfolio_section_post_three',
      array(
          'label' => __( 'Select Post Three', 'water-press' ),
          'section' => 'water_press_portfolio_section',
          'type' => 'select',
          'choices' => $options_posts,
      )
  );

  /** Select Post Four */
  $wp_customize->add_setting(
      'water_press_portfolio_section_post_four',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_select',
      )
  );

  $wp_customize->add_control(
      'water_press_portfolio_section_post_four',
      array(
          'label' => __( 'Select Post Four', 'water-press' ),
          'section' => 'water_press_portfolio_section',
          'type' => 'select',
          'choices' => $options_posts,
      )
  );

  /** Select Post Five */
  $wp_customize->add_setting(
      'water_press_portfolio_section_post_five',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_select',
      )
  );

  $wp_customize->add_control(
      'water_press_portfolio_section_post_five',
      array(
          'label' => __( 'Select Post Five', 'water-press' ),
          'section' => 'water_press_portfolio_section',
          'type' => 'select',
          'choices' => $options_posts,
      )
  );
/** End Of Portfolio Section Settings */

/** Second Promotional Block Section */
  $wp_customize->add_section(
      'water_press_cta2_section',
      array(
          'title' => __( 'Second Promotional Block Section', 'water-press' ),
          'priority' => 100,
          'panel' => 'water_press_home_page_settings',
      )
  );

  /** Enable/Disable Second Promotional Block Section */
  $wp_customize->add_setting(
      'water_press_ed_cta2_section',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_checkbox',
      )
  );

  $wp_customize->add_control(
      'water_press_ed_cta2_section',
      array(
          'label' => __( 'Enable Promotional Block Section', 'water-press' ),
          'section' => 'water_press_cta2_section',
          'type' => 'checkbox',
      )
  );

  /** Promotional Block Section Title */
  $wp_customize->add_setting(
      'water_press_cta2_section_title',
      array(
          'default' => '',
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_cta2_section_title',
      array(
          'label' => __( 'Promotional Block Section Title', 'water-press' ),
          'section' => 'water_press_cta2_section',
          'type' => 'text',
      )
  );

  /** Promotional Block Section Content */
  $wp_customize->add_setting(
      'water_press_cta2_section_content',
      array(
          'default' => '',
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_cta2_section_content',
      array(
          'label' => __( 'Promotional Block Section Content', 'water-press' ),
          'section' => 'water_press_cta2_section',
          'type' => 'textarea',
      )
  );

  /** Promotional Block Section Button */
  $wp_customize->add_setting(
      'water_press_cta2_section_button',
      array(
          'default' => '',
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_cta2_section_button',
      array(
          'label' => __( 'Promotional Block Section Button', 'water-press' ),
          'section' => 'water_press_cta2_section',
          'type' => 'text',
      )
  );

  /** Promotional Block Section Button Url */
  $wp_customize->add_setting(
      'water_press_cta2_section_button_url',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_url',
      )
  );

  $wp_customize->add_control(
      'water_press_cta2_section_button_url',
      array(
          'label' => __( 'Promotional Block Section Button Url', 'water-press' ),
          'section' => 'water_press_cta2_section',
          'type' => 'text',
      )
  );
/** End Of Second Promotional Block Section */

/** Contact Section */
  $wp_customize->add_section(
      'water_press_contact_section',
      array(
          'title' => __( 'Contact Section', 'water-press' ),
          'priority' => 110,
          'panel' => 'water_press_home_page_settings',
      )
  );

  /** Enable/Disable Contact Section */
  $wp_customize->add_setting(
      'water_press_ed_contact_section',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_checkbox',
      )
  );

  $wp_customize->add_control(
      'water_press_ed_contact_section',
      array(
          'label' => __( 'Enable Contact Section', 'water-press' ),
          'section' => 'water_press_contact_section',
          'type' => 'checkbox',
      )
  );

  /** Contact Section Menu Title */
  $wp_customize->add_setting(
      'water_press_contact_section_menu_title',
      array(
          'default' => '',
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_contact_section_menu_title',
      array(
          'label' => __( 'Contact Section Menu Title', 'water-press' ),
          'section' => 'water_press_contact_section',
          'type' => 'text',
      )
  );

  /** Select Page */
  $wp_customize->add_setting(
      'water_press_contact_section_page',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_select',
      )
  );

  $wp_customize->add_control(
      'water_press_contact_section_page',
      array(
          'label' => __( 'Select Page', 'water-press' ),
          'section' => 'water_press_contact_section',
          'type' => 'select',
          'choices' => $options_pages,
      )
  );

  /** Contact Section Contact Form */
  $wp_customize->add_setting(
      'water_press_contact_section_form',
      array(
          'default' => '',
          'sanitize_callback' => 'wp_kses_post',
      )
  );

  $wp_customize->add_control(
      'water_press_contact_section_form',
      array(
          'label' => __( 'Contact Section Contact Form', 'water-press' ),
          'description' => __( 'Enter the Contact Form 7 Shortcode. Ex. [contact-form-7 id="186" title="Google contact"]', 'water-press' ),
          'section' => 'water_press_contact_section',
          'type' => 'text',
      )
  );

  /** Contact Info Title */
  $wp_customize->add_setting(
      'water_press_contact_section_info_title',
      array(
          'default' => '',
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_contact_section_info_title',
      array(
          'label' => __( 'Contact Info Title', 'water-press' ),
          'section' => 'water_press_contact_section',
          'type' => 'text',
      )
  );

  /** Contact Info Content */
  $wp_customize->add_setting(
      'water_press_contact_section_info_content',
      array(
          'default' => '',
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_contact_section_info_content',
      array(
          'label' => __( 'Contact Info Content', 'water-press' ),
          'section' => 'water_press_contact_section',
          'type' => 'textarea',
      )
  );

  /** Contact Address */
  $wp_customize->add_setting(
      'water_press_contact_section_address',
      array(
          'default' => '',
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_contact_section_address',
      array(
          'label' => __( 'Contact Address', 'water-press' ),
          'section' => 'water_press_contact_section',
          'type' => 'textarea',
      )
  );

  /** Contact Phone */
  $wp_customize->add_setting(
      'water_press_contact_section_phone',
      array(
          'default' => '',
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_contact_section_phone',
      array(
          'label' => __( 'Contact Phone', 'water-press' ),
          'section' => 'water_press_contact_section',
          'type' => 'text'
      )
  );

  /** Contact Fax */
  $wp_customize->add_setting(
      'water_press_contact_section_fax',
      array(
          'default' => '',
          'sanitize_callback' => 'sanitize_text_field',
      )
  );

  $wp_customize->add_control(
      'water_press_contact_section_fax',
      array(
          'label' => __( 'Contact Fax', 'water-press' ),
          'section' => 'water_press_contact_section',
          'type' => 'text',
      )
  );

  /** Contact Email */
  $wp_customize->add_setting(
      'water_press_contact_section_email',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_email',
      )
  );

  $wp_customize->add_control(
      'water_press_contact_section_email',
      array(
          'label' => __( 'Contact Email', 'water-press' ),
          'section' => 'water_press_contact_section',
          'type' => 'email',
      )
  );
/** End Of Contact Section*/

/** End Of Home Page Settings */

  /** Social Settings */
  $wp_customize->add_section(
      'water_press_social_settings',
      array(
          'title' => __( 'Social Settings', 'water-press' ),
          'description' => __( 'Leave blank if you do not want to show the social link.', 'water-press' ),
          'priority' => 40,
          'capability' => 'edit_theme_options',
      )
  );

  /** Facebook */
  $wp_customize->add_setting(
      'water_press_facebook',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_url',
      )
  );

  $wp_customize->add_control(
      'water_press_facebook',
      array(
          'label' => __( 'Facebook', 'water-press' ),
          'section' => 'water_press_social_settings',
          'type' => 'text',
      )
  );

  /** Twitter */
  $wp_customize->add_setting(
      'water_press_twitter',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_url',
      )
  );

  $wp_customize->add_control(
      'water_press_twitter',
      array(
          'label' => __( 'Twitter', 'water-press' ),
          'section' => 'water_press_social_settings',
          'type' => 'text',
      )
  );

  /** Pinterest */
  $wp_customize->add_setting(
      'water_press_pinterest',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_url',
      )
  );

  $wp_customize->add_control(
      'water_press_pinterest',
      array(
          'label' => __( 'Pinterest', 'water-press' ),
          'section' => 'water_press_social_settings',
          'type' => 'text',
      )
  );

  /** LinkedIn */
  $wp_customize->add_setting(
      'water_press_linkedin',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_url',
      )
  );

  $wp_customize->add_control(
      'water_press_linkedin',
      array(
          'label' => __( 'LinkedIn', 'water-press' ),
          'section' => 'water_press_social_settings',
          'type' => 'text',
      )
  );

  /** Google Plus */
  $wp_customize->add_setting(
      'water_press_google_plus',
      array(
          'default' => '',
          'sanitize_callback' => 'water_press_sanitize_url',
      )
  );

  $wp_customize->add_control(
      'water_press_google_plus',
      array(
          'label' => __( 'Google Plus', 'water-press' ),
          'section' => 'water_press_social_settings',
          'type' => 'text',
      )
  );
  /** Social Settings Ends */

  /** Custom CSS*/
  $wp_customize->add_section(
      'water_press_custom_settings',
      array(
          'title' => __( 'Custom CSS Settings', 'water-press' ),
          'priority' => 50,
          'capability' => 'edit_theme_options',
      )
  );

  $wp_customize->add_setting(
      'water_press_custom_css',
      array(
          'default' => '',
          'capability'        => 'edit_theme_options',
          'sanitize_callback' => 'water_press_sanitize_css'
          )
  );

  $wp_customize->add_control(
      'water_press_custom_css',
      array(
          'label' => __( 'Custom Css', 'water-press' ),
          'section' => 'water_press_custom_settings',
          'description' => __( 'Add your own custom CSS here', 'water-press' ),
          'type' => 'textarea',
      )
  );
  /** Custom CSS Ends */

  /**
   * Sanitization Functions
   *
   * @link https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php
   */
  function water_press_sanitize_url( $url ){
      return esc_url_raw( $url );
  }

  function water_press_sanitize_checkbox( $checked ){
      // Boolean check.
   return ( ( isset( $checked ) && true == $checked ) ? true : false );
  }

  function water_press_sanitize_select( $input, $setting ) {
  	// Ensure input is a slug.
  	$input = sanitize_key( $input );
  	// Get list of choices from the control associated with the setting.
  	$choices = $setting->manager->get_control( $setting->id )->choices;
  	// If the input is a valid key, return it; otherwise, return the default.
  	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
  }

  function water_press_sanitize_number_absint( $number, $setting ) {
  	// Ensure $water_press_number is an absolute integer (whole number, zero or greater).
  	$number = absint( $number );
  	// If the input is an absolute integer, return it; otherwise, return the default
  	return ( $number ? $number : $setting->default );
  }

  function water_press_sanitize_email( $email, $setting ) {
  	// Sanitize $input as a hex value without the hash prefix.
  	$email = sanitize_email( $email );
  	// If $email is a valid email, return it; otherwise, return the default.
  	return ( !empty( $email ) ? $email : $setting->default );
  }

  function water_press_sanitize_css( $css ){
  	return wp_strip_all_tags( $css );
  }

}
add_action( 'customize_register', 'water_press_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function water_press_customize_preview_js() {
	wp_enqueue_script( 'water_press_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'water_press_customize_preview_js' );
