<?php
/*
 * Template Name: Church Missional Community Page
 */

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );

// Render the page
Timber::render( 'pages/missional-community.twig', $context );
