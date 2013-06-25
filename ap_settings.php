<?php
$dom_selectors = array(
'#main'=>'#main',
'#primary'=>'#primary',
'#content'=>'#content'
);
$ap_taxonomies = get_taxonomies();
$stored_tax = get_option('ap_tax');

if(empty($ap_taxonomies))
$ap_taxonomies = array();

if(empty($stored_tax))
$stored_tax = array();

$dom_default = false;
$dom_selected = (get_option('ap_dom')==''?false:true);
?>

<div class="wrap ap_settings_div">


        

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



<fieldset class="doms">

	
    <div class="dom_options <?php echo $dom_selected?'hide':''; ?>">
    <a id="dom_default">Default</a>&nbsp;|&nbsp;
    <a id="dom_custom">Custom</a>
    </div>
    
  
  	<?php if(in_array(get_option('ap_dom'), $dom_selectors)): ?>
        
    <?php $dom_default = true; ?>
    
    <?php endif; ?>
    
	
	<p>
    
    <select class="<?php echo $dom_default?'':'hide'; ?> dom_opt" name="ap_dom" id="dom_selector">
        <option value="">Select</option>
        <?php foreach($dom_selectors as $dom): ?>
        <option value="<?php echo $dom; ?>" <?php selected( $dom, get_option('ap_dom') ); ?>><?php echo $dom; ?></option>    
        <?php endforeach; ?>        
    </select>
    
    <?php echo $dom_default?'':'<input type="text" name="ap_dom" value="'.get_option('ap_dom').'" />'; ?>
    
    &nbsp;
    <a id="dom_reset" class="<?php echo $dom_selected?'':'hide'; ?>">Reset</a>
    </p>    
	
    
    
	





</fieldset>





</td></tr>



<tr valign="top">



<th scope="row">Taxonomies?</th>



<td>



<fieldset>

	<p>
    <select class="ap_taxes" name="ap_tax[]" id="tax_selector" multiple="multiple">
    	<option value="">Select</option>
    	<?php foreach($ap_taxonomies as $tax): ?>
    	<option value="<?php echo $tax; ?>" <?php echo in_array($tax, $stored_tax)?'selected="selected"':''; ?>><?php echo $tax; ?></option>    
        <?php endforeach; ?>  
    </select>
    
	</p>





</fieldset>





</td></tr>




<th scope="row">Display on all lists?</th>



<td>



<fieldset>

	<p>
   <label for="ap_all">
		<input type="checkbox" <?php echo (get_option('ap_all')?'checked="checked"':''); ?> class="tog" id="ap_all" value="1" name="ap_all">Yes, i want to display pagination on all available listings.</label>
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
	
	
	

	jQuery('#dom_custom').click(function(){
		
		
		jQuery('#dom_selector').hide();
		jQuery('#dom_selector').parent().find('#dom_reset').before('<input type="text" name="ap_dom" value="<?php echo get_option('ap_dom'); ?>" />');	
		jQuery('.dom_options').hide();
		jQuery('#dom_reset').show();
		
	});	
	
	jQuery('#dom_default').click(function(){
		
		jQuery(this).parent().hide();
		jQuery('#dom_selector').show();
		jQuery('#dom_reset').show();
		
	});
	
	jQuery('#dom_reset').click(function(){
		jQuery(this).hide();
		jQuery('.dom_opt').hide();
		jQuery('.dom_options').show();
		jQuery('#dom_selector').parent().find('input[name="ap_dom"]').remove();
		
	});
	
	
	
	
});	
</script>