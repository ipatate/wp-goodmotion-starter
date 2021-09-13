<?php

namespace GoodmotionStarter\inc\assets;

/**
 * get manifest file generated by vite
 */
function getManifest()
{
  $strJsonFileContents = file_get_contents(dirname(__FILE__) . "/../dist/manifest.json");
  return json_decode($strJsonFileContents);
}

/**
 * Register the JavaScript for the public-facing side of the site.
 */
function enqueue_scripts()
{
  add_filter('script_loader_tag', function ($tag, $handle, $src) {
    if (strpos($handle, 'goodmotion-starter-theme') === false) {
      return $tag;
    }
    // change the script tag by adding type="module" and return it.
    $tag = '<script type="module" crossorigin src="' . esc_url($src) . '"></script>';
    return $tag;
  }, 10, 3);

  add_action('wp_enqueue_scripts', function () {
    $path = get_template_directory_uri();

    if (WP_ENV !== 'development') {
      // get file name from manifest
      $config = getManifest();
      $files = get_object_vars($config);
      // set polyfill on first
      //            foreach ($files as $key => $value) {
      //              if($key === 'vite/legacy-polyfills') {
      //                $file = $config->{$key}->file;
      //                // get token file
      //                $k = explode('.', $file);
      //                $token = $k[1];
      //                wp_enqueue_script('goodmotion-starter-theme-' . $token, $path . '/dist/' . $file, array(), $token, true);
      //              }
      //            }

      foreach ($files as $key => $value) {
        //              if($key !== 'vite/legacy-polyfills') {
        $file = $config->{$key}->file;

        // get token file
        $k = explode('.', $file);
        $token = $k[1];
        wp_enqueue_script('goodmotion-starter-theme-' . $token, $path . '/dist/' . $file, array(), $token, true);
        //              }
      }
    } else {

      wp_enqueue_script('goodmotion-starter-theme', 'http://localhost:3000/main.js', [
        //                'wp-block-editor',
        //                'wp-blocks',
        //                'wp-editor',
        //                'wp-components',
        //                'wp-compose',
        //                'wp-data',
        //                'wp-element',
        //                'wp-hooks',
        //                'wp-i18n',
        //                'wp-blocks',
        //                'wp-i18n',
        //                'wp-element',
      ]);
    }
  });
}


/**
 * Register the CSS
 */
function enqueue_styles()
{
  add_action(
    'wp_enqueue_scripts',
    function () {
      $path = get_template_directory_uri();
      if (WP_ENV !== 'development') {
        // get file name from manifest
        $config = getManifest();
        $files = get_object_vars($config);
        // search css key
        foreach ($files as $key => $value) {
          if (property_exists($config->{$key}, 'css')) {
            $css = $config->{$key}->css;
            // $css is array
            foreach ($css as $file) {
              $k = explode('.', $file);
              $token = $k[1];
              wp_enqueue_style(
                'goodmotion-starter-theme-' . $token,
                $path . '/dist/' . $file,
                array(),
                $token,
                'all'
              );
            }
          }
        }
      }
    }
  );
}



/**
 * Completely Remove jQuery From WordPress if not admin and is not connected
 */
function removeJquery()
{
  if ($GLOBALS['pagenow'] !== 'wp-login.php' && !is_admin() && !is_user_logged_in()) {
    wp_deregister_script('jquery');
    wp_register_script('jquery', false);
  }
}


add_action('init', __NAMESPACE__ . '\removeJquery');
add_action('init', __NAMESPACE__ . '\enqueue_scripts');
add_action('init', __NAMESPACE__ . '\enqueue_styles');
