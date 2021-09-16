<?php

namespace GoodmotionStarter\inc\images;

/**
 * resize image and add prefetch to head
 */
function prefetch_images($hero)
{
  $hasWebP = (strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false || strpos($_SERVER['HTTP_USER_AGENT'], ' Chrome/') !== false);
  if (!$hero || count($hero) === 0) return;
  // get path
  $path = explode('/', $hero[0]['image']['url']);
  $relativePath = preg_replace('#^(://|[^/])+#', '', $hero[0]['image']['url']);
  array_pop($path);
  $imagePath = str_replace($hero[0]['image']['filename'], '', $relativePath);
  // get image name and extension
  $split = explode('.', $hero[0]['image']['filename']);
  $sizes = [[1400, 800], [1000, 600], [600, 550]];
  foreach ($sizes as $key => $value) {
    $op = new \Timber\Image\Operation\Resize($value[0], $value[1], 'default');
    $imageName = $op->filename($split[0], $split[1]);
    $op->run($hero[0]['image']['filename'], $imageName);
    $imageName = \Timber\ImageHelper::img_to_jpg($imagePath . $imageName);
    if ($hasWebP) {
      $imageName = \Timber\ImageHelper::img_to_webp($imageName);
    }
    add_action(
      'wp_head',
      function () use ($imageName) {
        echo '<link rel="preload" href="' . $imageName . '" as="image" />';
      }
    );
  }
}
