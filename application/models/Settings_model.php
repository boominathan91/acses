<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model {

	public $variable;

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
	public function get_company_settings_row(){
		$where = array('status' => 1 );
		return $this->db->order_by('company_id','desc')->get_where('company_details',$where)->row();
	}	
}

/* End of file  */
/* Location: ./application/models/ */