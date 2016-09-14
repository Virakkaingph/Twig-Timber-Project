<?php
/*
Author: Belief
URL: http://beliefagency.com

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

/************* INCLUDE SETUP FILES ***************/
/*
1. lib/setup.php
	- head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
	- custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once( 'lib/setup.php' );
/*
2. lib/translation/translation.php
	- adding support for other languages
*/
// require_once( 'lib/translation/translation.php' );
/*
3. lib/admin.php
	- removing some default WordPress dashboard widgets
	- an example custom dashboard widget
	- adding custom login css
	- changing text in footer of admin
*/
require_once( 'lib/admin.php' );



/************* DEPENDENCIES ***************/

// To remove all visual interfaces from the ACF plugin, you
// can use this constant to enable lite mode:
define( 'ACF_LITE', false );
// include_once('../../plugins/advanced-custom-fields/acf.php');



/************* INCLUDE THEME FILES ***************/

require_once( 'lib/settings.php' );
require_once( 'lib/post-types.php' );
require_once( 'lib/helpers.php' );
require_once( 'lib/timber.php' );
require_once( 'lib/assets.php' );



/************* DEFAULT THEME OPTIONS ***************/

if ( ! isset( $home_slug ) )
	$home_slug = 'home';

if ( ! isset( $blog_slug ) )
	$blog_slug = 'blog';

if ( ! isset( $thumb_size ) )
	$thumb_size = 125;

if ( ! isset( $num_posts ) )
	$num_posts = 10;

if ( ! isset( $excerpt_length ) )
	$excerpt_length = 40;

/*
Post content often has specified width.
Thus, images which has bigger size than content width can break up the layout of theme.
To prevent this situation, WordPress provides one way to specify the maximum image size for themes.
Define the maximum image size
*/
if ( ! isset( $content_width ) )
	$content_width = 920;



/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'vibe-banner', 1622, 150, true );
add_image_size( 'hero-film', 1622, 690, true ); // 2.35:1
//add_image_size( 'hero-film', 1568, 784, true ); // 962 x 680
//add_image_size( 'hero-text', 920, 706, true );
//add_image_size( 'grid-thumb', 240, 130, true );
add_image_size( 'menu-tile', 605, 364, true ); // FIXME: larger?
add_image_size( 'post-thumb', 656, 377, true );
add_image_size( 'square-thumb', 450, 450, true );
//add_image_size( 'video-thumb', $content_width, 518, true );
add_image_size( 'artwork-thumb', 333, 240, true );

/*
To add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image:
<?php the_post_thumbnail( 'belief-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'belief-thumb-600' ); ?>

Note: hard cropping will not be applied to images
uploaded with either dimension smaller than the
numbers given to add_image_size.
*/



/************* AJAX ACTIONS *************/

// Allows lookup of the image-size variation of a
// url for a given image url from an ajax call
add_action( 'wp_ajax_image_size_url', function() {
	global $wpdb; // Access to the database

	$original_url = $_POST['original_url'];
	$image_id = intval( $_POST['image_id'] );
	$image_size = $_POST['image_size'];
	$image_size_url = wp_get_attachment_image_src( $image_id, $image_size, false );

	echo $image_size_url[0]; // Return value
	die(); // Required to return a proper result
} );



/************* SHORT CODES *************/

function email_link( $address, $html = null, $title = null, $classes = null ) {
	$address = strtolower($address);
	$coded = '';
	$unmixedkey = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789.@';
	$inprogresskey = $unmixedkey;
	$mixedkey = '';
	$unshuffled = strlen($unmixedkey);
	for ($i = 0; $i <= strlen($unmixedkey); $i++) {
		$ranpos = rand(0, $unshuffled - 1);
		$nextchar = isset($inprogresskey{$ranpos}) ? $inprogresskey{$ranpos} : null;
		$mixedkey .= $nextchar;
		$before = substr($inprogresskey, 0, $ranpos);
		$after = substr($inprogresskey, $ranpos + 1, $unshuffled - ($ranpos + 1));
		$inprogresskey = $before .''. $after;
		$unshuffled -= 1;
	}
	$cipher = $mixedkey;
	$shift = strlen($address);
	$txt = "<script type=\"text/javascript\" language=\"javascript\">\n".
		"<!-"."-\n".
		"// Email obfuscator script 2.1 by Tim Williams, University of Arizona\n".
		"// Random encryption key feature by Andrew Moulden, Site Engineering Ltd\n".
		"// PHP version coded by Ross Killen, Celtic Productions Ltd\n".
		"// This code is freeware provided these six comment lines remain intact\n".
		"// A wizard to generate this code is at http://www.jottings.com/obfuscator/\n".
		"// The PHP code may be obtained from http://www.celticproductions.net/\n\n";
	for ($j=0; $j<strlen($address); $j++) {
		if (strpos($cipher,$address{$j}) == -1) {
			$chr = $address{$j};
			$coded .= $address{$j};
		} else {
			$chr = (strpos($cipher,$address{$j}) + $shift) % strlen($cipher);
			$coded .= $cipher{$chr};
		}
	}
	$html = isset($html) && $html ? $html : "\"+link+\"";
	$classes = isset($classes) ? " class='". $classes ."'" : "";
	$title = isset($title) ? " title='". $title ."'" : "";
	$txt .= "  coded = \"" . $coded . "\"\n" .
		"  key = \"".$cipher."\"\n" .
		"  shift=coded.length\n" .
		"  link=\"\"\n" .
		"  for (i=0; i<coded.length; i++) {\n" .
		"    if (key.indexOf(coded.charAt(i))==-1) {\n" .
		"      ltr = coded.charAt(i)\n" .
		"      link += (ltr)\n" .
		"    }\n" .
		"    else {     \n" .
		"      ltr = (key.indexOf(coded.charAt(i))-shift+key.length) % key.length\n" .
		"      link += (key.charAt(ltr))\n" .
		"    }\n" .
		"  }\n" .
		"  document.write(\"<a href='mailto:\"+link+\"'". $classes . $title .">". $html ."</a>\");\n" .
		"\n" .
		"//-"."->\n" .
		"<" . "/script><noscript>N/A" .
		"<"."/noscript>";
	return $txt;
}

function emailShortcode( $atts, $content = null ) {
	$email = isset($atts['address']) ? $atts['address'] : $content;
	$text = isset($atts['address']) ? $content : null;
	$title = isset($atts['title']) ? $atts['title'] : $text;
	return email_link( $email, $text, $title );
}
add_shortcode( 'email', 'emailShortcode' );

function pageActions( $atts, $content = null ) {
	$content = do_shortcode( $content );
	return '<p class="page-actions">'. $content .'</p>';
}
add_shortcode( 'page_actions', 'pageActions' );



/************* PAGE LINKS TO *************/

add_filter( 'page-links-to-post-types', function( $post_types ) {
	// Page-links-to metabox
	return array( 'page', 'post' );
});



/************* SEARCH FILTERS *************/

/*function belief_search_filter( $query ) {
	if ( $query->is_search ) {
		$homeId = get_option( 'page_on_front' );
		$blogId = get_option( 'page_for_posts' );
		$query->set( 'post__not_in', array($homeId, $blogId) );
	}
	return $query;
}
add_filter('pre_get_posts', 'belief_search_filter');*/

?>
