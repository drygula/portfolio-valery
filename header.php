<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <?php
  get_template_part('includes/meta');
  wp_head();
  ?>
  <title><?php echo get_bloginfo('name');
          wp_title('|', true); ?></title>
</head>

<?php
$logo_id = get_field('logo', 'options');
$logo_target = is_front_page() ? '#top' : home_url();
$logo_class = is_front_page() ? 'logo js-navigation' : 'logo';
?>

<body <?php body_class(); ?>>
  <div class="page" id="top">
    <header class="header" data-modal-close>
      <div class="container header__inner">
        <a class="<?php echo $logo_class ?>" href="<?php echo $logo_target ?>" aria-label="Valery">
          <?php echo wp_get_attachment_image($logo_id, 'full', null, ['loading' => 'lazy']) ?>
        </a>

        <div class="nav__wrapper js-nav">
          <?php wp_nav_menu([
            'theme_location' => 'main_menu',
            'menu_id' => 'main_menu',
            'container' => 'nav',
            'container_class' => 'nav',
            'menu_class' => 'nav__list',
          ]); ?>
        </div>

        <button
          class="nav-button js-nav-button"
          type="button"
          aria-label="Toggle menu"
          aria-expanded="false"
          data-menu-toggle>
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
    </header>