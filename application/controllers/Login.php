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
	{	if($this->session->userdata('login_id') && $this->session->userdata('type') == 'admin'){
			redirect('employees');
		}
		$data['title'] = 'Login';
		render_login('login',$data);		
	}
	public function check_login(){

		echo  $this->login->check_login();
	}
	/*Forgot Password   Page */
	public function forgot_password()
	{
		$data['title'] = 'Forgot Password';
		render_login('forgot_password',$data);		
	}
	public function logout(){
		$data = array('login_id','user_name','email','label_data','type');
		$this->session->unset_userdata($data);
		redirect('login');
	}
	
	
	

	
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */

