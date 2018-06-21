<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Employees';
		render_page('employees',$data);
	}

}

/* End of file Employees.php */
/* Location: ./application/controllers/Employees.php */
