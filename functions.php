<?php



	

	//FOR QUICK DEBUGGING

	



	if(!function_exists('pre')){
	function pre($data){



			echo '<pre>';



			print_r($data);



			echo '</pre>';	



		}	 



	}


	if(!function_exists('alphabets_bar')){
                    function alphabets_bar(){                                			
                                            global $ap;
                                            $alphabets = ap_alphabets();
                                            
                                            $alphabetz_bar = '';

                                            foreach($alphabets as $language=>$alphabetz){
                                            
                                            $alphabetz_bar .= '<ul class="ap_'.$language.' ap_pagination case_'.get_option('ap_case').' layout_'.get_option('ap_layout').' '.get_option('ap_style').'">';
											
$alphabetz_bar .= '<li>';
                                                    $alphabetz_bar .= '<a href="'.$_SERVER["REQUEST_URI"].'">#</a>';

                                                    $alphabetz_bar .= '</li>';
																								

                                            foreach($alphabetz as $alphabet){

                                                    $alphabetz_bar .= '<li>';
                                                    $alphabetz_bar .= '<a href="'.add_query_arg( array('ap' => $alphabet), $_SERVER["REQUEST_URI"]).'" class="'.(strtolower($ap)==$alphabet?'selected':'').'">'.$alphabet.'</a>';

                                                    $alphabetz_bar .= '</li>';
                                                    }

                                                    $alphabetz_bar .= '</ul>';
                                            }
                                            
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
			
			$response = false;
			$ap_tax_types = get_option('ap_tax_types');
			
			switch($taxonomy){
				
				case 'category':
					$categories = get_the_category();
					$current_cat = $categories[0]->cat_ID;					
					
					$response = is_category();
					
					if(!empty($ap_tax_types)){
						$response = !in_array($current_cat, $ap_tax_types);
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
		
		if(get_option('ap_all')){
			$ap_go = TRUE; 
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
			global $ap;

			$where .= ' AND '.$wpdb->prefix.'posts.post_title LIKE "'.mysql_real_escape_string($ap).'%"';
			
			return $where;
	
		}
	}

	if(!function_exists('ap_pagination')){
	function ap_pagination(){


			if(!is_admin() && WP_Query::is_main_query())

				if(!function_exists('ap_where')){
					function ap_where($where){

						$where = ap_where_clause($where);
						
						return $where;

					}

				}


				add_filter( 'posts_where' , 'ap_where' );	
				
				
				pre_render_alphabets();
			}

		}



	

	
		if(!function_exists('render_alphabets')){
function render_alphabets($settings = array()){

		global $ap_implementation;
		global $rendered;

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
		


				if(!$rendered){
				
					if($ap_implementation==AP_CUSTOM){
				
						$rendered=TRUE;
				
						echo $script;		
				
					}elseif(ap_go()){
				
						$rendered=TRUE;
				
						echo $script;
				
					}
				
				}										

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
			
			
			$str = "quick brown fox jumps over the lazy dog";

			$alpha_array = array_unique(str_split(str_replace(' ', '', $str)));

			asort($alpha_array);
			
			$alphabets['english'] = array_values($alpha_array);			
			
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

	if(!function_exists('ap_pagination_halt')){
		function ap_pagination_halt( $settings ) {
			
			pre_render_alphabets($settings);
			
		}
	}

	
	if(!function_exists('ap_pagination_custom')){
		function ap_pagination_custom( $atts ) {
			
			
			$settings = array(
				''=>''
			);
			ap_pagination_halt($settings);
			//WILL RENDER AFTER SOME SETTINGS WITH SHORTCODE
			add_action('wp_footer', 'ap_ready');
		}
	}
	

?>