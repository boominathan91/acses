<?php 

if(!function_exists('render_login')){
	/* Rendering Login Page */
	function render_login($page,$data=null){
		$CI = &get_instance();
		$CI->load->view('login/includes/header',$data);
		$CI->load->view('login/'.$page);
		$CI->load->view('login/includes/footer');

	}
}
if(!function_exists('render_page')){
	/* Rendering Login Page */
	function render_page($page,$data=null){
		$CI = &get_instance();
		if($CI->session->userdata('type') == 'admin'){
			$CI->load->view('admin/includes/header',$data);		
			$CI->load->view('admin/'.$page);
			$CI->load->view('admin/includes/footer');	
		}else{
			$CI->load->view('user/includes/header',$data);		
			$CI->load->view('user/'.$page);
			$CI->load->view('user/includes/footer');	
		}
		

	}
}

if(!function_exists('lang')){
	/*  Language  */
	function lang($data=null){
		$CI = &get_instance();		
		$result='';
		$default_lang = $CI->session->userdata('default_lang');
		if(!$CI->session->userdata('label_data')){

			//if(empty($default_lang)){ /*Default language is empty */
			$where = array('l.lang_id'=>1);
			// }else{
			// 	$where = array('l.status'=>1,'l.lang_id'=>$default_lang); /*Default Language selected*/
			// }			
			$output = $CI->db
			->select('l.lang,l.lang_id,lb.label_key,lb.label_value')
			->join('label_details lb','lb.lang_id = l.lang_id')
			->get_where('lang_details l',$where)
			->result_array();
			$CI->session->set_userdata(array('label_data'=>$output,'default_lang'=>'English'));


			$datas = $CI->session->userdata('label_data');
			foreach ( $datas as $key => $val) {
				if ($val['label_key'] === $data) {
					$result =  $datas[$key]['label_value'];				
				}
			}

		}else{
			$datas = $CI->session->userdata('label_data');
			foreach ( $datas as $key => $val) {
				if ($val['label_key'] === $data) {
					$result =  $datas[$key]['label_value'];				
				}
			}
			
		}




		echo  (!empty($result))?$result:'';			
	}
}



if(!function_exists('convert_datetime')){	/*  Covert Date time Format for call details   */

	function convert_datetime($date=null) {	
		 $date = substr($date, 0, strpos($date, '('));
		$date = new DateTime($date, new DateTimeZone('IST'));
		return   $date->format('Y-m-d H:i:s');
	}
}



if(!function_exists('lang_new')){
	/*  Language  */
	function lang_new($data=null){
		$CI = &get_instance();		
		$result='';
		$default_lang = $CI->session->userdata('default_lang');
		if(!$CI->session->userdata('label_data')){

			//if(empty($default_lang)){ /*Default language is empty */
			$where = array('l.lang_id'=>1);
			// }else{
			// 	$where = array('l.status'=>1,'l.lang_id'=>$default_lang); /*Default Language selected*/
			// }			
			$output = $CI->db
			->select('l.lang,l.lang_id,lb.label_key,lb.label_value')
			->join('label_details lb','lb.lang_id = l.lang_id')
			->get_where('lang_details l',$where)
			->result_array();
			$CI->session->set_userdata(array('label_data'=>$output,'default_lang'=>'English'));


			$datas = $CI->session->userdata('label_data');
			foreach ( $datas as $key => $val) {
				if ($val['label_key'] === $data) {
					$result =  $datas[$key]['label_value'];				
				}
			}

		}else{
			$datas = $CI->session->userdata('label_data');
			foreach ( $datas as $key => $val) {
				if ($val['label_key'] === $data) {
					$result =  $datas[$key]['label_value'];				
				}
			}
			
		}




		return   (!empty($result))?$result:'';			
	}
}

?>