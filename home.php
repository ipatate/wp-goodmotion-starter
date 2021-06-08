<?php /* Template Name: Home page Template */

$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
Timber::render(array('home.twig', 'page.twig'), $context);
