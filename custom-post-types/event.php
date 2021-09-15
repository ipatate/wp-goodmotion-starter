<?php

namespace GoodmotionStarter\CustomPostTypes\Event;

function get_labels(): array
{
  return array(
    'name' => __('Events', 'goodmotion-theme'),
    'singular_name' => __('Event', 'goodmotion-theme'),
    'add_new' => __('Add', 'goodmotion-theme'),
    'add_new_item' => __('Add new event', 'goodmotion-theme'),
    'edit_item' => __('Edit event', 'goodmotion-theme'),
    'new_item' => __('New event', 'goodmotion-theme'),
    'view_item' => __('See the event', 'goodmotion-theme'),
    'search_items' => __('Search event', 'goodmotion-theme'),
    'not_found' => __('No event found', 'goodmotion-theme'),
    'not_found_in_trash' => __('No event in trash', 'goodmotion-theme'),
    'parent_item_colon' => __('Parent event:', 'goodmotion-theme'),
    'menu_name' => __('Events', 'goodmotion-theme'),
  );
}

function custom_post_type()
{
  global $labels;

  register_post_type(
    'events',
    array(
      'labels'      => namespace\get_labels(),
      'show_in_rest' => true,
      'supports' => array(
        'title',
        'editor',
      ),
      'taxonomies' => [
        'events_categories',
      ],
      'public'      => true,
      'has_archive' => true,
      'menu_position' => 4,
      'menu_icon' => 'dashicons-calendar',
      'rewrite'     => array('slug' => 'agenda', 'with_front' => true),
      'show_in_graphql' => true,
      'publicly_queryable'  => true,
      'hierarchical' => true,
      'graphql_single_name' => 'Event',
      'graphql_plural_name' => 'Events',
    )
  );

  register_taxonomy('events_categories', 'events', [
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    'hierarchical' => true, 'show_tagcloud' => false, 'show_admin_column' => true,             'show_in_rest' => true,
    'rewrite'     => array('slug' => 'agenda-categorie', 'with_front' => true),

  ]);
  //    add_theme_support( 'post-thumbnails', array( 'models' ) );
}
add_action('init', __NAMESPACE__ . '\custom_post_type');



function set_custom_edit_columns($columns)
{
  unset($columns['date']);
  return array_merge($columns, array(
    'date_event' => __('Date Event', 'goodmotion-theme'),
  ));
}

add_filter('manage_events_posts_columns',  __NAMESPACE__ . '\set_custom_edit_columns');


function registered_column_sortable($columns)
{
  return wp_parse_args(array('date_event' => 'date_event'), $columns);
}

add_filter('manage_edit-events_sortable_columns',  __NAMESPACE__ . '\registered_column_sortable');


// Add the data to the custom columns for post type:
function custom_column($column, $post_id)
{
  switch ($column) {
    case 'date_event':
      // get date event
      $_d = get_post_meta($post_id, 'date_event', true);
      if ($_d) {
        $s = strtotime($_d);
        printf('%s %s %s', date('d', $s), date('F', $s), date('Y', $s));
      }
      break;
  }
}

add_action('manage_events_posts_custom_column',  __NAMESPACE__ . '\custom_column', 10, 2);
