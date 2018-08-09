<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat_model extends CI_Model {	

	public function __construct()
	{
		parent::__construct();
		$this->login_id = $this->session->userdata('login_id');
	}
	public function get_group_details($type){
		$sql = "SELECT g.group_id,g.group_name,l.sinch_username FROM chat_group_details g 
		JOIN chat_group_members m ON g.group_id = m.group_id 
		JOIN login_details l ON l.login_id = m.login_id
		WHERE m.login_id =$this->login_id AND g.type = '$type' ";
		$data['groups'] =  $this->db->query($sql)->result_array();			
		$data['group_members'] = $this->get_group_members($data['groups']);
		return $data;

	}
	public function get_screen_share_group_details(){
		$sql = "SELECT distinct group_name,from_id,url FROM screen_share_details";
		$data =  $this->db->query($sql)->result_array();
		return $data;

	}

	public function get_call_history_row(){
		$data = array();
		if($this->session->userdata('session_chat_id')){
			$session_chat_id = $this->session->userdata('session_chat_id');
			$sql = "SELECT l.login_id,l.profile_img,l.first_name,l.last_name,c.call_duration,c.end_cause,c.call_ended_at FROM call_details c 
		JOIN login_details l ON l.login_id = c.call_from_id
		WHERE ( c.call_type = 'video' OR c.call_type = 'audio') AND c.group_id = 0 AND (c.call_from_id = $this->login_id AND c.call_to_id = $session_chat_id) OR (c.call_from_id = $session_chat_id AND c.call_to_id = $this->login_id)  ORDER BY c.call_id DESC LIMIT 1";
		$data = $this->db->query($sql)->result_array();	
		}	
		
		return $data;

	}


	public function get_call_history(){
		$data = array();
		if($this->session->userdata('session_chat_id')){
			$session_chat_id = $this->session->userdata('session_chat_id');
			$sql = "SELECT l.login_id,l.profile_img,l.first_name,l.last_name,c.call_duration,c.end_cause,c.call_ended_at FROM call_details c 
		JOIN login_details l ON l.login_id = c.call_from_id
		WHERE ( c.call_type = 'video' OR c.call_type = 'audio') AND c.group_id = 0 AND (c.call_from_id = $this->login_id AND c.call_to_id = $session_chat_id) OR (c.call_from_id = $session_chat_id AND c.call_to_id = $this->login_id)  ORDER BY c.call_id DESC  LIMIT 10 ";
		$data = $this->db->query($sql)->result_array();	
		}	
		
		return $data;

	}
	public function get_group_datas($group_id){

		$this->db->update('chat_seen_details',array('read_status'=>'1'),array('group_id'=>$group_id,'login_id'=>$this->login_id));
		$query = "SELECT * FROM chat_group_details g WHERE g.group_id = $group_id";
		$data['group'] =  $this->db->query($query)->row_array();	
		$data['group']['group_name'] = ucfirst($data['group']['group_name']);
		$data['group_members']	= $this->get_group_members_list($group_id);

		

		return $data;
	}


	public function get_group_messages($total=null,$group_id){

		$result = array();
		if(!empty($this->session->userdata('session_group_id'))){
			$session_group_id = $this->session->userdata('session_group_id');

			$per_page = 5;   


			if(empty($total)){

				$total =  $this->get_total_chat_group_count($group_id);
				if($total>5){
					$total = $total-5;    
				}else{
					$total = 0;
				}

			}else{
				if($total>0){
					$total = $total-5;  
				}else{
					$total = 0;
				}
			}



			//$this->update_group_counts($group_id);

			$sql= "SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as sender_name, sender.profile_img as sender_profile_image, msg.sender_id,msg.message, msg.chatdate,msg.chat_id,msg.type,msg.file_name,msg.file_path,msg.time_zone,msg.created_at FROM chat_details msg  
			LEFT  join login_details sender on msg.sender_id = sender.login_id
			left join chat_deleted_details cd on cd.chat_id  = msg.chat_id
			where msg.group_id = $group_id AND msg.message_type = 'group'  ORDER BY msg.chat_id ASC LIMIT $total,$per_page";
			$query = $this->db->query($sql);
			$result = $query->result_array();
		}
		return $result;

	}
	//public function update_group_counts()

	public function get_total_chat_group_count($group_id){


		$result = 0;
		if(!empty($this->session->userdata('session_group_id'))){
			$session_group_id = $this->session->userdata('session_group_id');

			$sql= "SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as sender_name, sender.profile_img as sender_profile_image, msg.sender_id,msg.message, msg.chatdate,msg.chat_id,msg.type,msg.file_name,msg.file_path,msg.time_zone,msg.created_at FROM chat_details msg  
			LEFT  join login_details sender on msg.sender_id = sender.login_id
			left join chat_deleted_details cd on cd.chat_id  = msg.chat_id
			where  msg.group_id = $group_id AND msg.message_type = 'group'";
			$query = $this->db->query($sql);
			$result = $query->num_rows();
		}
		return $result;
	}



	public function get_group_members_list($group_id){

		$result = array();
		if(!empty($group_id)){				
			$this->db->select('l.sinch_username,l.login_id,l.profile_img,l.first_name,l.last_name, cg.members_id');
			$this->db->where('cg.group_id',$group_id);
			$this->db->where('cg.login_id !=',$this->login_id);
			$this->db->join('login_details l','l.login_id = cg.login_id');
			$result =  $this->db->get('chat_group_members cg')->result_array();	
		}
		return $result;

	}

	public function get_group_members($data){

		if(!empty($data)){
			foreach($data as $d){
				$group_ids[]=$d['group_id'];					
			}	
			$this->db->select('l.sinch_username,l.login_id,l.profile_img,l.first_name,l.last_name');
			$this->db->where_in('cg.group_id',$group_ids);
			$this->db->join('login_details l','l.login_id = cg.login_id');
			return $this->db->get('chat_group_members cg')->result_array();	
		}

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

		if(!empty($this->session->userdata('session_chat_id'))){
			$session_chat_id = $this->session->userdata('session_chat_id');


			$query = "SELECT l.first_name,l.last_name,l.login_id,l.online_status,l.sinch_username FROM chat_details c JOIN login_details l ON l.login_id = c.sender_id WHERE (c.receiver_id = '$this->login_id' OR c.sender_id = '$this->login_id') AND l.login_id !='$this->login_id' AND l.login_id !='$session_chat_id' GROUP BY c.sender_id LIMIT 5";			

		}else{

		$query = "SELECT l.first_name,l.last_name,l.login_id,l.online_status,l.sinch_username FROM chat_details c JOIN login_details l ON l.login_id = c.sender_id WHERE (c.receiver_id = '$this->login_id' OR c.sender_id = '$this->login_id') AND l.login_id !='$this->login_id' GROUP BY c.sender_id LIMIT 5";			
		}
		return $this->db->query($query)->result_array();

	}
	public function get_chat_data(){
		$result = array();
		if(!empty($this->session->userdata('session_chat_id'))){
			$session_chat_id = $this->session->userdata('session_chat_id');
			$where = array('l.login_id' => $session_chat_id);
			$result =  $this->db
			->select('l.email,l.phone_number,l.first_name,l.last_name,l.login_id,l.online_status,l.sinch_username,l.profile_img,d.department_name,l.dob')
			->join('department_details d','d.department_id = l.department_id')
			->get_where('login_details l',$where)
			->row_array();

		}elseif(!empty($this->session->userdata('session_group_id'))){
			
			$session_group_id = $this->session->userdata('session_group_id');
			$group_type = $this->session->userdata('group_type');
			$sql = "SELECT g.group_id,g.group_name,l.sinch_username,l.login_id FROM chat_group_details g 
			JOIN chat_group_members m ON g.group_id = m.group_id 
			JOIN login_details l ON l.login_id = m.login_id
			WHERE m.group_id =$session_group_id AND g.type = '$group_type' AND l.login_id !=$this->login_id";

			$result =  $this->db
			->query($sql)
			->result_array();

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

	public function get_page_no(){
		$page = 0;
		if(!empty($this->session->userdata('session_chat_id'))){
			$total_chat= $this->get_total_chat_count(); 
			if($total_chat>5){
				$total_chat = $total_chat - 5;
				$page = $total_chat / 5;
				$page = ceil($page);
				$page--;
			}
		}else if(!empty($this->session->userdata('session_group_id'))){
			$total_chat= $this->get_total_chat_group_count($this->session->userdata('session_group_id')); 
			if($total_chat>5){
				$total_chat = $total_chat - 5;
				$page = $total_chat / 5;
				$page = ceil($page);
				$page--;	
			}
		}
		return $page;
	}

	Public function deletable_chats()
	{
		$selected_user = $_POST['sender_id'];
		$query = $this->db->query("SELECT msg.chat_id from chat_details msg  			
			left join chat_deleted_details cd on cd.chat_id  = msg.chat_id
			where cd.can_view = $this->login_id AND ((msg.receiver_id = $selected_user AND msg.sender_id = $this->login_id) or  (msg.receiver_id = $this->login_id AND msg.sender_id =  $selected_user))");
		$result = $query->result_array();
		return $result;   
	}



	public function get_latest_chat($total=null){



		$result = array();
		if(!empty($this->session->userdata('session_chat_id'))){
			$session_chat_id = $this->session->userdata('session_chat_id');

			$per_page = 5;   
			if(empty($total)){

				$total =  $this->get_total_chat_count();
				if($total>5){
					$total = $total-5;    
				}else{
					$total = 0;
				}

			}else{
				if($total>0){
					$total = $total-5;  
				}else{
					$total = 0;
				}
			}



			$this->update_counts();

			$sql= "SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as sender_name, sender.profile_img as sender_profile_image, msg.sender_id,msg.message, msg.chatdate,msg.chat_id,msg.type,msg.file_name,msg.file_path,msg.time_zone,msg.created_at FROM chat_details msg  
			LEFT  join login_details sender on msg.sender_id = sender.login_id
			left join chat_deleted_details cd on cd.chat_id  = msg.chat_id
			where cd.can_view =  $this->login_id AND ((msg.receiver_id = $session_chat_id AND msg.sender_id =  $this->login_id) OR (msg.receiver_id = $this->login_id AND msg.sender_id =  $session_chat_id)) AND msg.message_type = 'text'   ORDER BY msg.chat_id ASC LIMIT $total,$per_page";
			$query = $this->db->query($sql);
			$result = $query->result_array();
		}elseif(!empty($this->session->userdata('session_group_id'))){
			$result = $this->get_group_messages($total,$this->session->userdata('session_group_id'));
		}
		return $result;

	}
	Public function get_total_chat_count()
	{	
		$result = 0;
		if(!empty($this->session->userdata('session_chat_id'))){
			$session_chat_id = $this->session->userdata('session_chat_id');
			$sql = "SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as sender_name, sender.profile_img as sender_profile_image, msg.sender_id,msg.message, msg.chatdate,msg.chat_id,msg.type,msg.file_name,msg.file_path,time_zone FROM chat_details msg  
			LEFT  join login_details sender on msg.sender_id = sender.login_id
			left join chat_deleted_details cd on cd.chat_id  = msg.chat_id
			where cd.can_view =  $this->login_id AND ((msg.receiver_id = $session_chat_id  AND msg.sender_id =  $this->login_id) OR (msg.receiver_id = $this->login_id AND msg.sender_id =  $session_chat_id)) AND msg.message_type = 'text'    ORDER BY msg.chat_id ASC ";
			$result =  $this->db->query($sql)->num_rows(); 
		}
		return $result;



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
				$this->db->update('chat_details',array('read_status'=>1,'message_type'=>'text'),array('chat_id'=>$d['chat_id']));
			}

		}else{
			return true;
		}

	}

}

/* End of file Chat_model.php */
/* Location: ./application/models/Chat_model.php */