<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('chat_model','chat');
	}

	public function index()
	{
		$data['title'] = 'Chat';		
		$data['chat'] = $this->chat->get_chat_data();
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
		$data = $this->db
					->select('first_name,last_name,login_id,online_status,sinch_username')
					->get_where('login_details',array('login_id'=>$_POST['login_id']))
					->row_array();
		$data['first_name'] = ucfirst($data['first_name']);
		$data['last_name'] =ucfirst($data['last_name']);
		$data['sinch_username'] =$data['sinch_username'];
		if($data['online_status'] == 1){
			$data['online_status'] = 'online';
		}else{
			$data['online_status'] = 'offline';
		}
		echo json_encode($data);
	}

}

/* End of file  */
/* Location: ./application/controllers/ */