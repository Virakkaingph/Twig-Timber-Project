<?php
/*
  Plugin Name: AJC Network Plugin
  Plugin URI: http://wordpress.org/extend/plugins/ajc-network/
  Description: Add functionality specific to the A Jesus Church network site.
  Version: 1.0.0
  Author: Belief
  Author URI: http://beliefagency.com/
  License: GPLv2
 */

/************* PLUGIN FILES ***************/

add_action( 'after_setup_theme', function () {

	// Include plugin code
	require_once( 'lib/post-types.php' );
	require_once( 'lib/custom-fields.php' );
	require_once( 'lib/menus.php' );

}, 1 );
