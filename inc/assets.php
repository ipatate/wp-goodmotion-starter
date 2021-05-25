<?php

namespace GoodmotionStarter\inc\assets;

/**
 * get manifest file generated by vite
 */
function getManifest() {
    $strJsonFileContents = file_get_contents(dirname(__FILE__) . "/../dist/manifest.json");
    return json_decode($strJsonFileContents);
}

/**
 * Register the JavaScript for the public-facing side of the site.
 */
function enqueue_scripts()
{
    add_action('wp_enqueue_scripts', function () {
        $path = get_template_directory_uri();

        if (WP_ENV !== 'development') {
            // get file name from manifest
            $config = getManifest();
            $files = get_object_vars($config);

            foreach ($files as $key => $value) {
                $file = $config->{$key}->file;
                // get token file
                $k = explode('.', $file);
                $token = $k[1];
                wp_enqueue_script('goodmotion-starter-theme-' . $token, $path . '/dist/' . $file, array(), $token, true);
            }

        } else {

            // add module attribute for dev
            add_filter('script_loader_tag', function($tag, $handle, $src) {
                if ( 'goodmotion-starter-theme' !== $handle ) {
                    return $tag;
                }
                // change the script tag by adding type="module" and return it.
                $tag = '<script type="module" crossorigin src="' . esc_url( $src ) . '"></script>';
                return $tag;
            } , 10, 3);

            wp_enqueue_script('goodmotion-starter-theme', 'http://localhost:3000/main.js');

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
                    $css = $config->{$key}->css;
                    if ($css) {
                        // $css is array
                        foreach ($css as $file) {
                            $k = explode('.', $file);
                            $token = $k[1];
                            wp_enqueue_style('goodmotion-starter-theme-' . $token, $path . '/dist/' . $file, array(),
                                $token, 'all');
                        }
                    }
                }
            }
        }
    );
}



add_action('init', __NAMESPACE__ . '\enqueue_scripts');
add_action('init', __NAMESPACE__ . '\enqueue_styles');
