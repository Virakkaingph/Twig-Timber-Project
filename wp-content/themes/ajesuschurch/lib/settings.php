<?php
/*
Author: Belief
URL: http://beliefagency.com

Here we add our own settings (per-site)
using the WordPress Settings API.
*/

if ( is_admin() ) : // Load only for admin

/************* OPTION DEFAULTS ***************/

$ajc_options = array(

	'location' => 'Portland, OR',
	'tile_image' => '',
	'tile_position' => 0,

	'audio_podcast_url' => '',
	'video_podcast_url' => '',
	'audio_itunes_url' => '',
	'video_itunes_url' => '',

	'office_address' => '',
	'gather_address' => '',
	'gather_times' => '',
	'phone' => '(503) 620-1120',
	'email' => '',
	'copyright' => '',

	'facebook_url' => '',
	'vimeo_url' => '',
	'youtube_url' => '',
	'twitter_url' => '',
	'gplus_url' => ''
);


/************* OPTIONS CONFIG ***************/

// Register settings and call sanitation functions
function ajc_register_settings() {
	register_setting( 'ajc_theme_options', 'ajc_options', 'ajc_validate_options' );
}
add_action( 'admin_init', 'ajc_register_settings' );

// Add theme options page to the addmin menu
function ajc_theme_options() {
	add_theme_page( 'Church Settings', 'Church Settings', 'edit_theme_options', 'theme_options', 'ajc_theme_options_page' );
}
add_action( 'admin_menu', 'ajc_theme_options' );

// Validate inputs before they are saved as options
function ajc_validate_options( $input ) {
	global $ajc_options, $ajc_categories, $ajc_layouts;

	// Grab the application settings (or populate defaults)
	$settings = get_option( 'ajc_options', $ajc_options );

	// We strip all tags from the textarea, to avoid vulnerablilties like XSS
	$input['office_address'] = wp_filter_nohtml_kses( $input['office_address'] );
	$input['gather_address'] = wp_filter_nohtml_kses( $input['gather_address'] );
	$input['gather_times'] = wp_filter_nohtml_kses( $input['gather_times'] );

	// We strip all tags from the text field, to avoid vulnerablilties like XSS
	$input['tile_image'] = wp_filter_post_kses( $input['tile_image'] );
	$input['tile_position'] = wp_filter_post_kses( $input['tile_position'] );
	$input['audio_podcast_url'] = wp_filter_post_kses( $input['audio_podcast_url'] );
	$input['video_podcast_url'] = wp_filter_post_kses( $input['video_podcast_url'] );
	$input['audio_itunes_url'] = wp_filter_post_kses( $input['audio_itunes_url'] );
	$input['video_itunes_url'] = wp_filter_post_kses( $input['video_itunes_url'] );
	$input['location'] = wp_filter_post_kses( $input['location'] );
	$input['email'] = wp_filter_post_kses( $input['email'] );
	$input['phone'] = wp_filter_post_kses( $input['phone'] );
	$input['copyright'] = wp_filter_post_kses( $input['copyright'] );
	$input['facebook_url'] = wp_filter_post_kses( $input['facebook_url'] );
	$input['vimeo_url'] = wp_filter_post_kses( $input['vimeo_url'] );
	$input['youtube_url'] = wp_filter_post_kses( $input['youtube_url'] );
	$input['twitter_url'] = wp_filter_post_kses( $input['twitter_url'] );
	$input['gplus_url'] = wp_filter_post_kses( $input['gplus_url'] );

	return $input;
}


/************* OPTIONS TEMPLATE ***************/

