<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(empty($this->session->userdata('login_id'))){
			$this->session->set_flashdata('msg','Please login to continue !');
			redirect('login');
		}
		$this->load->model('chat_model','chat');
		$this->login_id = $this->session->userdata('login_id');
	}

	public function index()
	{
		$data['title'] = 'Chat';		
		$data['chat'] = $this->chat->get_chat_data();
		$data['recent_chats'] = $this->chat->get_recent_chats();
		$data['profile'] = $this->chat->get_profile_data();
		$data['chat_users'] = $this->chat->get_chated_users();
		render_page('chat',$data);
	}
	public function get_users_by_name(){
		$users_record = array();
		$data = $this->chat->get_users_by_name();
		if(!empty($data)){
			
			foreach($data as $u){
				$datas['first_letter'] = ucfirst(substr($u['first_name'], 0, 1));
				$datas['first_name'] = ucfirst($u['first_name']);
				$datas['last_name'] =ucfirst( $u['last_name']);
				$datas['sinch_username'] = $u['sinch_username'];
				$datas['department_name'] = $u['department_name'];
				$datas['login_id'] = $u['login_id'];
				$users_record[] =$datas;
			}

		}		
		echo json_encode($users_record);
	}
	public function set_chat_user(){
		$this->session->set_userdata(array('session_chat_id'=>$_POST['login_id']));

		$this->db->update('chat_details',array('read_status'=>1),array('receiver_id' => $this->login_id,'sender_id' =>$_POST['login_id']));
		$data = $this->db
		->select('first_name,last_name,login_id,online_status,sinch_username,profile_img')
		->get_where('login_details',array('login_id'=>$_POST['login_id']))
		->row_array();

		$data['first_name'] = ucfirst($data['first_name']);
		$data['last_name'] =ucfirst($data['last_name']);
		$data['sinch_username'] =$data['sinch_username'];
		
		if(empty($data['profile_img'])){
			$data['profile_img'] = base_url().'assets/img/user.jpg';
		}else{
			$data['profile_img'] = base_url().'uploads/'.$data['profile_img'];
		}
		echo json_encode($data);
	}

	Public function insert_chat()
	{	
		$login_id = 
		$data['receiver_id'] =$_POST['receiver_id'];
		$data['sender_id'] = $this->session->userdata('login_id');
		$data['time_zone'] = $this->session->userdata('time_zone');
		$data['chatdate'] = date('Y-m-d H:i:s');
		$data['message'] = $_POST['message'];
		$result = $this->db->insert('chat_details',$data);
		$chat_id = $this->db->insert_id();
		$users = array($data['receiver_id'],$data['sender_id']);
		for ($i=0; $i <2 ; $i++) { 
			$datas = array('chat_id' =>$chat_id ,'can_view'=>$users[$i]);
			$this->db->insert('chat_deleted_details',$datas);
		}
		echo json_encode($users);

	}


	Public function get_message_details()
	{
		/*Receiver data */
		$data= $this->db
		->select('first_name,last_name,login_id,sinch_username')
		->get_where('login_details',array('sinch_username'=>$_POST['receiver_sinchusername']))
		->row_array();
		/*Message*/
		$msg['msg_data'] = $this->db
		->order_by('chat_id','desc')
		->get_where('chat_details',array('sender_id'=>$data['login_id']))
		->row_array();
		$msg['reciever_data'] = $data;
		echo json_encode($msg);
	}
	Public function get_user_details(){
		$data = array();
		$where =array('sinch_username'=>$_POST['receiver_sinchusername']);
		$data= $this->db
		->select('first_name,last_name,login_id,sinch_username,online_status')
		->get_where('login_details',$where)
		->row_array();
		$data['first_name'] = ucfirst($data['first_name']); 
		$data['last_name'] = ucfirst($data['last_name']); 

		$where = array('sender_id'=>$data['login_id'] ,'receiver_id' =>$this->login_id,'read_status'=>0);
		$data['count'] = $this->db
		->get_where('chat_details',$where)
		->num_rows();

		echo json_encode($data);
	}





}

/* End of file  */
/* Location: ./application/controllers/ */