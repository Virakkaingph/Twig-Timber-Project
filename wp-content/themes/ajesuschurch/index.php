<?php
/*
 * Template Name: Network Blog Page
 */

global $num_posts;

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );

// Customize blog queries
$featured_query = Timber::get_posts('posts_per_page=1');
$context['featured'] = $featured_query[0];
$context['posts'] = Timber::get_posts('offset=1&posts_per_page='. $num_posts);

// Paging behavior
$context['more_articles'] = true; // TODO: total > $num_posts + 1

// Render the page
Timber::render('pages/blog.twig', $context);
