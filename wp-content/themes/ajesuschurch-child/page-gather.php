<?php
/*
 * Template Name: Church Gather Page
 */

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );

// Custom query
$context['ministries'] = Timber::get_terms('ministry', array(
	'orderby' => 'term_order',
	'order' => 'ASC'
));

// Render the page
Timber::render( 'pages/gather.twig', $context );
