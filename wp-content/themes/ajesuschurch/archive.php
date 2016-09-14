<?php
/*
 * Template Name: Network Blog Archive Page
 */

global $num_posts;

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );
require_once ( get_template_directory() .'/lib/blog-context.php' );

// Customize query
$args = array(
    'offset' => $num_posts + 1 + ( ($paged - 1) * 12 ),
    'posts_per_page' => 12,
    'paged' => $paged
);
/* THIS LINE IS CRUCIAL */
/* in order for WordPress to know what to paginate */
/* your args have to be the defualt query */
query_posts($args);

$context['posts'] = Timber::get_posts(); // ('posts_per_page=100&offset='. ($num_posts + 1));
$context['pagination'] = Timber::get_pagination();

// Render the page
Timber::render('blog/archive.twig', $context);
