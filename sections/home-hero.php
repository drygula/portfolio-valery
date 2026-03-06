<?php
$title = !empty($args['hero_title']) ? $args['hero_title'] : '';
$mark = !empty($args['hero_mark']) ? $args['hero_mark'] : '';
$description = !empty($args['hero_description']) ? $args['hero_description'] : '';
$buttons = !empty($args['hero_buttons']) ? $args['hero_buttons'] : [];
?>

<section class="hero" aria-label="Hero">
  <div class="hero__bg" aria-hidden="true">
    <div class="hero__geometry">
      <svg viewBox="0 0 500 500" class="hero__decor _01">
        <circle
          cx="250"
          cy="250"
          r="248"
          fill="none"
          stroke="currentColor"
          stroke-width="0.5"
          stroke-dasharray="4 4"></circle>
        <path
          d="M250 10 L466 385 L34 385 Z"
          fill="none"
          stroke="currentColor"
          stroke-width="0.5"></path>
        <path
          d="M250 490 L34 115 L466 115 Z"
          fill="none"
          stroke="currentColor"
          stroke-width="0.5"></path>
      </svg>

      <svg viewBox="0 0 400 400" class="hero__decor _02">
        <polygon
          points="200,10 390,105 390,295 200,390 10,295 10,105"
          fill="none"
          stroke="currentColor"
          stroke-width="0.8"></polygon>
        <circle
          cx="200"
          cy="200"
          r="150"
          fill="none"
          stroke="currentColor"
          stroke-width="0.5"></circle>
        <path
          d="M200 10 L200 390 M10 105 L390 295 M390 105 L10 295"
          fill="none"
          stroke="currentColor"
          stroke-width="0.5"
          opacity="0.5"></path>
      </svg>

      <svg viewBox="0 0 300 300" class="hero__decor _03">
        <circle
          cx="150"
          cy="150"
          r="140"
          fill="none"
          stroke="currentColor"
          stroke-width="1"></circle>
        <circle
          cx="150"
          cy="150"
          r="100"
          fill="none"
          stroke="currentColor"
          stroke-width="0.5"
          stroke-dasharray="2 4"></circle>
        <rect
          x="75"
          y="75"
          width="150"
          height="150"
          fill="none"
          stroke="currentColor"
          stroke-width="0.5"
          transform="rotate(45 150 150)"></rect>
      </svg>

      <svg viewBox="0 0 100 100" class="hero__decor _04">
        <circle
          cx="50"
          cy="50"
          r="45"
          fill="none"
          stroke="currentColor"
          stroke-width=".5"></circle>
        <circle
          cx="50"
          cy="50"
          r="10"
          stroke="currentColor"
          stroke-width="1"></circle>
      </svg>
    </div>
  </div>

  <div class="container hero__inner">
    <div class="hero__divider" aria-hidden="true"></div>

    <?php if (!empty($title)): ?>
      <h1 class="hero__title">
        <?php echo $title ?>
      </h1>
    <?php endif ?>

    <?php if (!empty($mark)): ?>
      <p class="hero__subtitle">
        <?php echo $mark ?>
      </p>
    <?php endif ?>

    <?php if (!empty($description)): ?>
      <p class="hero__lead">
        <?php echo $description ?>
      </p>
    <?php endif ?>

    <?php if (!empty($buttons)): ?>
      <div class="hero__buttons">
        <?php foreach ($buttons as $button): ?>
          <?php display_button($button['button'], '_large js-navigation') ?>
        <?php endforeach ?>
      </div>
    <?php endif ?>
  </div>

  <div class="hero__scroll" aria-hidden="true"></div>
</section>