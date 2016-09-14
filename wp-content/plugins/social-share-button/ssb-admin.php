<?php

	if(empty($_POST['ssb_hidden']))
		{
			$ssb_share_content_display = get_option( 'ssb_share_content_display' );	
			$ssb_share_content_themes = get_option( 'ssb_share_content_themes' );
			$ssb_share_content_position = get_option( 'ssb_share_content_position' );
			$ssb_share_content_icon_margin = get_option( 'ssb_share_content_icon_margin' );
			$ssb_share_filter_posttype = get_option( 'ssb_share_filter_posttype' );			
			$ssb_share_target_tab = get_option( 'ssb_share_target_tab' );				
					
		}

	else
		{
		
		if($_POST['ssb_hidden'] == 'Y')
			{
			//Form data sent
			
			
			$ssb_share_content_display = $_POST['ssb_share_content_display'];
			update_option('ssb_share_content_display', $ssb_share_content_display);			
			
			
			
			$ssb_share_content_themes = $_POST['ssb_share_content_themes'];
			update_option('ssb_share_content_themes', $ssb_share_content_themes);
			
			$ssb_share_content_position = $_POST['ssb_share_content_position'];
			update_option('ssb_share_content_position', $ssb_share_content_position);
			
			$ssb_share_content_icon_margin = $_POST['ssb_share_content_icon_margin'];
			update_option('ssb_share_content_icon_margin', $ssb_share_content_icon_margin);
			

			if(!empty($_POST['ssb_share_filter_posttype']))
				{
					$ssb_share_filter_posttype = $_POST['ssb_share_filter_posttype'];
					
				}
			else
				{
					$ssb_share_filter_posttype = "";
				}

			
			update_option('ssb_share_filter_posttype', $ssb_share_filter_posttype);			
			
			$ssb_share_target_tab = $_POST['ssb_share_target_tab'];
			

			
			
			update_option('ssb_share_target_tab', $ssb_share_target_tab);				
			
			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.' ); ?></strong></p>
            </div>
            
            
            
            
<?php
			}
		} 
?>


<div class="wrap">
<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="ssb_hidden" value="Y">
        <?php settings_fields( 'ssb_plugin_options' );
				do_settings_sections( 'ssb_plugin_options' );
		?>

<div class="wp-settings-pro">
    <div class="heading"><h2>Social Share Button Settings</h2></div>
    
    <div class="settings-saved">

    </div>
    

    
    <div class="setting-descriptions"><p>Control social share button option here, choose different style and themes, display top or bottom of content.</p></div>


    <div class="option-area">
    <div class="option-title"><strong>Display On Content</strong>
    
    </div>
    <div class="option-descriptions">Choose 'yes' to display share buttons on content and choose 'No' to hide share buttons on post.
    
    </div>
    
    <div class="option-input">
        <select name="ssb_share_content_display">
        	<option value="yes" <?php  if($ssb_share_content_display=='yes') echo "selected"; ?>>Yes</option>
            <option value="no" <?php  if($ssb_share_content_display=='no') echo "selected"; ?>>No</option>
           
        </select> 
    </div>

</div>








<div class="option-area">
    <div class="option-title"><strong>Display share button On These Post Type Only</strong>
    
    </div>
    <div class="option-descriptions">By choosing post type you can filter display share button only these post type.
    </div>
    
    <div class="option-input">
<?php

$post_types = get_post_types( '', 'names' ); 

foreach ( $post_types as $post_type ) {

   echo '<label for="ssb_share_filter_posttype['.$post_type.']"><input type="checkbox" name="ssb_share_filter_posttype['.$post_type.']" id="ssb_share_filter_posttype['.$post_type.']"  value ="1" ' ?> 
   <?php if ( isset( $ssb_share_filter_posttype[$post_type] ) ) echo "checked"; ?>
   <?php echo' >'. $post_type.'</label><br />' ;
}
?>
    </div>

</div>







<div class="option-area">
    <div class="option-title"><strong>Open new tab when click share buttons</strong>
    
    </div>
    <div class="option-descriptions">When someone try to click share buttons it will open new tab to sahre link on social media sites.
    </div>
    
    <div class="option-input">
        <select name="ssb_share_target_tab">
        	<option value="new" <?php  if($ssb_share_target_tab=='new') echo "selected"; ?>>New</option> 
        	<option value="same" <?php  if($ssb_share_target_tab=='same') echo "selected"; ?>>Same</option>
        </select>
    </div>

</div>



















    <div class="option-area">
    <div class="option-title"><strong>Select Buttons Themes</strong>
    
    </div>
    <div class="option-descriptions">Select different style themes to display different style buttons on post.
    </div>
    
    <div class="option-input">
<style type="text/css">

.ssb_share_content_themes input[type="radio"] {
  display: none;
}

