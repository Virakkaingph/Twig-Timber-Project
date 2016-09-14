<?php
/*
 * Template Name: Church Bookstore Page
 */

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );

// Render the page
Timber::render( 'pages/bookstore.twig', $context );
