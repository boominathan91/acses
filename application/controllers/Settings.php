<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function company_settings()
	{
		$data['title'] = 'Company Settings';		
		render_page('company_settings',$data);
	}
	public function localization_settings()
	{
		$data['title'] = 'Localization';		
		render_page('localization',$data);
	}
	public function theme_settings()
	{
		$data['title'] = 'Theme Settings';		
		render_page('theme_settings',$data);
	}
	public function change_password()
	{
		$data['title'] = 'Change Password';		
		render_page('change_password',$data);
	}
	public function department()
	{
		$data['title'] = 'Department Settings';		
		render_page('department',$data);
	}
	public function designation()
	{
		$data['title'] = 'Designation Settings';		
		render_page('designation',$data);
	}

}

/* End of file Settings.php */
/* Location: ./application/controllers/Settings.php */