<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '../vendor/autoload.php');

use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;
use OpenTok\Session;
use OpenTok\Role;

class Chat extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(empty($this->session->userdata('login_id'))){
			$this->session->set_flashdata('msg','Please login to continue !');
			redirect('login');
		}
		$this->load->model('chat_model','chat');
		$this->load->model('Profile_model','profile');
		$this->load->model('Settings_model','settings');
		$this->login_id = $this->session->userdata('login_id');
		date_default_timezone_set($this->session->userdata('time_zone'));
		$this->apiKey = '46145352';
		$this->apiSecret = 'ba588dc2fd5ff997c82add14f3d32778566ffc7f';

	}
	public function index()
	{	

		$page = $this->session->userdata('page');

		$data['profile_class'] = "hidden";
		$data['text_chat_class'] = "hidden";
		$data['audio_class'] = "hidden";
		$data['video_class'] = "hidden";
		$data['group_video_class'] = "hidden";
		$data['group_audio_class'] = "hidden";
		$data['screen_share_class'] = "hidden";
		if(!empty($page)){							 	
			switch($page){
				case 'profile':
				$data['profile_class'] = '';
				break;
				case 'text_chat':
				$data['text_chat_class'] = '';
				break;
				case 'audio':
				$data['audio_class'] = '';
				break;
				case 'video':
				$data['video_class'] = '';
				break;
				case 'screen_share':
				$data['screen_share_class'] = '';
				break;
				default:
				$data['profile_class'] = '';
				break;
			}
		}else{
			$data['profile_class']  = "";
		}
		$data['title'] = 'Chat';	


		$records =  $this->settings->profile_details($this->login_id);	
		$data['user_profile']  = $profile = $records['profile'];
		$data['education_details'] = $records['education_details'];
		$data['experience_informations'] = $records['experience_informations'];

		$data['text_group'] = $this->chat->get_group_details('text');
		$data['audio_group'] = $this->chat->get_group_details('audio');
		$data['video_group'] = $this->chat->get_group_details('video');
		$data['screen_share_group'] = $this->chat->get_screen_share_group_details();
		$data['call_history'] = $this->chat->get_call_history();
		$data['page'] = $this->chat->get_page_no();
		$data['chat'] = $this->chat->get_chat_data();
		$data['latest_chats'] = $this->chat->get_latest_chat();
		$data['profile'] = $this->chat->get_profile_data();
		$data['chat_users'] = $this->chat->get_chated_users();
		$session_values = array('dummy_group_id' => '','dummy_group_name' => '','dummy_session_id' => '','dummy_session' => '','dummy_token' => '');
		$this->session->set_userdata($session_values);

		render_page('chat',$data);
	}
	public function delete_group(){
		$count = $this->db->get_where('login_details',array('group_id'=>$_POST['group_id'],'call_status'=>1))->num_rows();
		if($count == 0){
			$this->db->update('chat_group_details',array('status'=>0),array('group_id'=>$_POST['group_id']));	
			$result = array('success' => 'deleted');
		}else{
			$result = array('error' => 'Group call is active in this group!');
		}
		echo json_encode($result);
		
	}
	public function set_call_status(){

		$where = array('login_id' =>$this->login_id);
		$data = array('call_status' =>$_POST['call_status']);
		$this->db->update('login_details',$data,$where);
		if(!empty($_POST['type'])){
			echo $this->db->insert('call_type',array('login_id'=>$this->login_id,'type'=>$_POST['type']));
		}

	}


	public function insert_call_type(){
		$data = array(
			'login_id' => $this->login_id,
			'type' => $_POST['type'],
		);
		echo $this->db->insert('call_type',$data);
	}

	public function update_group_member() {
		$result = $this->db->update('chat_group_members', array('is_active'=>$_POST['is_active']),array('group_id'=>$_POST["group_id"],'login_id'=>$this->login_id));
		echo json_encode($result);
	}

	public function get_group_members_status() {
		$result = $this->db->get_where('chat_group_members', array('group_id'=>$_POST["group_id"]))->result_array();
		echo json_encode($result);
	}

	public function update_call_details(){

		if($_POST['call_to_id'] == $this->login_id){
			$call_started_at = convert_datetime($_POST['call_started_at']);
			$call_ended_at = convert_datetime($_POST['call_ended_at']);			
			$data = array(
				'call_from_id' => $_POST['call_from_id'],
				'call_to_id' => $_POST['call_to_id'],
				'group_id' => $_POST['group_id'],
				'call_type' => $_POST['call_type'],
				'call_duration' => $_POST['call_duration'],
				'call_started_at' => $call_started_at,
				'call_ended_at' => $call_ended_at,
				'end_cause' => $_POST['end_cause']
			);
			$this->db->insert('call_details',$data);


		}
		$this->set_call_status();
		$datas['call_history'] =$this->chat->get_call_history_row();
		echo json_encode($datas);
		
		
	}
	public function set_nav_bar(){
		$page = array();
		if(!empty($_POST['page'])){
			$page = array('page'=>$_POST['page']);
			$this->session->set_userdata($page);
		}
		echo json_encode($page);
	}
	public function get_group_member_details(){
		$where = array('sinch_username' => $_POST['sinch_username']);
		$data = $this->db
		->select('l.first_name,l.last_name,l.login_id as call_from_id,l.sinch_username,l.profile_img,c.type')
		->join('call_type c','l.login_id = c.login_id')
		->order_by('c.date_created','desc')
		->get_where('login_details l',$where)
		->row_array();
		$data['name'] = ucfirst($data['first_name']).' '.ucfirst($data['last_name']);
		$data['profile_img'] = (!empty($data['profile_img']))?base_url().'uploads/'.$data['profile_img'] : base_url().'assets/img/user.jpg';
		$data['call_to_id'] = $this->login_id;
		echo json_encode($data);
	}
	public function get_call_status(){
		$data=array();
		$result=array();
		$where = array('sinch_username'=>$_POST['sinch_username']);

		$data = $this->db
		->select('first_name,last_name,online_status,call_status')
		->get_where('login_details',$where)
		->row_array();

		if($data['online_status'] == 0){
			$result['name'] = ucfirst($data['first_name']).'  '.ucfirst($data['last_name']).' is Offline';
		}elseif($data['call_status'] == 1){
			$result['name'] = ucfirst($data['first_name']).'  '.ucfirst($data['last_name']).' already in Call';
		}else{
			$this->db->insert('call_type',array('login_id' => $this->login_id,'type' => $_POST['type']));
			$this->db->update('login_details',array('call_status'=>1),array('login_id' =>$this->login_id));		
		}			
		echo json_encode($result);
		
		
	}
	public function get_caller_details(){

		$where = array('sinch_username' => $_POST['sinch_username']);

		$data = $this->db
		->select('l.first_name,l.last_name,l.login_id as call_from_id,l.sinch_username,l.profile_img,c.type')
		->join('call_type c','l.login_id = c.login_id')
		->order_by('c.date_created','desc')
		->get_where('login_details l',$where)
		->row_array();
		
		$data['name'] = ucfirst($data['first_name']).' '.ucfirst($data['last_name']);
		$data['profile_img'] = (!empty($data['profile_img']))?base_url().'uploads/'.$data['profile_img'] : base_url().'assets/img/user.jpg';
		$data['call_to_id'] = $this->login_id;
		echo json_encode($data);
	}

	public function get_new_group_datas(){
		$group_id = $this->session->userdata('session_group_id');
		$data = $this->chat->get_group_datas($group_id);
		echo json_encode($data);
	}
	
	public function get_group_datas(){
		
		


		$group_id = $_POST['group_id'];
		$count = $this->db->get_where('chat_group_details',array('status'=>1,'group_id'=>$group_id))->num_rows();
		if($count == 0){
			echo json_encode(array('error'=>'No group'));
			exit;
		}
		// echo '<pre>'; print_r($_POST);
		//  exit;


		$this->session->set_userdata(array('session_chat_id'=>''));		
		$data = $this->chat->get_group_datas($group_id);
		$total_chat= $this->chat->get_total_chat_group_count($group_id); 

		$this->session->set_userdata(array('session_group_id'=>$group_id,'group_type'=>$data['group']['type']));
		$latest_chats = $this->chat->get_group_messages($total=null,$group_id);  		
		$page=0;
		if($total_chat>5){
			$total_chat = $total_chat - 5;
			$page = $total_chat / 5;
			$page = ceil($page);
			$page--;
		}

		if(count($latest_chats)>4){

			$html ='<div class="load-more-btn text-center" total="'.$page.'">
			<button class="btn btn-default" data-page="2"><i class="fa fa-refresh"></i> Load More</button>
			</div><div class="ajax_old"></div>';      
		}else{
			$html ='';
		}


		if(!empty($latest_chats)){

			foreach($latest_chats as $l){
				$sender_name = $l['sender_name'];
				$sender_profile_img = (!empty($l['sender_profile_image']))?base_url().'uploads/'.$l['sender_profile_image'] : base_url().'assets/img/user.jpg';
				$msg = $l['message'];
				$type = $l['type'];
				$file_name = base_url().$l['file_path'].'/'.$l['file_name'];
				$time = date('h:i A',strtotime($l['chatdate']));
				$up_file_name =$l['file_name'];

				if($l['sender_id'] == $this->login_id){
					$class_name = 'chat-right';
					$img_avatar='';
				}else{
					$img_avatar = '<div class="chat-avatar">
					<a href="#" class="avatar">
					<img alt="'.$sender_name.'" title="'.$sender_name.'" src="'.$sender_profile_img.'" class="img-responsive img-circle">
					</a>
					</div>';
					$class_name = 'chat-left';
				}
				if($msg == 'file' && $type == 'image'){

					$html .= '<div class="chat '.$class_name.'">'.$img_avatar.'
					<div class="chat-body">
					<div class="chat-bubble">
					<div class="chat-content img-content">
					<div class="chat-img-group clearfix">
					<a class="chat-img-attach" href="'.$file_name.'" target="_blank">
					<img width="182" height="137" alt="" src="'.$file_name.'">
					<div class="chat-placeholder">
					<div class="chat-img-name">'.$up_file_name.'</div>
					</div>
					</a>
					</div>
					<span class="chat-time">'.$time.'</span>
					</div>               
					</div>
					</div>
					</div>';

				}else if($msg == 'file' && $type == 'others'){

					$html .= '<div class="chat '.$class_name.'">'.$img_avatar.'
					<div class="chat-body">
					<div class="chat-bubble">
					<div class="chat-content "><ul class="attach-list">
					<li><i class="fa fa-file"></i><a href="'.$file_name.'">'.$up_file_name.'</a></li>
					</ul>
					<span class="chat-time">'.$time.'</span>       
					</div>
					</div>
					</div>
					</div>';

				}else{

					$html .= '<div class="chat '.$class_name.'">'.$img_avatar.'
					<div class="chat-body">
					<div class="chat-bubble">
					<div class="chat-content">
					<p>'.$msg.'</p>         
					<span class="chat-time">'.$time.'</span>
					</div>
					</div>
					</div>
					</div>';
				}														
			}

		}

		$html .='<div class="ajax"></div><input type="hidden"  id="hidden_id">';

		if($total_chat == 0){
			$html .='<div class="no_message"></div>';
		}
		$data['messages'] = $html;


		echo json_encode($data);
	}
	Public function get_username(){
		$data = array();
		$data = $this->db->select('first_name,last_name,profile_img')
		->get_where('login_details',array('sinch_username' => $_POST['sinch_username']))
		->row_array();
		if(!empty($data)){
			$data['first_name'] = ucfirst($data['first_name']);
			$data['last_name'] = ucfirst($data['last_name']);
			$data['profile_img'] = (!empty($data['profile_img']))?base_url().'uploads/'.$data['profile_img'] : base_url().'assets/img/user.jpg';
		}
		echo json_encode($data);
	}

	public function add_group_user(){
		// echo '<pre>';
		// 	print_r($_POST);
		// 	print_r($this->session->userdata('session_group_id'));
		// exit;
		$group_name='';

		if(!empty($_POST['group_id'])){
			$group_id = $_POST['group_id'];			
		}elseif(!empty($this->session->userdata('session_group_id'))){ 
			/* Checking for session Group id */		
			$group_id = $this->session->userdata('session_group_id');

		}elseif(!empty($this->session->userdata('dummy_group_id'))){ 
			/* Checking for Dummy group id */
			$group_id = $this->session->userdata('dummy_group_id');
		}else{
			/* No session & dummy group id & post group id */
			$opentok = new OpenTok($this->apiKey, $this->apiSecret);
				// An automatically archived session:
			$sessionOptions = array(
				// 'archiveMode' => ArchiveMode::ALWAYS,
				'mediaMode' => MediaMode::ROUTED
			);
			$new_session = $opentok->createSession($sessionOptions);
				// Store this sessionId in the database for later use
			$sessionId = $new_session->getSessionId();
			$data = array(					
				'session_id' => $sessionId,
				'type' => 'text',
				'created_by' => $this->login_id
			);
			$this->db->insert('chat_group_details',$data);
			$group_id =$this->db->insert_id();				

			$where = array('group_id' => $group_id,'login_id'=>$this->login_id);
			$check  = $this->db->get_where('chat_group_members',$where)->num_rows();

			/* Check already users presence in group */
			
			if($check == 0){				
				$det = array(
					
					'group_id' => $group_id,
					'login_id' => $this->login_id,
					'new_user' => 1
				);

				$this->db->insert('chat_group_members',$det);
				$this->db->insert('chat_seen_details',$det);							
			}
		}

		/* Insert Current User in group */
			$group_name = 'Group'.$group_id;
			$this->db->update('chat_group_details',array('group_name'=>$group_name,'type' => 'text' ),array('group_id'=>$group_id));



		$member = explode(',',$_POST['members']);
		$new_users = array();

		$this->db->update('chat_group_members',array('new_user'=>0),array('group_id'=>$group_id));

		for ($i=0; $i <count($member) ; $i++) { 
			$user = $this->db->get_where('login_details',array('user_name'=>$member[$i],'status'=>1))->row_array();
			if(!empty($user)){
				$sinch_usernames[]=$user['sinch_username'];
				$datas = array(
					'group_id' => $group_id,
					'login_id' => $user['login_id'],
					'new_user' => 1
				);

				$where = array('group_id' => $group_id,'login_id'=>$user['login_id']);
				$check  = $this->db->get_where('chat_group_members',$where)->num_rows();
				/* Check already users presence in group */
				if($check == 0){
					$new_users[]=$datas['login_id'];
					$this->db->insert('chat_group_members',$datas);
					$this->db->insert('chat_seen_details',$datas);							
				}
			}
		}

		/* Session chat user id */
		if(!empty($this->session->userdata('session_chat_id'))){
			$where = array('group_id' => $group_id,'login_id'=>$this->session->userdata('session_chat_id'));
			$check  = $this->db->get_where('chat_group_members',$where)->num_rows();
			/* Check already users presence in group */
			if($check == 0){
				$new_users +=array($this->session->userdata('session_chat_id'));
				$dat = array(
					'group_id' => $group_id,
					'login_id' => $this->session->userdata('session_chat_id'),
					'new_user' => 1
				);
				$this->db->insert('chat_group_members',$dat);
				$this->db->insert('chat_seen_details',$dat);							
			}
			
		}



		$sinch_users=array();
		if(!empty($new_users)){		
			/* Check Current user in Call */
			 $count = $this->db
			->get_where('login_details',array('login_id' => $this->login_id, 'call_status' =>1 ))
			->num_rows();



			if($count!=0){
				/*Make Call ringing for new user */

				for ($i=0; $i <count($new_users) ; $i++) { 
					/* Check Calling user already  in Call */
					$where = array('login_id' => $new_users[$i], 'call_status' =>1 );
					$count = $this->db
					->get_where('login_details',$where)
					->num_rows();

					if($count==0){
						$new = array(
							'type' => 'many',
							'group_id' => $group_id ,
							'from_id' => $this->login_id,
							'to_id'=>$new_users[$i]
						);
						$this->db->insert('call_notification',$new);									
					}

				}
			}




			$sinch_users=$this->db
			->select('sinch_username,first_name,last_name,login_id,profile_img')
			->where_in('login_id',$new_users)
			->get('login_details')
			->result_array();
		}				
		$session_values = array('session_chat_id' =>'','session_group_id' => $group_id);
		$this->session->set_userdata($session_values);
		echo json_encode(array('group_name'=>$group_name,'group_id'=>$group_id,'users'=>$sinch_users));

	}
	public function update_group(){
		 $this->db->update('chat_group_details',array('group_name'=>$_POST['group_name']),array('group_id' => $_POST['group_id']));
		 $hidden_group_name = str_replace(' ','_',$_POST['hidden_group_name']);
		 $new_group_name = str_replace(' ','_',$_POST['group_name']);
echo json_encode(array('hidden_group_name'=>ucfirst($hidden_group_name),'group_name'=>$_POST['group_name'],'new_group_name'=>ucfirst($new_group_name)));
	}
	public function create_group(){

		$this->session->set_userdata(array('session_chat_id'=>''));
		$group_type = $_POST['group_type'];

		/* No session & dummy group id & post group id */
			$opentok = new OpenTok($this->apiKey, $this->apiSecret);
				// An automatically archived session:
			$sessionOptions = array(
				// 'archiveMode' => ArchiveMode::ALWAYS,
				'mediaMode' => MediaMode::ROUTED
			);
			$new_session = $opentok->createSession($sessionOptions);
				// Store this sessionId in the database for later use
			$sessionId = $new_session->getSessionId();



		$data = array('group_name' => $_POST['group_name'],'type' => $group_type,'session_id' => $sessionId);
		$count = $this->db->get_where('chat_group_details',$data)->num_rows();
		if($count!=0){
			$result = array('error'=>'Group name already taken!');		
			
		}else{

			$this->db->insert('chat_group_details',$data);
			$group_id = $this->db->insert_id();
			$this->session->set_userdata(array('session_group_id'=>$group_id,'group_type' => $group_type));

			$member = explode(',',$_POST['members']);
			for ($i=0; $i <count($member) ; $i++) { 

				$user = $this->db
				->select('sinch_username,login_id,profile_img,first_name,last_name')
				->get_where('login_details',array('user_name'=>$member[$i],'status'=>1))
				->row_array();
				$group_members[]=$user;
				if(!empty($user)){
					$sinch_usernames[]=$user['sinch_username'];
					$datas = array(
						'group_id' => $group_id,
						'login_id' => $user['login_id']
					);
					$this->db->insert('chat_group_members',$datas);
					$this->db->insert('chat_seen_details',$datas);	
				}
				
			}
			@$sinch_usernames = implode(',',$sinch_usernames);
			$datas = array(
				'group_id' => $group_id,
				'login_id' => $this->login_id
			);
			$this->db->insert('chat_group_members',$datas);

			$datas = array(
				'group_id' => $group_id,
				'login_id' => $this->login_id
			);

			$datta['receiver_id'] = 0;
			$datta['sender_id'] = $this->login_id;
			$datta['time_zone'] = $this->session->userdata('time_zone');
			$datta['chatdate'] = date('Y-m-d H:i:s');
			$datta['message'] = 'Hi there!';
			$datta['message_type'] = 'group';
			$datta['group_id'] = $group_id;
			$this->db->insert('chat_details',$datta);

			$note_data = array(
				'created_by' => $this->login_id,
				'group_id' => $group_id,
				'group_type' =>$group_type,				
			);
			$this->db->insert('notification_details',$note_data);



			$result = array(
				'success'=>'Group created successfully!',
				'group_name' => ucfirst($_POST['group_name']),
				'group_id'=>$group_id,
				'group_type'=>$group_type,
				'sinch_username' => $sinch_usernames,
				'group_members' => $group_members
			);
			
		}	
		echo json_encode($result);

	}

	public function get_notification(){
		$data = array();
		$where = array('l.sinch_username' => $_POST['created_by']);
		$data = $this->db
		->select('l.first_name,l.last_name,l.profile_img,g.group_name,g.type as group_type')				
		->order_by('n.note_id','desc')
		->join('notification_details n','l.login_id = n.created_by')
		->join('chat_group_details g','g.group_id = n.group_id')					
		->get_where('login_details l',$where)
		->row_array();

		if(!empty($data)){
			$data['group_name'] = ucfirst($data['group_name']);
			$data['first_name'] = ucfirst($data['first_name']);
			$data['last_name'] = ucfirst($data['last_name']);
			$data['profile_img'] = (!empty($data['profile_img']))?base_url().'uploads/'.$data['profile_img'] : base_url().'assets/img/user.jpg';						
		}

		echo json_encode($data);
	}

	public function create_share(){
		$data = array('group_name' => $_POST['group_name'], 'from_id' => $this->login_id);
		$count = $this->db->get_where('screen_share_details',$data)->num_rows();
		if($count!=0){
			$result = array('error'=>'Group name already taken!');		
			
		}else{
			$da = array(
				'group_name' => $_POST['group_name'],
				'channel' =>'',
				'type' => 'screenshare',
				'created_by' => $this->login_id				
			);
			$this->db->insert('chat_group_details',$da);
			$group_id = $this->db->insert_id();

			$member = explode(',',$_POST['members']);
			for ($i=0; $i <count($member) ; $i++) { 
				$user = $this->db->get_where('login_details',array('user_name'=>$member[$i],'status'=>1))->row_array();
				if($user){
					$sinch_usernames[]=$user['sinch_username'];
					$datas = array(
						'group_name' => $_POST['group_name'],
						'from_id' => $this->login_id,
						'to_id' => $user['login_id'],
							//'status' => 'invited',
						'created_date' => date('Y-m-d H:i:s')
					);
					$this->db->insert('screen_share_details',$datas);	

					/*Add group member details */
					$datat = array(
						'group_id' => $group_id,
						'login_id' => $user['login_id'],
						'created_by' => $this->login_id
					);
					$this->db->insert('chat_group_members',$datat);	

				}
			}


			$result = array(
				'success'=>'Group created successfully!',
				'group_name' => ucfirst($_POST['group_name']),
				'url' => '',
				'fromId' => $this->login_id
			);
		}
		echo json_encode($result);

	}

	public function request_share() {

		/* Url to stop : POST https://api.screenleap.com/v2/screen-shares/{screenShareCode}/stop */
		
		$url = 'https://api.screenleap.com/v2/screen-shares';
		$ch = curl_init($url); curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('authtoken:LkoSIriJbW'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'accountid=dreamguys_technologies');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Whether you need the following line depends on your curl configuration.
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$screenShareData = curl_exec($ch);
		curl_close($ch);
		echo json_encode($screenShareData);
	}

	public function update_share(){


		$data['sender_id'] = $this->login_id;
		$data['time_zone'] = $this->session->userdata('time_zone');
		$data['chatdate'] = date('Y-m-d H:i:s');
		$data['message'] = 'Click the link to view the  Sharing screen <br><a data-src="'.$_POST["url"].'" href="'.$_POST["url"].'" target="blank">'.$_POST["url"].'</a>';


		if(!empty($_POST['group_id'])){

		// Saving the URL 
			$dt = array('screen_share_url'=> $_POST["url"]);
			$where = array('group_id'=> $_POST["group_id"]);
			$result = $this->db->update('chat_group_details',$dt,$where);

			$data['receiver_id'] = 0;		
		// $data['message_type'] = (!empty($_POST['group_id']))?'group':'text';
			$data['message_type'] = 'group';
			$data['group_id'] = (!empty($_POST['group_id']))?$_POST['group_id']:'';
			$result = $this->db->insert('chat_details',$data);
			$chat_id = $this->db->insert_id();

			$users = array($data['receiver_id'],$data['sender_id']);
			$wher = array('login_id !='=>$this->login_id ,'group_id'=>$data['group_id']);
			$userid_list = $this->db->select('login_id')->get_where('chat_group_members',$wher)->result_array();
			if(!empty($userid_list)){
				foreach($userid_list as $u){
					$insert_data = array('group_id'=>$data['group_id'],'login_id'=>$u['login_id']);
					$this->db->insert('chat_seen_details',$insert_data);
				}
			}
		}else{


			$data['receiver_id'] =$_POST['receiver_id'];		
			$data['message_type'] = 'text';
			$data['group_id'] = '';
			$result = $this->db->insert('chat_details',$data);
			$chat_id = $this->db->insert_id();
			$users = array($data['receiver_id'],$data['sender_id']);
			for ($i=0; $i <2 ; $i++) { 
				$datas = array('chat_id' =>$chat_id ,'can_view'=>$users[$i]);
				$this->db->insert('chat_deleted_details',$datas);
			}



		}

		
		
		
		echo json_encode($result);
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
	public function get_old_messages(){

		if($_POST['total']<0){
			return false;
		}else{
			$total = $_POST['total'];
			$total = $total * 5;
		}

		$latest_chats= $this->chat->get_latest_chat($total);  


		$html='';
		if(!empty($latest_chats)){

			foreach($latest_chats as $l){
				$sender_name = $l['sender_name'];
				$sender_profile_img = (!empty($l['sender_profile_image']))?base_url().'uploads/'.$l['sender_profile_image'] : base_url().'assets/img/user.jpg';
				$msg = $l['message'];
				$type = $l['type'];
				$file_name = base_url().$l['file_path'].'/'.$l['file_name'];
				$time = date('h:i A',strtotime($l['created_at']));
				$up_file_name =$l['file_name'];

				if($l['sender_id'] == $this->login_id){
					$class_name = 'chat-right';
					$img_avatar='';
				}else{
					$img_avatar = '<div class="chat-avatar">
					<a href="#" class="avatar">
					<img alt="'.$sender_name.'" src="'.$sender_profile_img.'" class="img-responsive img-circle">
					</a>
					</div>';
					$class_name = 'chat-left';
				}
				if($msg == 'file' && $type == 'image'){

					$html .= '<div class="chat '.$class_name.'">'.$img_avatar.'
					<div class="chat-body">
					<div class="chat-bubble">
					<div class="chat-content img-content">
					<div class="chat-img-group clearfix">
					<a class="chat-img-attach" href="'.$file_name.'" target="_blank">
					<img width="182" height="137" alt="" src="'.$file_name.'">
					<div class="chat-placeholder">
					<div class="chat-img-name">'.$up_file_name.'</div>
					</div>
					</a>
					</div>
					<span class="chat-time">'.$time.'</span>
					</div>               
					</div>
					</div>
					</div>';

				}else if($msg == 'file' && $type == 'others'){

					$html .= '<div class="chat '.$class_name.'">'.$img_avatar.'
					<div class="chat-body">
					<div class="chat-bubble">
					<div class="chat-content "><ul class="attach-list">
					<li><i class="fa fa-file"></i><a href="'.$file_name.'">'.$up_file_name.'</a></li>
					</ul>
					<span class="chat-time">'.$time.'</span>       
					</div>
					</div>
					</div>
					</div>';

				}else{

					$html .= '<div class="chat '.$class_name.'">'.$img_avatar.'
					<div class="chat-body">
					<div class="chat-bubble">
					<div class="chat-content">
					<p>'.$msg.'</p>         
					<span class="chat-time">'.$time.'</span>
					</div>
					</div>
					</div>
					</div>';
				}														
			}
			$html .='<div class="ajax"></div><input type="hidden"  id="hidden_id">';
		}

		echo $html;


	}




	public function get_call_notification(){
		$result = array('status'=>false);

		/* Checking any call for login user  */

		$wh = array('login_id'=>$this->login_id);
		$data = $this->db->get_where('login_details',$wh)->row_array();
		if($data['call_status'] == 1){
			echo json_encode($result);
			exit;
		}

		/* Get call notification */

		$where = array('to_id'=>$this->login_id);
		$data = $this->db->get_where('call_notification',$where)->row_array();
		if(!empty($data)){			

			/* If one to one call */
			if($data['type'] == 'one'){

				$wheres = array('login_id'=>$data['from_id']);
				$response = $this->db->select('login_id,first_name,last_name,profile_img,sinch_username,online_status')
				->get_where('login_details',$wheres)->row_array();
				$response['group_id'] = $data['group_id'];	
				$response['type'] = 'one';	
				$response['call_type'] = $data['call_type'];

			}else{
				/* Group Details */
				$wheres = array('group_id'=>$data['group_id']);
				$response = $this->db->get_where('chat_group_details',$wheres)->row_array();			
				/* Group Members Details */

					// $this->db->select('l.sinch_username,l.login_id,l.profile_img,l.first_name,l.last_name, cg.members_id,l.online_status');
					// $this->db->where('cg.group_id',$data['group_id']);
					// $this->db->where('cg.login_id !=',$this->login_id);
					// $this->db->join('login_details l','l.login_id = cg.login_id');
					// $response['group_members']=  $this->db->get('chat_group_members cg')->result_array();
					$response['type'] = 'many';	
					$response['call_type'] = $data['call_type'];

			}
			
			$result=array('status'=>true,'data'=>$response);
		}
		echo json_encode($result);
	}

	public function get_dummy_datas(){


		$result = array();
		$data = array();	

		if(!empty($this->session->userdata('dummy_session_id'))){
			$my_token = $this->session->userdata('dummy_token');
			$sessionId = $this->session->userdata('dummy_session_id');
			$group_id = $this->session->userdata('dummy_group_id');				

			/* Update the user is in call */				

			$this->db->update('login_details',array('call_status'=>1,'group_id'=>$group_id),array('login_id'=>$this->login_id));



		}else{

			$opentok = new OpenTok($this->apiKey, $this->apiSecret);

			$group_id = $_POST['group_id'];

			/* Update the user is in call */				
$this->db->update('login_details',array('call_status'=>1,'group_id'=>$group_id),array('login_id'=>$this->login_id));


			$where = array('g.group_id' => $_POST['group_id'],'m.login_id'=>$this->login_id);
			$data = $this->db->select('g.session_id,m.token,g.group_id')
			->join('chat_group_members m','m.group_id = g.group_id')
			->get_where('chat_group_details g',$where)
			->row_array();
		// echo '<pre>'; print_r($data); exit;

			if(!empty($data)){

				$sessionId = $data['session_id'];
				$name = $this->session->userdata('first_name').' '.$this->session->userdata('last_name');

				$responses['first_name'] = $this->session->userdata('first_name');
				$responses['last_name'] = $this->session->userdata('last_name');
				$responses['sinch_username'] = $this->session->userdata('sinch_username');
				$responses['login_id'] = $this->session->userdata('login_id');
				
									// Replace with meaningful metadata for the connection:
				$connectionMetaData = json_encode($responses);

					// Replace with the correct session ID:
				$my_token = $opentok->generateToken($sessionId,array('expireTime' => time()+(7 * 24 * 60 * 60), 'data' =>  $connectionMetaData));
				$where = array('group_id' => $data['group_id'],'login_id'=>$this->login_id);
				$this->db->update('chat_group_members',array('token'=>$my_token),$where);					
				$session_values = array('dummy_session_id' => $sessionId,'dummy_token'=>$my_token ,'dummy_group_id' =>$_POST['group_id']);
				$this->session->set_userdata($session_values);				
			}
		}

		$this->db->delete('call_notification',array('group_id' => $_POST['group_id']));

		$result = array('apiKey' => $this->apiKey,'sessionId' =>$sessionId , 'token' => $my_token,'dummy_group_id' =>$_POST['group_id']);
		echo json_encode($result);

		
	}
	public function discard_notify(){
		echo $this->db->delete('call_notification',array('group_id' => $_POST['group_id']));
	}


	public function get_chat_token(){

		




		/*Check  Login User Already in a call */
		$user = $this->db
		->get_where('login_details',array('login_id'=>$this->login_id))
		->row_array();

		if($user['call_status']==1){
			echo json_encode(array('error' => 'You are already in a call!'));
			exit;
		}	


		/* Check it is a One to One call Or Group Call */

		if(!empty($this->session->userdata('session_chat_id'))){ /* One to One */		

			


		/* Check calling user is online or in a call   */
		$user =array();
		$session_chat_id = $this->session->userdata('session_chat_id');

		$user = $this->db
		->get_where('login_details',array('login_id'=>$session_chat_id))
		->row_array();

		
		if($user['online_status']==0){ 
			echo json_encode(array('error' => $user['first_name'].' '.$user['last_name'].' is offline'));
			exit;
		}elseif($user['call_status']==1){ 
			echo json_encode(array('error' => $user['first_name'].' '.$user['last_name'].' already in a call'));
			exit;
		}	








		/* Call again in a same group  */

		if(!empty($this->session->userdata('dummy_session_id'))){
			$my_token = $this->session->userdata('dummy_token');
			$sessionId = $this->session->userdata('dummy_session_id');
			$group_id =  $this->session->userdata('dummy_group_id');
		
		$count = $this->db->get_where('chat_group_details',array('status'=>1,'group_id'=>$group_id))->num_rows();
		if($count == 0){
			echo json_encode(array('error'=>'No group'));
			exit;
		}





			/* Update in login details */
			$this->db->update('login_details',array('call_status'=>1,'group_id'=>$group_id),array('login_id'=>$this->login_id));








		}else{

			/* Make One to One new Call */ 			

			$result = array();
			$data = array();	

		

			/* Generate a Session Id  */

			$opentok = new OpenTok($this->apiKey, $this->apiSecret);
				// An automatically archived session:
			$sessionOptions = array(
				// 'archiveMode' => ArchiveMode::ALWAYS,
				'mediaMode' => MediaMode::ROUTED
			);
			$new_session = $opentok->createSession($sessionOptions);


				// Store this sessionId in the database for later use
			$sessionId = $new_session->getSessionId();





			/* Get count of group table */
			$data = $this->db
			->order_by('group_id','desc')
			->get('chat_group_details')->row_array();

			$group_id  = (!empty($data)? $data['group_id'] : 0 ); 
			$group_id++;

			$group_name = 'dummy'.$group_id;

			/* Insert Dummy entry in Group Table */
			$datas = array(
				'group_name' => $group_name,
				'type' => 'video',
				'session_id' => $sessionId,
				'created_by' => $this->login_id
			);
			$this->db->insert('chat_group_details',$datas);
			$group_id = $this->db->insert_id();


				/* Update Login User as in a Call */				

			$this->db->update('login_details',array('call_status'=>1,'group_id'=>$group_id),array('login_id'=>$this->login_id));




			$login_details = 	$this->db
			->select('first_name,last_name,sinch_username,login_id')
			->get_where('login_details',array('login_id' => $this->login_id))
			->row_array();
			$login = json_encode($login_details);

			
			// Set some options in a token
			$my_token = $new_session->generateToken(array(
				'role'       => Role::MODERATOR,
			'expireTime' => time()+(7 * 24 * 60 * 60), // in one week
			'data'       => $login
		));


			/* Insert Group members */
			$dat = array('group_id' => $group_id,'login_id' => $this->login_id,'token' => $my_token);
			$this->db->insert('chat_group_members',$dat);

			$session_values = array(
				'dummy_group_id' => $group_id,
				'dummy_group_name' => $group_name,
				'dummy_session_id' => $sessionId				
			);

			$this->session->set_userdata($session_values);

			$dats = array('group_id' => $group_id,'login_id' => $session_chat_id);
			$this->db->insert('chat_group_members',$dats);

			/* RINGING one to one call notitification to single user */
			$notify = array(
			'group_id' => $group_id,
			'from_id' => $this->login_id,
			'to_id' => $session_chat_id,						
			'call_type' => $_POST['type_of_call']
		);
			$this->db->insert('call_notification',$notify);


		}    		

			

		}elseif(!empty($this->session->userdata('session_group_id'))){ /* Group Call */

			$group_id = $this->session->userdata('session_group_id');



			$count = $this->db->get_where('chat_group_details',array('status'=>1,'group_id'=>$group_id))->num_rows();
		if($count == 0){
			echo json_encode(array('error'=>'No group'));
			exit;
		}





			/* Get the session id  from group  table */

			$sessionId = $this->db->get_where('chat_group_details',array('group_id'=>$group_id))->row()->session_id;


				$responses['first_name'] = $this->session->userdata('first_name');
				$responses['last_name'] = $this->session->userdata('last_name');
				$responses['sinch_username'] = $this->session->userdata('sinch_username');
				$responses['login_id'] = $this->session->userdata('login_id');
				
									// Replace with meaningful metadata for the connection:
				$connectionMetaData = json_encode($responses);



			/* Generate as token */
			$opentok = new OpenTok($this->apiKey, $this->apiSecret);
		 	// Replace with the correct session ID:
			$my_token = $opentok->generateToken($sessionId,array('expireTime' => time()+(7 * 24 * 60 * 60), 'data' =>  $connectionMetaData));


			/* Update in login details */
			$this->db->update('login_details',array('call_status'=>1,'group_id'=>$group_id),array('login_id'=>$this->login_id));


			$members = $this->db							
							->join('login_details l','l.login_id = m.login_id')
							->get_where('chat_group_members m',array('m.group_id'=>$group_id,'m.login_id !=' =>$this->login_id))
							->result_array();

			if(!empty($members)){

				foreach ($members as $m) {

						/* Make call notification to group members */


						/* Check calling user is online or in a call   */
						$user =array();
						$user_login_id = $m['login_id'];

						$user = $this->db
						->get_where('login_details',array('login_id'=>$user_login_id))
						->row_array();


						if($user['online_status'] !=0 && $user['call_status']!=1){

							/* RINGING Group call notitification to  user */
							$notify = array(
							'group_id' => $group_id,
							'from_id' => $this->login_id,
							'to_id' => $user_login_id,
							'type' => 'group',
							'call_type' => $_POST['type_of_call']
							);
							$this->db->insert('call_notification',$notify);												
						}
				}
			}
		}

		$result = array('apiKey' => $this->apiKey,'sessionId' =>$sessionId , 'token' => $my_token ,'dummy_group_id' => $group_id);
		echo json_encode($result);	

	}

	public function set_chat_user(){

	

		$this->session->set_userdata(array('session_group_id'=>''));
		$this->session->set_userdata(array('session_chat_id'=>$_POST['login_id']));
		$latest_chats= $this->chat->get_latest_chat($total=null);  
		$total_chat= $this->chat->get_total_chat_count(); 

		$page=0;
		if($total_chat>5){
			$total_chat = $total_chat - 5;
			$page = $total_chat / 5;
			$page = ceil($page);
			$page--;
		}


		if(count($latest_chats)>4){

			$html ='<div class="load-more-btn text-center" total="'.$page.'">
			<button class="btn btn-default" data-page="2"><i class="fa fa-refresh"></i> Load More</button>
			</div><div class="ajax_old"></div>';      
		}else{
			$html ='';
		}


		if(!empty($latest_chats)){

			foreach($latest_chats as $l){
				$sender_name = $l['sender_name'];
				$sender_profile_img = (!empty($l['sender_profile_image']))?base_url().'uploads/'.$l['sender_profile_image'] : base_url().'assets/img/user.jpg';
				$msg = $l['message'];
				$type = $l['type'];
				$file_name = base_url().$l['file_path'].'/'.$l['file_name'];
				$time = date('h:i A',strtotime($l['chatdate']));
				$up_file_name =$l['file_name'];

				if($l['sender_id'] == $this->login_id){
					$class_name = 'chat-right';
					$img_avatar='';
				}else{
					$img_avatar = '<div class="chat-avatar">
					<a href="#" class="avatar">
					<img alt="'.$sender_name.'" title="'.ucfirst($sender_name).'" src="'.$sender_profile_img.'" class="img-responsive img-circle">
					</a>
					</div>';
					$class_name = 'chat-left';
				}
				if($msg == 'file' && $type == 'image'){

					$html .= '<div class="chat '.$class_name.'">'.$img_avatar.'
					<div class="chat-body">
					<div class="chat-bubble">
					<div class="chat-content img-content">
					<div class="chat-img-group clearfix">
					<a class="chat-img-attach" href="'.$file_name.'" target="_blank">
					<img width="182" height="137" alt="" src="'.$file_name.'">
					<div class="chat-placeholder">
					<div class="chat-img-name">'.$up_file_name.'</div>
					</div>
					</a>
					</div>
					<span class="chat-time">'.$time.'</span>
					</div>               
					</div>
					</div>
					</div>';

				}else if($msg == 'file' && $type == 'others'){

					$html .= '<div class="chat '.$class_name.'">'.$img_avatar.'
					<div class="chat-body">
					<div class="chat-bubble">
					<div class="chat-content "><ul class="attach-list">
					<li><i class="fa fa-file"></i><a href="'.$file_name.'">'.$up_file_name.'</a></li>
					</ul>
					<span class="chat-time">'.$time.'</span>       
					</div>
					</div>
					</div>
					</div>';

				}else{

					$html .= '<div class="chat '.$class_name.'">'.$img_avatar.'
					<div class="chat-body">
					<div class="chat-bubble">
					<div class="chat-content">
					<p>'.$msg.'</p>         
					<span class="chat-time">'.$time.'</span>
					</div>
					</div>
					</div>
					</div>';
				}														
			}

		}

		$html .='<div class="ajax"></div><input type="hidden"  id="hidden_id">';

		if($total_chat == 0){
			$html .='<div class="no_message"></div>';
		}






		$this->db->update('chat_details',array('read_status'=>1),array('receiver_id' => $this->login_id,'sender_id' =>$_POST['login_id']));

		$data = $this->db
		->select('l.phone_number,l.email,l.dob,l.first_name,l.last_name,l.login_id,l.online_status,l.sinch_username,l.profile_img,d.department_name')
		->join('department_details d','d.department_id = l.department_id','left')
		->get_where('login_details l',array('l.login_id'=>$_POST['login_id']))
		->row_array();

		$data['first_name'] = ucfirst($data['first_name']);
		$data['last_name'] =ucfirst($data['last_name']);
		$data['dob'] =(!empty($data['dob']) && $data['dob']!='0000-00-00')?date('d-m-Y',strtotime($data['dob'])):'N/A';

		if(empty($data['profile_img'])){
			$data['profile_img'] = base_url().'assets/img/user.jpg';
		}else{
			$data['profile_img'] = base_url().'uploads/'.$data['profile_img'];
		}
		$data['messages'] = $html;
		$data['call_history'] =$this->chat->get_call_history();
		echo json_encode($data);
	}

	Public function insert_chat()
	{	

		  // echo '<pre>'; print_r($_POST); exit;
		if($_POST['message_type'] == 'group'){
				
			$data['receiver_id'] = 0;
			$data['sender_id'] = $this->login_id;
			$data['time_zone'] = $this->session->userdata('time_zone');
			$data['chatdate'] = date('Y-m-d H:i:s');
			$data['message'] = $_POST['message'];
			$data['message_type'] = 'group';
			$data['group_id'] = (!empty($_POST['group_id']))?$_POST['group_id']:'';
			$result = $this->db->insert('chat_details',$data);
			$chat_id = $this->db->insert_id();
			$users = array($data['receiver_id'],$data['sender_id']);
			$wher = array('login_id !='=>$this->login_id ,'group_id'=>$data['group_id']);
			$userid_list = $this->db->select('login_id')->get_where('chat_group_members',$wher)->result_array();
			if(!empty($userid_list)){
				foreach($userid_list as $u){
					$insert_data = array('group_id'=>$data['group_id'],'login_id'=>$u['login_id']);
					$this->db->insert('chat_seen_details',$insert_data);

					$datas = array('chat_id' =>$chat_id ,'can_view'=>$u['login_id'],'group_id'=>$_POST['group_id']);
					$this->db->insert('chat_deleted_details',$datas);


				}
			}	
			exit;	

		}elseif($_POST['message_type'] == 'text'){

			$data['receiver_id'] =$_POST['receiver_id'];
			$data['sender_id'] = $this->login_id;
			$data['time_zone'] = $this->session->userdata('time_zone');
			$data['chatdate'] = date('Y-m-d H:i:s');
			$data['message'] = $_POST['message'];
			$data['message_type'] = 'text';
			$data['group_id'] = 0;

			$result = $this->db->insert('chat_details',$data);
			$chat_id = $this->db->insert_id();
			$users = array($data['receiver_id'],$data['sender_id']);
			for ($i=0; $i <2 ; $i++) { 
				$datas = array('chat_id' =>$chat_id ,'can_view'=>$users[$i]);
				$this->db->insert('chat_deleted_details',$datas);
			}
		}
		echo json_encode($users);

	}
	public function delete_conversation()
	{

	// echo '<pre>'; print_r($_POST);

		$selected_user = $_POST['sender_id'];

		if(!empty($_POST['group_id'])){

			$this->db->delete('chat_seen_details',array('login_id'=>$this->login_id,'group_id' => $_POST['group_id'])); 
		}else{

			$data = $this->chat->deletable_chats();
			if(!empty($data)){
				foreach ($data as $d) {
					$this->db->delete('chat_deleted_details',array('chat_id'=>$d['chat_id'],'can_view'=>$this->login_id)); 
				}  
			}

		}

    // echo $this->db->last_query();
		echo '1';
	}


	Public function get_message_details()
	{

		// echo '<pre>'; print_r($_POST);exit;
		/*Receiver data */
		$data= $this->db
		->select('first_name,last_name,login_id,sinch_username')
		->get_where('login_details',array('sinch_username'=>$_POST['receiver_sinchusername']))
		->row_array();

		/*Message*/
		$msg['msg_data'] = $this->db
		->select('c.chat_id,c.message_type,c.message,c.receiver_id,c.sender_id,c.chatdate,c.file_path,c.file_name,
			c.read_status,
			c.time_zone,
			c.type,
			c.status'

		)
		->order_by('c.chat_id','desc')		
		->get_where('chat_details c',array('c.sender_id'=>$data['login_id']))
		->row_array();



		if($msg['msg_data']['message_type'] == 'group'){
			$msg['msg_data'] = '';
			$msg['msg_data'] = $this->db
			->select('c.chat_id,c.group_id,c.message_type,c.message,c.receiver_id,c.sender_id,c.chatdate,c.file_path,c.file_name,
				c.read_status,
				c.time_zone,
				c.type,
				c.status,
				g.group_name'
			)
			->order_by('c.chat_id','desc')
			->join('chat_group_details g','g.group_id = c.group_id')
			->get_where('chat_details c',array('c.sender_id'=>$data['login_id']))
			->row_array();
			$msg['msg_data']['group_name'] = ucfirst($msg['msg_data']['group_name']);
			$msg['msg_data']['new_group_name'] = str_replace(' ','_',$msg['msg_data']['group_name']);




			$where = array('login_id'=>$this->login_id ,'read_status'=>'0','group_id' =>$msg['msg_data']['group_id']);
			$msg['count'] = $this->db
			->get_where('chat_seen_details',$where)
			->num_rows();		


		}else{


			$where = array('sender_id'=>$data['login_id'] ,'receiver_id' =>$this->login_id,'read_status'=>0,'message_type' =>'group');
			$msg['count'] = $this->db
			->get_where('chat_details',$where)
			->num_rows();

			$where = array('c.sender_id'=>$data['login_id'] ,'c.receiver_id' =>$this->login_id,'c.read_status'=>0,'c.message_type' =>'group');


			$this->db->update('chat_details',array('read_status'=>1,'message_type'=>'text'),array('chat_id'=>$msg['msg_data']['chat_id']));		

		}




		$msg['reciever_data'] = $data;
		echo json_encode($msg);
	}


	Public function get_user_details(){

		//echo '<pre>';print_r($_POST);exit;
		$data = array();
		$where =array('sinch_username'=>$_POST['receiver_sinchusername']);
		$data= $this->db
		->select('first_name,last_name,login_id,sinch_username,online_status,profile_img')
		->get_where('login_details',$where)
		->row_array();

		$data['profile_img'] = (!empty($data['profile_img']))?base_url().'uploads/'.$data['profile_img']:base_url().'assets/img/user.jpg';

		$data['first_name'] = ucfirst($data['first_name']); 
		$data['last_name'] = ucfirst($data['last_name']); 	


		if($_POST['message_type'] == 'group'){




			$where = array(
				'c.sender_id'=>$data['login_id'],
				'receiver_id' =>0,
				'c.read_status'=>0,
				'c.message_type' => $_POST['message_type']
			);
			$data['message'] = $this->db
			->order_by('chat_id','desc')
			->join('chat_group_details cg','c.group_id = cg.group_id ')
			->get_where('chat_details c',$where)
			->row_array();


			$data['message']['group_name'] = ucfirst($data['message']['group_name']);
			$data['message']['new_group_name'] = str_replace(' ','_',$data['message']['group_name']);
			$group_id = $_POST['group_id'];

		// echo '<pre>';
		// print_r($data['message']);


			$sinch_users=array();

			$wheres = array('g.new_user' => 1 ,'g.group_id' => $group_id);
			$sinch_users=$this->db
			->select('l.sinch_username,l.first_name,l.last_name,l.login_id,l.profile_img')
			->join('login_details l','l.login_id = g.login_id')
			->get_where('chat_group_members g',$wheres)
			->result_array();
			$data['message']['new_group_members']=$sinch_users;

		// echo '<pre>';
		// print_r($data);
		// exit;

			$where = array(
				'login_id'=>$this->login_id ,
				'group_id' =>$group_id,
				'read_status'=>'0'				
			);
			$data['count'] = $this->db
			->get_where('chat_seen_details',$where)
			->num_rows();


		}else{


			$where = array('sender_id'=>$data['login_id'] ,'receiver_id' =>$this->login_id,'read_status'=>0,'message_type' => $_POST['message_type']);
			$data['count'] = $this->db
			->get_where('chat_details',$where)
			->num_rows();



			$where = array('sender_id'=>$data['login_id'] ,'receiver_id' =>$this->login_id,'read_status'=>0,'message_type' => $_POST['message_type']);
			$data['message'] = $this->db
			->order_by('chat_id','desc')
			->get_where('chat_details',$where)
			->row_array();


		}




		// $data['msg'] = $this->db->get_where('chat_details',array('chat_id',$_POST['']))->row_array();

		echo json_encode($data);
	}

	public function upload_files()
	{

		$path = "uploads/".$this->login_id;
		if(!is_dir($path)){
			mkdir($path);
		}

		$target_file =$path . basename($_FILES["userfile"]["name"]);
		$file_type = pathinfo($target_file,PATHINFO_EXTENSION);

		if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif" ){
			$type = 'others';
		}else{
			$type = 'image';
		}


		$config['upload_path']   = './'.$path;
		$config['allowed_types'] = '*';		
		$this->load->library('upload',$config);

		if($this->upload->do_upload('userfile')){	
			$file_name=$this->upload->data('file_name');	

			if($_POST['message_type'] == 'text'){

				$data = array(
					'receiver_id' =>$_POST['receiver_id'],
					'sender_id' => $this->login_id,
					'message' =>'file',
					'file_name'=>$file_name,		
					'chatdate' => date('Y-m-d H:i:s'),
					'type' =>$type,
					'read_status' =>0,
					'time_zone' =>$this->session->userdata('time_zone'),
					'file_path' => $path,
					'message_type' =>'text'				
				);			

				$result = $this->db->insert('chat_details',$data);
				$chat_id = $this->db->insert_id();
				$users = array($data['receiver_id'],$data['sender_id']);
				for ($i=0; $i <2 ; $i++) { 
					$datas = array('chat_id' =>$chat_id ,'can_view'=>$users[$i]);
					$this->db->insert('chat_deleted_details',$datas);
				}

			}else{

				$data = array(
					'group_id' =>$_POST['group_id'],
					'receiver_id' =>0,
					'sender_id' => $this->login_id,
					'message' =>'file',
					'file_name'=>$file_name,		
					'chatdate' => date('Y-m-d H:i:s'),
					'type' =>$type,
					'message_type'=>'group',
					'read_status' =>0,
					'time_zone' =>$this->session->userdata('time_zone'),
					'file_path' => $path				
				);			

				$result = $this->db->insert('chat_details',$data);



			}


			echo  json_encode(array('img'=>$path.'/'.$file_name,'type'=>$type,'file_name' => $file_name));
		}else{
			echo  json_encode(array('error'=>$this->upload->display_errors()));
		}
	}


	public function get_messages()
	{

		$selected_user = $_POST['selected_user_id'];
		$latest_chat= $this->chat->get_latest_chat($selected_user,$session_id);  
		$total_chat= $this->chat->get_total_chat_count($selected_user,$session_id);  

		echo '<pre>'; 
		print_r($latest_chat); 
		exit;


		if($total_chat>5){
			$total_chat = $total_chat - 5;
			$page = $total_chat / 5;
			$page = ceil($page);
			$page--;
		}



  // echo $this->db->last_query();
  // exit;

		if(count($latest_chat)>4){

			$html ='<div class="load-more-btn text-center" total="'.$page.'">
			<button class="btn btn-default" data-page="2"><i class="fa fa-refresh"></i> Load More</button>
			</div><div class="ajax_old"></div>';      
		}else{
			$html ='';
		}



		if(!empty($latest_chat)){
			foreach($latest_chat as $key => $currentuser) : 


				$class_name =($currentuser['sender_id'] != $session_id) ? 'chat-left' : '';
				$user_image = ($currentuser['senderImage']!= '') ? base_url().'assets/images/'.$currentuser['senderImage']: base_url().'assets/images/default-avatar.png';


				if($currentuser['senderImage']!=''){
					$img =  base_url().'assets/images/'.$currentuser['senderImage'];
				}elseif($currentuser['socialImage']!=''){
					$img = $currentuser['socialImage'];
				}else{
					$img = base_url().'assets/images/default-avatar.png';
				}


				$time_zone = $this->session->userdata('time_zone');
				$from_timezone = $currentuser['time_zone'];
				$date_time = $currentuser['chatdate'];
				$date_time  = $this->converToTz($date_time,$time_zone,$from_timezone);
				$time = date('h:i a',strtotime($date_time));


				if($currentuser['type'] == 'image'){

					$html .='<div class="chat '.$class_name.'">
					<div class="chat-avatar">
					<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
					<img  src="'.$img.'" class="img-responsive img-circle">
					</a>
					</div>
					<div class="chat-body">
					<div class="chat-content">
					<p><img alt="" src="'.base_url().$currentuser['file_path'].'/'.$currentuser['file_name'].'" class="img-responsive"></p>
					<p>'.$currentuser['file_name'].'</p>
					<a href="'.base_url().$currentuser['file_path'].'/'.$currentuser['file_name'].'" target="_blank" download>Download</a>
					<span class="chat-time">'.$time.'</span>
					</div>
					</div>
					</div>';

				}else if($currentuser['type'] == 'others'){

					$html .='<div class="chat '.$class_name.'">
					<div class="chat-avatar">
					<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
					<img  src="'.$img.'" class="img-responsive img-circle">
					</a>
					</div>
					<div class="chat-body">
					<div class="chat-content">
					<p><img alt="" src="'.base_url().'assets/images/download.png" class="img-responsive"></p>
					<p>'.$currentuser['file_name'].'</p>
					<a href="'.base_url().$currentuser['file_path'].'/'.$currentuser['file_name'].'" target="_blank" download class="chat-time">Download</a>
					<span class="chat-time">'.$time.'</span>
					</div>
					</div>
					</div>';


				}
				else if($currentuser['msg']=='ENABLE_STREAM' || $currentuser['msg']=='DISABLE_STREAM'){


				}else{
					$html .='<div class="chat '.$class_name.'">
					<div class="chat-avatar">
					<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
					<img  src="'.$img.'" class="img-responsive img-circle">
					</a>
					</div>
					<div class="chat-body">
					<div class="chat-content">
					<p>
					'.$currentuser['msg'].'
					</p>
					<span class="chat-time">'.$time.'</span>
					</div>
					</div>
					</div>';

				}




			endforeach;


		}
		$html .='<div class="ajax"></div><input type="hidden"  id="hidden_id">';

		if($total_chat == 0){
			$html .='<div class="no_message"></div>';
		}


		echo $html;

	}
	public function get_all_users(){
		$users = array();
		$data = $this->db->select('user_name,first_name,last_name')
		->get_where('login_details',array('type'=>'user','login_id !='=>$this->login_id))
		->result_array();
		if(!empty($data)){
			foreach($data as $d){
				$users[] = $d['user_name'];
				//$users['text'] = ucfirst($d['first_name']).' '.ucfirst($d['last_name']);
				//$datas[]=$users;
			}

		}
		echo json_encode($users);
	}







}

/* End of file  */
/* Location: ./application/controllers/ */