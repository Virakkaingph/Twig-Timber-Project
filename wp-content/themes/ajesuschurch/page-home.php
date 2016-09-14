<?php
/*
 * Template Name: Network Home Page
 */

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );

// NOTE: blog.site_id really means network_id
$network_site_id = get_current_blog_id();
$context['sites'] = get_ajc_locations();

// Render the page
Timber::render( 'pages/home.twig', $context );
