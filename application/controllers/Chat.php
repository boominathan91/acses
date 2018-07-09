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
		$data['latest_chats'] = $this->chat->get_latest_chat();
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

		$this->db->update('chat_details',array('read_status'=>1),array('chat_id'=>$msg['msg_data']['chat_id']));		

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