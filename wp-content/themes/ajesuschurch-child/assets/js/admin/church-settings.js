(function ($) {
'use strict';

	// Redirect user click on tile image button
	$(document).ready(function ($) {
		$('#tile_image_button').click(function () {
			tb_show('Upload Tile Image', 'media-upload.php?referer=ajc-settings&type=image&TB_iframe=true&post_id=0', false);
			return false;
		});
	});

	// Send tile image path to medial library
	window.send_to_editor = function (html) {
		var image_url = $('img', html).attr('src'),
			classes   = $('img', html).attr('class').split(' '),
			i, len, matches, image_id;
		// Look for the image attachment_id
		for (i=0, len=classes.length; i< len; i++) {
			matches = /^wp-image\-(.+)/.exec(classes[i]);
			if (matches != null) {
				image_id = matches[1];
			}
		}
		// Grab menu-tile version of the image
		var data = {
			action: 'image_size_url',
			image_size: 'menu-tile',
			image_id: image_id,
			original_url: image_url
		}
		jQuery.post(ajaxurl, data, function(response) {
			// Debugging
			// console.log('From image_size_url: '+ response);
			if (response) {
				image_url = response;
			}
			// Update settings screen
			$('#tile_image').val(image_url);
			$('#tile_image_preview img').attr('src', image_url);
			tb_remove();
		});
	};

	// Update preview when #tile_image changes
	/*$('#tile_image').change(function () {

	});*/

})(jQuery);
