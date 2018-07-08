<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat_model extends CI_Model {	

	public function __construct()
	{
		parent::__construct();
		$this->login_id = $this->session->userdata('login_id');
	}

	public function get_users_by_name(){		
		$query = "SELECT `l`.`login_id`, `l`.`sinch_username`, `l`.`first_name`, `l`.`last_name`, `d`.`department_name`
					FROM `login_details` `l`
					JOIN `department_details` `d` ON `d`.`department_id` = `l`.`department_id`
					WHERE (`l`.`first_name` LIKE '%$_POST[user_name]%' OR  `l`.`last_name` LIKE '%$_POST[user_name]%')
					AND `login_id` != '$this->login_id'
					AND `l`.`status` = 1
					AND `l`.`type` = 'user'
					LIMIT 10";
		return $this->db->query($query)->result_array();
	}

	public function get_chated_users(){
	
			$query = "SELECT l.first_name,l.last_name,l.login_id,l.online_status,l.sinch_username FROM chat_details c JOIN login_details l ON l.login_id = c.sender_id WHERE (c.receiver_id = '$this->login_id' OR c.sender_id = '$this->login_id') AND l.login_id !='$this->login_id' GROUP BY sender_id LIMIT 5";			
			return $this->db->query($query)->result_array();

	}
	public function get_chat_data(){
		if(!empty($this->session->userdata('session_chat_id'))){
			$session_chat_id = $this->session->userdata('session_chat_id');
			$where = array('login_id' => $session_chat_id);
			$result =  $this->db->select('first_name,last_name,online_status,sinch_username,profile_img')
			->get_where('login_details',$where)
			->row_array();
		}else{
			$result=array();
		}
		return $result;
		

	}	
		public function get_recent_chats(){
		if(!empty($this->session->userdata('session_chat_id'))){
			$session_chat_id = $this->session->userdata('session_chat_id');
			$query="SELECT msg.message  from chat_details msg     
     left join chat_deleted_details cd on cd.chat_id  = msg.chat_id
    where  cd.can_view = '$this->login_id' AND ((msg.receiver_id = '$this->login_id' AND msg.sender_id = '$session_chat_id') or  (msg.receiver_id = '$session_chat_id' AND msg.sender_id =  '$this->login_id' ))   ORDER BY msg.chat_id DESC";
			$result =  $this->db->query($query)->result_array();
		}else{
			$result=array();
		}
		return $result;
		

	}	
	public function get_profile_data(){
		$result=array();
		if(!empty($this->session->userdata('login_id'))){
			$login_id = $this->session->userdata('login_id');
			$where = array('login_id' => $login_id);
			$result =  $this->db
			->get_where('login_details',$where)
			->row_array();
		}
		return $result;
		

	}

}

/* End of file Chat_model.php */
/* Location: ./application/models/Chat_model.php */