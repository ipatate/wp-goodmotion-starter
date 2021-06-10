<?php
namespace GoodmotionStarter\inc\disablePost;


/* ----------------------------------------------------------
  Remove edit menu
---------------------------------------------------------- */

add_action('admin_menu', __NAMESPACE__ . '\disable_posts_pages');
function disable_posts_pages() {
  remove_menu_page('edit.php');
  global $menu;
  unset($menu[5]);
}

/* ----------------------------------------------------------
  Remove Posts and Comments RSS feeds
---------------------------------------------------------- */

add_action('template_redirect', __NAMESPACE__ . '\disable_posts_rss_feeds');
function disable_posts_rss_feeds() {
  remove_action('wp_head', 'feed_links', 2);
}

/* ----------------------------------------------------------
  Disable post single view
---------------------------------------------------------- */

add_action('template_redirect', __NAMESPACE__ . '\disable_posts_check_single');
function disable_posts_check_single() {
  if (is_singular('post')) {
    wp_redirect(site_url());
    die;
  }
}

/* ----------------------------------------------------------
  Disable link in admin bar
---------------------------------------------------------- */

add_action('admin_bar_menu', function ($wp_admin_bar) {
  $wp_admin_bar->remove_node('new-post');
}, 999);

/* ----------------------------------------------------------
  Disable features
---------------------------------------------------------- */

add_action('init', function () {
  remove_post_type_support('post', 'title');
  remove_post_type_support('post', 'editor');
  remove_post_type_support('post', 'author');
  remove_post_type_support('post', 'thumbnail');
  remove_post_type_support('post', 'trackbacks');
  remove_post_type_support('post', 'custom-fields');
  remove_post_type_support('post', 'comments');
  remove_post_type_support('post', 'excerpt');
  remove_post_type_support('post', 'revisions');
  remove_post_type_support('post', 'post-formats');
});

/* ----------------------------------------------------------
  Disable RSS feed for posts
---------------------------------------------------------- */

add_action('do_feed', __NAMESPACE__ . '\disable_posts_disable_feed', 1);
add_action('do_feed_rdf', __NAMESPACE__ . '\disable_posts_disable_feed', 1);
add_action('do_feed_rss', __NAMESPACE__ . '\disable_posts_disable_feed', 1);
add_action('do_feed_rss2', __NAMESPACE__ . '\disable_posts_disable_feed', 1);
add_action('do_feed_atom', __NAMESPACE__ . '\disable_posts_disable_feed', 1);

function disable_posts_disable_feed() {
  global $post;
  if (isset($post->post_type) && $post->post_type == 'post') {
    wp_die(sprintf(__('Our RSS feed is disabled. Please <a href="%s">visit our homepage</a>.', 'wputh'), home_url()));
  }
}

/* ----------------------------------------------------------
  Remove dashboard widget
---------------------------------------------------------- */

add_action('wp_dashboard_setup', __NAMESPACE__ . '\disable_posts_remove_dashboard_widgets');
function disable_posts_remove_dashboard_widgets() {
  remove_meta_box('dashboard_activity', 'dashboard', 'normal');
  remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
}

/* ----------------------------------------------------------
  Remove count
---------------------------------------------------------- */

add_filter('wp_count_posts', __NAMESPACE__ . '\disable_posts_remove_count', 10, 3);
function disable_posts_remove_count($counts, $type, $perm) {
  if ($type == 'post') {
    return 0;
  }
  return $counts;
}

/* ----------------------------------------------------------
  Remove from menu editor
---------------------------------------------------------- */

add_action('admin_head', function () {
  global $wp_meta_boxes;
  if (isset($wp_meta_boxes['nav-menus']['side']['default']['add-post-type-post'])) {
    unset($wp_meta_boxes['nav-menus']['side']['default']['add-post-type-post']);
  }
});

add_filter('customize_nav_menu_available_item_types', function ($types) {
  $_types = array();
  foreach ($types as $type) {
    if (isset($type['object']) && $type['object'] == 'post') {
      continue;
    }
    $_types[] = $type;
  }
  return $_types;
}, 10, 1);

/* ----------------------------------------------------------
  Disable admin post list
---------------------------------------------------------- */

add_action('admin_menu', function () {
  global $pagenow;
  if (empty($_GET) && ($pagenow == 'edit.php' || $pagenow == 'post-new.php')) {
    wp_redirect(admin_url());
    die;
  }
});

/* ----------------------------------------------------------
  Disable default post taxonomies
---------------------------------------------------------- */

class wpudisableposts_tax {
  public function __construct() {
    add_filter('plugins_loaded', array(&$this, 'plugins_loaded'));
  }

  public function plugins_loaded() {
    if (!apply_filters('wpudisableposts__disable__taxonomies', true)) {
      return;
    }
    $this->disable_taxonomies();
    add_filter('nav_menu_meta_box_object', array(&$this, '_nav_menu_meta_box_object'), 10, 1);
  }

  public function disable_taxonomies() {
    global $wp_taxonomies;
    unregister_taxonomy_for_object_type('category', 'post');
    unregister_taxonomy_for_object_type('post_tag', 'post');
    if (isset($wp_taxonomies['category'])) {
      unset($wp_taxonomies['category']);
    }
    if (isset($wp_taxonomies['post_tag'])) {
      unset($wp_taxonomies['post_tag']);
    }

    unregister_taxonomy('category');
    unregister_taxonomy('post_tag');
  }

  public function _nav_menu_meta_box_object($tax) {
    if ($tax->name == 'category' || $tax->name == 'post_tag') {
      return false;
    }
    return $tax;
  }
}

$wpudisableposts_tax = new wpudisableposts_tax();

/* ----------------------------------------------------------
  Destroy posts if still available
---------------------------------------------------------- */

add_action('wp_loaded', __NAMESPACE__ . '\wpudisableposts_clean_wp_loaded');
function wpudisableposts_clean_wp_loaded() {
  if (false === ($wpudisableposts_clean = get_transient('wpudisableposts_clean')) ) {
    $posts = get_posts(array(
      'post_type' => 'post'
    ));
    foreach ($posts as $post) {
      if ($post->post_type == 'post') {
        wp_delete_post($post->ID);
      }
    }
    set_transient('wpudisableposts_clean', $wpudisableposts_clean, 86400);
  }
}
