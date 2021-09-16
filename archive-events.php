<?php /* Template Name: Events page Template */

global $paged;
if (!isset($paged) || !$paged) {
    $paged = 1;
}


$context = Timber::context();
$timber_post = new Timber\Post();
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
    )
);
$context['posts'] = new Timber\PostQuery($query);
$context['title_list_events'] = get_field('title_list_events', 'options');
$templates = 'events.twig';

//$context['breadcrumb'] = get_breadcrumb($timber_post);
Timber::render($templates, $context);
