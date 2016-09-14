<?php
/*
 * Template Name: Network Music Page
 */

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );

// Get music releases
$limit = 'posts_per_page=60';
$order = 'orderby=menu_order&order=asc';
$context['releases'] = Timber::get_posts('post_type=music_release&'. $limit .'&'. $order);

// Render the page
Timber::render( 'pages/music.twig', $context );
