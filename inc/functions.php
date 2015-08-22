<?php



	function ap_search_orderby($orderby) {
	
		global $wpdb;	
	
		if ( isset($_GET['ap']) ) {
			$orderby = $wpdb->prefix . "posts.post_title ASC";	
		}
	
		return $orderby;
	
	}
	
	

	//FOR QUICK DEBUGGING

	



	if(!function_exists('pre')){
	function pre($data){



			echo '<pre>';



			print_r($data);



			echo '</pre>';	



		}	 



	}


	if(!function_exists('ap_vimeo_is_connected')){
		function ap_vimeo_is_connected()
		{
			$connected = @fsockopen("vimeo.com", 80); 
												
			if ($connected){
				$is_conn = true; //action when connected
				fclose($connected);
			}else{
				$is_conn = false; //action in connection failure
			}
			return $is_conn;
		
		}
	}
	
	if(!function_exists('ap_init_actions')){
		function ap_init_actions(){
			global $ap_current_cat;
	
			$categories = get_the_category();
			$ap_current_cat = $categories;

		}
	}


	function ap_menu()
	{
		global $ap_custom;
		
		$title = 'Alphabetic Pagination'.($ap_custom?' Pro':'');
		
		add_options_page($title, $title, 'update_core', 'alphabetc_pagination', 'alphabetc_pagination');



	}

	function alphabetc_pagination(){ 



		if ( !current_user_can( 'update_core' ) )  {



			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );



		}



		global $wpdb, $ap_group; 

		

		

		if(isset($_REQUEST['ap_layout']) && in_array($_REQUEST['ap_layout'], array('H', 'V')))		

		{

			update_option( 'ap_layout', $_REQUEST['ap_layout'] );

		}

		

		if(isset($_REQUEST['ap_case']) && in_array($_REQUEST['ap_case'], array('U', 'L')))		

		{

			update_option( 'ap_case', $_REQUEST['ap_case'] );

		}
		if(isset($_REQUEST['ap_single']) && in_array($_REQUEST['ap_single'], array(1, 0)))		

		{

			update_option( 'ap_single', $_REQUEST['ap_single'] );

		}		
	
		if(isset($_REQUEST['ap_dom'])){
			
			if($_REQUEST['ap_dom']!='')
			update_option( 'ap_dom', $_REQUEST['ap_dom'] );
			else
			update_option( 'ap_dom', '' );

		}
		
		if(isset($_REQUEST['ap_implementation'])){
			
			if($_REQUEST['ap_implementation']!='')
			update_option( 'ap_implementation', $_REQUEST['ap_implementation'] );
			else
			update_option( 'ap_implementation', '' );

		}		
		
		
		
		if(isset($_REQUEST['ap_tax']) && !empty($_REQUEST['ap_tax']))		

		{


			update_option( 'ap_tax', $_REQUEST['ap_tax'] );

		}
		
		if(isset($_REQUEST['ap_tax_types']) && !empty($_REQUEST['ap_tax_types']))		

		{


			update_option( 'ap_tax_types', $_REQUEST['ap_tax_types'] );

		}		
		
		if(isset($_REQUEST['ap_all'])){
		
		 	if($_REQUEST['ap_all']==1)
			update_option( 'ap_all', 1);
			else
			update_option( 'ap_all', 0);
		}			
		
		if(isset($_REQUEST['ap_numeric_sign'])){
		
		 	if($_REQUEST['ap_numeric_sign']==1)
			update_option( 'ap_numeric_sign', 1);
			else
			update_option( 'ap_numeric_sign', 0);
		}			
				
		
		if(isset($_REQUEST['ap_lang']) && !empty($_REQUEST['ap_lang']))		

		{


			update_option( 'ap_lang', $_REQUEST['ap_lang'] );

		}			
			
                
 		if(isset($_REQUEST['ap_style']) && !empty($_REQUEST['ap_style']))		

		{


			update_option( 'ap_style', $_REQUEST['ap_style'] );

		}	               
		
		
 		if(isset($_REQUEST['ap_grouping'])){
			update_option( 'ap_grouping', $_REQUEST['ap_grouping'] );
			
		}	 
		$ap_group = (get_option('ap_grouping')==0?false:true);
				
		include('ap_settings.php');	

		

	}	

	
	function ap_add_query_vars( $vars ){
	  global $ap_vv;
	  $ap_vv = $vars;
	  return $vars;
	}
	
	
	
	function ap_get_query_vars(){
		global $ap_vv;
		$v_val = array();
		if(!empty($vv)){
			foreach($vv as $vals){
				$v_val[$vals] = get_query_var($vals, '');
			}
			$v_val = array_filter($v_val, 'strlen');
			$v_val = array_filter($v_val, 'is_numeric');
			$v_val = array_keys();
		}
											
		return $v_val;									
	}

	function ap_remove_var($url, $key) { 
		$url = preg_replace('/(.*)(?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&'); 
		$url = substr($url, 0, -1); 
		
		$in = '/'.$key;
		if(stristr($url, $in)){
			$url2 = explode($in, $url);
			$url = current($url2);
		}
		
		return $url; 
	}
	

	

	if(!function_exists('alphabets_bar')){
                    function alphabets_bar(){                                			
                                            global $ap, $ap_custom, $arg, $ap_queries, $ap_group;
											
											$url = $_SERVER['REQUEST_URI'];
											
                                            $alphabets = ap_alphabets();
                                            
                                            $alphabetz_bar = '';

                                            foreach($alphabets as $language=>$alphabetz){
                                         

												
											if(
												(!isset($_GET['ap']) && get_query_var('paged', 0)!=0)
												||	
												(isset($_GET['ap']) && $_GET['ap']!='numeric')
											){
												$url_x = ap_remove_var( $url, 'page' );
											}
																					    
                                            $alphabetz_bar .= '<ul class="ap_'.$language.' ap_pagination case_'.get_option('ap_case').' layout_'.get_option('ap_layout').' '.get_option('ap_style').' by_'.$ap_queries.'">';
											
$alphabetz_bar .= '<li class="ap_numeric">';
                                                    $alphabetz_bar .= '<a href="'.add_query_arg( array($arg => 'numeric'), $url_x).'"  class="'.(strtolower($ap)=='numeric'?'selected':'').'">#</a>';

                                                    $alphabetz_bar .= '</li>';
																								
											
											$alpha_count = 0;
											$alpha_jump = ($ap_group?4:0);
											$alpha_jump_count = 0;
											$alpha_jump_arr = array();
											
                                            foreach($alphabetz as $alphabet){
											
											$alpha_count++;	
												
													if(
														(!isset($_GET['ap']) && get_query_var('paged', 0)!=0)
														||	
														(isset($_GET['ap']) && $_GET['ap']!=$alphabet)
													){
														$url_x = ap_remove_var( $url, 'page' );
													}	
													
													
													
														if($alpha_jump==0){										
																										
															$alphabetz_bar .= '<li class="ap_'.strtolower($alphabet).'">';
															$alphabetz_bar .= '<a href="'.add_query_arg( array($arg => $alphabet), $url_x).'" class="'.(strtolower($ap)==$alphabet?'selected':'').'">'.$alphabet.'</a>';
															$alphabetz_bar .= '</li>';
																													
														}else{
															
															$alpha_jump_count++;
															
															if($alpha_jump_count<=$alpha_jump){
																$alpha_jump_arr[] = $alphabet;
																if($alpha_jump_count==$alpha_jump || $alpha_count==count($alphabetz)){
																	$alphabet_arg = current($alpha_jump_arr).(current($alpha_jump_arr)!=end($alpha_jump_arr)?'-'.end($alpha_jump_arr):'');
																	$alphabet_str = implode(' ap_', $alpha_jump_arr);
																	$alphabetz_bar .= '<li class="ap_'.strtolower($alphabet_str).'">';
																	$alphabetz_bar .= '<a href="'.add_query_arg( array($arg => $alphabet_arg), $url_x).'" class="'.(strtolower($ap)==$alphabet_arg?'selected':'').'">'.$alphabet_arg.'</a>';
																	$alphabetz_bar .= '</li>';
																}
															}else{					
																$alpha_jump_arr = array();
																$alpha_jump_arr[] = $alphabet;
																$alpha_jump_count = 1;
															}
															
															
															
															
														}
													
                                                    }

                                                    $alphabetz_bar .= '</ul>';
                                            }
                                            //pre($alpha_jump_arr);
                                            return $alphabetz_bar;
											
											
                    }
       }
                                
	if(!function_exists('ap_tax_types_callback')){    
		function ap_tax_types_callback() {
			
			if(!isset($_POST['type']))
			die();
			
			global $wpdb;
			$return['msg'] = false;
			$return = array();
			
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => $_POST['type'],
				'pad_counts'               => false 
			
			); 
			
			$categories = get_categories( $args );
			
			if(!empty($categories)){
				$return['msg'] = true;
				$return['data'][0] = 'Select';
				$return['selected'] = get_option('ap_tax_types');
				foreach($categories as $cats){
					$return['data'][$cats->cat_ID] = $cats->cat_name;
				}
			}
			
			echo json_encode($return);
			exit;
		}		                        
	}
	if(!function_exists('ap_has_term')){
	function ap_has_term($taxonomy){
			
			global $ap_current_cat;
			
			$response = false;
			$ap_tax_types = get_option('ap_tax_types');
			
			switch($taxonomy){
				
				case 'category':
					$categories = $ap_current_cat;//get_the_category();
					$current_cat = ((isset($categories[0]) && isset($categories[0]->cat_ID))?$categories[0]->cat_ID:'');					
					
					$response = is_category();
					
					if(!empty($ap_tax_types)){
						$response = in_array($current_cat, $ap_tax_types);
					}
					
					
				break;
				case 'post_tag':
					$response = is_tag();
				break;	
				default:
					$response = has_term('', $taxonomy);
				break;							
				
			}
			
			return $response;
		}
	}

	if(!function_exists('ap_go')){
	function ap_go(){
		
		
		
		$allowed_taxes = get_option('ap_tax');
		$ap_go = FALSE;
		if(!empty($allowed_taxes) && $allowed_taxes[0]!=''){
			
			foreach($allowed_taxes as $taxonomy_allowed){
				
				$ap_go = ap_has_term($taxonomy_allowed);
				if($ap_go)

				break;
			}
		}

		 if(!$ap_go && get_option('ap_all')){				
			$ap_go = TRUE; 				
		}
		
		if($ap_go){		
			global $post, $wp_query, $ap;
			
			$condition = true;
			if($ap=='' && have_posts() && !get_option('ap_single'))
			$condition = ($wp_query->post_count>1);
			
			$ap_go = (!is_single() && $condition);		
		}
		
		return $ap_go;
	}
	}
	
	if(!function_exists('ap_ready')){
	function ap_ready(){

		
			echo '<script type="text/javascript" language="javascript">
			jQuery(document).ready(function($) {
			setTimeout(function(){ 
			if(jQuery(".ap_pagination").length){
			jQuery(".ap_pagination").show();} }, 10);
			
			});
			</script>';
		
		
		
		}
	}


	
	if(!function_exists('ap_start')){
	function ap_start(){	



				
				update_option( 'ap_case', 'U');
				update_option( 'ap_layout', 'H');
				update_option( 'ap_dom', '#content' );

		}	





	}

	if(!function_exists('ap_end')){
	function ap_end(){	

				delete_option( 'ap_case');
				delete_option( 'ap_layout');
				delete_option( 'ap_dom');

		}
	}	

	


	if(!function_exists('ap_where_clause')){
		function ap_where_clause($where=''){
			
			
			
			
			global $wpdb;
			global $ap, $ap_custom, $ap_queries, $ap_query;
			
			$ap_queries++;
			
			
			
			
			if($ap_query && $ap_query!=$ap_queries)
			return $where;
			
			//pre($ap_queries);
			//$ap_query && $ap_query==$ap_queries && 

			
			if($ap=='numeric'){
				$where .= ' AND '.$wpdb->prefix.'posts.post_title NOT REGEXP \'^[[:alpha:]]\'';
			}else{
				$ap_arr = explode('-', $ap);
				$ap_arr = array_filter($ap_arr, 'strlen');
				if(count($ap_arr)>1){
					$ap_arr = range(current($ap_arr), end($ap_arr));
					$where .= ' AND (';
					$mwhere = array();
					foreach($ap_arr as $ap){
						$mwhere[] = $wpdb->prefix.'posts.post_title LIKE "'.esc_sql($ap).'%"';
					}
					$where .= implode(' OR ', $mwhere).')';
				}elseif($ap!=''){
					$where .= ' AND '.$wpdb->prefix.'posts.post_title LIKE "'.esc_sql($ap).'%"';
				}
			}
	
	
			if(function_exists('ap_disable_empty')){
				ap_disable_empty($where);
			}
						
			//pre($ap_queries);
			//echo $where.'<br /><br />';
			add_filter('posts_orderby', 'ap_search_orderby', 999);
			return $where;
	
		}
	}

	
	if(!function_exists('set_ap_query_1')){
		function set_ap_query_1(){
			global $ap_query;
			$ap_query = 1;
		}
	}	
	if(!function_exists('set_ap_query_2')){
		function set_ap_query_2(){
			global $ap_query;
			$ap_query = 2;
		}
	}	
	if(!function_exists('set_ap_query_3')){
		function set_ap_query_3(){
			global $ap_query;
			$ap_query = 3;
		}
	}	
	if(!function_exists('set_ap_query_4')){
		function set_ap_query_4(){
			global $ap_query;
			$ap_query = 4;
		}
	}	
	if(!function_exists('set_ap_query_5')){
		function set_ap_query_5(){
			global $ap_query;
			$ap_query = 5;
		}
	}	
	if(!function_exists('set_ap_query_6')){
		function set_ap_query_6(){
			global $ap_query;
			$ap_query = 6;
		}
	}						

	
	
	if(!function_exists('ap_pagination')){
		function ap_pagination($query){

			
			
			if(!is_admin()){

				global $ap_custom, $ap_implementation;
				
				if($query->is_main_query() && $ap_implementation=='auto'){
					ap_where_filter();
				} 
			}

		}
		
	}
	
	if(!function_exists('ap_where')){
		function ap_where($where){


			$where = ap_where_clause($where);
			
			return $where;

		}

	}

	if(!function_exists('ap_where_filter')){
		function ap_where_filter(){
			
			global $wpdb;
			add_filter( 'posts_where' , 'ap_where' );	
			
			pre_render_alphabets();
		}
	}

	

	
		if(!function_exists('render_alphabets')){
		function render_alphabets($settings = array()){

		global $ap_implementation;
		global $rendered;

		//if(isset($_GET['debug']))
		//pre(ap_get_queries());
		
		$default_place = get_option('ap_dom')==''?'#content':get_option('ap_dom');
		
		
		
		$alphabets_bar = alphabets_bar();
		
		
		$script = '<script type="text/javascript" language="javascript">jQuery(document).ready(function($) {
		
		// Handler for .ready() called.
		
		jQuery("'.$default_place.'").prepend(\''.$alphabets_bar.'\');
		
		
		
		});';
		
		
		
		if(get_option('ap_layout')=='V'){
		
		
		
		$script .= '
		
		setTimeout(function(){
		
		var p = jQuery("'.$default_place.'");
		
		
		
		var position = p.position();
		
		
		
		jQuery(".layout_V").css({left:position.left-26}); }, 100);';
		
		
		
		}
		
		
		
		
		
		$script .= '
		
		
		
		
		
		</script>';
		
		$style = '<style type="text/css">';
		$style = ap_numeric_sign_visibility($style);
		$style .= '</style>';


				if(!$rendered){
				
					if($ap_implementation==AP_CUSTOM){
				
						$rendered=TRUE;
				
						//echo $script;		
				
					}elseif(ap_go()){
				
						$rendered=TRUE;
				
						echo $script.$style;
				
					}
				
				}										

			}

		}

		
	if(!function_exists('ap_numeric_sign_visibility')){
	function ap_numeric_sign_visibility($style=''){
			

		$ap_numeric_sign = (get_option('ap_numeric_sign')==0?false:true);
		
		if(!$ap_numeric_sign){
			$style .= 'ul.ap_pagination li:nth-child(1){ display:none; } ';
		}			
		return $style;	
	}
	}

	if(!function_exists('ap_get_alphabets')){
		function ap_get_alphabets(){
		
			$alpha_array = range('a','z');
			
			return $alpha_array;
		
		}
	}
					
	if(!function_exists('ap_alphabets')){
		function ap_alphabets(){

			$languages_selected = get_option('ap_lang');
			
			if(empty($languages_selected))
			$languages_selected = array();
			
			require_once('languages.php');
			global $ap_langs;
			$ap_langs = is_array($ap_langs)?$ap_langs:array();
			$alphabets = array();
			
			if(empty($languages_selected) || in_array('English', $languages_selected)){
			
				//LETS START WITH AN OLD STRING
				
				

				
				$alphabets['english'] = ap_get_alphabets();		
			
			}
			
			if(!empty($languages_selected)){
			
				foreach($languages_selected as $language_selected){
				
					$language_selected = strtolower($language_selected);
					
					if(in_array($language_selected, array_keys($ap_langs)) && !isset($alphabets[$language_selected])){
					
						$alphabets[$language_selected] = $ap_langs[$language_selected];
					
					}
				}
			}			
			
			return $alphabets;

			

		}

	}
	
	if(!function_exists('pre_render_alphabets')){
		function pre_render_alphabets( $settings=array() ) {
			//render_alphabets($settings);
			add_action("wp_footer", 'render_alphabets');
		}
	}




	function ap_plugin_links($links) { 
		global $premium_link, $ap_custom;
		
		$settings_link = '<a href="options-general.php?page=alphabetc_pagination">Settings</a>';
		
		if($ap_custom){
			array_unshift($links, $settings_link); 
		}else{
			 
			$premium_link = '<a href="'.$premium_link.'" title="Go Premium" target=_blank>Go Premium</a>'; 
			array_unshift($links, $settings_link, $premium_link); 
		
		}
		
		
		return $links; 
	}
	
	function register_ap_scripts() {
		
		
		
		wp_enqueue_script(
			'ap-scripts',
			plugins_url('js/scripts.js', dirname(__FILE__)),
			array('jquery')
		);	
		
		
	
		wp_register_style('ap-pagination', plugins_url('css/style.css', dirname(__FILE__)));
		
		
		wp_enqueue_style( 'ap-pagination' );
		
	
	}
	
	function ap_pro_admin_style() {
		
		global $css_arr;
		
		wp_register_style('ap-pagination-pro', plugins_url('css/admin-style.css', dirname(__FILE__)));
		
		
		wp_enqueue_style( 'ap-pagination-pro' );
		
		$css_arr[] = '#menu-settings li.current {
					border-left: 4px #25bcf0 solid;
					border-right: 4px #fc5151 solid;
					}
					#menu-settings li.current a{
						margin-left:-4px;
					}';
	}		
	
	function ap_get_queries(){
		global $wpdb;
		
		return $wpdb->queries;
	}