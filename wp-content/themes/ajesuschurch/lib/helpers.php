<?php
/*
Author: Belief
URL: http://beliefagency.com

General reusable functions for the theme.
*/

function the_attr( $arr, $attr ) {
	if (isset( $arr[$attr] )) {
		echo esc_attr( $arr[$attr] );
	}
}

/************* NETWORK SITES ***************/

function get_ajc_locations() {
	global $ajc_options;

	// Sites with network/primary site removed
	$sites = wp_get_sites( array( 'public' => 1 ) );
	array_shift( $sites );

	// Store current blog id
	$active_blog_id = get_current_blog_id();

	// Gather sites and settings
	for ( $i=0; $i<count($sites); $i++ ) {
		switch_to_blog( $sites[$i]['blog_id'] );
		$settings = get_option( 'ajc_options', $ajc_options );

		// Iterate over settings
		foreach ( $settings as $key => $value ) {
			$sites[$i][$key] = $settings[$key];
		}

		// Add blog info
		foreach ( array('name', 'description', 'url') as $key ) {
			$sites[$i][$key] = get_bloginfo($key);
		}
	}
	switch_to_blog( $active_blog_id );
	// Did not perform the expected behavior after duplicating
	// the first blog. It appears to only restore the blog to
	// its precursor value, not the original value.
	// restore_current_blog();

	// Sort sites by tile_position
	usort( $sites, function( $a, $b ) {
		if ( is_numeric( $a['tile_position'] ) && is_numeric( $b['tile_position'] ) )
			return ( $a['tile_position'] < $b['tile_position'] ) ? -1 : 1;
		else return -1;
	} );

	return $sites;
}

// Grab an option from the current site
function get_ajc_option( $key ) {
	global $ajc_options;
	$settings = get_option( 'ajc_options', $ajc_options );
	return $settings[$key];
}

// Are we running the network site?
function is_network_site() {
	return (get_current_blog_id() == 1);
}

/************* BLOG SELECTS ***************/

function categories_select($prompt = 'Select Category') { ?>
	<form action="<?php bloginfo('url'); ?>/" method="get">
	<div class="btn-select"><span><?php echo $prompt; ?></span>
	<?php
		$curr_id = 0;
		if ( get_queried_object() ) {
			$curr_id = get_queried_object()->term_id;
		}
		$select = wp_dropdown_categories('show_option_none='. $prompt .'&show_count=1&orderby=name&echo=0&selected='. $curr_id);
		$select = preg_replace("#<select([^>]*)>#", "<select$1 onchange='return this.form.submit()'>", $select);
		echo $select;
	?>
	</div>
	<noscript><input type="submit" value="View" /></noscript>
	</form><?php
}

function locations_select($prompt = 'Select Location') { ?>
	<form action="<?php bloginfo('url'); ?>/" method="get">
	<div class="btn-select"><span><?php echo $prompt; ?></span>
	<select name="tag" id="tag" class="postform" onchange="document.location.href=this.options[this.selectedIndex].value;">
	<option value='-1'><?php echo $prompt; ?></option>
	<?php
	$curr_id = 0;
	if ( get_queried_object() ) {
		$curr_id = get_queried_object()->term_id;
	}
	$locations = get_tags();
	foreach ( $locations as $location ) :
		$is_location = get_option( 'post_tag_'. $location->term_id .'_location_tag' );
		if ( $is_location ) : ?>
		<option class="level-0" value="<?php echo get_tag_link($location->term_id); ?>" <?php if ( $location->term_id == $curr_id ) echo 'selected'; ?>><?php echo $location->name; ?></option>
		<?php endif; ?>
	<?php endforeach; ?>
	</select></div>
	<noscript><input type="submit" value="View" /></noscript>
	</form><?php
}
