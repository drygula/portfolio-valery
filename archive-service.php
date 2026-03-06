<?php
get_header();
?>

<main id="primary" class="main inner-page">
  <section class="section _light">
    <div class="container">
      <header class="section-head">
        <h2 class="section__title _center">
          <?php the_archive_title() ?>
        </h2>
      </header>

      <?php if (have_posts()) : ?>
        <div class="services__list _multiline">
          <?php
          while (have_posts()) {
            the_post();

            get_template_part('template-parts/card-service', null, array(
              'service_id' => get_the_ID()
            ));
          } ?>
        </div>
      <?php endif ?>
    </div>
  </section>

  <?php
  get_template_part('sections/home-contact');
  ?>
</main>

<?php
get_footer();
