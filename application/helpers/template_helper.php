<?php 

if(!function_exists('render_login')){
	/* Rendering Login Page */
	function render_login($page,$data=null){
		$CI = &get_instance();
		$CI->load->view('login/includes/header');
		$CI->load->view('login/'.$page,$data);
		$CI->load->view('login/includes/footer');

	}
}
if(!function_exists('render_page')){
	/* Rendering Login Page */
	function render_page($page,$data=null){
		$CI = &get_instance();
		$CI->load->view('includes/header',$data);		
		$CI->load->view($page);
		$CI->load->view('includes/footer');

	}
}

?>