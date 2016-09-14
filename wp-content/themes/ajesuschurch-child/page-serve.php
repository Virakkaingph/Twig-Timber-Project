<?php
/*
 * Template Name: Church Serve Page
 */

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );

// Custom query
$context['staff_members'] = Timber::get_posts('post_type=staff_member&orderby=menu_order&posts_per_page=60');

// Render the page
Timber::render( 'pages/serve.twig', $context );
