<?php



	

	//FOR QUICK DEBUGGING





	if(!function_exists('pre')){
	function pre($data){



			echo '<pre>';



			print_r($data);



			echo '</pre>';	



		}	 



	}


	if(!function_exists('ap_has_term')){
	function ap_has_term($taxonomy){
			
			$response = false;
			
			switch($taxonomy){
				
				case 'category':
					$response = is_category();
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

	





	

	if(!function_exists('ap_pagination')){
	function ap_pagination(){

			global $wpdb;

			

			if(!is_admin() && is_main_query())// && $wpdb->num_rows>0){

				if(!function_exists('ap_where')){
	function ap_where($where){

						global $wpdb;

						$where .= ' AND '.$wpdb->prefix.'posts.post_title LIKE "'.mysql_real_escape_string($_GET['ap']).'%"';

						return $where;

					}

				}

			

					

				add_filter( 'posts_where' , 'ap_where' );	

				

				if(!function_exists('render_alphabets')){
	function render_alphabets(){

							$default_place = get_option('ap_dom')==''?'#content':get_option('ap_dom');

							 

							$alphabets = ap_alphabets();

							

							$alphabets_bar = '<ul class="ap_pagination case_'.get_option('ap_case').' layout_'.get_option('ap_layout').'">';

							

							foreach($alphabets as $alphabet){

								$alphabets_bar .= '<li>';

								$alphabets_bar .= '<a href="'.add_query_arg( array('ap' => $alphabet), $_SERVER["REQUEST_URI"]).'" class="'.(strtolower($_GET['ap'])==$alphabet?'selected':'').'">'.$alphabet.'</a>';

								$alphabets_bar .= '</li>';

							}

							

							$alphabets_bar .= '</ul>';

							

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

							

							
							if(ap_go())
							echo $script;

					}

				}

				

				

				add_action("wp_footer", 'render_alphabets');

				

			}

		}



	

	

	if(!function_exists('ap_alphabets')){
	function ap_alphabets(){

			//LETS START WITH AN OLD STRING

			

			$str = "quick brown fox jumps over the lazy dog";

			

			$alpha_array = array_unique(str_split(str_replace(' ', '', $str)));

			asort($alpha_array);

			

			$alphabets = array_values($alpha_array);

			

			return $alphabets;

			

		}

	}

?>