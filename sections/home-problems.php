<?php
$description = !empty($args['problems_description']) ? $args['problems_description'] : '';
$decisions_title = !empty($args['problems_decisions_title']) ? $args['problems_decisions_title'] : '';
$decisions_list = !empty($args['problems_decisions_list']) ? $args['problems_decisions_list'] : [];
?>

<section class="problem section" id="help-offer" aria-label="Problem &amp; Offer">
  <div class="problem__bg" aria-hidden="true">
    <span class="problem__blob problem__blob--left"></span>
    <span class="problem__blob problem__blob--right"></span>
  </div>

  <div class="container">
    <div class="problem__grid">
      <article class="problem__card problem__card--pain">
        <?php if (!empty($description)): ?>
          <div class="text-content">
            <?php echo $description ?>
          </div>

          <div class="problem__decor" aria-hidden="true">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/decor-01.svg" alt="decor" />
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/decor-02.svg" alt="decor" />
          </div>
        <?php endif ?>
      </article>

      <article class="problem__card problem__card--offer">
        <?php if (!empty($decisions_title)): ?>
          <header class="section-head">
            <h2 class="section__title _center">
              <?php echo $decisions_title ?>
            </h2>
          </header>
        <?php endif ?>

        <?php if (!empty($decisions_list)): ?>
          <div class="problem__features" role="list">
            <?php foreach ($decisions_list as $decision): ?>
              <?php
              $icon = !empty($decision['icon']) ? $decision['icon'] : '';
              $title = !empty($decision['title']) ? $decision['title'] : '';
              $description = !empty($decision['description']) ? $decision['description'] : '';
              ?>
              <article class="problem__feature" role="listitem">
                <div class="problem__feature-icon" aria-hidden="true">
                  <?php echo wp_get_attachment_image($icon, 'full', null, ['loading' => 'lazy']) ?>
                </div>
                <div class="problem__feature-body">
                  <?php if (!empty($title)): ?>
                    <h3 class="problem__feature-title">
                      <?php echo $title ?>
                    </h3>
                  <?php endif ?>

                  <?php if (!empty($description)): ?>
                    <p class="problem__feature-text">
                      <?php echo $description ?>
                    </p>
                  <?php endif ?>
                </div>
              </article>
            <?php endforeach ?>
          </div>
        <?php endif ?>
      </article>
    </div>
  </div>
</section>