<?php
/*
 * Template Name: Church Scatter Page
 */

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );

// Render the page
Timber::render( 'pages/scatter.twig', $context );
