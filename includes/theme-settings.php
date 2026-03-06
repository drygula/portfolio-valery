<?php

/** Кастомізуємо сторінку логіну
 * 
 */
function login_logo()
{
?>
  <style type="text/css">
    #login h1 a,
    .login h1 a {
      background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/logo.svg);
      background-size: contain;
      background-position: center;
      width: 80%;
      aspect-ratio: 120/52;
    }
  </style>
<?php
}
add_action('login_enqueue_scripts', 'login_logo');

function login_logo_url()
{
  return home_url();
}
add_filter('login_headerurl', 'login_logo_url');

function login_logo_url_title()
{
  return get_bloginfo('name');
}
add_filter('login_headertext', 'login_logo_url_title');

/** Прибираємо примітки в архівних заголовках 
 * 
 */
add_filter('get_the_archive_title', function ($title) {
  if (is_category()) {
    $title = single_cat_title('', false);
  } elseif (is_tag()) {
    $title = single_tag_title('', false);
  } elseif (is_author()) {
    $title = get_the_author();
  } elseif (is_post_type_archive()) {
    $title = post_type_archive_title('', false);
  }
  return $title;
});

/** Ховаємо в меню "Записи"
 * 
 */
add_action('admin_init', function () {
  global $pagenow;
  $hidden_menu = ['edit.php', 'edit-comments.php'];
  remove_menu_page('edit.php');
  remove_menu_page('edit-comments.php');
  remove_post_type_support('post', 'comments');
  remove_post_type_support('post', 'trackbacks');
  if (in_array($pagenow, $hidden_menu) && isset($_GET['post_type']) === false) {
    wp_safe_redirect(admin_url());
    exit;
  }
});

/** Вимикаємо синглові сторінки для типів записів
 * 
 */
add_action('template_redirect', function () {
  if (is_singular(['course', 'service'])) {
    wp_redirect(get_post_type_archive_link(get_post_type()), 301);
    exit;
  }
});

/** Вимикаємо віджети в майстерні
 * 
 */
function disable_default_dashboard_widgets()
{
  global $wp_meta_boxes;
  // wp
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
  // bbpress
  unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);
  // yoast seo
  unset($wp_meta_boxes['dashboard']['normal']['core']['wpseo-dashboard-overview']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['wpseo-wincher-dashboard-overview']);
  // gravity forms
  unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);
}
add_action('wp_dashboard_setup', 'disable_default_dashboard_widgets', 999);

/** Додаємо підтримку svg, featured images та menu
 * 
 */
function cc_mime_types($mimes)
{
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

add_theme_support('post-thumbnails');

add_theme_support('menus');

register_nav_menus(array(
  'main_menu' => 'Main Menu',
  'footer_menu' => 'Footer Menu',
));

/** Виправляємо розміри для svg в featured images
 * 
 */
add_filter('wp_get_attachment_image_src', function ($image, $attachment_id, $size, $icon) {
  $mime = get_post_mime_type($attachment_id);

  if ($mime === 'image/svg+xml') {
    $image[1] = 150; // width
    $image[2] = 150; // height
  }

  return $image;
}, 10, 4);

/** Чистимо дефолтні розміри картинок
 * 
 */
add_action('after_setup_theme', 'remove_plugin_image_sizes');

function remove_plugin_image_sizes()
{
  remove_image_size('2048x2048');
  remove_image_size('1536x1536');
  remove_image_size('medium_large');
}


/** Вимикаємо редактор Гутенберг
 * 
 */
add_filter('use_block_editor_for_post', 'my_disable_gutenberg', 10, 2);
function my_disable_gutenberg($can_edit, $post)
{
  if ($post->post_type == 'post') {
    return true;
  }
  return false;
}

/** Підключаємо домен для багатомовності
 * 
 */
add_action('after_setup_theme', 'lang_localization');
function lang_localization()
{
  load_theme_textdomain('chitko', get_template_directory());
}

add_filter('wpcf7_load_css', '__return_false', 999);
add_filter('wpcf7_autop_or_not', '__return_false');
