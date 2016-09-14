<?php
/*
 * Template Name: Network Page
 */

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );

// Render the page
Timber::render( 'pages/default.twig', $context );
