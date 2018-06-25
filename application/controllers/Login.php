<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->model('login_model','login');		
	}

	/*Login  Page */
	public function index()
	{	if($this->session->userdata('login_id')){
			redirect('employees');
		}
		render_login('login');		
	}
	public function check_login(){

		echo  $this->login->check_login();
	}
	/*Forgot Password   Page */
	public function forgot_password()
	{				
		render_login('forgot_password');		
	}
	public function logout(){
		$data = array('login_id','user_name','email','session_data');
		$this->session->unset_userdata($data);
		redirect('login');
	}
	
	
	

	
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */

