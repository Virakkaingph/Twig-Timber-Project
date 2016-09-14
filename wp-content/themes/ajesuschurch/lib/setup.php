<?php
/*
Author: Belief
URL: http://beliefagency.com

Welcome to the Belief WP boilerplate
This is the core setup file where most of the
main functions & features reside. If you have
any custom functions, it's best to put them
in the functions.php file.
*/

/*********************
Let's fire off all the functions
and tools. I put it up here so it's
right up top and clean.
*********************/

// Fire all our initial functions at the start
add_action( 'after_setup_theme', 'belief_init', 16 );

function belief_init() {

	// Launching operation cleanup
	add_action( 'init', 'belief_head_cleanup' );
	// Remove WP version from RSS
	add_filter( 'the_generator', 'belief_rss_version' );
	// Remove pesky injected css for recent comments widget
	add_filter( 'wp_head', 'belief_remove_wp_widget_recent_comments_style', 1 );
	// Clean up comment styles in the head
	add_action( 'wp_head', 'belief_remove_recent_comments_style', 1 );
	// Clean up gallery output
	add_filter( 'gallery_style', 'belief_gallery_style' );

	// Enqueue base scripts and styles
	// add_action( 'wp_enqueue_scripts', 'belief_scripts_and_styles', 999 );

	// Launching this stuff after theme setup
	belief_theme_support();

	// Adding sidebars to Wordpress (these are created in functions.php)
	// add_action( 'widgets_init', 'belief_register_sidebars' );

	// Clean up random code around images
	add_filter( 'the_content', 'belief_filter_ptags_on_images' );

	// Sort terms by term_order
	// add_filter('get_terms_orderby', 'belief_apply_order_filter', 10, 2);

	// Clean up excerpts --> Timber has its own implemntation
	// add_filter( 'excerpt_length', 'belief_excerpt_length' );
	// add_filter( 'excerpt_more', 'belief_excerpt_more' );

}



/*********************
The default wordpress head is
a mess. Let's clean it up by
removing all the junk we don't
need.
*********************/

function belief_head_cleanup() {
	// Category feeds
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	// Post and comment feeds
	remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// Windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// Index link
	remove_action( 'wp_head', 'index_rel_link' );
	// Previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// Start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// Links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// Remove WP canonical links
	remove_action('wp_head', 'rel_canonical');
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// Remove generated feed links
	add_action( 'after_setup_theme', 'belief_remove_feed_links' );
	// Remove WP version from css
	add_filter( 'style_loader_src', 'belief_remove_wp_ver_css_js', 9999 );
	// Remove WP version from scripts
	add_filter( 'script_loader_src', 'belief_remove_wp_ver_css_js', 9999 );
	// Removes the WP Toolbar from the website
	add_filter('show_admin_bar', '__return_false');
}

// Remove WP version from RSS
function belief_rss_version() { return ''; }

// Remove WP version from scripts
function belief_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

// Remove generated feed links
function belief_remove_feed_links() {
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
}

// Remove injected CSS for recent comments widget
function belief_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

