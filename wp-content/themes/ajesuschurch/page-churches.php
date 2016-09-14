<?php
/*
 * Template Name: Network Churches Page
 */

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );

// NOTE: blog.site_id really means network_id
$network_site_id = get_current_blog_id();
$context['sites'] = get_ajc_locations();

// Uses media library for files
if ( isset($page->full_doctrine) ) {
	$full_doctrine = new TimberImage( $page->full_doctrine );
	$context['doctrine_file_src'] = $full_doctrine->src();
}

// Render the page
Timber::render( 'pages/churches.twig', $context );