<?php
/*
Author: Belief
URL: http://beliefagency.com

This is where you should register custom post types.
*/

add_action( 'init', 'ajc_network_post_types' );

function ajc_network_post_types() {

	/************* MUSIC RELEASE POST TYPE ***************/

	register_post_type( 'music_release',
		array(
			'labels' => array(
				'name' => __( 'Music Releases', 'ajc' ),
				'singular_name' => __( 'Music Release', 'ajc' ),
				'all_items' => __( 'All Music Releases', 'ajc' ),
				'add_new_item' => __( 'Add Music Release', 'ajc' ),
				'edit_item' => __( 'Edit Music Release', 'ajc' ),
				'new_item' => __( 'New Music Release', 'ajc' ),
				'view_item' => __( 'View Music Release', 'ajc' ),
				'search_items' => __( 'Search Music Releases', 'ajc' )
			),
			'extras' => array( 'enter_title_here' => __( 'Enter Release Title', 'ajc' ) ),
			'description' => __( 'Music Releases', 'ajc' ),
			'supports' => array( 'title' ), // 'editor', 'thumbnail'
			'show_ui' => true,
			'public' => false,
			'menu_position' => 4,
			'rewrite' => array( 'slug' => 'releases', 'with_front' => false ),
			// TODO: Should appear in search but link to /music
			'exclude_from_search' => true,
			'has_archive' => false
		)
	);

}
