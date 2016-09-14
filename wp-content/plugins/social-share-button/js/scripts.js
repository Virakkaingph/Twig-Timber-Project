jQuery(document).ready(function(jQuery)
	{

		// will be using for trace stats
			jQuery(".ssb-share a").click(function(){
				
				var ssb_site = jQuery(this).attr('class');
				var post_id = jQuery(this).parent().attr("post_id");
				


				jQuery.ajax(
					{
					type:"POST",
					url:ssb_ajax.ssb_ajaxurl,
					data:{action:"ssb_ajax_form",ssb_site:ssb_site,post_id:post_id},
					success:function(data)
						{
							
						}
					})
		});
					
	})