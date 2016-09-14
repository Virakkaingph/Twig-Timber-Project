<?php
/*
Author: Belief
URL: http://beliefagency.com

This is where you should register custom post types.
*/

add_action( 'init', 'ajc_church_post_types' );

function ajc_church_post_types() {

	/************* TEACHING TAXONOMY ***************/

	register_taxonomy( 'teaching_series',
		array( 'teaching' ),
		array( 'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Teaching Series', 'ajc' ),
				'singular_name' => __( 'Teaching Series', 'ajc' ),
				'search_items' =>  __( 'Search Teaching Series', 'ajc' ),
				'all_items' => __( 'All Teaching Series', 'ajc' ),
				'edit_item' => __( 'Edit Teaching Series', 'ajc' ),
				'update_item' => __( 'Update Teaching Series', 'ajc' ),
				'add_new_item' => __( 'Add New Teaching Series', 'ajc' ),
				'new_item_name' => __( 'New Teaching Series Name', 'ajc' )
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'public' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'series', 'with_front' => false ) // 'hierarchical' => true
		)
	);

	/************* TEACHING POST TYPE ***************/

	register_post_type( 'teaching',
		array(
			'labels' => array(
				'name' => __( 'Teachings', 'ajc' ),
				'singular_name' => __( 'Teaching', 'ajc' ),
				'all_items' => __( 'All Teachings', 'ajc' ),
				'add_new_item' => __( 'Add Teaching', 'ajc' ),
				'edit_item' => __( 'Edit Teaching', 'ajc' ),
				'new_item' => __( 'New Teaching', 'ajc' ),
				'view_item' => __( 'View Teaching', 'ajc' ),
				'search_items' => __( 'Search Teachings', 'ajc' )
			),
			'extras' => array( 'enter_title_here' => __( 'Enter Title', 'ajc' ) ),
			'description' => __( 'Teachings', 'ajc' ),
			'supports' => array( 'title', 'editor', 'excerpt' ), // 'thumbnail', 'author', 'revisions', 'sticky', 'custom-fields'
			'taxonomies' => array( 'teaching_series', 'post_tag' ),
			'show_ui' => true,
			'public' => true,
			'menu_position' => 6,
			'rewrite' => array( 'slug' => 'teaching', 'with_front' => true ),
			'exclude_from_search' => false,
			'has_archive' => false
		)
	);

	/************* STAFF MEMBER TAXONOMY ***************/

	register_taxonomy( 'primary_role',
		array( 'staff_member' ),
		array( 'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Primary Role', 'ajc' ),
				'singular_name' => __( 'Primary Role', 'ajc' ),
				'search_items' =>  __( 'Search Primary Roles', 'ajc' ),
				'all_items' => __( 'All Primary Roles', 'ajc' ),
				'edit_item' => __( 'Edit Primary Role', 'ajc' ),
				'update_item' => __( 'Update Primary Role', 'ajc' ),
				'add_new_item' => __( 'Add New Primary Role', 'ajc' ),
				'new_item_name' => __( 'New Primary Role Name', 'ajc' )
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'public' => false,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'roles' ),
		)
	);

	/************* STAFF MEMBER POST TYPE ***************/

	register_post_type( 'staff_member',
		array(
			'labels' => array(
				'name' => __( 'Staff Members', 'ajc' ),
				'singular_name' => __( 'Staff Member', 'ajc' ),
				'all_items' => __( 'All Staff Members', 'ajc' ),
				'add_new_item' => __( 'Add New Staff Member', 'ajc' ),
				'edit_item' => __( 'Edit Staff Member', 'ajc' ),
				'new_item' => __( 'New Staff Member', 'ajc' ),
				'view_item' => __( 'View Staff Member', 'ajc' )
			),
			'extras' => array( 'enter_title_here' => __( 'Enter Full Name', 'ajc' ) ),
			'description' => __( 'Staff Members', 'ajc' ),
			'supports' => array( 'title', 'thumbnail'),
			'taxonomies' => array( 'primary_role', 'post_tag' ),
			'show_ui' => true,
			'public' => false,
			'menu_position' => 9,
			'rewrite' => array( 'slug' => 'people', 'with_front' => true ),
			// TODO: Should appear in search but link to /serve
			'exclude_from_search' => true,
			'has_archive' => false
		)
	);
  
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
			'menu_position' => 10,
			'rewrite' => array( 'slug' => 'releases', 'with_front' => false ),
			// TODO: Should appear in search but link to /music
			'exclude_from_search' => true,
			'has_archive' => false
		)
	);

}
