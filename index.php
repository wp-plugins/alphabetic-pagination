<?php 



/*



Plugin Name: Alphabetic Pagination



Plugin URI: http://www.websitedesignwebsitedevelopment.com/wordpress/plugins/alphabetic-pagination



Description: Alphabetic pagination is a great plugin to filter your posts/pages with alphabets. It is simple to use and easy to understand for customization.



Version: 0.2



Author: Fahad Mahmood 



Author URI: http://www.androidbubbles.com



License: GPL3



*/ 



	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');



	include('functions.php');



	



	function ap_menu()



	{



		 add_options_page('Alphabetic Pagination', 'Alphabetic Pagination', 'update_core', 'alphabetc_pagination', 'alphabetc_pagination');



	}

	function alphabetc_pagination() 



	{ 



		if ( !current_user_can( 'update_core' ) )  {



			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );



		}



		global $wpdb; 

		

		

		if(isset($_REQUEST['ap_layout']) && in_array($_REQUEST['ap_layout'], array('H', 'V')))		

		{

			update_option( 'ap_layout', $_REQUEST['ap_layout'] );

		}

		

		if(isset($_REQUEST['ap_case']) && in_array($_REQUEST['ap_case'], array('U', 'L')))		

		{

			update_option( 'ap_case', $_REQUEST['ap_case'] );

		}

	

		include('ap_settings.php');	

		

			



	}	



	

	

	register_activation_hook(__FILE__, 'ap_start');



	//KBD END WILL REMOVE .DAT FILES	

	register_deactivation_hook(__FILE__, 'ap_end' );



	wp_enqueue_script('jquery');

	wp_enqueue_style('ap-pagination', plugins_url('style.css', __FILE__));

	//add_filter('found_posts_query', 'ap_pagination', 1);

	//pre_get_posts

	add_filter('pre_get_posts', 'ap_pagination', 1);

	add_action( 'admin_menu', 'ap_menu' );	



	