<?php
$title = get_field('contact_title', 'options');
$form = get_field('contact_form', 'options');
$social = get_field('contact_social', 'options');
?>

<section class="contact section _light" id="contact">
  <div class="container">
    <?php if (!empty($title)): ?>
      <header class="section-head">
        <h2 class="section__title _center">
          <?php echo $title ?>
        </h2>
      </header>
    <?php endif ?>

    <div class="contact__grid">
      <div class="contact__form form">
        <?php if (!empty($form)) {
          $full_form = WPCF7_ContactForm::get_instance($form);
          echo do_shortcode($full_form->shortcode());
        } ?>
      </div>

      <aside class="contact__social">
        <?php if (!empty($social)): ?>
          <div class="social__list">
            <?php foreach ($social as $item): ?>
              <?php
              $icon = isset($item['icon']) ? $item['icon'] : null;
              $title = isset($item['title']) ? $item['title'] : '';
              $description = isset($item['description']) ? $item['description'] : '';
              $url = isset($item['url']) ? $item['url'] : '';
              ?>
              <a href="<?php echo $url ?>" class="social__item" target="_blank" rel="noopener noreferrer">
                <figure class="social__icon">
                  <?php echo wp_get_attachment_image($icon, [100, 100], null, ['loading' => 'lazy']) ?>
                  <figcaption>
                    <b>
                      <?php echo $title ?>
                    </b>
                    <span>
                      <?php echo $description ?>
                    </span>
                  </figcaption>
                </figure>
              </a>
            <?php endforeach ?>
          </div>
        <?php endif ?>
      </aside>
    </div>
  </div>
</section>