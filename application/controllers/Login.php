<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
		
	/*Login  Page */
	public function index()
	{				
		render_login('login');		
	}
	/*Forgot Password   Page */
	public function forgot_password()
	{				
		render_login('forgot_password');		
	}
	
	/*Gettings Default Language Data*/
	Public function get_default_language_data(){

		/*Login Page */
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
	}
	

	
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */

