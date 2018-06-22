<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('settings_model','settings');
	}
	/*Company Settings */
	public function company_settings()
	{
		$data['title'] = 'Company Settings';	
		render_page('settings/company_settings',$data);
	}

	public function insert_company_settings(){	

		$data = array(
			'company_name' => $_POST['company_name'],
			'contact_person' => $_POST['contact_person'],
			'address' => $_POST['address'],
			'country_id' => $_POST['country_id'],
			'state_id' => $_POST['state_id'],
			'city_id' => $_POST['city_id'],
			'postal_code' => $_POST['postal_code'],
			'email' => $_POST['email'],
			'phone_number' => $_POST['phone_number'],
			'mobile_number' => $_POST['mobile_number'],
			'fax' => $_POST['fax'],
			'website_url' => $_POST['website_url']
		);
		$result_data = $this->get_company_settings_row(); /* Checking old Company settings */
		if(count($result_data) == 0){  /*Insert New Settings */
			$result = $this->settings->insert_company_settings($data);		
		}else{ /*Update  New Settings */
			$where = array('company_id' => $result_data->company_id);
			$result = $this->settings->update_company_settings($data,$where);		
		}
		echo json(array('company_id'=>$result));
		
	}

	public function get_company_settings(){
		$data = $this->get_company_settings_row();
		$result = array();
		$result['country']	 = $this->get_all_countries();

		if(!empty($data)){
			$result['company_name'] = $data->company_name;
			$result['contact_person'] = $data->contact_person;
			$result['address'] = $data->address;
			$result['country_id'] = $data->country_id;
			$result['state_id'] = $data->state_id;
			$result['city_id'] = $data->city_id;
			$result['postal_code'] = $data->postal_code;
			$result['email'] = $data->email;
			$result['phone_number'] = $data->phone_number;
			$result['mobile_number'] = $data->mobile_number;
			$result['fax'] = $data->fax;
			$result['website_url'] = $data->website_url;
			
			if(!empty($data->country_id)){ /*gettings states for the selected country */
				$result['state'] = $this->get_states_by_id($data->country_id);	
			}
			if(!empty($data->state_id)){ /*gettings cities  for the selected state */
				$result['city'] = $this->get_cities_by_id($data->state_id);	
			}
		}
		echo json($result);
	}


	/*Get last company settings*/
	public function get_company_settings_row(){		
		return $this->settings->get_company_settings_row();
	}

	/*Gettings country details */
	public function get_countries(){
		$result = $this->settings->get_countries();
		foreach($result as $r){
			$data['value']=$r['country_id'];
			$data['label']=$r['country'];
			$json[]=$data;			
		}
		echo json($json);
	}

	/*Gettings all  country details */
	public function get_all_countries(){
		$result = $this->settings->get_countries();
		foreach($result as $r){
			$data['value']=$r['country_id'];
			$data['label']=$r['country'];
			$json[]=$data;			
		}
		return  json($json);
	}
	/*Gettings state details */
	public function get_states_by_id($country_id){
		$result = $this->settings->get_states_by_id($country_id);
		$data=array();
		foreach($result as $r){
			$data['value']=$r['state_id'];
			$data['label']=$r['statename'];
			$json[]=$data;
		}
		return  json($json);
	}
	/*Gettings city details */

	Public function get_cities_by_id($state_id){
		$result=$this->settings->get_cities_by_id($state_id);     		
		$data=array();
		foreach($result as $r){
			$data['value']=$r['city_id'];
			$data['label']=$r['city'];
			$json[]=$data;
		}
		return  json($json);
	}

	/*Gettings state details */
	public function get_states(){
		$result = $this->settings->get_states();
		$data=array();
		foreach($result as $r){
			$data['value']=$r['state_id'];
			$data['label']=$r['statename'];
			$json[]=$data;
		}
		echo json($json);
	}
	/*Gettings city details */

	Public function get_cities(){
		$result=$this->settings->get_cities();     		
		$data=array();
		foreach($result as $r){
			$data['value']=$r['city_id'];
			$data['label']=$r['city'];
			$json[]=$data;
		}
		echo json($json);
	}

	/*Company Settings ends  */

	/*Localization Settings */
	public function localization_settings()
	{
		$data['title'] = 'Localization';		
		render_page('settings/localization',$data);
	}
	public function insert_localization_settings(){
		$data = array(
			'country_id' => $_POST['country_id'],
			'date_format' => $_POST['date_format'],
			'time_zone' => $_POST['time_zone'],
			'default_language' => $_POST['default_language']
		);
		$result_data = $this->get_localization_settings_row(); /* Checking old Company settings */
		if(count($result_data) == 0){  /*Insert New Settings */
			$result = $this->settings->insert_localization_settings($data);		
		}else{ /*Update  New Settings */
			$where = array('local_id' => $result_data->local_id);
			$result = $this->settings->update_localization_settings($data,$where);		
		}
		echo json(array('local_id'=>$result));
	}

	public function get_localization_settings(){
		$data = $this->get_localization_settings_row();
		$result = array();
		$result['country']	 = $this->get_all_countries();
		if(!empty($data)){
			$result['country_id'] = $data->country_id;
			$result['date_format'] = $data->date_format;
			$result['time_zone'] = $data->time_zone;
			$result['default_language'] = $data->default_language;		
		}
		echo json($result);
	}


	/*Get last company settings*/
	public function get_localization_settings_row(){		
		return $this->settings->get_localization_settings_row();
	}

	/*Localization Settings ends*/





	public function theme_settings()
	{
		$data['title'] = 'Theme Settings';		
		render_page('settings/theme_settings',$data);
	}
	public function change_password()
	{
		$data['title'] = 'Change Password';		
		render_page('settings/change_password',$data);
	}
	public function department()
	{
		$data['title'] = 'Department Settings';		
		render_page('settings/department',$data);
	}
	public function designation()
	{
		$data['title'] = 'Designation Settings';		
		render_page('settings/designation',$data);
	}


}

/* End of file Settings.php */
/* Location: ./application/controllers/Settings.php */