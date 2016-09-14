<?php
/*
Author: Belief
URL: http://beliefagency.com

Customize your menu helpers here.
*/

/*********************
MENU LOCATIONS
*********************/

add_action( 'after_setup_theme', function() {
	// registering wp3+ menu locations
	register_nav_menus(
		array(
			'heaver-nav' => __( 'Header Nav', 'ajc' ),
			'learning-menu' => __( 'Learning Links', 'ajc' ),
			'scatter-menu' => __( 'Scatter Links', 'ajc' ),
			'youth-menu' => __( 'Youth Links', 'ajc' ),
			'bible-menu' => __( 'Bible Links', 'ajc' ),
			'about-menu' => __( 'About Links', 'ajc' ),
			'bible-listen-menu' => __( 'Bible Listen Links', 'ajc' ),
			'bible-video-menu' => __( 'Bible Video Links', 'ajc' ),
			'missional-menu' => __( 'Missional Links', 'ajc' ),
			'footer-links' => __( 'Footer Links', 'ajc' )
		)
	);
}, 16 );

/*********************
MAIN NAVIGATION
*********************/

// The main menu
function church_main_nav() {
	// Display the wp3 menu if available
	wp_nav_menu(array(
		'container' => false,                           // remove nav container
		'container_class' => 'menu clearfix',           // class of container (should you choose to use it)
		'menu' => __( 'Nav Menu', 'ajc' ),              // nav name
		'menu_class' => 'nav top-nav',         	        // adding custom nav class
		'theme_location' => 'heaver-nav',               // where it's located in the theme
		'sort_column' => 'menu_order',                  // column used to sort items
		'before' => '',                                 // before the menu
		'after' => '',                                  // after the menu
		'link_before' => '',                            // before each link
		'link_after' => '',                             // after each link
		'depth' => 1,                                   // limit the depth of the nav
		'fallback_cb' => 'church_main_nav_fallback',    // fallback function
		'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'
	));
	
	
}

// This is the fallback for header menu
function church_main_nav_fallback() {
	wp_page_menu( array(
		'show_home' => true,
		'menu_class' => 'nav top-nav',                  // adding custom nav class
		'depth' => 1,                                   // limit the depth of the nav
		'include' => '',
		'exclude' => '',
		'echo' => true,
		'link_before' => '',                            // before each link
		'link_after' => ''                              // after each link
	) );
}

/*********************
NAV TILE WALKER
*********************/

// Depends on Advanced Custom Fields
class ajc_walker_nav_menu extends Walker_Nav_Menu {

	// add classes to ul sub-menus
	/*function start_lvl( &$output, $depth = 0, $args = null ) {
		// depth dependent classes
		$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
		$display_depth = ( $depth + 1); // because it counts the first submenu as 0
		$classes = array(
			'sub-menu',
			( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
			( $display_depth >=2 ? 'sub-sub-menu' : '' ),
			'menu-depth-' . $display_depth
			);
		$class_names = implode( ' ', $classes );

		// build html
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}*/

	// add main/sub classes to li's and links
	function start_el( &$output, $item, $depth = 0, $args = null, $current_object_id = 0 ) {
		global $wp_query;
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

		// depth dependent classes
		/*$depth_classes = array(
			( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
			( $depth >=2 ? 'sub-sub-menu-item' : '' ),
			( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
			'menu-item-depth-' . $depth
		);
		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );*/

		// passed classes
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

		// tile image url
		$img_id = get_field('tile_image', $item->object_id);
		$img_url = '';
		if ( $img_id ) {
			$img_url = wp_get_attachment_image_src($img_id, 'menu-tile', false);
			if ($img_url) (string)$img_url = $img_url[0];
		}

		// build html
		$output .= $indent . '<li style="background-image:url('. $img_url .')" id="nav-menu-item-'. $item->ID . '" class="' . /*$depth_class_names . ' ' .*/ $class_names . '">';

		// link attributes
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

		$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
			$args->before,
			$attributes,
			$args->link_before,
			apply_filters( 'the_title', $item->title, $item->ID ),
			$args->link_after,
			$args->after
		);

