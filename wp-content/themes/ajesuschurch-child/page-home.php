<?php
/*
 * Template Name: Church Home Page
 */

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );

// Get upcoming and standing events
require_once ( get_template_directory() .'/lib/events-query.php' );

// Menu tiles
$context['gather_tile_id'] = get_page_by_title('Gather')->tile_image;
$context['scatter_tile_id'] = get_page_by_title('Scatter')->tile_image;
$context['serve_tile_id'] = get_page_by_title('Serve')->tile_image;
$context['give_tile_id'] = get_page_by_title('Give')->tile_image;

// Render the page
Timber::render( 'pages/home.twig', $context );
