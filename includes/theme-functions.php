<?php
$GLOBALS['INDEX_REGISTRY'] = [
  'course'  => [],
  'service' => [],
];

function register_entity_for_index($type, $post_id)
{
  if (empty($post_id) || empty($type)) return;
  $GLOBALS['INDEX_REGISTRY'][$type][(int)$post_id] = true;
}

function display_button($button, ...$classes)
{
  if (!empty($button)) {
    $url = isset($button['url']) && $button['url'] ? $button['url'] : '';
    $title = isset($button['title']) && $button['title'] ? $button['title'] : __('<Назва відсутня>', 'chitko');
    $target = isset($button['target']) && $button['target'] ? $button['target'] : '_self';
    $classes = implode(' ', $classes);
    $download = isset($button['download']) && $button['download'] ? ' download' : '';
  }
  if (!empty($url)) {
    echo sprintf(
      '<a href="%s" target="%s" class="button %s" %s>%s</a>',
      $url,
      $target,
      $classes,
      $download,
      $title
    );
  }
}

function get_currency_symbol($currency)
{
  if (!$currency) {
    return false;
  }
  $symbols = [
    'UAH' => '₴',
    'USD' => '$',
    'EUR' => '€',
  ];

  return $symbols[$currency] ?? $currency;
}

/** Додаємо класи до посилань у головному меню
 * 
 */
add_filter('nav_menu_link_attributes', function ($atts, $item, $args, $depth) {

  if ($args->theme_location === 'main_menu') {
    $atts['class'] = 'nav__link js-navigation';
  }

  return $atts;
}, 10, 4);

/** Формуємо дані для попапів обраних постів
 * 
 */
function save_index()
{
  if (empty($GLOBALS['INDEX_REGISTRY'])) return;

  $registry = $GLOBALS['INDEX_REGISTRY'];

  $courses_ids  = array_keys($registry['course'] ?? []);
  $services_ids = array_keys($registry['service'] ?? []);

  if (!$courses_ids && !$services_ids) return;

  $payload = [
    'course'  => [],
    'service' => [],
  ];

  foreach ($courses_ids as $course_id) {
    $payload['course'][$course_id] = [
      'templateId' => 'tpl-details',
      'image'    => get_the_post_thumbnail_url($course_id, 'full'),
      'title'    => get_the_title($course_id) ?: __('<Назву не задано>', 'chitko'),
      'excerpt'  => get_the_excerpt($course_id),
      'duration' => get_field('duration', $course_id),
      'price'    => get_field('price', $course_id),
      'currency' => get_field('currency', $course_id),
      'description' => get_the_content(null, false, $course_id),
    ];
  }

  foreach ($services_ids as $service_id) {
    $payload['service'][$service_id] = [
      'templateId' => 'tpl-details',
      'image'   => get_the_post_thumbnail_url($service_id, 'full'),
      'title'   => get_the_title($service_id) ?: __('<Назву не задано>', 'chitko'),
      'excerpt' => get_the_excerpt($service_id),
      'price'   => get_field('service_price', $service_id),
      'currency' => get_field('service_currency', $service_id),
      'description' => get_the_content(null, false, $service_id),
    ];
  }

  wp_add_inline_script(
    'main',
    'window.popupsData = ' . wp_json_encode(['popupsIndex' => $payload]) . ';',
    'before'
  );
}
add_action('wp_print_footer_scripts', 'save_index', 5);

/** Заповнюємо форму оплати даними
 * 
 */
function handle_order_form_ajax()
{
  parse_str($_POST['form_data'], $form);
  $public_key = get_field('liqpay_public_key', 'option');
  $private_key = get_field('liqpay_private_key', 'option');
  $id = $form['order-item-id'];
  $amount = get_field('price', $id) ?: get_field('service_price', $id);
  $currency = get_field('currency', $id) ?: get_field('service_currency', $id);
  $title = get_the_title($id) ?: '';

  $json_string = json_encode(array(
    "public_key" => $public_key,
    "version" => "3",
    "action" => 'pay',
    "amount" => $amount,
    "currency" => $currency,
    "description" => $title,
    "order_id" => uniqid(),
    "result_url" => home_url(),
  ));

  $data = base64_encode($json_string);
  $sign_string = $private_key . $data . $private_key;
  $signature = base64_encode(sha1($sign_string, true));

  wp_send_json_success([
    'data' => $data,
    'signature' => $signature,
    'price' => $amount,
    'currency' => $currency,
    'title' => $title
  ]);
}
add_action('wp_ajax_handle_order_form_ajax', 'handle_order_form_ajax');
add_action('wp_ajax_nopriv_handle_order_form_ajax', 'handle_order_form_ajax');


/** Додаємо додаткові колонки для Flamingo
 * 
 */
add_filter('manage_flamingo_inbound_posts_columns', 'my_custom_filter_flamingo_inbound_message_table_columns', 10, 1);
add_action('manage_flamingo_inbound_posts_custom_column', 'my_custom_filter_flamingo_action_inbound_message_table_column_value', 10, 2);
function my_custom_filter_flamingo_inbound_message_table_columns($columns)
{
  $columns['date'] = 'Дата оформлення';
  $columns['order_item'] = 'Замовлення';
  $columns['price'] = 'Вартість';

  return $columns;
}

function my_custom_filter_flamingo_action_inbound_message_table_column_value($column, $entry_id)
{
  if (empty($column) || empty($entry_id)) {
    return;
  }
  switch ($column) {
    case 'date':
      echo esc_html(get_post_meta($entry_id, '_field_date', true));
      break;
    case 'order_item':
      echo esc_html(get_post_meta($entry_id, '_field_order-title', true));
      break;
    case 'price':
      echo esc_html(get_post_meta($entry_id, '_field_order-price', true));
      break;
  }
}
