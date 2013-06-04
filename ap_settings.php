<?php
$dom_selectors = array(
'#main'=>'#main',
'#primary'=>'#primary',
'#content'=>'#content',
'Custom'=>'Custom'

);
?>

<div class="wrap">


        

<div class="icon32" id="icon-options-general"><br></div><h2>Alphabetic Pagination - Settings</h2>





<?php echo $settings['notification']; $wpurl = get_bloginfo('wpurl'); ?>



<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">



<div class="welcome-panel" id="request_panel">
<a class="welcome-panel-close dismiss_link">Dismiss</a>
<img class="flower_img" src="<?php echo plugin_dir_url(__FILE__); ?>/flower.png">

		<h2><span class="promo">Show some love!</span></h2>
		<p>Want to appreciate the effort behind this plugin? <a target="_blank" class="button" href="http://www.websitedesignwebsitedevelopment.com/donate-now/" >Donate</a> $5, $10 or $50 now!</p>
       
        <p>Or you could:</p><ul><li><a href="http://wordpress.org/support/view/plugin-reviews/alphabetic-pagination" target="_blank">Rate this plugin 5 stars on WordPress.org</a></li></ul>	
</div>



<table class="form-table">



<tbody><tr valign="top">



<th scope="row">Layout Required?</th>



<td id="front-static-pages"><fieldset>



	<p><label for="layout_H">



		<input type="radio" <?php echo (get_option('ap_layout')=='H'?'checked="checked"':''); ?> class="tog" id="layout_H" value="H" name="ap_layout">Horizontal</label>







	</p>



	<p><label for="layout_V">



		<input type="radio" <?php echo (get_option('ap_layout')=='V'?'checked="checked"':''); ?> class="tog" id="layout_V" value="V" name="ap_layout">Vertical</label>









	</p>







    

</fieldset></td>



</tr>



<tr valign="top">



<th scope="row">Alphabets in?</th>



<td>



<fieldset>

	<p><label for="case_U">
		<input type="radio" <?php echo (get_option('ap_case')=='U'?'checked="checked"':''); ?> class="tog" id="case_U" value="U" name="ap_case">Uppercase</label>

	</p>



	<p><label for="case_L">
		<input type="radio" <?php echo (get_option('ap_case')=='L'?'checked="checked"':''); ?> class="tog" id="case_L" value="L" name="ap_case">Lowercase</label>
	</p>







    

</fieldset>





</td></tr>






<tr valign="top">



<th scope="row">DOM Position?</th>



<td>



<fieldset>

	<p>
    <select name="ap_dom" id="dom_selector">
    	<option value="">Select</option>
    	<?php foreach($dom_selectors as $dom): ?>
    	<option value="<?php echo $dom; ?>" <?php selected( $dom, get_option('ap_dom') ); ?>><?php echo $dom; ?></option>    
        <?php endforeach; ?>
        <?php if(!in_array(get_option('ap_dom'), $dom_selectors)): ?>
        <option value="<?php echo get_option('ap_dom'); ?>" <?php selected( get_option('ap_dom'), get_option('ap_dom') ); ?>><?php echo get_option('ap_dom'); ?></option>
        <?php endif; ?>
    </select>
    
	</p>





</fieldset>





</td></tr>


</tbody></table>

<p class="submit"><input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit"><a class="useful_link">Find this plugin useful?</a></p>

</form>



</div>

<script type="text/javascript" language="javascript">
jQuery(document).ready(function($) {
	jQuery('.dismiss_link').click(function(){
		jQuery(this).parent().slideUp();
		jQuery('.useful_link').fadeIn();
	});
	jQuery('.useful_link').click(function(){
		jQuery('.dismiss_link').parent().slideDown();
		jQuery(this).fadeOut();
	});
	setInterval(function(){ jQuery('.useful_link').fadeTo('slow', 0).fadeTo('slow', 1.0);
	
	}, 1000*60);
	
	jQuery('#dom_selector').click(function(){
		if(jQuery(this).val()=='Custom'){
		
		jQuery(this).parent().append('<input type="text" name="ap_dom" value="<?php echo get_option('ap_dom'); ?>" />');
		jQuery(this).remove();
		}
	});
	
	
});	
</script>