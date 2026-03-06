<?php
$logo_id = get_field('logo', 'options');
$dev_logo_id = get_field('dev_logo', 'options');
$dev_url = get_field('dev_url', 'options');
$order_instruction = get_field('order_instruction', 'options');
$order_form = get_field('order_form', 'options');
?>

<footer class="footer">
  <div class="container footer__inner">
    <a href="#" class="footer__logo">
      <?php echo wp_get_attachment_image($logo_id, 'full', null, ['loading' => 'lazy']) ?>
    </a>

    <?php wp_nav_menu([
      'theme_location' => 'footer_menu',
      'menu_id' => 'footer_menu',
      'container' => false,
      'menu_class' => 'footer__links',
    ]); ?>

    <div class="footer__copy">
      © <?php echo date('Y') . '&nbsp;';
        _e('Валерія Цикало. Нумеролог', 'chitko') ?>
    </div>

    <?php if (!empty($dev_logo_id) && !empty($dev_url)): ?>
      <div class="footer__dev">
        <?php _e('Дизайн та розробка:', 'chitko') ?>
        <a href="<?php echo $dev_url ?>" target="_blank" rel="noopener noreferrer">
          <?php echo wp_get_attachment_image($dev_logo_id, 'full', null, ['loading' => 'lazy']) ?>
        </a>
      </div>
    <?php endif ?>
  </div>
</footer>

<div class="modal" id="modal">
  <div class="modal__overlay" data-modal-close></div>
  <div
    class="modal__dialog"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-title"
    tabindex="-1">
    <button class="modal__close" type="button" data-modal-close></button>
    <div id="modal__content" class="modal__content">

      <div class="modal__grid">
        <h3 id="modal__title" class="modal__title section__title _center"></h3>

        <div class="modal__text">
          <div
            id="modal__description"
            class="section__description text-content _small">
          </div>
        </div>

        <div class="modal__form">
          <div class="modal__price">
            <span>
              <?php _e('Вартість: ') ?>
            </span>
            <span id="modal__price"></span>
          </div>

          <?php if (!empty($order_instruction)): ?>
            <div class="text-content _small">
              <?php echo $order_instruction ?>
            </div>
          <?php endif ?>

          <?php if (!empty($order_form)) {
            $full_form = WPCF7_ContactForm::get_instance($order_form);
            echo do_shortcode($full_form->shortcode());
          } ?>

          <form id="liqpay-form" method="POST" action="https://www.liqpay.ua/api/3/checkout" hidden>
            <input type="hidden" name="data">
            <input type="hidden" name="signature">
            <input type="hidden" name="order-item-id" id="order-item-id" value="">
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
</div>

<?php wp_footer(); ?>

</body>

</html>