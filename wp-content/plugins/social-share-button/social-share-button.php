<?php
/*
Plugin Name: Social Share Button
Plugin URI: 
Description: Social share buttons display on post or page or custom post.
Version: 1.5
Author: wpkids
Author URI: 
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


require_once('themes/icons-body.php');
require_once('themes/icons-style.php');
define('ssb_plugin_path', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
function ssb_script()
	{
		wp_enqueue_script('jquery');
		wp_enqueue_style('ssb-style', ssb_plugin_path.'css/style.css');
		wp_enqueue_script('ssb-js', plugins_url( '/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script( 'ssb-js', 'ssb_ajax', array( 'ssb_ajaxurl' => admin_url( 'admin-ajax.php')));
	}
	
add_action('init', 'ssb_script');






register_activation_hook(__FILE__, 'ssb_share_activation');
register_uninstall_hook(__FILE__, 'ssb_share_uninstall');


function ssb_share_activation()
	{
		
		$ssb_share_version = "1.5";
		update_option('ssb_share_version', $ssb_share_version); //update plugin version.
		
	}



function ssb_share_uninstall()
	{
		
		delete_post_meta_by_key( 'ssb_post_sites' ); //delete post meta from post
		
		delete_option( 'ssb_share_version' ); //delete option from database.
		delete_option( 'ssb_share_filter_posttype' ); //delete option from database.
		delete_option( 'ssb_share_content_display' ); //delete option from database.	
		delete_option( 'ssb_share_target_tab' ); //delete option from database.			
		delete_option( 'ssb_share_content_themes' ); //delete option from database.	
		delete_option( 'ssb_share_content_position' ); //delete option from database.			
		delete_option( 'ssb_share_content_icon_margin' ); //delete option from database.			
	
	}

















function ssb_ajax_form()
	{	
		$ssb_site = $_POST['ssb_site'];
		$post_id = $_POST['post_id'];
		
		$ssb_post_sites = get_post_meta( $post_id, 'ssb_post_sites', true );

	
$ssb_post_sites['fb'] = $ssb_post_sites['fb'];
$ssb_post_sites['gplus'] = $ssb_post_sites['gplus'];
$ssb_post_sites['twitter'] = $ssb_post_sites['twitter'];
$ssb_post_sites['linkedin'] = $ssb_post_sites['linkedin'];
$ssb_post_sites['pineterst'] = $ssb_post_sites['pineterst'];
$ssb_post_sites['reddit'] = $ssb_post_sites['reddit'];


		if($ssb_site=="fb")
			{
			$ssb_post_sites['fb'] = $ssb_post_sites['fb']+1;
			}
		elseif($ssb_site=="gplus")
			{
			$ssb_post_sites['gplus'] = $ssb_post_sites['gplus']+1;
			}
		elseif($ssb_site=="twitter")
			{
			$ssb_post_sites['twitter'] = $ssb_post_sites['twitter']+1;
			}
		elseif($ssb_site=="linkedin")
			{
			$ssb_post_sites['linkedin'] = $ssb_post_sites['linkedin']+1;
			}
		elseif($ssb_site=="pineterst")
			{
			$ssb_post_sites['pineterst'] = $ssb_post_sites['pineterst']+1;
			}
		elseif($ssb_site=="reddit")
			{
			$ssb_post_sites['reddit'] = $ssb_post_sites['reddit']+1;
			}

		// trace stats
		update_post_meta( $post_id, 'ssb_post_sites', $ssb_post_sites );
		die();
	}



add_action('wp_ajax_ssb_ajax_form', 'ssb_ajax_form');
add_action('wp_ajax_nopriv_ssb_ajax_form', 'ssb_ajax_form');




function ssb_display($content)
	{
		$ssb_share_content_position = get_option( 'ssb_share_content_position' );
		$ssb_share_content_display = get_option( 'ssb_share_content_display' );
		$ssb_share_filter_posttype = get_option( 'ssb_share_filter_posttype' );
		
		
		
		

		if($ssb_share_filter_posttype==NULL)
			{
				$type ="none";
			}
		else
			{
				$type = "";
			foreach ( $ssb_share_filter_posttype as  $post_type => $post_type_value )
				{
			
				$type .= $post_type.",";
				}
			}
		
		
		if(is_singular(explode(',',$type)))
			{
				
				$content_new = "";
				if($ssb_share_content_position=='top')
					{
						$content_new.=ssb_share_icons();
						$content_new .=$content;
					}
				elseif($ssb_share_content_position=='bottom')
					{	
						$content_new .=$content;
						$content_new.=ssb_share_icons();
						
					}
			
				if($ssb_share_content_display=='yes')
					{
						return $content_new;
					}
				else
					{
						return $content;
					}
			
			}	
		else
			{
				return $content;
			}
	
	
	}

add_filter('the_content', 'ssb_display');



function ssb_share_icons()
	{	
		$ssb_share_content_themes = get_option( 'ssb_share_content_themes' );
		$ssb_share_content_icon_margin = get_option( 'ssb_share_content_icon_margin' );		

		$ssb_share_icons = "";
		$ssb_share_icons.="<div class='ssb-share ".$ssb_share_content_themes."' post_id='".get_the_ID()."' >";
		$ssb_share_icons.= ssb_share_body();
		$ssb_share_icons.="</div>";	
		

		return $ssb_share_icons;
	}



function ssb_share_get_title()
	{
		global $post;
		$title = get_the_title( $post->ID );
		
		return $title;	
	}


function ssb_share_get_url()
	{
		global $post;
		$permalink = get_permalink( $post->ID );
		
		return $permalink;	
	}



function ssb_share_get_image()
	{	global $post;
		if ( has_post_thumbnail())
			{
				$post_thumbnail_id = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ));
				$post_thumbnail_id = $post_thumbnail_id[0];
		 	}
		else
			{
				$post_thumbnail_id ="";
			}
		 
	return $post_thumbnail_id;	
	}














////////////////////////////////////////////////////////////

add_action('admin_init', 'ssb_options_init' );
add_action('admin_menu', 'ssb_menu_init');

function ssb_options_init(){
	register_setting('ssb_plugin_options', 'ssb_share_content_display');
	register_setting('ssb_plugin_options', 'ssb_share_filter_posttype');	
	register_setting('ssb_plugin_options', 'ssb_share_target_tab');	
	register_setting('ssb_plugin_options', 'ssb_share_content_themes');	
	register_setting('ssb_plugin_options', 'ssb_share_content_position');		
	register_setting('ssb_plugin_options', 'ssb_share_content_icon_margin');		

    }
	
function ssb_settings(){
	include('ssb-admin.php');	
}

function ssb_menu_init() {
	add_menu_page(__('ssb','ssb'), __('SSB Settings','ssb'), 'manage_options', 'ssb_settings', 'ssb_settings');

}



?>