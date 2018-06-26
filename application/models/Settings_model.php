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
		return insert('company_details',$data);					
	}
	public function update_company_settings($data,$where){		
		$this->db->update('company_details',$data,$where);		
		return $where['company_id'];			
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




}

/* End of file  */
/* Location: ./application/models/ */