<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('login_id')){
			$this->session->set_flashdata('msg','Please login to continue !');
			redirect('login');
		}
	}

	public function index()
	{	
		
		$data['title'] = 'Employees';
		render_page('employees',$data);
	}

}

/* End of file Employees.php */
/* Location: ./application/controllers/Employees.php */
