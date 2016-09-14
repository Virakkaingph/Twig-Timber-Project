<?php
/*
Author: Belief
URL: http://beliefagency.com

This is where you should register custom post types.
*/

add_action( 'init', 'ajc_register_post_types' );

function ajc_register_post_types() {

	/************* MINISTRY TAXONOMY ***************/

	register_taxonomy( 'ministry',
		array('event'),
		array('hierarchical' => true, // Better UI
			'labels' => array(
				'name' => __( 'Ministries', 'ajc' ),
				'singular_name' => __( 'Ministry', 'ajc' ),
				'search_items' =>  __( 'Search Ministries', 'ajc' ),
				'all_items' => __( 'All Ministries', 'ajc' ),
				'edit_item' => __( 'Edit Ministry', 'ajc' ),
				'update_item' => __( 'Update Ministry', 'ajc' ),
				'add_new_item' => __( 'Add New Ministry', 'ajc' ),
				'new_item_name' => __( 'New Ministry Name', 'ajc' )
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'public' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'ministries' )
		)
	);

	/************* EVENT POST TYPE ***************/

	register_post_type( 'event',
		array(
			'labels' => array(
				'name' => __( 'Events', 'ajc' ),
				'singular_name' => __( 'Event', 'ajc' ),
				'all_items' => __( 'All Events', 'ajc' ),
				'add_new_item' => __( 'Add Event', 'ajc' ),
				'edit_item' => __( 'Edit Event', 'ajc' ),
				'new_item' => __( 'New Event', 'ajc' ),
				'view_item' => __( 'View Event', 'ajc' ),
				'search_items' => __( 'Search Events', 'ajc' )
			),
			'supports' => array( 'title', 'editor' ),
			'extras' => array( 'enter_title_here' => __( 'Enter Event Name', 'ajc' ) ),
			'taxonomies' => array( 'ministry' ),
			'show_ui' => true,
			'public' => false,
			'menu_position' => 7,
			'rewrite' => array( 'slug' => 'events' ),
			'exclude_from_search' => true,
			'has_archive' => false
		)
	);

}

/************* CUSTOMIZE SLUGS ***************/

add_filter( 'wp_unique_post_slug', 'custom_unique_post_slug', 10, 4 );
function custom_unique_post_slug( $slug, $post_ID, $post_status, $post_type ) {
	// For events use a timestamp
	if ( 'event' == $post_type ) {
		$post = get_post($post_ID);
		if ( empty($post->post_name) || $slug != $post->post_name ) {
			$slug = time();
		}
	}
	return $slug;
}
