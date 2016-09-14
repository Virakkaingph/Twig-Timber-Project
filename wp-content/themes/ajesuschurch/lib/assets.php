<?php
/*
Author: Belief
URL: http://beliefagency.com

This is where you should load js & css.
*/

/************* SCRIPTS & STYLES ***************/

function application_assets() {
	global $wp_styles;
	if ( !is_admin() ) {

		wp_enqueue_style('stylesheet', assets_url() . '/css/style.css', false, null);
		wp_enqueue_style('ie-only', assets_url() . '/css/ie.css', false, null );
		$wp_styles->add_data( 'ie-only', 'conditional', 'lt IE 9' );

		wp_register_script('modernizr', assets_url() . '/js/vendor/modernizr.min.js', false, null, false);
		wp_register_script('vendor', assets_url() . '/js/vendor.min.js', false, null, true);
		wp_register_script('application', assets_url() . '/js/main.min.js', false, null, true);

		// jquery_cdn_with_fallback();
		wp_enqueue_script('modernizr');
		wp_enqueue_script('vendor');
		wp_enqueue_script('application');
	}
}
add_action('wp_enqueue_scripts', 'application_assets');

/*
- disable concatenate_scripts
- check what version of jquery was wordpress about to load
- try to load that version from google CDN instead (or from jquery CDN if prefered)
- if OK, run jQuery.noConflict()
- if failed – just use the local file

- check what version of jquery-migrate was WP about to load (if any)
- try to load that version from jquery CDN
- if failed – just use the local file
*/
function jquery_cdn_with_fallback() {
	global $wp_scripts;
	$script = $wp_scripts->query( 'jquery' );
	$ver = $script->ver;
	$url = "//ajax.googleapis.com/ajax/libs/jquery/$ver/jquery.min.js";
	/*$script->src = $url;*/ ?>
	<script src="<?php echo $url; ?>"></script>
	<script>window.jQuery || document.write('<script src="wp-includes/js/jquery/jquery.js"><\/script>')</script>
<?php }
