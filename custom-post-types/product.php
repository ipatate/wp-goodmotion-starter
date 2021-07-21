<?php

namespace GoodmotionStarter\CustomPostTypes\Product;

function get_labels(): array
{
  return array(
    'name' => __('Products', 'goodmotion-theme'),
    'singular_name' => __('Product', 'goodmotion-theme'),
    'add_new' => __('Add', 'goodmotion-theme'),
    'add_new_item' => __('Add new product', 'goodmotion-theme'),
    'edit_item' => __('Edit product', 'goodmotion-theme'),
    'new_item' => __('New product', 'goodmotion-theme'),
    'view_item' => __('See the product', 'goodmotion-theme'),
    'search_items' => __('Search product', 'goodmotion-theme'),
    'not_found' => __('No product found', 'goodmotion-theme'),
    'not_found_in_trash' => __('No product in trash', 'goodmotion-theme'),
    'parent_item_colon' => __('Parent product:', 'goodmotion-theme'),
    'menu_name' => __('Products', 'goodmotion-theme'),
  );
}

function custom_post_type()
{
  global $labels;

  register_post_type(
    'products',
    array(
      'labels'      => namespace\get_labels(),
      'show_in_rest' => true,
      'supports' => array(
        'title',
        'editor'
      ),
      'menu_position' => 4,
      'menu_icon' => 'dashicons-products',
      'rewrite'     => array('slug' => 'products', 'with_front' => true),
      'show_in_graphql' => true,
      'public' => true,
      'publicly_queryable'  => true,
      'exclude_from_search' => true,
      'has_archive' => false,
      'show_ui' => true,
      //   'hierarchical' => true,
      'graphql_single_name' => 'Product',
      'graphql_plural_name' => 'Products',
    )
  );

  register_taxonomy('products_categories', 'products', [
    'public' => false,
    'show_ui' => true,
    // 'show_in_menu' => true,
    // 'show_in_nav_menus' => true,
    'hierarchical' => true, 'show_tagcloud' => false, 'show_admin_column' => true,             'show_in_rest' => false,
  ]);
  //    add_theme_support( 'post-thumbnails', array( 'models' ) );
}
add_action('init', __NAMESPACE__ . '\custom_post_type');



// function set_custom_edit_columns($columns)
// {
//   unset($columns['date']);
//   return array_merge($columns, array(
//     'date_product' => __('Date Product', 'goodmotion-theme'),
//   ));
// }

// add_filter('manage_products_posts_columns',  __NAMESPACE__ . '\set_custom_edit_columns');


// function registered_column_sortable($columns)
// {
//   return wp_parse_args(array('date_product' => 'date_product'), $columns);
// }

// add_filter('manage_edit-products_sortable_columns',  __NAMESPACE__ . '\registered_column_sortable');


// Add the data to the custom columns for post type:
function custom_column($column, $post_id)
{
  switch ($column) {
      // case 'date_product':
      //   // get date product
      //   $_d = get_post_meta($post_id, 'date_product', true);
      //   if ($_d) {
      //     $s = strtotime($_d);
      //     printf('%s %s %s', date('d', $s), date('F', $s), date('Y', $s));
      //   }
      //   break;
  }
}

add_action('manage_products_posts_custom_column',  __NAMESPACE__ . '\custom_column', 10, 2);
