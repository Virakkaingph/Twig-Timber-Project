<?php
/*
 * Template Name: Church Bible Listen Page
 */

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );

// Render the page
Timber::render( 'pages/bible-listen.twig', $context );