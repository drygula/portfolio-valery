<?php
get_header();
?>

<main id="primary" class="main inner-page">
  <section class="section">
    <div class="container">
      <header class="section-head">
        <h2 class="section__title _center">
          <?php the_archive_title() ?>
        </h2>
      </header>

      <?php if (have_posts()) : ?>
        <div class="courses__list _multiline">
          <?php
          while (have_posts()) {
            the_post();

            get_template_part('template-parts/card-course', null, array(
              'course_id' => get_the_ID()
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
