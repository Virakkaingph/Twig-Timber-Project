<?php

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );

// Lessons for current series
$term_list = wp_get_post_terms($post->ID, 'teaching_series', array('fields' => 'all'));
$current_series = new TimberTerm($term_list[0]->term_id);
$context['series'] = $current_series;

// Use media library for files
/*if ( isset($post->audio_file) ) {
	$audio_file = new TimberImage( $post->audio_file );
	$context['audio_file_src'] = $audio_file->src();
}*/

// Use current series as hero image
$context['header_bg'] = set_bg_id( $current_series->poster_image, 'hero-film' );
$context['hero_graphic'] = $current_series->poster_image;
$context['foreground'] = $current_series->foreground;
$context['watch_button_text'] = 'Watch this teaching';

// Render the page
Timber::render( 'teaching/single.twig', $context );
