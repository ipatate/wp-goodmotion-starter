<?php

namespace GoodmotionStarter\CustomPostTypes\Menu;

function get_labels(): array
{
  return array(
    'name' => __('Menus', 'goodmotion-theme'),
    'singular_name' => __('Menu', 'goodmotion-theme'),
    'add_new' => __('Add', 'goodmotion-theme'),
    'add_new_item' => __('Add new Menu', 'goodmotion-theme'),
    'edit_item' => __('Edit Menu', 'goodmotion-theme'),
    'new_item' => __('New Menu', 'goodmotion-theme'),
    'view_item' => __('See the Menu', 'goodmotion-theme'),
    'search_items' => __('Search Menu', 'goodmotion-theme'),
    'not_found' => __('No Menu found', 'goodmotion-theme'),
    'not_found_in_trash' => __('No Menu in trash', 'goodmotion-theme'),
    'parent_item_colon' => __('Parent Menu:', 'goodmotion-theme'),
    'menu_name' => __('Menus', 'goodmotion-theme'),
  );
}

function custom_post_type()
{
  global $labels;

  register_post_type(
    'menus',
    array(
      'labels'      => namespace\get_labels(),
      'show_in_rest' => true,
      'supports' => array(
        'title',
        'editor'
      ),
      'menu_position' => 4,
      'menu_icon' => 'dashicons-menu',
      'rewrite'     => array('slug' => 'menus', 'with_front' => false),
      'show_in_graphql' => true,
      'public' => false,
      'publicly_queryable'  => true,
      'exclude_from_search' => true,
      'has_archive' => false,
      'show_ui' => true,
      //   'hierarchical' => true,
      'graphql_single_name' => 'Menu',
      'graphql_plural_name' => 'Menus',
    )
  );

  register_taxonomy('menus_categories', 'menus', [
    'public' => false,
    'show_ui' => true,
    // 'show_in_menu' => true,
    // 'show_in_nav_menus' => true,
    'hierarchical' => true, 'show_tagcloud' => false, 'show_admin_column' => true,             'show_in_rest' => true,
  ]);
  //    add_theme_support( 'post-thumbnails', array( 'models' ) );
}
add_action('init', __NAMESPACE__ . '\custom_post_type');



// function set_custom_edit_columns($columns)
// {
//   unset($columns['date']);
//   return array_merge($columns, array(
//     'date_Menu' => __('Date Menu', 'goodmotion-theme'),
//   ));
// }

// add_filter('manage_Menus_posts_columns',  __NAMESPACE__ . '\set_custom_edit_columns');


// function registered_column_sortable($columns)
// {
//   return wp_parse_args(array('date_Menu' => 'date_Menu'), $columns);
// }

// add_filter('manage_edit-Menus_sortable_columns',  __NAMESPACE__ . '\registered_column_sortable');


// Add the data to the custom columns for post type:
// function custom_column($column, $post_id)
// {
//   switch ($column) {
//       // case 'date_Menu':
//       //   // get date Menu
//       //   $_d = get_post_meta($post_id, 'date_Menu', true);
//       //   if ($_d) {
//       //     $s = strtotime($_d);
//       //     printf('%s %s %s', date('d', $s), date('F', $s), date('Y', $s));
//       //   }
//       //   break;
//   }
// }

// add_action('manage_menus_posts_custom_column',  __NAMESPACE__ . '\custom_column', 10, 2);
