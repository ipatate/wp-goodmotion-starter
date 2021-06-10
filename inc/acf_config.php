<?php

namespace GoodmotionStarter\inc\acf_config;

function register_acf_options_pages()
{
  // add page for setting section social wall
  if (function_exists('acf_add_options_page')) {


    acf_add_options_page(array(
      'page_title'     => __('General Settings', 'goodmotion-theme'),
      'menu_title'    => __('General Settings', 'goodmotion-theme'),
      'menu_slug'     => 'general-settings',
      'capability'    => 'edit_posts',
      'position' => '50',
      // 'redirect'		=> false
    ));

    acf_add_options_sub_page([
      'page_title' => __('Social settings', 'goodmotion-theme'),
      'capability' => 'edit_posts',
      'parent_slug'     => 'general-settings',
    ]);

//    acf_add_options_sub_page([
//      'page_title' => __('Text content', 'goodmotion-theme'),
//      'capability' => 'edit_posts',
//      // 'position' => '50',
//      'parent_slug'    => 'general-settings',
//    ]);
//
//    acf_add_options_sub_page([
//      'page_title' => __('Terms and conditions', 'goodmotion-theme'),
//      'capability' => 'edit_posts',
//      // 'position' => '50',
//      'parent_slug'    => 'general-settings',
//    ]);
  }
}

add_action('init', __NAMESPACE__ . '\register_acf_options_pages');
