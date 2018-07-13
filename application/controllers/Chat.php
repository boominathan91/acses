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

		$page = $this->session->userdata('page');
		$data['profile_class'] = "hidden";
		$data['text_chat_class'] = "hidden";
		$data['audio_class'] = "hidden";
		$data['video_class'] = "hidden";
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
				default:
				$data['profile_class'] = '';
				break;
			}
		}else{
			$data['profile_class']  = "";
		}
		$data['title'] = 'Chat';		
		$data['text_group'] = $this->chat->get_text_group();
		$data['call_history'] = $this->chat->get_call_history();
		$data['page'] = $this->chat->get_page_no();
		$data['chat'] = $this->chat->get_chat_data();
		$data['latest_chats'] = $this->chat->get_latest_chat();
		$data['profile'] = $this->chat->get_profile_data();
		$data['chat_users'] = $this->chat->get_chated_users();
		// echo '<pre>';print_r($data);exit;
		render_page('chat',$data);
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
			return  $this->db->insert('call_details',$data);
		}
	}
	public function set_nav_bar(){
		$page = array();
		if(!empty($_POST['page'])){
			$page = array('page'=>$_POST['page']);
			$this->session->set_userdata($page);
		}
		echo json_encode($page);
	}
	public function get_caller_details(){
		$where = array('sinch_username' => $_POST['sinch_username']);
		$data = $this->db
		->select('first_name,last_name,login_id as call_from_id,sinch_username,profile_img')
		->get_where('login_details',$where)
		->row_array();
		$data['name'] = ucfirst($data['first_name']).' '.ucfirst($data['last_name']);
		$data['profile_img'] = (!empty($data['profile_img']))?base_url().'uploads/'.$data['profile_img'] : base_url().'assets/img/user.jpg';
		$data['call_to_id'] = $this->login_id;
		echo json_encode($data);
	}
	public function get_group_datas(){
		$group_id = $_POST['group_id'];
		$this->session->set_userdata(array('session_chat_id'=>''));		
		$data = $this->chat->get_group_datas($group_id);
		$total_chat= $this->chat->get_total_chat_group_count($group_id); 



		$this->session->set_userdata(array('session_group_id'=>$group_id));
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
			</div><div id="ajax_old"></div>';      
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

					$html .= '<div class="chat '.$class_name.' slimscrollleft">'.$img_avatar.'
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

					$html .= '<div class="chat '.$class_name.' slimscrollleft">'.$img_avatar.'
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

					$html .= '<div class="chat '.$class_name.' slimscrollleft">'.$img_avatar.'
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

		$html .='<div id="ajax"></div><input type="hidden"  id="hidden_id">';

		if($total_chat == 0){
			$html .='<div class="no_message">No Record Found</div>';
		}
		$data['messages'] = $html;


		echo json_encode($data);
	}
	public function create_group(){

		$this->session->set_userdata(array('session_chat_id'=>''));
		$data = array('group_name' => $_POST['group_name'],'type' => $_POST['type']);
		$count = $this->db->get_where('chat_group_details',$data)->num_rows();
		if($count!=0){
			$result = array('error'=>'Group name already taken!');		
			
		}else{

			$this->db->insert('chat_group_details',$data);
			$group_id = $this->db->insert_id();
			$this->session->set_userdata(array('session_group_id'=>$group_id));

			$member = explode(',',$_POST['members']);
			for ($i=0; $i <count($member) ; $i++) { 
				$user = $this->db->get_where('login_details',array('user_name'=>$member[$i],'status'=>1))->row_array();
				$sinch_usernames[]=$user['sinch_username'];
				$datas = array(
					'group_id' => $group_id,
					'login_id' => $user['login_id']
				);
				$this->db->insert('chat_group_members',$datas);	
			}
			$sinch_usernames = implode(',',$sinch_usernames);
			$datas = array(
				'group_id' => $group_id,
				'login_id' => $this->login_id
			);
			$this->db->insert('chat_group_members',$datas);	
			$result = array(
				'success'=>'Group created successfully!',
				'group_name' => ucfirst($_POST['group_name']),
				'group_id'=>$group_id,
				'sinch_username' => $sinch_usernames
			);
			
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

					$html .= '<div class="chat '.$class_name.' slimscrollleft">'.$img_avatar.'
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

					$html .= '<div class="chat '.$class_name.' slimscrollleft">'.$img_avatar.'
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

					$html .= '<div class="chat '.$class_name.' slimscrollleft">'.$img_avatar.'
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
			$html .='<div id="ajax"></div><input type="hidden"  id="hidden_id">';
		}

		echo $html;
		

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
			</div><div id="ajax_old"></div>';      
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

					$html .= '<div class="chat '.$class_name.' slimscrollleft">'.$img_avatar.'
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

					$html .= '<div class="chat '.$class_name.' slimscrollleft">'.$img_avatar.'
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

					$html .= '<div class="chat '.$class_name.' slimscrollleft">'.$img_avatar.'
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

		$html .='<div id="ajax"></div><input type="hidden"  id="hidden_id">';

		if($total_chat == 0){
			$html .='<div class="no_message">No Record Found</div>';
		}




		

		$this->db->update('chat_details',array('read_status'=>1),array('receiver_id' => $this->login_id,'sender_id' =>$_POST['login_id']));
		
		$data = $this->db
		->select('l.phone_number,l.email,l.dob,l.first_name,l.last_name,l.login_id,l.online_status,l.sinch_username,l.profile_img,d.department_name')
		->join('department_details d','d.department_id = l.department_id')
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
		echo json_encode($data);
	}

	Public function insert_chat()
	{	

		 // echo '<pre>'; print_r($_POST); exit;
		if( $_POST['message_type'] == 'group'){

			$receiver_id =explode(',',$_POST['receiver_id']);
			
				//$data['receiver_id'] = $receiver_id[$j];	
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


			

		}elseif( $_POST['message_type'] == 'text'){

			$data['receiver_id'] =$_POST['receiver_id'];
			$data['sender_id'] = $this->login_id;
			$data['time_zone'] = $this->session->userdata('time_zone');
			$data['chatdate'] = date('Y-m-d H:i:s');
			$data['message'] = $_POST['message'];
			$data['message_type'] = 'text';
			$data['group_id'] = (!empty($_POST['group_id']))?$_POST['group_id']:'';

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


		$selected_user = $_POST['sender_id'];


		$data = $this->chat->deletable_chats();
		if(!empty($data)){
			foreach ($data as $d) {
				$this->db->delete('chat_deleted_details',array('chat_id'=>$d['chat_id'],'can_view'=>$this->login_id)); 
			}  
		}
    // echo $this->db->last_query();
		echo '1';
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


		$where = array('sender_id'=>$data['login_id'] ,'receiver_id' =>$this->login_id,'read_status'=>0,'message_type' =>'group');
		$msg['count'] = $this->db
		->get_where('chat_details',$where)
		->num_rows();

		$where = array('c.sender_id'=>$data['login_id'] ,'c.receiver_id' =>$this->login_id,'c.read_status'=>0,'c.message_type' =>'group');

		
		$this->db->update('chat_details',array('read_status'=>1,'message_type'=>'text'),array('chat_id'=>$msg['msg_data']['chat_id']));		

		$msg['reciever_data'] = $data;
		echo json_encode($msg);
	}
	Public function get_user_details(){

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
				'sender_id'=>$data['login_id'] ,
				'receiver_id' =>0,
				'read_status'=>0,
				'message_type' => $_POST['message_type']
			);
			$data['count'] = $this->db
			->get_where('chat_details',$where)
			->num_rows();



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



		ob_flush();		

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
					'file_path' => $path				
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
			</div><div id="ajax_old"></div>';      
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
		$html .='<div id="ajax"></div><input type="hidden"  id="hidden_id">';

		if($total_chat == 0){
			$html .='<div class="no_message">No Record Found</div>';
		}


		echo $html;

	}







}

/* End of file  */
/* Location: ./application/controllers/ */