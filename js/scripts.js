// JavaScript Document
jQuery(document).ready(function($){
								
	var ap_methods = {
		load_sub_items: function(type){
			
			jQuery.post(ajaxurl, {action: 'ap_tax_types',"type":type}, function(response) {
				response = jQuery.parseJSON(response);																
				if(response.msg){
					var data = response.data;
					var selected = response.selected;
					var items = '';
					jQuery.each(data, function(i, v){
						var is_selected = '';											   
						jQuery.each(selected, function(is, vs){
							
							
							if(vs==i)
							is_selected = 'selected="selected"';
							
							
							
						});
						
						items+='<option value="'+i+'" '+is_selected+'>'+v+'</option>';
					
						
					});
					jQuery('#tax_types_selector').html(items);
					jQuery('div.ap_tax_types').show();

				}																
				
			});
		}
	}
	
	jQuery('body').on('#tax_selector', 'change',function(){
		var type = jQuery(this).val();				
		if(type.length>0)
		ap_methods.load_sub_items(type);

	  
   	});
	
	$('div.ap_shortcode code, div.ap_shortcode div').click(function(){
		
		var o = $( "div.ap_shortcode.hide > a" );
		
		
	});
	
});