		// build html
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

/*********************
LEARNING PAGE MENU
*********************/

function church_learning_menu() {
	// Display the wp3 menu if available
	wp_nav_menu(array(
		'container' => false,                           // remove nav container
		'menu' => __( 'Learning Menu', 'ajc' ),         // nav name
		'menu_class' => 'grid-menu',         	        // adding custom nav class
		'theme_location' => 'learning-menu',            // where it's located in the theme
		'sort_column' => 'menu_order',                  // column used to sort items
		'before' => '',                                 // before the link
		'after' => '',                                  // after the link
		'link_before' => '<div class="inner"><span class="name">', // before link text
		'link_after' => '</span></div>',                // after link text
		'depth' => 1,                                   // limit the depth of the nav
		'fallback_cb' => false,                         // fallback function
		'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'walker' => new ajc_walker_nav_menu
	));
}

/*********************
SCATTER PAGE MENU
*********************/

function church_scatter_menu() {
	// Display the wp3 menu if available
	wp_nav_menu(array(
		'container' => false,                           // remove nav container
		'menu' => __( 'Scatter Menu', 'ajc' ),          // nav name
		'menu_class' => 'grid-menu',         	        // adding custom nav class
		'theme_location' => 'scatter-menu',             // where it's located in the theme
		'sort_column' => 'menu_order',                  // column used to sort items
		'before' => '',                                 // before the link
		'after' => '',                                  // after the link
		'link_before' => '<div class="inner"><span class="name">', // before link text
		'link_after' => '</span></div>',                // after link text
		'depth' => 1,                                   // limit the depth of the nav
		'fallback_cb' => false,                         // fallback function
		'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'walker' => new ajc_walker_nav_menu
	));
}


/*********************
FOOTER LINKS
*********************/

// The footer menu (should you choose to use one)
function church_footer_links() {
	// Display the wp3 menu if available
	wp_nav_menu(array(
		'container' => '',                              // remove nav container
		'container_class' => 'footer-links clearfix',   // class of container (should you choose to use it)
		'menu' => __( 'Footer Links', 'ajc' ),          // nav name
		'menu_class' => 'nav footer-nav',               // adding custom nav class
		'theme_location' => 'footer-links',             // where it's located in the theme
		'before' => '',                                 // before the menu
		'after' => '',                                  // after the menu
		'link_before' => '',                            // before each link
		'link_after' => '',                             // after each link
		'depth' => 0,                                   // limit the depth of the nav
		'fallback_cb' => false                          // fallback function
	));
}



/*********************
YOUTH PAGE MENU
*********************/

function church_youth_menu() {
	// Display the wp3 menu if available
	wp_nav_menu(array(
		'container' => false,                           // remove nav container
		'menu' => __( 'Youth Menu', 'ajc' ),         // nav name
		'menu_class' => 'grid-menu',         	        // adding custom nav class
		'theme_location' => 'youth-menu',            // where it's located in the theme
		'sort_column' => 'menu_order',                  // column used to sort items
		'before' => '',                                 // before the link
		'after' => '',                                  // after the link
		'link_before' => '<div class="inner"><span class="name">', // before link text
		'link_after' => '</span></div>',                // after link text
		'depth' => 1,                                   // limit the depth of the nav
		'fallback_cb' => false,                         // fallback function
		'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'walker' => new ajc_walker_nav_menu
	));
}





/*********************
MISSIONAL PAGE MENU
*********************/

function church_missional_menu() {
	// Display the wp3 menu if available
	wp_nav_menu(array(
		'container' => false,                           // remove nav container
		'menu' => __( 'Missional Menu', 'ajc' ),         // nav name
		'menu_class' => 'grid-menu',         	        // adding custom nav class
		'theme_location' => 'missional-menu',            // where it's located in the theme
		'sort_column' => 'menu_order',                  // column used to sort items
		'before' => '',                                 // before the link
		'after' => '',                                  // after the link
		'link_before' => '<div class="inner"><span class="name">', // before link text
		'link_after' => '</span></div>',                // after link text
		'depth' => 1,                                   // limit the depth of the nav
		'fallback_cb' => false,                         // fallback function
		'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'walker' => new ajc_walker_nav_menu
	));
}





/*********************
BIBLE PAGE MENU
*********************/

function church_bible_menu() {
	// Display the wp3 menu if available
	wp_nav_menu(array(
		'container' => false,                           // remove nav container
		'menu' => __( 'Bible Menu', 'ajc' ),         // nav name
		'menu_class' => 'grid-menu',         	        // adding custom nav class
		'theme_location' => 'bible-menu',            // where it's located in the theme
		'sort_column' => 'menu_order',                  // column used to sort items
		'before' => '',                                 // before the link
		'after' => '',                                  // after the link
		'link_before' => '<div class="inner"><span class="name">', // before link text
		'link_after' => '</span></div>',                // after link text
		'depth' => 1,                                   // limit the depth of the nav
		'fallback_cb' => false,                         // fallback function
		'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'walker' => new ajc_walker_nav_menu
	));
}



/*********************
BIBLE LISTEN PAGE MENU
*********************/

function church_bible_listen_menu() {
	// Display the wp3 menu if available
	wp_nav_menu(array(
		'container' => false,                           // remove nav container
		'menu' => __( 'Bible Listen Menu', 'ajc' ),         // nav name
		'menu_class' => 'grid-menu',         	        // adding custom nav class
		'theme_location' => 'bible-listen-menu',            // where it's located in the theme
		'sort_column' => 'menu_order',                  // column used to sort items
		'before' => '',                                 // before the link
		'after' => '',                                  // after the link
		'link_before' => '<div class="inner"><span class="name">', // before link text
		'link_after' => '</span></div>',                // after link text
		'depth' => 1,                                   // limit the depth of the nav
		'fallback_cb' => false,                         // fallback function
		'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'walker' => new ajc_walker_nav_menu
	));
}



/*********************
BIBLE VIDEO PAGE MENU
*********************/

function church_bible_video_menu() {
	// Display the wp3 menu if available
	wp_nav_menu(array(
		'container' => false,                           // remove nav container
		'menu' => __( 'Bible Video Menu', 'ajc' ),         // nav name
		'menu_class' => 'grid-menu',         	        // adding custom nav class
		'theme_location' => 'bible-video-menu',            // where it's located in the theme
		'sort_column' => 'menu_order',                  // column used to sort items
		'before' => '',                                 // before the link
		'after' => '',                                  // after the link
		'link_before' => '<div class="inner"><span class="name">', // before link text
		'link_after' => '</span></div>',                // after link text
		'depth' => 1,                                   // limit the depth of the nav
		'fallback_cb' => false,                         // fallback function
		'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'walker' => new ajc_walker_nav_menu
	));
}




/*********************
CHURCH ABOUT MENU
*********************/

function church_about_menu() {
	// Display the wp3 menu if available
	wp_nav_menu(array(
		'container' => false,                           // remove nav container
		'menu' => __( 'Church About Menu', 'ajc' ),         // nav name
		'menu_class' => 'grid-menu',         	        // adding custom nav class
		'theme_location' => 'church-about-menu',            // where it's located in the theme
		'sort_column' => 'menu_order',                  // column used to sort items
		'before' => '',                                 // before the link
		'after' => '',                                  // after the link
		'link_before' => '<div class="inner"><span class="name">', // before link text
		'link_after' => '</span></div>',                // after link text
		'depth' => 1,                                   // limit the depth of the nav
		'fallback_cb' => false,                         // fallback function
		'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'walker' => new ajc_walker_nav_menu
	));
}
