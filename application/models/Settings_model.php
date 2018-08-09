<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model {


	public function __construct()
	{
		parent::__construct();		
	}
	public function get_countries(){		
		return get_all('country_details');
	}
	public function get_states(){				
		$where =array('country_id' => $_POST['country_id']);
		return get_where('state_details',$where);
	}
	public function get_cities(){				
		$where =array('state_id' => $_POST['state_id']);
		return get_where('city_details',$where);
	}
	public function get_states_by_id($country_id){				
		$where =array('country_id' => $country_id);
		return get_where('state_details',$where);
	}
	public function get_cities_by_id($state_id){				
		$where =array('state_id' => $state_id);
		return get_where('city_details',$where);
	}
	public function insert_company_settings($data){		
		insert('company_details',$data);		
		$this->get_default_company_data();
		return true;			
	}
	public function update_company_settings($data,$where){		
		$this->db->update('company_details',$data,$where);
		$this->get_default_company_data();		
		return $where['company_id'];			
	}
	/*Gettings Default Company Data*/
	Public function get_default_company_data(){

		$where = array('status'=>1);
		$output = $this->db->get_where('company_details',$where)->row_array();
		$this->session->set_userdata($output);	
	}
	public function insert_localization_settings($data){		
		return insert('localization_details',$data);					
	}
	public function update_localization_settings($data,$where){		
		$this->db->update('localization_details',$data,$where);		
		return $where['local_id'];			
	}
	public function get_company_settings_row(){
		$where = array('status' => 1 );
		return $this->db->order_by('company_id','desc')->get_where('company_details',$where)->row();
	}	
	public function get_localization_settings_row(){
		$where = array('status' => 1 );
		return $this->db->order_by('local_id','desc')->get_where('localization_details',$where)->row();
	}	
	public function get_theme_settings_row(){
		$where = array('status' => 1 );
		return $this->db->order_by('theme_id','desc')->get_where('theme_details',$where)->row();
	}	
	public function insert_theme_settings($data){		
		return insert('theme_details',$data);					
	}
	public function update_theme_settings($data,$where){		
		$this->db->update('theme_details',$data,$where);		
		return $where['theme_id'];			
	}

	/*Gettings Default Theme Data*/
	Public function get_default_theme_data(){

		$where = array('status'=>1);
		$output = $this->db->get_where('theme_details',$where)->row_array();
		$this->session->set_userdata($output);	
	}

	
	public function check_department_settings_by_id(){
		$where = array('status' => 1 ,'department_name' => $_POST['department_name']);
		if(!empty($_POST['department_id'])){
			$where +=array('department_id !=' => $_POST['department_id']);
		}
		return $this->db->get_where('department_details',$where)->row();
	}
	
	public function get_department_settings_by_id(){

		$where =array('department_id' => $_POST['department_id']);	
		return $this->db->get_where('department_details',$where)->row()->department_name;
	}

	public function insert_department_settings($data){		
		return insert('department_details',$data);					
	}
	public function update_department_settings($data,$where){		
		$this->db->update('department_details',$data,$where);		
		return $where['department_id'];			
	}

	private function _get_datatables_query()
	{
		$columns = array('department_id','department_name');
		$search_value = trim($_POST['search']['value']);
		$sql ="SELECT * FROM department_details  WHERE status = 1  ";
		if($_POST['search']['value']){ 
			$sql .=" AND (	department_name LIKE '%$search_value%' ) ";		
		} 				
		if(isset($_POST['order'])) {			
			$orde = $columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'];
			$sql .=" ORDER BY $orde";
		}else if(isset($this->orders)){
			$orders = $this->orders;	
			$orde = key($orders).' '.$orders[key($orders)];	
			$sql .=" ORDER BY $orde";
		}
		return $sql;
	}
	public function get_all_departments()
	{
		$sql = $this->_get_datatables_query();			
		if($_POST['length'] != -1)
			$limits = $_POST['start'].','.$_POST['length'];
		$sql .=" LIMIT $limits"; 		
		return $this->db->query($sql)->result();	
	}	
	public function count_filtered()
	{
		$sql = $this->_get_datatables_query();	
		return $this->db->query($sql)->num_rows();		
	}
	public function count_all()
	{
		$sql = $this->_get_datatables_query();			
		return $this->db->query($sql)->num_rows();
	}

	public function delete_department(){
		$where = array('department_id'=> $_POST['department_id']);
		$data = array('status' => 0);
		return $this->db->update('department_details',$data,$where);
	}
	public function get_departments(){
		$where = array('status' => 1);
		return $this->db->order_by('department_name','asc')->get_where('department_details',$where)->result();
	}
	public function get_designation_by_id(){
		$where = array('status' => 1,'department_id'=>$_POST['department_id']);
		return $this->db->order_by('designation_name','asc')->get_where('designation_details',$where)->result_array();
	}



	public function check_designation_settings_by_id($where){
		

		if(!empty($_POST['designation_id'])){
			$where +=array('designation_id !=' => $_POST['designation_id']);
		}
		return $this->db->get_where('designation_details',$where)->row();
	}

	public function insert_designation_settings($data){		
		return insert('designation_details',$data);					
	}
	public function update_designation_settings($data,$where){		
		$this->db->update('designation_details',$data,$where);		
		return $where['designation_id'];			
	}
	
	private function _get_datatables()
	{
		$columns = array('ds.designation_id','ds.designation_name','dp.department_name');
		$search_value = trim($_POST['search']['value']);
		$sql ="SELECT ds.designation_id,ds.designation_name,dp.department_name FROM designation_details as ds 
		JOIN department_details as dp ON dp.department_id = ds.department_id
		WHERE ds.status = 1 ";
		
		if($_POST['search']['value']){ 
			$sql .=" AND (	ds.designation_name LIKE '%$search_value%' OR dp.department_name LIKE '%$search_value%' ) ";	
		} 				

		if(isset($_POST['order'])) {			
			$orde = $columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'];
			$sql .=" ORDER BY $orde";
		}else if(isset($this->orders)){
			$orders = $this->orders;	
			$orde = key($orders).' '.$orders[key($orders)];	
			$sql .=" ORDER BY $orde";
		}
		return $sql;
	}
	public function get_all_designations()
	{
		$sql = $this->_get_datatables();			
		if($_POST['length'] != -1)
			$limits = $_POST['start'].','.$_POST['length'];
		$sql .=" LIMIT $limits"; 		
		return $this->db->query($sql)->result();	
	}	
	public function count_all_design()
	{
		$sql = $this->_get_datatables();	
		return $this->db->query($sql)->num_rows();		
	}
	public function count_filtered_design()
	{
		$sql = $this->_get_datatables();			
		return $this->db->query($sql)->num_rows();
	}
	public function get_designation_settings_by_id(){

		$where =array('designation_id' => $_POST['designation_id']);	
		return $this->db->get_where('designation_details',$where)->row();
	}
	public function delete_designation(){
		$where = array('designation_id'=> $_POST['designation_id']);
		$data = array('status' => 0);
		return $this->db->update('designation_details',$data,$where);
	}
	public function update_password(){
		$where = array('login_id' => $this->session->userdata('login_id'));
			$data = array('password'=> md5($_POST['password']));
		return $this->db->update('login_details',$data,$where);
	}
	public function check_old_pwd(){
		$where = array('login_id'=>$this->session->userdata('login_id'),'password' => md5($_POST['password']));
		return $this->db->get_where('login_details',$where)->num_rows();
	}
	/*Sivamani Profile Setting 07/17/2018 Start */

	public function profile_details($user_id='')
	{

		if(!empty($user_id)){
			
			$where = array('login_id'=>$user_id);
			$where1 = array('user_id'=>$user_id);

			$data = array('call_status'=>0)
;			$this->db->update('login_details',$data,$where);

			$this->db->select('LD.*,CD.city as cityname,SD.statename as statename,CUD.country as countryname');
			$this->db->from('login_details LD');
			$this->db->join('city_details CD', 'CD.city_id = LD.city', 'left');
			$this->db->join('state_details SD', 'SD.state_id = LD.state', 'left');
			$this->db->join('country_details CUD', 'CUD.country_id = LD.country', 'left');
			$this->db->where($where);
			$profile = $this->db->get()->row_array();
			$records['profile'] = $profile; 
			$records['education_details'] =  get_where('profile_education_details',$where1);		
			$records['experience_informations'] =  get_where('profile_experience_informations',$where1);		
			return $records;
		}
	}

	public function countries()
	{
		return get_all('country_details');		
	}

	public function update_profile($inputs)
	{
		$session  = $this->session->userdata();
		$login_id = $session['login_id'];

		 
		$user_details['first_name'] = $inputs['first_name'];
		$user_details['last_name'] = $inputs['last_name'];
		$user_details['profile_img'] = $inputs['profile_img'];

		$user_details['dob'] = date('Y-m-d',strtotime(str_replace('/', '-',$inputs['dob'])));
		$user_details['gender'] = $inputs['gender'];
		$user_details['country'] = $inputs['country'];
		$user_details['state'] = $inputs['state'];
		$user_details['phone_number'] = $inputs['phone_number'];
		$user_details['pincode'] = $inputs['pincode'];
		$user_details['city'] = $inputs['city'];
		$user_details['address'] = $inputs['address'];

		$this->db->where('login_id', $login_id);
		$this->db->update('login_details', $user_details);
		 
		$institution	= array_filter($inputs['institution']);
		$subject		= array_filter($inputs['subject']);
		$start_year		= array_filter($inputs['start_year']);
		$complete_year	= array_filter($inputs['complete_year']);
		$degree		    = array_filter($inputs['degree']);
		$grade		    = array_filter($inputs['grade']);
		for ($l=0; $l <count($institution) ; $l++) { 
			$education_new[$l]['institution'] = $institution[$l];	
			$education_new[$l]['subject'] = $subject[$l];	
			$education_new[$l]['start_year']=  $start_year[$l];		
			$education_new[$l]['complete_year']=  $complete_year[$l];		
			$education_new[$l]['degree']=  $degree[$l];		
			$education_new[$l]['grade']= $grade[$l];	
			$education_new[$l]['user_id']= $login_id;	
		}
		if(!empty($education_new)){
			$this->db->where('user_id', $login_id);
			$this->db->delete('profile_education_details');
			$this->db->insert_batch('profile_education_details', $education_new);
		}
		
		$experience_new = array();
		$company = array_filter($inputs['company']);
		$location = array_filter($inputs['location']);
		$jop_position = array_filter($inputs['jop_position']);
		$period_from = array_filter($inputs['period_from']);
		$period_to = array_filter($inputs['period_to']);
		for ($i=0; $i < count($company); $i++) { 
			$experience_new[$i]['company'] = $company[$i];
			$experience_new[$i]['location'] = $location[$i];
			$experience_new[$i]['jop_position'] = $jop_position[$i];
			$experience_new[$i]['period_from'] = $period_from[$i];
			$experience_new[$i]['period_to'] = $period_to[$i];
			$experience_new[$i]['user_id']= $login_id;	
		}
		
		if(!empty($experience_new)){
			$this->db->where('user_id', $login_id);
			$this->db->delete('profile_experience_informations');
			$this->db->insert_batch('profile_experience_informations', $experience_new);	
		}
		return TRUE;
	}

	/*Sivamani Profile Setting 07/17/2018 End */



}

/* End of file  */
/* Location: ./application/models/ */