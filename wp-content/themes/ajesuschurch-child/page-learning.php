<?php
/*
 * Template Name: Church Learning Page
 */

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );

// Uses media library for files
if ( isset($context['page']->reading_plan) ) {
	$reading_plan = new TimberImage( $context['page']->reading_plan );
	$context['reading_plan_src'] = $reading_plan->src();
}

// Render the page
Timber::render( 'pages/learning.twig', $context );
