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
			$where = array('l.login_id' => $session_chat_id);
			$result =  $this->db
			->select('l.email,l.phone_number,l.first_name,l.last_name,l.login_id,l.online_status,l.sinch_username,l.profile_img,d.department_name,l.dob')
			->join('department_details d','d.department_id = l.department_id')
			->get_where('login_details l',$where)
			->row_array();

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
			->select('profile_img')
			->get_where('login_details',$where)
			->row_array();
		}
		return $result;
	}



	public function get_latest_chat(){

		$result = array();
		if(!empty($this->session->userdata('session_chat_id'))){
			$session_chat_id = $this->session->userdata('session_chat_id');

			$per_page = 5;   
			$total =  $this->get_total_chat_count();
			if($total>5){
				$total = $total-5;    
			}else{
				$total = 0;
			}  
			$this->update_counts();

			$sql= "SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as sender_name, sender.profile_img as sender_profile_image, msg.sender_id,msg.message, msg.chatdate,msg.chat_id,msg.type,msg.file_name,msg.file_path,msg.time_zone,msg.created_at FROM chat_details msg  
			LEFT  join login_details sender on msg.sender_id = sender.login_id
			left join chat_deleted_details cd on cd.chat_id  = msg.chat_id
			where cd.can_view =  $this->login_id AND ((msg.receiver_id = $session_chat_id AND msg.sender_id =  $this->login_id) OR (msg.receiver_id = $this->login_id AND msg.sender_id =  $session_chat_id))   ORDER BY msg.chat_id ASC LIMIT $total,$per_page";
			$query = $this->db->query($sql);
			$result = $query->result_array();
		}
		return $result;

	}
	Public function get_total_chat_count()
	{
		$session_chat_id = $this->session->userdata('session_chat_id');

		$sql = "SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as sender_name, sender.profile_img as sender_profile_image, msg.sender_id,msg.message, msg.chatdate,msg.chat_id,msg.type,msg.file_name,msg.file_path,time_zone FROM chat_details msg  
		LEFT  join login_details sender on msg.sender_id = sender.login_id
		left join chat_deleted_details cd on cd.chat_id  = msg.chat_id
		where cd.can_view =  $this->login_id AND ((msg.receiver_id = $session_chat_id  AND msg.sender_id =  $this->login_id) OR (msg.receiver_id = $this->login_id AND msg.sender_id =  $session_chat_id))   ORDER BY msg.chat_id ASC ";

		return  $this->db->query($sql)->num_rows(); 


	}


	Public function update_counts()
	{

		$session_chat_id = $this->session->userdata('session_chat_id');

		$sql="SELECT msg.chat_id from chat_details msg 
		WHERE msg.read_status = 0 AND (msg.receiver_id = '$this->login_id' AND msg.sender_id = '$session_chat_id' )";
		$query = $this->db->query($sql);
		$result = $query->result_array();

		if(!empty($result)){
			foreach ($result as $d) {            
				$this->db->update('chat_details',array('read_status'=>1),array('chat_id'=>$d['chat_id']));
			}

		}else{
			return true;
		}

	}

}

/* End of file Chat_model.php */
/* Location: ./application/models/Chat_model.php */