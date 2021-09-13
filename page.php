<?php

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/templates/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::context();
$timber_post     = new Timber\Post();
$context['post'] = $timber_post;


function prefetch_images($hero)
{
  $hasWebP = (strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false ||  strpos($_SERVER['HTTP_USER_AGENT'], ' Chrome/') !== false);
  if (!$hero || count($hero) === 0) return;
  // get path
  $path = explode('/', $hero[0]['image']['url']);
  $relativePath = preg_replace('#^(://|[^/])+#', '', $hero[0]['image']['url']);
  array_pop($path);
  $imagePath = implode('/', $path);
  // get image name and extension
  $split = explode('.', $hero[0]['image']['filename']);
  $sizes = [[1400, 800], [1000, 600], [600, 550]];
  foreach ($sizes as $key => $value) {
    $op = new Timber\Image\Operation\Resize($value[0], $value[1], 'default');
    $imageName = $op->filename($split[0], $split[1]);
    $op->run($hero[0]['image']['filename'], $imageName);
    $imageName = Timber\ImageHelper::img_to_jpg($relativePath);
    if ($hasWebP) {
      $imageName = Timber\ImageHelper::img_to_webp($imageName);
    }
    add_action(
      'wp_head',
      function () use ($imageName) {
        echo '<link rel="preload" href="' . $imageName . '" as="image" />';
      }
    );
  }
}
prefetch_images($timber_post->meta("page_hero"));
Timber::render(array('page-' . $timber_post->post_name . '.twig', 'page.twig'), $context);
