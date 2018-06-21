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

if(!function_exists('lang')){
	/*  Language  */
	function lang($data=null){
		$CI = &get_instance();

		/* Hiddable  */ 

		$default_lang = $CI->session->userdata('default_lang');	

		if(empty($default_lang)){ /*Default language is empty */
			$where = array('l.lang_id'=>1);
		}else{
			$where = array('l.status'=>1,'l.lang_id'=>$default_lang); /*Default Language selected*/
		}	

		$output = $CI->db
		->select('l.lang,l.lang_id,lb.label_key,lb.label_value')
		->join('label_details lb','lb.lang_id = l.lang_id')
		->get_where('lang_details l',$where)
		->result_array();
		$CI->session->set_userdata(array('session_data'=>$output));	

		/* Hiddable  ends */

		$datas = $CI->session->userdata('session_data');
		foreach ( $datas as $key => $val) {
			if ($val['label_key'] === $data) {
				$result =  $datas[$key]['label_value'];				
			}
		}		 
		echo  (!empty($result))?$result:'';			
	}
}


?>