<?php
$course_id = !empty($args['course_id']) ? $args['course_id'] : null;
if (!get_post_status($course_id)) {
  return;
}

register_entity_for_index('course', $course_id);

$image = get_the_post_thumbnail($course_id, 'full', ['class' => 'course-card__icon']) ?: null;
$title = get_the_title($course_id) ?: __('<Назву не задано>', 'chitko');
$excerpt = get_the_excerpt($course_id);
$duration = get_field('duration', $course_id);
$price = get_field('price', $course_id);
$currency = get_field('currency', $course_id);
?>

<article class="course-card" data-id="<?php echo $course_id ?>">
  <?php if (!empty($image)): ?>
    <div class="course-card__icon-wrap" aria-hidden="true">
      <?php echo $image ?>
    </div>
  <?php endif ?>

  <?php if (!empty($title)): ?>
    <h3 class="course-card__title">
      <?php echo $title ?>
    </h3>
  <?php endif ?>

  <?php if (!empty($excerpt)): ?>
    <p class="course-card__text">
      <?php echo $excerpt ?>
    </p>
  <?php endif ?>

  <div class="course-card__meta">
    <div class="course-card__meta-row">
      <span>
        <?php echo $duration ?>
      </span>
      <span class="course-card__price">
        <?php echo $price . get_currency_symbol($currency) ?>
      </span>
    </div>
    <button class="button _simple js-open-popup">
      <?php _e('Детальніше', 'chitko') ?>
    </button>
  </div>
</article>