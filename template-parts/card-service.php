<?php
$service_id = !empty($args['service_id']) ? $args['service_id'] : null;
if (!get_post_status($service_id)) {
  return;
}

register_entity_for_index('service', $service_id);

$image = get_the_post_thumbnail($service_id, 'full', ['class' => 'service-card__icon']) ?: null;
$title = get_the_title($service_id) ?: __('<Назву не задано>', 'chitko');
$excerpt = get_the_excerpt($service_id);
$price = get_field('service_price', $service_id);
$currency = get_field('service_currency', $service_id);
?>


<article class="service-card" data-id="<?php echo $service_id ?>">
  <?php if (!empty($image)): ?>
    <?php echo $image ?>
  <?php endif ?>

  <?php if (!empty($title)): ?>
    <h3 class="service-card__title">
      <?php echo $title ?>
    </h3>
  <?php endif ?>

  <?php if (!empty($excerpt)): ?>
    <p class="service-card__text">
      <?php echo $excerpt ?>
    </p>
  <?php endif ?>

  <?php if (!empty($price)): ?>
    <div class="service-card__price">
      <?php echo $price . get_currency_symbol($currency) ?>
    </div>
  <?php endif ?>

  <button class="button _simple js-open-popup">
    <?php _e('Замовити послугу', 'chitko') ?>
  </button>
</article>