// Function to generate options page
function ajc_theme_options_page() {
	global $ajc_options, $ajc_categories, $ajc_layouts;

	// check whether the form was just submitted
	if ( ! isset( $_REQUEST['updated'] ) ) {
		$_REQUEST['updated'] = false;
	} ?>

	<div class="wrap">

	<?php screen_icon(); echo '<h2>' . wp_get_theme() . __( ' Options', 'ajc' ) . '</h2>';
	// This shows the page's name and an icon if one has been provided ?>

	<?php if ( false !== $_REQUEST['updated'] ) : ?>
	<div class="updated fade"><p><strong><?php _e( 'Options saved', 'ajc' ); ?></strong></p></div>
	<?php endif; // If the form has just been submitted, this shows the notification ?>

	<form method="post" action="options.php">

	<?php $settings = get_option( 'ajc_options', $ajc_options ); ?>

	<?php /* This function outputs some hidden fields required by the form,
	including a nonce, a unique number used to ensure the form has been submitted
	from the admin page and not somewhere else, very important for security */
	settings_fields( 'ajc_theme_options' ); ?>

	<table class="form-table">

	<tr valign="top"><th scope="row"><label for="location"><?php _e( 'Location', 'ajc' ); ?></label></th><td>
	<input id="location" name="ajc_options[location]" type="text" value="<?php  echo esc_attr($settings['location']); ?>" />
	</td></tr>

	<tr><th><label for="tile_image"><?php _e('Tile Image', 'ajc' ); ?></label></th><td>
	<input type="text" id="tile_image" name="ajc_options[tile_image]" value="<?php echo esc_url( $settings['tile_image'] ); ?>" />
	<input id="tile_image_button" type="button" class="button" value="<?php _e( 'Change Tile Image', 'ajc' ); ?>" />
	</td></tr>

	<tr valign="top"><th><?php _e( 'Tile Image Preview', 'ajc' ); ?></th><td>
	<div id="tile_image_preview" style="min-height:100px;">
		<img style="max-width:100%;" src="<?php echo esc_url( $settings['tile_image'] ); ?>" />
	</div>
	</td></tr>

	<tr valign="top"><th scope="row"><label for="tile_position"><?php _e( 'Tile Position', 'ajc' ); ?></label></th><td>
	<input id="tile_position" name="ajc_options[tile_position]" type="number" value="<?php  echo esc_attr($settings['tile_position']); ?>" />
	</td></tr>

	<!-- CHURCH INFO --><tr valign="top"><td colspan="2"><hr/></td></tr>

	<tr valign="top"><th scope="row"><label for="office_address"><?php _e( 'Office Address', 'ajc' ); ?></label></th><td>
	<textarea id="office_address" name="ajc_options[office_address]" rows="4" cols="30"><?php echo stripslashes($settings['office_address']); ?></textarea>
	</td></tr>

	<tr valign="top"><th scope="row"><label for="email"><?php _e( 'Email', 'ajc' ); ?></label></th><td>
	<input id="email" name="ajc_options[email]" type="email" value="<?php echo  esc_attr($settings['email']); ?>" size="30" />
	</td></tr>

	<tr valign="top"><th scope="row"><label for="phone"><?php _e( 'Phone', 'ajc' ); ?></label></th><td>
	<input id="phone" name="ajc_options[phone]" type="text" value="<?php echo  esc_attr($settings['phone']); ?>" size="13"/>
	</td></tr>

	<tr valign="top"><th scope="row"><label for="gather_address"><?php _e( 'Gather Address', 'ajc' ); ?></label></th><td>
	<textarea id="gather_address" name="ajc_options[gather_address]" rows="4" cols="30"><?php echo stripslashes($settings['gather_address']); ?></textarea>
	</td></tr>

	<tr valign="top"><th scope="row"><label for="gather_times"><?php _e( 'Gather Times', 'ajc' ); ?></label></th><td>
	<textarea id="gather_times" name="ajc_options[gather_times]" rows="4" cols="30"><?php echo stripslashes($settings['gather_times']); ?></textarea>
	</td></tr>

	<tr valign="top"><th scope="row"><label for="copyright"><?php _e( 'Copyright Line', 'ajc' ); ?></label></th><td>
	<input id="copyright" name="ajc_options[copyright]" type="text" value="<?php echo  esc_attr($settings['copyright']); ?>" size="30" />
	</td></tr>

	<!-- PODCASTS --><tr valign="top"><td colspan="2"><hr/></td></tr>

	<tr valign="top"><th scope="row"><label for="audio_podcast_url"><?php _e( 'Audio Podcast Feed', 'ajc' ); ?></label></th><td>
	<input id="audio_podcast_url" name="ajc_options[audio_podcast_url]" type="text" value="<?php the_attr($settings, 'audio_podcast_url'); ?>" size="38" />
	</td></tr>

	<tr valign="top"><th scope="row"><label for="video_podcast_url"><?php _e( 'Video Podcast Feed', 'ajc' ); ?></label></th><td>
	<input id="video_podcast_url" name="ajc_options[video_podcast_url]" type="text" value="<?php the_attr($settings, 'video_podcast_url'); ?>" size="38" />
	</td></tr>

	<tr valign="top"><th scope="row"><label for="audio_itunes_url"><?php _e( 'Audio iTunes Podcast', 'ajc' ); ?></label></th><td>
	<input id="audio_itunes_url" name="ajc_options[audio_itunes_url]" type="text" value="<?php the_attr($settings, 'audio_itunes_url'); ?>" size="38" />
	</td></tr>

	<tr valign="top"><th scope="row"><label for="video_itunes_url"><?php _e( 'Video iTunes Podcast', 'ajc' ); ?></label></th><td>
	<input id="video_itunes_url" name="ajc_options[video_itunes_url]" type="text" value="<?php the_attr($settings, 'video_itunes_url'); ?>" size="38" />
	</td></tr>

	<!-- SOCIAL LINKS --><tr valign="top"><td colspan="2"><hr/></td></tr>

	<tr valign="top"><th scope="row"><label for="facebook_url"><?php _e( 'Facebook Page', 'ajc' ); ?></label></th><td>
	<input id="facebook_url" name="ajc_options[facebook_url]" type="text" value="<?php the_attr($settings, 'facebook_url'); ?>" size="38" />
	</td></tr>

	<tr valign="top"><th scope="row"><label for="vimeo_url"><?php _e( 'Vimeo Page', 'ajc' ); ?></label></th><td>
	<input id="vimeo_url" name="ajc_options[vimeo_url]" type="text" value="<?php the_attr($settings, 'vimeo_url'); ?>" size="38" />
	</td></tr>

	<tr valign="top"><th scope="row"><label for="youtube_url"><?php _e( 'YouTube Page', 'ajc' ); ?></label></th><td>
	<input id="youtube_url" name="ajc_options[youtube_url]" type="text" value="<?php the_attr($settings, 'youtube_url'); ?>" size="38" />
	</td></tr>

	<tr valign="top"><th scope="row"><label for="twitter_url"><?php _e( 'Twitter Page', 'ajc' ); ?></label></th><td>
	<input id="twitter_url" name="ajc_options[twitter_url]" type="text" value="<?php the_attr($settings, 'twitter_url'); ?>" size="38" />
	</td></tr>

	<tr valign="top"><th scope="row"><label for="gplus_url"><?php _e( 'Google Plus Page', 'ajc' ); ?></label></th><td>
	<input id="gplus_url" name="ajc_options[gplus_url]" type="text" value="<?php the_attr($settings, 'gplus_url'); ?>" size="38" />
	</td></tr>
	
	<tr valign="top"><th scope="row"><label for="instagram_url"><?php _e( 'Instagram Page', 'ajc' ); ?></label></th><td>
	<input id="instagram_url" name="ajc_options[instagram_url]" type="text" value="<?php the_attr($settings, 'instagram_url'); ?>" size="38" />
	</td></tr>

	</table>

	<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>
	</form>

	</div>
	<?php
}

endif;  // is_admin()


/************* MEDIA LIBRARY INTEGRATION ***************/

function ajc_options_enqueue_scripts() {
	wp_register_script( 'church-settings', get_template_directory_uri() .'/assets/js/admin/church-settings.js', array('jquery', 'media-upload', 'thickbox') );

	if ( 'appearance_page_theme_options' == get_current_screen() -> id ) {
		wp_enqueue_script('jquery');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('church-settings');
	}
}
add_action( 'admin_enqueue_scripts', 'ajc_options_enqueue_scripts' );

function ajc_options_setup() {
	global $pagenow;

	if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
		// Now we'll replace the 'Insert into Post Button' inside Thickbox
		add_filter( 'gettext', 'replace_thickbox_text' , 1, 3 );
	}
}
add_action( 'admin_init', 'ajc_options_setup' );

// Change Thickbox message text
function replace_thickbox_text( $translated_text, $text, $domain ) {
	if ('Insert into Post' == $text) {
		$referer = strpos( wp_get_referer(), 'ajc-settings' );
		if ( $referer != '' ) {
			return __('Use this image', 'ajc' );
		}
	}
	return $translated_text;
}
