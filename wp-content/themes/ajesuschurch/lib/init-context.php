<?php
/*
 * Use to initialize context and reduce duplication
 * in our template files.
 */

global $ajc_options;

if ( !class_exists('Timber') ) {
	echo 'Timber not activated. Activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
}

// Normalize pagination value
global $paged;
if (!isset($paged) || !$paged){
    $paged = 1;
}

// Make accessible to every screen
$context = Timber::get_context();
$context['settings'] = get_option( 'ajc_options', $ajc_options );
$context['nowhere'] = 'javascript:void(0)';

// Timber isn't smart enough to grab blog page id
$post_id = 0;
if ( $post ) {
	$post_id = $post->ID;
}
if ( is_home() ) {
	$post_id = get_option('page_for_posts');
}
if ( $post_id ) {
	$post = $page = new TimberPost( $post_id );
	$context['page'] = $context['post'] = $post;
}

if ( get_queried_object() ) {
	// Page might be a category rather than a post
	$term_id = get_queried_object()->term_id;
	$term_taxonomy = get_queried_object()->taxonomy;
	if ( $term_id ) {
		$term = new TimberTerm( $term_id, $term_taxonomy );
		$context['term'] = $term;
	}
}

// Find appropriate hero/vibe graphic (hero takes precedence)

if ( isset($post->hero_graphic) && $post->hero_graphic > 0 ) {
	$context['header_bg'] = set_bg_id( $post->hero_graphic, 'hero-film' );
	$context['hero_graphic'] = $post->hero_graphic;

}
else if ( isset($term->hero_graphic) && $term->hero_graphic > 0 ) {
	$context['header_bg'] = set_bg_id( $term->hero_graphic, 'hero-film' );
	$context['hero_graphic'] = $term->hero_graphic;

}
// Special case for teaching series
else if ( isset($term->poster_image) && $term->poster_image > 0 ) {
	$context['header_bg'] = set_bg_id( $term->poster_image, 'hero-film' );
	$context['hero_graphic'] = $term->poster_image;
}
else if ( isset($post->vibe_banner) && $post->vibe_banner > 0 ) {
	$context['header_bg'] = set_bg_id( $post->vibe_banner, 'vibe-banner' );
}
else if ( isset($term->vibe_banner) && $term->vibe_banner > 0 ) {
	$context['header_bg'] = set_bg_id( $term->vibe_banner, 'vibe-banner' );
}

// Find hero phrase
if ( isset($post->hero_phrase) ) {
	$context['hero_phrase'] = $post->hero_phrase;
}
else if ( isset($term->hero_phrase) ) {
	$context['hero_phrase'] = $term->hero_phrase;
}

// Find hero font size
if ( isset($post->hero_font_size) ) {
	$context['hero_font_size'] = $post->hero_font_size;
}
else if ( isset($term->hero_font_size) ) {
	$context['hero_font_size'] = $term->hero_font_size;
}

// Find vimeo id
if ( isset($post->vimeo_id) ) {
	$context['hero_vimeo_id'] = $post->vimeo_id;
}
else if ( isset($term->vimeo_id) ) {
	$context['hero_vimeo_id'] = $term->vimeo_id;
}

// Find button text
if ( isset($post->watch_button_text) ) {
	$context['watch_button_text'] = $post->watch_button_text;
}
else if ( isset($term->watch_button_text) ) {
	$context['watch_button_text'] = $term->watch_button_text;
}


////////////////////////////////////
if ( isset($post->custom_url) ) {
	$context['hero_custom_url'] = $post->custom_url;
}
else if ( isset($term->custom_url) ) {
	$context['hero_custom_url'] = $term->custom_url;
}

// Find button text
if ( isset($post->custom_url_button) ) {
	$context['custom_url_button'] = $post->custom_url_button;
}
else if ( isset($term->custom_url_button) ) {
	$context['custom_url_button'] = $term->custom_url_button;
}



/////////////////////////////////////

// Find the foreground color
$context['foreground'] = 'white';
if ( isset($post->foreground) ) {
	$context['foreground'] = $post->foreground;
}
else if ( isset($term->foreground) ) {
	$context['foreground'] = $term->foreground;
}
else {
	// echo "Foreground not set!";
}

//find custom field
$context['chek_vimeo'] = new TimberPost(get_field('vimeo'));



// Darken hero image?
$context['darken_header'] = '';
if ( (isset($post->darken_header) && $post->darken_header) ||
     (isset($term->darken_header) && $term->darken_header) ) {
	$context['darken_header'] = 'darken-header';
}

$context['hero_header'] = '';
if ( (isset($post->hero_graphic) && $post->hero_graphic) ||
     (isset($term->hero_graphic) && $term->hero_graphic) ) {
	$context['hero_header'] = 'hero-header';
}
