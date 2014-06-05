<?php
global $ap_implementation;
$ap_implementation = get_option('ap_implementation');
require_once('languages.php');
$dom_selectors = array(
'#main'=>'#main',
'#primary'=>'#primary',
'#content'=>'#content'
);
$ap_styles = array(
'ap_gogowords'=>'Gogo Words',
'ap_chess'=>'AP Chess',
'ap_classic'=>'AP Classic',
'ap_mahjong'=>'AP Mahjong'   
);
ksort($ap_styles);
$ap_classes = implode(' ', array_keys($ap_styles));

$ap_taxonomies = get_taxonomies();
$stored_tax = get_option('ap_tax');
$stored_langs = get_option('ap_lang');


if(empty($ap_taxonomies))
$ap_taxonomies = array();

if(empty($stored_tax))
$stored_tax = array();

if(empty($stored_langs) || !is_array($stored_langs))
$stored_langs = array();



$dom_default = false;
$dom_selected = (get_option('ap_dom')==''?false:true);

$ap_all = (get_option('ap_all')==1?true:false);



?>

<div class="wrap ap_settings_div">


        

<div class="icon32" id="icon-options-general"><br></div><h2>Alphabetic Pagination - Settings</h2>





<?php $wpurl = get_bloginfo('wpurl'); ?>



<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">



<div class="welcome-panel" id="request_panel">
<a class="welcome-panel-close dismiss_link">Dismiss</a>
<img class="flower_img" src="<?php echo plugin_dir_url(__FILE__); ?>/flower.png">

		<h2><span class="promo">Show some love!</span></h2>
		<p>Want to appreciate the effort behind this plugin? <a target="_blank" class="button" href="http://www.websitedesignwebsitedevelopment.com/donate-now/" >Donate</a> $2, $4 or $8 now!</p>
       
        <p>Or you could:</p><ul><li><a href="http://wordpress.org/support/view/plugin-reviews/alphabetic-pagination" target="_blank">Rate this plugin 5 stars on WordPress.org</a></li></ul>	
</div>


<div class="ap_notes">By default this plugin enables pagination on the default posts page (Settings > Reading).<br />
The following option enables Alphabetical Pagination on all other templates.</div>

<table class="form-table">



<tbody>

<tr>
<th scope="row">Implentation:</th>
<td>

<fieldset>

	<p>
   <label for="ap_implementation_auto">
		<input type="radio" <?php echo ($ap_implementation!=AP_CUSTOM?'checked="checked"':''); ?> class="ap_imp" id="ap_implementation_auto" value="auto" name="ap_implementation">Auto</label>
	</p>
    <p>
   <label for="ap_implementation_custom">
		<input type="radio" <?php echo ($ap_implementation!=AP_CUSTOM?'':'checked="checked"'); ?> class="ap_imp" id="ap_implementation_custom" value="<?php echo AP_CUSTOM; ?>" name="ap_implementation"><?php echo ucwords(AP_CUSTOM); ?></label>
	</p>
</fieldset>

</td>
<td rowspan="5" width="54%" valign="top">
<div class="ap_shortcode <?php echo ($ap_implementation==AP_CUSTOM?'':'hide'); ?>">
Shortcode:<br />
<br />

<code>
[ap_pagination]
</code>
<div>
or
</div>
<code>
&lt;?php echo do_shortcode('[ap_pagination]'); ?&gt;
</code>


</div>
<br />
<br />



Styles:
<select name="ap_style" id="ap_styles">
    <option value="">Select</option>
    <?php foreach($ap_styles as $style_name=>$style_value): ?>
    <option value="<?php echo $style_name; ?>" <?php selected( $style_name, get_option('ap_style') ); ?>><?php echo $style_value; ?></option>    
    <?php endforeach; ?>        
</select><br /><br /><br />

Preview:

<?php 
echo alphabets_bar();
ap_ready();
?>
</td>
</tr>

<tr>
<th scope="row">Display on all lists?</th>
<td>



