<?php
/*
This file handles the admin area and functions.
You can use this file to make changes to the
dashboard.

Author: Belief
URL: http://beliefagency.com

*/

if ( is_admin() ) : // Load only for admin

/************* ADMIN TOOLBAR *******************/

// Remove the Wordpress logo, etc from the WP Toolbar
add_action( 'wp_before_admin_bar_render', function() {
	global $wp_admin_bar;

	$wp_admin_bar->remove_menu('wp-logo');
	$wp_admin_bar->remove_menu('comments');

	// Remove Post from New menu
	// $wp_admin_bar->remove_node( 'new-page' );
	// $wp_admin_bar->remove_node( 'new-post' );
	// $wp_admin_bar->remove_node( 'new-link' );
}, 7 );



/************* SIDEBAR MENU *******************/

// Hide unnecessary admin menus
// http://wordpress.stackexchange.com/a/28784
add_action('admin_menu', function() {

	if ( function_exists('remove_menu_page') ) {
		// remove_menu_page('edit.php');
		// This is how you would remove a post type:
		// remove_menu_page('edit.php?post_type=custom_type');
		remove_menu_page('edit-comments.php');
	}
}, 100 );

// Move the Media menu item down
// http://wordpress.stackexchange.com/q/10475
add_action( 'admin_head', function() {
	global $menu;
	$menu[12] = $menu[10];
	unset( $menu[10] );
});



/************* EDITING POSTS *******************/

// Change 'enter title here' text for any post type
add_filter( 'enter_title_here', function( $message ) {
	$screen         = get_current_screen();
	$post_type_slug = $screen->post_type;
	$post_type_ob   = get_post_type_object( $post_type_slug );

	if ( isset($post_type_ob->extras) && $extras = $post_type_ob->extras ):
		$message = $extras['enter_title_here'];
	endif;
	return $message;
}, 8 );

// Change what's hidden by default
add_filter( 'default_hidden_meta_boxes', 'custom_hidden_meta_boxes', 10, 2 );
function custom_hidden_meta_boxes( $hidden, $screen ) {
	if ( 'post' == $screen->id ) {
		$hidden = array('postcustom', 'slugdiv', 'trackbacksdiv', 'commentstatusdiv', 'commentsdiv', 'revisionsdiv'); // Removed 'postexcerpt, authordiv'
	}
	if ( 'page' == $screen->id ) {
		$hidden = array('postcustom', 'slugdiv', 'trackbacksdiv', 'commentstatusdiv', 'commentsdiv', 'postexcerpt', 'authordiv', 'revisionsdiv');
	}
	return $hidden;
}



/************* DASHBOARD WIDGETS *****************/

// Disable default dashboard widgets
function disable_default_dashboard_widgets() {
	// remove_meta_box( 'dashboard_right_now', 'dashboard', 'core' );    // Right Now Widget
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'core' ); // Comments Widget
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'core' );  // Incoming Links Widget
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'core' );         // Plugins Widget

	// remove_meta_box('dashboard_quick_press', 'dashboard', 'core' );   // Quick Press Widget
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'core' );   // Recent Drafts Widget
	remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );         //
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );       //

	// Remove plugin dashboard boxes
	remove_meta_box( 'yoast_db_widget', 'dashboard', 'normal' );         // Yoast's SEO Plugin Widget
}

/*
Now let's talk about adding your own custom Dashboard widget.
Sometimes you want to show clients feeds relative to their
site's content. For example, the NBA.com feed for a sports
site. Here is an example Dashboard Widget that displays recent
entries from an RSS Feed.

For more information on creating Dashboard Widgets, view:
http://digwp.com/2010/10/customize-wordpress-dashboard/
*/

// RSS Dashboard Widget
function belief_rss_dashboard_widget() {
	if ( function_exists( 'fetch_feed' ) ) {
		include_once( ABSPATH . WPINC . '/feed.php' );               // include the required file
		$feed = fetch_feed( 'http://themble.com/feed/rss/' );        // specify the source feed
		$limit = $feed->get_item_quantity(7);                        // specify number of items
		$items = $feed->get_items(0, $limit);                        // create an array of items
	}
	if ($limit == 0) echo '<div>The RSS Feed is either empty or unavailable.</div>';   // fallback message
	else foreach ($items as $item) { ?>

	<h4 style="margin-bottom: 0;">
		<a href="<?php echo $item->get_permalink(); ?>" title="<?php echo mysql2date( __( 'j F Y @ g:i a', 'ajc' ), $item->get_date( 'Y-m-d H:i:s' ) ); ?>" target="_blank">
			<?php echo $item->get_title(); ?>
		</a>
	</h4>
	<p style="margin-top: 0.5em;">
		<?php echo substr($item->get_description(), 0, 200); ?>
	</p>
	<?php }
}

// Call all custom dashboard widgets
function belief_custom_dashboard_widgets() {
	// wp_add_dashboard_widget( 'belief_rss_dashboard_widget', __( 'Recently on Themble (Customize on admin.php)', 'ajc' ), 'belief_rss_dashboard_widget' );
	/*
	Be sure to drop any other created Dashboard Widgets
	in this function and they will all load.
	*/
}

// Remove the dashboard widgets
add_action( 'admin_menu', 'disable_default_dashboard_widgets' );
// Add any custom widgets
add_action( 'wp_dashboard_setup', 'belief_custom_dashboard_widgets' );



/************* CUSTOM LOGIN PAGE *****************/

// Adds a style block for the login screen
function custom_login_logo() {
	echo "<style type=\"text/css\">";
		echo "body.login div#login h1 a {";
			echo "background-image: url(". get_template_directory_uri() ."/assets/images/login-logo.png);";
			echo "background-size: 323px 110px;";
			echo "width: 323px;";
			echo "height: 110px;";
		echo "}";
	echo "</style>";
}
add_action( 'login_enqueue_scripts', 'custom_login_logo' );

// Updated to proper 'enqueue' method
// http://codex.wordpress.org/Plugin_API/Action_Reference/login_enqueue_scripts
/*function belief_login_css() {
	wp_enqueue_style( 'belief_login_css', get_template_directory_uri() . '/assets/css/login.css', false );
}*/

// Changing the logo link from wordpress.org to your site
function belief_login_url() {  return home_url(); }

// Changing the alt text on the logo to show your site name
function belief_login_title() { return get_option( 'blogname' ); }

// Calling it only on the login page
// add_action( 'login_enqueue_scripts', 'belief_login_css', 10 );
add_filter( 'login_headerurl', 'belief_login_url' );
add_filter( 'login_headertitle', 'belief_login_title' );



/************* CUSTOM FOOTER *******************/

// Custom Backend Footer
function custom_admin_footer() {
	_e( '<span id="footer-thankyou">Developed by <a href="http://beliefagency.com" target="_blank">Belief</a></span>.', 'ajc' );
}
// adding it to the admin area
add_filter( 'admin_footer_text', 'custom_admin_footer' );


endif;  // is_admin()
