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
	

	
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */

