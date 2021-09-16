<?php /* Template Name: Events categorie page Template */
require_once(dirname(__FILE__) . '/inc/images.php');

global $paged;
if (!isset($paged) || !$paged) {
  $paged = 1;
}

$pages = get_pages(array(
  'meta_key' => '_wp_page_template',
  'meta_value' => 'taxonomy-events_categories.php'
));

$context = Timber::context();
$timber_post = new Timber\Post(count($pages) > 0 ? $pages[0]->ID : null);
$context['post'] = $timber_post;
$today = date('Y-m-d');
$query = array(
  // limit element
  'posts_per_page'    => 1000,
  // post type
  'post_type'            => 'events',
  // order
  'meta_key'            => 'date_event',
  'orderby'            => 'meta_value',
  'order'   => 'ASC',
  // only next events
  'meta_query' => array(
    array(
      'key' => 'date_event',
      'value' => $today,
      'compare' => '>=',
      'type' => 'DATE'
    )
  ),
  'tax_query' => array(
    array(
      'taxonomy' => 'events_categories',
      'field' => 'term_id',
      'terms' =>
      get_queried_object()->term_id,
    )
  )
);
$context['posts'] = new Timber\PostQuery($query);
$context['taxonomy'] = get_queried_object();
$templates = 'events.twig';
GoodmotionStarter\inc\images\prefetch_images($timber_post->meta("page_hero"));

//$context['breadcrumb'] = get_breadcrumb($timber_post);
Timber::render($templates, $context);
