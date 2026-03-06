<?php
$title = !empty($args['services_title']) ? $args['services_title'] : '';
$list = !empty($args['services_list']) ? $args['services_list'] : '';
$button = !empty($args['services_button']) ? $args['services_button'] : '';
?>

<?php if (!empty($list)): ?>
  <section class="services section _light" id="services">
    <div class="container">
      <?php if (!empty($title)): ?>
        <header class="section-head">
          <h2 class="section__title _center">
            <?php echo $title ?>
          </h2>
        </header>
      <?php endif ?>

      <div class="services__slider swiper">
        <div class="services__list swiper-wrapper">
          <?php foreach ($list as $service): ?>
            <div class="swiper-slide">
              <?php
              get_template_part('template-parts/card-service', null, array(
                'service_id' => $service
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