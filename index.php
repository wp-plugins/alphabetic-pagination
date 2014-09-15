<?php 
/*



Plugin Name: Alphabetic Pagination



Plugin URI: http://www.websitedesignwebsitedevelopment.com/wordpress/plugins/alphabetic-pagination



Description: Alphabetic pagination is a great plugin to filter your posts/pages and WooCommerce products with alphabets. It is compatible with custom taxonomies.



Version: 1.4.2



Author: Fahad Mahmood 



Author URI: http://www.androidbubbles.com



License: GPL3



*/ 


        
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        

	global $ap, $ap_implementation, $rendered, $premium_link, $ap_data;
	$rendered = FALSE;
	$premium_link = 'http://shop.androidbubbles.com/product/alphabetic-pagination-pro';
	define('AP_CUSTOM', 'custom');
	
	$ap_data = get_plugin_data(__FILE__);
	$ap = isset($_GET['ap'])?$_GET['ap']:'';
	
	
	include('inc/functions.php');
        
	register_activation_hook(__FILE__, 'ap_start');

	//KBD END WILL REMOVE .DAT FILES	

	register_deactivation_hook(__FILE__, 'ap_end' );



	add_action( 'admin_enqueue_scripts', 'register_ap_scripts' );
	add_action( 'wp_enqueue_scripts', 'register_ap_scripts' );
	


	//add_filter('found_posts_query', 'ap_pagination', 1);

	//pre_get_posts
	
	
	if(is_admin()){
		add_action( 'admin_menu', 'ap_menu' );	
		add_action( 'wp_ajax_ap_tax_types', 'ap_tax_types_callback' );
		$plugin = plugin_basename(__FILE__); 
		add_filter("plugin_action_links_$plugin", 'ap_plugin_links' );	
		
	}else{
		
		
		$ap_implementation = get_option('ap_implementation');
		
		
		
		if($ap_implementation=='' || $ap_implementation=='auto'){
			add_filter('pre_get_posts', 'ap_pagination', 1);
			//WILL WORK FROM SETTINGS
			add_action('wp_footer', 'ap_ready');
		}elseif($ap_implementation==AP_CUSTOM){			
			add_filter('pre_get_posts', 'ap_pagination_halt', 1);
			//WILL WORK WITH SHORTCODE PARAMS
			add_shortcode('ap_pagination', 'ap_pagination_custom');
		}
		
		
	}


	