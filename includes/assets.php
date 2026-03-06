<?php
function theme_styles()
{
  wp_enqueue_style('aos', get_template_directory_uri() . '/assets/libs/aos/aos.min.css', array());
  wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/libs/swiper/swiper.min.css', array());
  //compiled styles
  wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.min.css', array());

  //additional styles
  wp_enqueue_style('add-style', get_template_directory_uri() . '/style.css', array());
}
add_action('wp_enqueue_scripts', 'theme_styles');

function register_scripts()
{
  //libs
  wp_enqueue_script('aos', get_template_directory_uri() . '/assets/libs/aos/aos.min.js', array(), true);
  wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/libs/swiper/swiper-bundle.min.js', array(), true);

  //custom scripts
  wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/main.min.js', array('jquery'), true, true);


  wp_localize_script(
    'main',
    'ajax_object',
    [
      'ajax_url' => admin_url('admin-ajax.php'),
    ]
  );
}

add_action('wp_footer', 'register_scripts', 10);
