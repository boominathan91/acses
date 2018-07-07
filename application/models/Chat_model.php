<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat_model extends CI_Model {	

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_users_by_name(){
		$login_id = $this->session->userdata('login_id');
		$where = array('login_id !='=>$login_id,'l.status'=>1,'l.type'=>'user');
	return $this->db
			->select('l.login_id,l.sinch_username,l.first_name,l.last_name,d.department_name')
			->like('l.first_name',$_POST['user_name'])
			// ->or_like('l.last_name',$_POST['user_name'])
			->join('department_details d','d.department_id = l.department_id')
			->limit(10)
			->get_where('login_details l',$where)
			->result_array();
	}
	public function get_chat_data(){
		if(!empty($this->session->userdata('session_chat_id'))){
			$session_chat_id = $this->session->userdata('session_chat_id');
			$where = array('login_id' => $session_chat_id);
			$result =  $this->db->select('first_name,last_name,online_status,sinch_username')
						->get_where('login_details',$where)
						->row_array();
		}else{
			$result=array();
		}
		return $result;
		

	}

}

/* End of file Chat_model.php */
/* Location: ./application/models/Chat_model.php */