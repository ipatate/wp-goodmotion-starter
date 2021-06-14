<?php

namespace GoodmotionStarter\inc\editor;


/**
 * add style for gutenberg editor block
 */
function gutenberg_css()
{
  // you must use this method because wp adapt css to gutenberg frame
  add_theme_support('editor-styles');
  add_editor_style('style-editor.css');
}


/**
 * gutenberg settings
 */
function gutenberg_settings()
{
  add_theme_support('editor-font-sizes', array(
    array(
      'name' => __('regular', 'gm-starter-theme'),
      'shortName' => __('M', 'gm-starter-theme'),
      'size' => '1rem',
      'slug' => 'regular'
    ),
  ));

  add_theme_support(
    'editor-color-palette',
    array(
      array('name' => 'accent', 'slug'  => 'accent', 'color' => '#450B40'),
    )
  );

  add_theme_support('editor-gradient-presets', []);

  add_theme_support('disable-custom-colors');
  add_theme_support('disable-custom-gradients');
  add_theme_support('disable-custom-font-sizes');
  add_theme_support('align-wide');
  add_theme_support('core-block-patterns');
  add_theme_support('responsive-embeds');
  //    add_theme_support( 'custom-line-height' );
  add_theme_support('custom-spacing');
  add_theme_support('wp-block-styles');
  remove_theme_support('core-block-patterns');
}


/**
 * remove blocl gutenberg
 */
function allowed_block_types($allowed_blocks)
{
  $registered_blocks = \WP_Block_Type_Registry::get_instance()->get_all_registered();

  // specify all the blocks you would like to disable here
  unset($registered_blocks['core/verse']);
  unset($registered_blocks['core/social-link-soundcloud']);

  // now $registered_blocks contains only blocks registered by plugins, but we need keys only
  $registered_blocks = array_keys($registered_blocks);

  // merge the whitelist with plugins blocks
  $allowed_blocks = array_merge(
    array(
      'core/image',
      'core/paragraph',
      'core/heading',
      'core/list',
    ),
    $registered_blocks
  );

  return $allowed_blocks;
}


/**
 * set editor full width
 */
add_action('admin_head', function () {
  echo '<style>
  .editor-styles-wrapper {
    max-width: none !important;
    margin: 0 auto;
  }
  </style>';
});

/**
 * enqueue script for editor settings
 */
function editor_enqueue()
{
  wp_enqueue_script('custom-editor-script', get_template_directory_uri() . '/editor/js/reset.js', array('wp-blocks', 'wp-dom-ready', 'wp-edit-post'), '1.0', true);
}


add_action('init', __NAMESPACE__ . '\gutenberg_css');
add_action('after_setup_theme', __NAMESPACE__ . '\gutenberg_settings');
add_filter('allowed_block_types_all', __NAMESPACE__ . '\allowed_block_types', 10, 2);
add_action('enqueue_block_editor_assets', __NAMESPACE__ . '\editor_enqueue');