.ssb_share_content_themes label {
  cursor: pointer;
  display: inline-block;
}
.ssb_share_content_themes span.selected {
  border: 3px solid #FF511C;
  box-shadow: 0 0 4px -1px #000000;
}



span.ssb_share_content_themes_defualt 
	{
  background: url("<?php echo ssb_plugin_path; ?>css/admin-defualt.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
  display: block;
  height: 100px;
  width: 100px;
	
	}
span.ssb_share_content_themes_flat {
  background: url("<?php echo ssb_plugin_path; ?>css/admin-flat.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
  display: block;
  height: 100px;
  width: 100px;
  
}








	
span.ssb_share_content_themes_round 
	{
  background: url("<?php echo ssb_plugin_path; ?>css/admin-round.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
  display: block;
  height: 100px;
  width: 100px;
	}
	
	
span.ssb_share_content_themes_wide 
	{
  background: url("<?php echo ssb_plugin_path; ?>css/admin-wide.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
  display: block;
  height: 100px;
  width: 100px;
	}	
	
	
span.ssb_share_content_themes_bodyname 
	{
  background: url("<?php echo ssb_plugin_path; ?>css/admin-bodyname.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
  display: block;
  height: 100px;
  width: 100px;
	}
span.ssb_share_content_themes_packslide 
	{
  background: url("<?php echo ssb_plugin_path; ?>css/admin-packslide.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
  display: block;
  height: 100px;
  width: 100px;
	}	
	
span.ssb_share_content_themes_hexa
	{
  background: url("<?php echo ssb_plugin_path; ?>css/admin-hexa.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
  display: block;
  height: 100px;
  width: 100px;
	}	
	
span.ssb_share_content_themes_hover_left
	{
  background: url("<?php echo ssb_plugin_path; ?>css/admin-hover-left.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
  display: block;
  height: 100px;
  width: 100px;
	}	
	
	
span.ssb_share_content_themes_hover_right 
	{
  background: url("<?php echo ssb_plugin_path; ?>css/admin-hover-right.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
  display: block;
  height: 100px;
  width: 100px;
	}	
	
</style>


<script>
jQuery(document).ready(function(jQuery)
	{
					jQuery(".ssb_share_content_themes span").click(function(){
						jQuery('.selected').removeClass('selected');
						jQuery(this).addClass('selected');
						
						})

					
	})

</script>







        <div class="ssb_share_content_themes">
        	<label ><input type="radio" name="ssb_share_content_themes"  value="defualt" <?php  if($ssb_share_content_themes=='defualt') echo "checked"; ?>/><span title="Defualt" class="ssb_share_content_themes_defualt <?php  if($ssb_share_content_themes=='defualt') echo "selected"; ?>"></span></label>
            
        	<label ><input type="radio" name="ssb_share_content_themes"  value="flat" <?php  if($ssb_share_content_themes=='flat') echo "checked"; ?>/><span title="Flat" class="ssb_share_content_themes_flat <?php  if($ssb_share_content_themes=='flat') echo "selected"; ?>"></span></label>
            
           <label ><input type="radio" name="ssb_share_content_themes"  value="round" <?php  if($ssb_share_content_themes=='round') echo "checked"; ?>/><span title="Round" class="ssb_share_content_themes_round <?php  if($ssb_share_content_themes=='round') echo "selected"; ?>" ></span></label>
           
           <label ><input type="radio" name="ssb_share_content_themes"  value="wide" <?php  if($ssb_share_content_themes=='wide') echo "checked"; ?>/><span title="Wide" class="ssb_share_content_themes_wide <?php  if($ssb_share_content_themes=='wide') echo "selected"; ?>"></span></label>
            
           <label > <input type="radio" name="ssb_share_content_themes"  value="bodyname" <?php  if($ssb_share_content_themes=='bodyname') echo "checked"; ?>/><span title="Body Name" class="ssb_share_content_themes_bodyname <?php  if($ssb_share_content_themes=='bodyname') echo "selected"; ?>"></span></label>
            
             <label ><input type="radio" name="ssb_share_content_themes"  value="packslide" <?php  if($ssb_share_content_themes=='packslide') echo "checked"; ?>><span title="Pack Slide"  class="ssb_share_content_themes_packslide <?php  if($ssb_share_content_themes=='packslide') echo "selected"; ?>"></span></label>
             
            <label ><input type="radio" name="ssb_share_content_themes"  value="hexa" <?php  if($ssb_share_content_themes=='hexa') echo "checked"; ?>/><span title="Hexa" class="ssb_share_content_themes_hexa <?php  if($ssb_share_content_themes=='hexa') echo "selected"; ?>"></span></label>
            
            <label > <input type="radio" name="ssb_share_content_themes"  value="hover-left" <?php  if($ssb_share_content_themes=='hover-left') echo "checked"; ?>><span title="Hover Left" class="ssb_share_content_themes_hover_left <?php  if($ssb_share_content_themes=='hover-left') echo "selected"; ?>"></span></label>
                 
             <label ><input type="radio" name="ssb_share_content_themes"   value="hover-right" <?php  if($ssb_share_content_themes=='hover-right') echo "checked"; ?>/><span title="Hover Right" class="ssb_share_content_themes_hover_right <?php  if($ssb_share_content_themes=='hover-right') echo "selected"; ?>"></span></label>                   
            </div>       
      
    </div>

</div>




<div class="option-area">
    <div class="option-title"><strong>Social Share Position</strong>
    
    </div>
    <div class="option-descriptions">Display share button top or bottom of content.
    </div>
    
    <div class="option-input">
        <select name="ssb_share_content_position">
        	<option value="top" <?php  if($ssb_share_content_position=='top') echo "selected"; ?>>Top</option>
            <option value="bottom" <?php  if($ssb_share_content_position=='bottom') echo "selected"; ?>>Bottom</option>
        </select>  
    </div>

</div>

    <div class="option-area">
        <div class="option-title"><strong>Buttons Margin</label></strong>
        
        </div>
        <div class="option-descriptions">Margin for buttons.</div>
        <div class="option-input">
<input name="ssb_share_content_icon_margin" size="5" type="text" value="<?php  if(!empty($ssb_share_content_icon_margin)) echo $ssb_share_content_icon_margin; else echo "0"; ?>" />px  
        </div>
    
    </div>


<div class="option-area">
        <div class="option-title"><strong>Need Help ?</strong>
        
        </div>
        <div class="option-descriptions">Please report any issue via support forum <a href="http://wordpress.org/support/plugin/social-share-button">wordpress.org &raquo; support</a>.
        
        
        
<?php


				$plugin_link = 'http://wordpress.org/plugins/social-share-button/';
				$ssb_share = '';
				$ssb_share.= '<br /><br /><strong>Help us by sharing with your friends.<strong><br /><table ><tr>
				<td width="90">
<iframe src="//www.facebook.com/plugins/like.php?href='.$plugin_link.'&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21&amp;appId=743541755673761" scrolling="no" frameborder="0" style="border:none; overflow:hidden;width:100px; height:21px;" allowTransparency="true"></iframe>
				</td>
    
';

				
				$ssb_share.= '
					<td width="90" >
				
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="'.$plugin_link.'">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document, "script", "twitter-wjs");</script>
					</td>';				
			
				$ssb_share.= '
					<td width="70">
				<script type="text/javascript" src="https://apis.google.com/js/platform.js"></script>
<div class="g-plusone" data-size="medium" data-href="'.$plugin_link.'"></div>
					</td>';				
			
			
				$ssb_share.= '
					<td width="110">
				<script src="//platform.linkedin.com/in.js" type="text/javascript">
  lang: en_US
</script>
<script type="IN/Share" data-url="'.$plugin_link.'" data-counter="right"></script>
					
					</td>';			
			
				$ssb_share.= '
					<td width="100">
					
					
					
<script type="text/javascript" src="http://www.reddit.com/buttonlite.js?i=1&styled=off&url='.$plugin_link.'&newwindow=1"></script>
					


					</td>';
	
					
				
				$ssb_share.= '</tr></table>';

				echo $ssb_share;



?>
        
        
        
        
        
        </div>
        <div class="option-input">

        </div>
    
    </div>


                <p class="submit">
                    <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes' ) ?>" />
                </p>

</div>



		</form>








<style type="text/css">
.wp-settings-pro {
  background: none repeat scroll 0 0 #FFFFFF;
  margin-bottom: 20px;
  padding-bottom: 20px;
  width: 100%;
}

.wp-settings-pro .heading {
  border-bottom: 2px solid #666666;
}




.wp-settings-pro .heading h2 {
  color: #333333;
  font-size: 20px;
  font-weight: bold;
  padding-left: 20px;
}

.wp-settings-pro .heading .updated {
  margin-left: 20px;
}


.wp-settings-pro .submit {
	margin-left: 20px;
}
.wp-settings-pro .setting-descriptions{

}

.wp-settings-pro .setting-descriptions p {
  border-bottom: 1px solid;
  color: #999999;
  font-size: 13px;
  margin-bottom: 15px;
  margin-left: 20px;
  margin-top: 15px;
  padding-bottom: 5px;
}

.wp-settings-pro .option-area {
  margin: 30px 0;
}


.wp-settings-pro .option-area .option-title {
  font-size: 15px;
  margin: 10px 0;
  padding-left: 20px;
}

.wp-settings-pro .option-area .option-descriptions {
  font-size: 13px;
  padding-left: 20px;
}

.wp-settings-pro .option-area .option-input {
  border-bottom: 1px solid #DDDDDD;
  margin-left: 20px;
  padding: 20px 0;
}

</style>







</div>
