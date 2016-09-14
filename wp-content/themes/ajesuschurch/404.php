<?php

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );

// Use home page banner & foreground
$home_page_id = get_option('page_on_front');
$home_page = new TimberPost( $home_page_id );
$context['header_bg'] = set_bg_id( $home_page->hero_graphic, 'hero-graphic' );
$context['foreground'] = $home_page->foreground;

// Render the page
Timber::render('pages/404.twig', $context);
