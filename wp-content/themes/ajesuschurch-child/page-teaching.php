<?php
/*
 * Template Name: Church Teaching Page
 */

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );

// Custom queries
$all_series = Timber::get_terms('teaching_series', array('hide_empty' => 0) );
$active_series = array_shift( $all_series );
$context['past_series'] = $all_series;

// Lessons for most recent series
$args = array(
	'post_type' => 'teaching',
	'posts_per_page' => 999,
	'meta_key' => 'teaching_date',
	'orderby' => 'meta_value', // menu_order
	'order' => 'DESC',
);
$context['series_lessons'] = $active_series->get_posts( $args );
$context['current_series'] = $active_series;

// Most recent lesson Vimeo ID
$lesson_count = count($context['series_lessons']);
if ( $lesson_count > 0 ) {
	$context['hero_vimeo_id'] = $context['series_lessons'][$lesson_count - 1]->vimeo_id;
}

// Use current series as hero image
$context['header_bg'] = set_bg_id( $active_series->poster_image, 'hero-film' );
$context['hero_graphic'] = $active_series->poster_image;
$context['foreground'] = $active_series->foreground;
$context['watch_button_text'] = 'Watch this teaching';

// Render the page
Timber::render( 'pages/teaching.twig', $context );
