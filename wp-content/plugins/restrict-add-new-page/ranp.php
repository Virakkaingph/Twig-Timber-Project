<?php

/*
  Plugin Name: Restrict 'Add New Page'
  Plugin URI: http://wordpress.org/extend/plugins/restrict-add-new-page/
  Description: This plugin will disable all non-admin users from creating new pages in your blog. The "add new - Page" submenu item will also be hidden in the users dashboard.
  Version: 1.0.0
  Author: RS Publishing
  License: GPLv2
 */

/*
  Copyright 2012  Rynaldo Stoltz  (email: rcstoltz@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

add_action('admin_init', 'capb_mod');
add_action('admin_menu', 'men_mod');
add_action('wp_before_admin_bar_render', 'adm_bar_mod');
add_action('admin_head', 'hide_anbu');
add_action('admin_menu', 'adm_redir');
add_action('admin_init', 'perm_notice');

function capb_mod() {
	$editor_role = get_role('editor');
	$editor_role -> remove_cap('publish_pages');
	$author_role = get_role('author');
	$author_role -> remove_cap('publish pages');
}

function men_mod() {
	if ( !current_user_can('publish_pages') ) {
		// global $submenu;
		// unset( $submenu['edit.php?post_type=page'][10] );
		// $submenu['edit.php?post_type=page'][10][1] = 'publish_pages';
	}
}

function adm_bar_mod() {
	global $wp_admin_bar;
	if ( !current_user_can('publish_pages') ) {
		$wp_admin_bar->remove_node( 'new-page' );
	}
}

function hide_anbu() {
	global $current_screen;
	if ( $current_screen->id == 'edit-page' && !current_user_can('publish_pages') ) {
		echo '<style>.add-new-h2{display: none;}</style>';
	}
}

function adm_redir() {
	$result = stripos($_SERVER['REQUEST_URI'], 'post-new.php?post_type=page');
	if ( $result !== false && !current_user_can('publish_pages') ) {
		wp_redirect(get_option('siteurl') . '/wp-admin/index.php?permissions_error=true');
	}
}

function dbo_noti() {
	echo "<div id='permissions-warning' class='error fade'><p><strong>". __('You do not have permission to access that page.') ."</strong></p></div>";
}

function perm_notice() {
	if ( isset($_GET['permissions_error']) && $_GET['permissions_error'] ) {
		add_action('admin_notices', 'dbo_noti');
	}
}
