<?php
// Using two queries here vastly simplifies the events
// query, which gives a 'pull down' date for events as
// well as the option of leaving an event up indefinitely.
//
// Events work the same way in multiple places on the site--
// they are pulled from a ministry taxonomy term. For
// this script to work for categories, make sure to have
// $term defined before including it.  Otherwise, all events
// will be queried for this site (home page case).

// Matches the jquery-ui date format 'yymmdd'
// which is the value stored in the meta field
$today = date('Ymd');

// Custom queries
$args = array(
	'post_type' => 'event',
	'posts_per_page' => 999,
	'meta_query' => array(
		// Has not yet expired
		array(
			'key' => 'expiration',
			'compare' => '>=',
			'value' => $today,
		)
	),
	'meta_key' => 'expiration',
	'orderby' => 'meta_value',
	'order' => 'ASC',
);
$upcoming = isset($term) ? $term->get_posts( $args ) : Timber::get_posts( $args );

$args = array(
	'post_type' => 'event',
	'posts_per_page' => 999,
	'meta_query' => array(
		// Has no expiration
		array(
			'key' => 'expiration',
			'compare' => '=',
			'value' => ''
		)
	),
	'orderby' => 'date',
	'order' => 'DESC',
);
$standing = isset($term) ? $term->get_posts( $args ) : Timber::get_posts( $args );

// Add data to context
$context['upcoming_events'] = $upcoming;
$context['standing_events'] = $standing;
$context['has_events'] = count( $upcoming ) + count( $standing );
