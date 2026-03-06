<?php
$title = !empty($args['about_title']) ? $args['about_title'] : '';
$mark = !empty($args['about_mark']) ? $args['about_mark'] : '';
$description = !empty($args['about_description']) ? $args['about_description'] : '';
$image = !empty($args['about_image']) ? $args['about_image'] : null;
?>

<section class="about section" id="about">
  <div class="container about__grid">
    <div class="about__content">
      <?php if (!empty($mark)): ?>
        <div class="about__badge">
          <?php echo $mark ?>
        </div>
      <?php endif ?>

      <?php if (!empty($title)): ?>
        <header class="section-head">
          <h2 class="section__title _center">
            <?php echo $title ?>
          </h2>
        </header>
      <?php endif ?>

      <?php if (!empty($description)): ?>
        <div class="text-content">
          <?php echo $description ?>
        </div>
      <?php endif ?>
    </div>

    <?php if (!empty($image)): ?>
      <figure class="about__photo">
        <?php echo wp_get_attachment_image($image, 'full', null, ['loading' => 'lazy']) ?>
      </figure>
    <?php endif ?>
  </div>
</section>