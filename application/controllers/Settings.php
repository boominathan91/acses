<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('login_id')){
			$this->session->set_flashdata('msg','Please login to continue !');
			redirect('login');
		}elseif($this->session->userdata('type')!='admin'){
			$this->session->set_flashdata('msg','You dont have permission to access that page !');
		}

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


	/*Get last localization settings*/
	public function get_localization_settings_row(){		
		return $this->settings->get_localization_settings_row();
	}

	/*Localization Settings ends*/



	/*Theme settings*/

	public function theme_settings()
	{
		$data['title'] = 'Theme Settings';		
		$data['theme'] = $this->get_theme_settings_row();
		render_page('settings/theme_settings',$data);
	}

	/*Get last theme settings*/

	/*Theme settings*/

	public function edit_profile_setting()
	{   
		$user_id 	      = $this->session->userdata('login_id');
		$data['title'] = 'Edit Profile';		
		$data['profile_class'] = "";
		$data['text_chat_class'] = "hidden";
		$data['audio_class'] = "hidden";
		$data['video_class'] = "hidden";
		$data['screen_share_class'] = "hidden";
		if($this->input->post('first_name')){
			$inputs = $this->input->post();
			$record = $this->settings->update_profile($inputs);		
			if($record){
				$this->session->set_flashdata('message', 'The profile has been updated.');	
				redirect(base_url().'chat');
			}else{
				$this->session->set_flashdata('message', 'The profile update something went wrong.');	
			}
			
			
		}
		
		$records =  $this->settings->profile_details($user_id);	
		
		$data['profile']  = $profile = $records['profile'];
		$data['education_details'] = $records['education_details'];
		$data['experience_informations'] = $records['experience_informations'];

		$data['countries']  = $this->settings->countries();		
		if(!empty($profile['country'])){
			$country_id = $profile['country'];
			$states  = $this->settings->get_states_by_id($country_id);
			$data['states'] = $states;
		}

		if(!empty($profile['state'])){
			$state_id = $profile['state'];
			$cities =$this->settings->get_cities_by_id($state_id);     		
			$data['cities'] = $cities;
		}
		render_page('edit_profile',$data);
	}

	public function profile_image(){

if(isset($_POST["image"]))
{
	$data = $_POST["image"];
 

	$image_array_1 = explode(";", $data);
 

	$image_array_2 = explode(",", $image_array_1[1]); 

	$data = base64_decode($image_array_2[1]);

	$imageName = time() . '.png';
	$savepath ='uploads/'.$imageName;


	file_put_contents($savepath, $data);
	
	$array['img']= '<img src="'.base_url().$savepath.'" class="img-thumbnail" />';
	$array['name']=$imageName;
	echo json_encode($array);
	exit;

}

	}

	public function profile($value='')
	{
		$user_id 	      = $this->session->userdata('login_id');
		$data['title'] 	  = 'Profile';		
		$data['profile_class'] = "";
		$data['text_chat_class'] = "hidden";
		$data['audio_class'] = "hidden";
		$data['video_class'] = "hidden";
		$data['screen_share_class'] = "hidden";
		$records =  $this->settings->profile_details($user_id);	
		$data['profile']  = $profile = $records['profile'];
		$data['education_details'] = $records['education_details'];
		$data['experience_informations'] = $records['experience_informations'];
		render_page('profile',$data);
	}

	public function get_country_states($country_id='')
	{
		$result = $this->settings->get_states_by_id($country_id);
		$data=array();
		foreach($result as $r){
			$data['value']=$r['state_id'];
			$data['label']=$r['statename'];
			$json[]=$data;
		}
		echo  json($json);	
		die();
	}
	
	public function get_state_cities($state_id){

		$result=$this->settings->get_cities_by_id($state_id);     		
		$data=array();
		foreach($result as $r){
			$data['value']=$r['city_id'];
			$data['label']=$r['city'];
			$json[]=$data;
		}
		echo  json($json);
		die();
	}

	/*Get last theme settings*/
	public function get_theme_settings_row(){		
		return $this->settings->get_theme_settings_row();
	}

	public function insert_theme_settings($data=null,$field_name=null){
		if($data == null){
			$data = array('website_name' => $_POST['website_name']);
			$field_name = 'website_name';
		}

		$result_data = $this->get_theme_settings_row(); /* Checking old Company settings */
		if(count($result_data) == 0){  /*Insert New Settings */
			$result = $this->settings->insert_theme_settings($data);		
		}else{ /*Update  New Settings */
			$where = array('theme_id' => $result_data->theme_id);
			$result = $this->settings->update_theme_settings($data,$where);		
		}
		$this->settings->get_default_theme_data();
		echo json(array('file_name' => $data[$field_name] ,'field_name' => $field_name));
	}

	public function upload_image(){					
		$data = array_keys($_FILES);
		$field_name = $data[0];			
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';				
		$this->load->library('upload', $config);
		$this->upload->do_upload($field_name);
		$file = $this->upload->data();
		$result = array($data[0] => $file['file_name']);
		$this->insert_theme_settings($result,$data[0]);
	}

	/*Theme settings ends */	

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
	public function insert_department_settings(){
		$data = array('department_name' => trim($_POST['department_name']));
		$result_data = $this->check_department_settings_by_id(); /* Checking old department settings */
		
		if(count($result_data) == 0){

			if(empty($_POST['department_id'])){  /*Insert New Settings */
				$result = $this->settings->insert_department_settings($data);		
			}else{ /*Update  New Settings */
				$where = array('department_id' => $_POST['department_id']);
				$result = $this->settings->update_department_settings($data,$where);		
			}
			$response = array('department_id' => $result);
		}else{
			$response = array('error' =>'Department name already exist!');
		}
		

		echo json($response);
	}
	public function delete_department(){
		echo  $this->settings->delete_department();
	}

	

	/*Check department settings*/
	public function check_department_settings_by_id(){		

		return $this->settings->check_department_settings_by_id();
	}
	/*get department settings*/
	public function get_department_settings_by_id(){		

		echo $this->settings->get_department_settings_by_id();
	}
	public function get_all_departments(){		

		$list = $this->settings->get_all_departments();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $g) {
			$row = array(); 
			$row[] = $i++;  
			$row[] = $g->department_name;  
			$row[] = '<div class="dropdown">
			<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
			<ul class="dropdown-menu pull-right">
			<li><a href="#"  data-toggle="modal" data-target="#add_department" title="Edit" onclick="show_modal('.$g->department_id.')"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
			<li><a href="#"   data-toggle="modal" data-target="#delete_department"  title="Delete" onclick="show_delete_modal('.$g->department_id.')"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
			</ul>
			</div>';  
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->settings->count_all(),
			"recordsFiltered" => $this->settings->count_filtered(),
			"data" => $data,
		);
                //output to json format
		echo json_encode($output);
	}	

	public function designation()
	{
		$data['title'] = 'Designation Settings';
		$data['department'] = $this->settings->get_departments();		
		render_page('settings/designation',$data);
	}
	public function insert_designation_settings(){
	$data = array(
			'status' => 1 ,
			'department_id' => $_POST['department_id'],
			'designation_name' => $_POST['designation_name']
		);
		$result_data = $this->check_designation_settings_by_id($data); /* Checking old designation settings */
		
		if(count($result_data) == 0){

			if(empty($_POST['designation_id'])){  /*Insert New Settings */
				$result = $this->settings->insert_designation_settings($data);		
			}else{ /*Update  New Settings */
				$where = array('designation_id' => $_POST['designation_id']);
				$result = $this->settings->update_designation_settings($data,$where);		
			}
			$response = array('designation_id' => $result);
		}else{
			$response = array('error' =>'Designation name already exist in this deparment!');
		}		

		echo json($response);
	}
	public function check_designation_settings_by_id($data){
		return $this->settings->check_designation_settings_by_id($data);
	}
	
	public function get_all_designations(){		

		$list = $this->settings->get_all_designations();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $g) {
			$row = array(); 
			$row[] = $i++;  
			$row[] = $g->designation_name;  
			$row[] = $g->department_name;  
			$row[] = '<div class="dropdown">
			<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
			<ul class="dropdown-menu pull-right">
			<li><a href="#"  data-toggle="modal" data-target="#add_designation" title="Edit" onclick="show_modal('.$g->designation_id.')"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
			<li><a href="#"   data-toggle="modal" data-target="#delete_designation"  title="Delete" onclick="show_delete_modal('.$g->designation_id.')"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
			</ul>
			</div>';  
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->settings->count_all_design(),
			"recordsFiltered" => $this->settings->count_filtered_design(),
			"data" => $data,
		);
                //output to json format
		echo json_encode($output);
	}	

	/*get designation settings*/
	public function get_designation_settings_by_id(){		

		$result = $this->settings->get_designation_settings_by_id();
		echo json($result);
	}

	public function delete_designation(){
		echo  $this->settings->delete_designation();
	}
	
	/*Gettings designation details */
	public function get_designation_by_id(){
		$result = $this->settings->get_designation_by_id();
		$data=array();
		foreach($result as $r){
			$data['value']=$r['designation_id'];
			$data['label']=$r['designation_name'];
			$json[]=$data;
		}
		echo json($json);
	}

	public function check_old_pwd(){
		$result = $this->settings->check_old_pwd();
		echo json(array('match'=>$result));
	}
	public function update_password(){
		echo $this->settings->update_password();
	}

}

/* End of file Settings.php */
/* Location: ./application/controllers/Settings.php */