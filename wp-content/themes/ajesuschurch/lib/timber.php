<?php
/*
Author: Belief
URL: http://beliefagency.com

These are settings and global variables
used for Timber, our templating system.
*/


add_action('init', function() {
	// Set views directory
	if ( defined('Timber') )
		Timber::$dirname = 'views';
});



/************* VIEW HELPERS ***************/

function template_url() {
	return get_template_directory_uri();
}

function assets_url() {
	return get_template_directory_uri() .'/assets';
}

function page_url( $name ) {
	return get_page_link( get_page_by_title( $name )->ID );
}

function network_page_url( $name ) {
	switch_to_blog( 1 );
	$url = page_url( $name );
	restore_current_blog();
	return $url;
}

// http://wordpress.org/plugins/download-shortcode/other_notes/
// add_filter( 'fds_rewrite_urls', '__return_false' );
/*function download_link( $url, $label ) {
	return do_shortcode( '[download label="'. $label .'"]'. $url .'[/download]' );
}*/

function audio_player( $audio_url ) {
	$code = '[sc_embed_player_template1 fileurl="'. $audio_url .'"]';
	return do_shortcode( $code );

}

function build_link( $url, $label ) {
	return '<a href="'. $url .'">'. $label .'</a>';
}

function page_title() {
	return bloginfo( 'name' ) . wp_title( ' &lsaquo; ', true, 'left' );
}

function banner_url() {
	if ( is_page() ) {
		$image = get_sub_field( 'banner' );
		return $image['sizes']['vibe-banner'];
	}
	return false;
}

function img_src( $id, $thumb_size ) {
	$image = new TimberImage( $id );
	return $image->src( $thumb_size );
}

function set_bg( $url ) {
	return 'style="background-image:url('. $url .')"';
}

function set_bg_id( $id, $thumb_size ) {
	return set_bg( img_src( $id, $thumb_size ) );
}



/************* VIEW FUNCTIONS *************/

function truncated_content( $length = 100 ) {
	$content = strip_tags( get_the_content() );
	$getlength = strlen( $content );
	$output = substr( $content, 0, $length );
	if ( $getlength > $length ) {
		$output .= '...';
	}
	echo $output;
}

?>
