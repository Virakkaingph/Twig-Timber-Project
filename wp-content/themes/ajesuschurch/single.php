<?php
/*
 * Template Name: Network Blog Post Page
 */

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );
require_once ( get_template_directory() .'/lib/blog-context.php' );

// Render the page
Timber::render('blog/single.twig', $context);
