<style type="text/css">
a
{
	cursor:pointer;
}


medium.expected


{


	float:right;


}


</style>


<div class="wrap">

<div class="icon32" id="icon-options-general"><br></div><h2>Alphabetic Pagination - Settings</h2>

<?php echo $settings['notification']; $wpurl = get_bloginfo('wpurl'); ?>

<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">



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

<th scope="row"><label for="recpient_email_address">Alphabets in?</label></th>

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


</tbody></table>

<p class="submit"><input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit"></p></form>

</div>
