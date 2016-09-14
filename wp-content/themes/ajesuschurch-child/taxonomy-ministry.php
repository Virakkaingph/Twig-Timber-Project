<?php

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );

// Get upcoming and standing events
require_once ( get_template_directory() .'/lib/events-query.php' );

// Add data to context
$context['ministry'] = $term;

// Render the page
Timber::render( 'pages/ministry.twig', $context );