<fieldset>

	<p>
   <label for="ap_all_yes">
		<input type="radio" <?php echo ($ap_all?'checked="checked"':''); ?> class="tog" id="ap_all_yes" value="1" name="ap_all">Yes</label>
	</p>
    <p>
   <label for="ap_all_no">
		<input type="radio" <?php echo ($ap_all?'':'checked="checked"'); ?> class="tog" id="ap_all_no" value="0" name="ap_all">No</label>
	</p>





</fieldset>


<div class="ap_tax_div <?php echo $ap_all?'hide':''; ?>">

<fieldset>

	<p>
    <select class="ap_taxes" name="ap_tax[]" id="tax_selector" multiple="multiple">
    	<option value="">Select</option>
    	<?php foreach($ap_taxonomies as $tax): ?>
    	<option value="<?php echo $tax; ?>" <?php echo in_array($tax, $stored_tax)?'selected="selected"':''; ?>><?php echo $tax; ?></option>    
        <?php endforeach; ?>  
    </select>
    
	</p>
Note: Multiple taxonomies can be selected.
</fieldset>

</div>

<div class="ap_tax_types hide">

<fieldset>

	<p>
    <select class="ap_taxes_types" name="ap_tax_types[]" id="tax_types_selector" multiple="multiple">
    	<option value="">Select</option>    	
    </select>
    
	</p>
Note: Multiple items can be selected.
</fieldset>

</div>




</td></tr>


<tr valign="top">

<tr valign="top">

<th scope="row">Hide/Show pagination if only one post available?</th>


<td id="front-static-pages"><fieldset>


	<p><label for="signle_hide">


		<input type="radio" <?php echo (get_option('ap_single')==0?'checked="checked"':''); ?> id="signle_hide" value="0" name="ap_single">Hide</label>

	</p>


	<p><label for="signle_show">

		<input type="radio" <?php echo (get_option('ap_single')==1?'checked="checked"':''); ?> id="signle_show" value="1" name="ap_single">Show</label>

	</p>

</fieldset></td>



</tr>

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



<th scope="row">DOM Position?
<br />
<div class="ap_caption">This is the HTML element where the Alphabetical Pagination will be placed into.</div>

</th>



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







<th scope="row">Language selection?</th>



<td>



<fieldset>

	<p><select class="ap_langs" name="ap_lang[]" id="ap_lang_selector" multiple="multiple">

    	<?php foreach($ap_langs as $titles=>$letters):
			  $lang = ucwords($titles);
			  
		 ?>
    	<option value="<?php echo $lang; ?>" <?php echo in_array($lang, $stored_langs)?'selected="selected"':''; ?>><?php echo $lang; ?></option>    
        <?php endforeach; ?>  
    </select></p>

</fieldset>





</td></tr>



</tbody></table>

<p class="submit"><input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit"><a class="useful_link">Want to appreciate?</a></p>

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
	
	jQuery('#ap_all_no').click(function(){
		jQuery('.ap_tax_div').slideDown();
	});
	jQuery('#ap_all_yes').click(function(){
		jQuery('.ap_tax_div').slideUp();
	});

	jQuery('input.ap_imp').click(function(){
		switch(jQuery(this).val()){
			case '<?php echo AP_CUSTOM; ?>':
				jQuery('div.ap_shortcode').slideDown('slow');
			break;
			default:
				jQuery('div.ap_shortcode').slideUp('slow');
			break;
		}
	
	});


        jQuery('input[name="ap_layout"]').click(function(){
		jQuery('.ap_pagination').removeClass('layout_H');
                jQuery('.ap_pagination').removeClass('layout_V');
                jQuery('.ap_pagination').addClass(jQuery(this).attr('id'));
	});
        
        jQuery('input[name="ap_case"]').click(function(){
		jQuery('.ap_pagination').removeClass('case_U');
                jQuery('.ap_pagination').removeClass('case_L');
                jQuery('.ap_pagination').addClass(jQuery(this).attr('id'));
	});
	
	jQuery('select[name="ap_style"]').change(function(){
                               
                jQuery('.ap_pagination').removeClass('<?php echo $ap_classes; ?>').addClass(jQuery(this).val());
        });
});	
</script>