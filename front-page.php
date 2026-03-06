<?php

/**
 * Template Name: Головна
 *
 */

get_header();
?>

<main id="primary" class="main">
  <?php
  $sections = get_field('home_content');

  if ($sections) :
    foreach ($sections as $section) :
      $template = str_replace('_', '-', $section['acf_fc_layout']);
      get_template_part('sections/' . $template, '', $section);
    endforeach;
  endif;

  get_template_part('sections/home-contact');
  ?>

</main>

<?php
get_footer();
