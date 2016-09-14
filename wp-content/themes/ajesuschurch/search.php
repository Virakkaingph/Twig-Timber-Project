<?php
/*
 * Template Name: Search Results
 */

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );
require_once ( get_template_directory() .'/lib/blog-context.php' );

// Grab the results
$context['posts'] = Timber::get_posts();

// Render the page
Timber::render('pages/search.twig', $context);