// Remove injected CSS from recent comments widget
function belief_remove_recent_comments_style() {
	global $wp_widget_factory;
	if ( isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments']) ) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}

// Remove injected CSS from gallery
function belief_gallery_style( $css ) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}



/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function belief_theme_support() {
	global $home_slug, $blog_slug, $thumb_size;

	// WP thumbnails (sizes handled in functions.php)
	add_theme_support( 'post-thumbnails' );

	// Set default thumb size
	set_post_thumbnail_size($thumb_size, $thumb_size, true);

	// Set front page default
	$about = get_page_by_path( $home_slug );
	if ( $about && !get_option( 'page_on_front' ) ) {
		update_option( 'page_on_front', $about->ID );
		update_option( 'show_on_front', 'page' );
	}

	// Set blog page default
	$blog = get_page_by_path( $blog_slug );
	if ( $blog && !get_option( 'page_for_posts' ) ) {
		update_option( 'page_for_posts', $blog->ID );
	}

	// RSS thingy - to add header image support go here:
	// http://themble.com/support/adding-header-background-image-support/
	add_theme_support('automatic-feed-links');

	// wp menus (not required)
	add_theme_support( 'menus' );
}



/*********************
MENUS & NAVIGATION
*********************/

// Fix menu highlighting for custom post types
add_action( 'nav_menu_css_class', function( $classes, $item ) {
	global $post;
	// Check post
	if (!$post) return $classes;
	// Getting the post type of the current post
	$current_post_type = get_post_type_object(get_post_type($post->ID));
	$current_post_type_slug = $current_post_type->rewrite['slug'];
	// Getting the URL of the menu item
	$menu_slug = strtolower(trim($item->url));
	// If the menu item URL contains the current post types slug add the current-menu-item class
	if (strpos($menu_slug, $current_post_type_slug) !== false) {
		$classes[] = 'current-menu-item';
	}
	// Return the corrected set of classes to be added to the menu item
	return $classes;
}, 10, 2 );



/*********************
RELATED POSTS FUNCTION
*********************/

// Related Posts Function (call using belief_related_posts(); )
/*function belief_related_posts() {
	echo '<ul id="belief-related-posts">';
	global $post;
	$tags = wp_get_post_tags( $post->ID );
	if($tags) {
		foreach( $tags as $tag ) {
			$tag_arr .= $tag->slug . ',';
		}
		$args = array(
			'tag' => $tag_arr,
			'numberposts' => 5, // you can change this to show more
			'post__not_in' => array($post->ID)
		);
		$related_posts = get_posts( $args );
		if($related_posts) {
			foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
				<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; }
		else { ?>
			<?php echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'ajc' ) . '</li>'; ?>
		<?php }
	}
	wp_reset_query();
	echo '</ul>';
} */



/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
/*function belief_page_navi() {
	global $wp_query;
	$bignum = 999999999;
	if ( $wp_query->max_num_pages <= 1 )
		return;

	echo '<nav class="pagination">';

		echo paginate_links( array(
			'base' 			=> str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
			'format' 		=> '',
			'current' 		=> max( 1, get_query_var('paged') ),
			'total' 		=> $wp_query->max_num_pages,
			'prev_text' 	=> '&larr;',
			'next_text' 	=> '&rarr;',
			'type'			=> 'list',
			'end_size'		=> 3,
			'mid_size'		=> 3
		) );

	echo '</nav>';
}*/



/*********************
RANDOM CLEANUP ITEMS
*********************/

// Remove default image sizes
add_filter( 'intermediate_image_sizes_advanced', function ( $sizes ) {
	// unset( $sizes['thumbnail']); --> Used by search
	// unset( $sizes['medium']);    --> Used by media library
	unset( $sizes['large']);
	return $sizes;
} );

// This is the expected behavior for terms (order by term_order)
// NOTE: This breaks for multisite
/*function belief_apply_order_filter( $orderby, $args ) {
	return 'tt.term_order';
}*/

// Remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function belief_filter_ptags_on_images( $content ) {
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This replaces the annoying […] to a Read More link
function belief_excerpt_more( $more ) {
	global $post;
	// return '...  <a class="read-more" href="'. get_permalink( $post->ID ) . '" title="'. __( 'Read', 'ajc' ) . get_the_title($post->ID).'">'. __( 'Read more', 'ajc' ) .'</a>';
	return '... <strong class="more">'. __( 'Read more', 'ajc' ) .'</strong>';
}

// Change excerpt length
function belief_excerpt_length( $length ) {
	global $excerpt_length;
	return $excerpt_length;
}

/*
 * This is a modified the_author_posts_link() which just returns the link.
 *
 * This is necessary to allow usage of the usual l10n process with printf().
 */
function belief_get_the_author_posts_link() {
	global $authordata;
	if ( !is_object( $authordata ) )
		return false;
	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ), // No further l10n needed, core will take care of this one
		get_the_author()
	);
	return $link;
}

?>
