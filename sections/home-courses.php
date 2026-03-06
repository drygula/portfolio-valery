<?php
$title = !empty($args['courses_title']) ? $args['courses_title'] : '';
$list = !empty($args['courses_list']) ? $args['courses_list'] : '';
$button = !empty($args['courses_button']) ? $args['courses_button'] : '';
?>

<?php if (!empty($list)): ?>
  <section class="courses section" id="courses">
    <div class="container">
      <?php if (!empty($title)): ?>
        <header class="section-head">
          <h2 class="section__title _center">
            <?php echo $title ?>
          </h2>
        </header>
      <?php endif ?>

      <div class="courses__slider swiper">
        <div class="courses__list swiper-wrapper">
          <?php foreach ($list as $course): ?>
            <div class="course-card__wrap swiper-slide">
              <?php
              get_template_part('template-parts/card-course', null, array(
                'course_id' => $course
              ));
              ?>
            </div>
          <?php endforeach ?>
        </div>
      </div>

      <?php if (!empty($button)): ?>
        <div class="section__button">
          <?php display_button($button, '_large') ?>
        </div>
      <?php endif ?>
    </div>
  </section>
<?php endif ?>