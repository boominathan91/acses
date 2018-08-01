<?php   

$light_logo = $this->session->userdata('light_logo');
if(!empty($light_logo)){
	$light_logo = 'uploads/'.$light_logo;
}else{
	$light_logo = 'assets/img/logo.png';
}

$website_name = $this->session->userdata('website_name');

$session_data = $this->session->userdata();


?>


<div class="header">
	<div class="header-left">
		<a href="#" class="logo">
			<img src="<?php echo base_url().$light_logo; ?>" width="40" height="40" alt="">
		</a>
	</div>
	<div class="page-title-box pull-left">
		<h3 class="website_name"><?php 
		echo (!empty($website_name))?$website_name:'Focus Technologies'; ?>
	</h3>
</div>
<a id="mobile_btn" class="mobile_btn pull-left" href="#sidebar"><i class="fa fa-bars" aria-hidden="true"></i></a>
<ul class="nav navbar-nav navbar-right user-menu pull-right">
	<!-- <li class="dropdown hidden-xs">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell-o"></i> <span class="badge bg-purple pull-right">3</span></a>
		<div class="dropdown-menu notifications">
			<div class="topnav-dropdown-header">
				<span>Notifications</span>
			</div>
			<div class="drop-scroll">
				<ul class="media-list">
					<li class="media notification-message">
						<a href="activities">
							<div class="media-left">
								<span class="avatar">
									<img alt="John Doe" src="<?php echo base_url(); ?>assets/img/user.jpg" class="img-responsive img-circle">
								</span>
							</div>
							<div class="media-body">
								<p class="m-0 noti-details"><span class="noti-title">John Doe</span> added new task <span class="noti-title">Patient appointment booking</span></p>
								<p class="m-0"><span class="notification-time">4 mins ago</span></p>
							</div>
						</a>
					</li>
					<li class="media notification-message">
						<a href="activities">
							<div class="media-left">
								<span class="avatar">V</span>
							</div>
							<div class="media-body">
								<p class="m-0 noti-details"><span class="noti-title">Tarah Shropshire</span> changed the task name <span class="noti-title">Appointment booking with payment gateway</span></p>
								<p class="m-0"><span class="notification-time">6 mins ago</span></p>
							</div>
						</a>
					</li>
					<li class="media notification-message">
						<a href="activities">
							<div class="media-left">
								<span class="avatar">L</span>
							</div>
							<div class="media-body">
								<p class="m-0 noti-details"><span class="noti-title">Misty Tison</span> added <span class="noti-title">Domenic Houston</span> and <span class="noti-title">Claire Mapes</span> to project <span class="noti-title">Doctor available module</span></p>
								<p class="m-0"><span class="notification-time">8 mins ago</span></p>
							</div>
						</a>
					</li>
					<li class="media notification-message">
						<a href="activities">
							<div class="media-left">
								<span class="avatar">G</span>
							</div>
							<div class="media-body">
								<p class="m-0 noti-details"><span class="noti-title">Rolland Webber</span> completed task <span class="noti-title">Patient and Doctor video conferencing</span></p>
								<p class="m-0"><span class="notification-time">12 mins ago</span></p>
							</div>
						</a>
					</li>
					<li class="media notification-message">
						<a href="activities">
							<div class="media-left">
								<span class="avatar">V</span>
							</div>
							<div class="media-body">
								<p class="m-0 noti-details"><span class="noti-title">Bernardo Galaviz</span> added new task <span class="noti-title">Private chat module</span></p>
								<p class="m-0"><span class="notification-time">2 days ago</span></p>
							</div>
						</a>
					</li>
				</ul>
			</div>
			<div class="topnav-dropdown-footer">
				<a href="activities">View all Notifications</a>
			</div>
		</div>
	</li>
	<li class="dropdown hidden-xs">
		<a href="javascript:;" id="open_msg_box" class="hasnotifications"><i class="fa fa-comment-o"></i> <span class="badge bg-purple pull-right">8</span></a>
	</li>-->	
	<li class="dropdown">
		<?php 
		$profile_img = $this->session->userdata('profile_img');
		$profile_img = !empty($profile_img)?'uploads/'.$profile_img:'assets/img/user.jpg';
		?>
		<a href="#" class="dropdown-toggle user-link" data-toggle="dropdown" title="<?php echo ucfirst($this->session->userdata('first_name')); ?>">
			<span class="user-img"><img class="img-circle" src="<?php echo base_url().$profile_img; ?>" width="40" alt="<?php echo ucfirst($this->session->userdata('first_name')); ?>">
				<span class="status online"></span></span>
				<span><?php echo ucfirst($this->session->userdata('first_name')); ?></span>
				<i class="caret"></i>
			</a>
			<ul class="dropdown-menu">				
				<?php if(strtolower($session_data['type']) == 'admin'){ ?>
					<li><a href="<?php echo base_url(); ?>company-settings">Settings</a></li>
				<?php }else{ ?>
					<li><a href="<?php echo base_url(); ?>edit-profile">Edit Profile</a></li>
				<?php } ?>			
				
				<li><a href="<?php echo base_url(); ?>logout">Logout</a></li>
			</ul>
		</li>
	</ul>
	<div class="dropdown mobile-user-menu pull-right">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
		<ul class="dropdown-menu pull-right">
						<!-- <li><a href="#">My Profile</a></li>
							<li><a href="#">Edit Profile</a></li> -->
							<?php if(strtolower($session_data['type']) == 'admin'){ ?>
								<li><a href="<?php echo base_url(); ?>company-settings">Settings</a></li>
							<?php }else{ ?>
								
								<li><a href="<?php echo base_url(); ?>edit-profile">Edit Profile</a></li>
							<?php } ?>			
							<li><a href="<?php echo base_url(); ?>login">Logout</a></li>
						</ul>
					</div>
				</div>

				<div class="sidebar" id="sidebar">
					<div class="sidebar-inner slimscroll">
						<div class="sidebar-menu">
							
							<?php $uri = $this->uri->segment(1);	

								if($uri == 'edit-profile'){

									echo '<ul>
											<li> 
										<a href="'.base_url().'chat" page="profile" onclick="navigate(this)"><i class="fa fa-home"></i> Back to Home</a>
									</li>';

								}else{

								
							?>

							<ul class="profile <?php echo $profile_class; ?>">		
								<li id="profile"><a href="javascript:void(0)" page="profile">Profile</a></li>			
								<li><a href="javascript:void(0)" page="text_chat" onclick="navigate(this)">Chat</a></li>
								<li><a href="javascript:void(0)" page="audio" onclick="navigate(this)">Audio Call</a></li>
								<li><a href="javascript:void(0)" page="video" onclick="navigate(this)">Video Call</a></li>	
								<li><a href="javascript:void(0)" page="screen_share" onclick="navigate(this)">Screen Share</a></li>							
							</ul>

							<ul>
								<div  class="text_chat <?php echo $text_chat_class; ?>">									
									<!-- Text Chat  -->	
									<li> 
										<a href="javascript:void(0)" page="profile" onclick="navigate(this)"><i class="fa fa-home"></i> Back to Home</a>
									</li>

									<li class="menu-title" id="text_chat" onclick="set_group_type(1)">Chat Groups <a href="#" data-toggle="modal" data-target="#add_group"><i class="fa fa-plus"></i></a></li>
									<!-- Session selected user  -->
									<div id="session_group_text"></div>	
									<!-- Newly Messaged user  -->
									<div id="new_group_user"></div>

									<div id="other_groups">

										<?php if(!empty($text_group)){ 
											foreach($text_group['groups'] as $t){


												$login_id = $this->session->userdata('login_id');
												$where = array(
													'group_id' => $t['group_id']
													,'login_id' =>$login_id,
													'read_status' =>'0'
												);
												$count = $this->db->get_where('chat_seen_details',$where)->num_rows();
												$count = ($count!=0)?$count:'';
												if(!empty($this->session->userdata('session_group_id'))){
													$class = ($this->session->userdata('session_group_id') == $t['group_id'])?'class="active"':'';
												}else{
													$class = '';	
												}

												$new_group_name = str_replace(' ','_',$t['group_name']);
												echo '<li '.$class.' id="'.ucfirst($new_group_name).'" onclick="set_nav_bar_group_user('.$t['group_id'].',this)" type="group_text_chat"><a href="javascript:void(0)" >#'.ucfirst($t['group_name']).'<span class="badge bg-danger pull-right" id="'.ucfirst($new_group_name).'danger">'.$count.'</span></a></li>';
											}
										} ?>
									</div>

									<li class="menu-title">Direct Chats <a href="javascript:void(0);" onclick="modal_open('text_chat')"><i class="fa fa-plus"></i></a></li>
									<!-- Session selected user  -->
									<div id="session_chat_user" class="session_chat_user">




										<?php 										
	// error_reporting(0);
										$name = '';
										$class = 'hidden';
										$online_status = 'online';
										$receiver_profile_img ='';
										$receiver_id = '';
										$receiver_sinchusername = '';
										$department_name = '';
										$dob ='';
										$receiver_email = '';
										$phone_number = '';
										$mesage_type='';
										$group_id = 0;
										$task_class = ''; 


										if(!empty($this->session->userdata('session_chat_id'))){
											$name = ucfirst($chat['first_name']).' '.ucfirst($chat['last_name']);
											$class = '';
											$online_status = ($chat['online_status'] == 1)?'online':'offline';
											$receiver_profile_img = (!empty($chat['profile_img']))?base_url().'uploads/'.$chat['profile_img']:base_url().'assets/img/user.jpg';
											$receiver_id = $chat['login_id'];
											$receiver_email = $chat['email'];
											$phone_number = $chat['phone_number'];
											$receiver_sinchusername = $chat['sinch_username'];
											$department_name = $chat['department_name'];
											$dob = $data['dob'] =(!empty($data['dob']) && $data['dob']!='0000-00-00')?date('d-m-Y',strtotime($data['dob'])):'N/A';
											$mesage_type = 'text';
											$task_class = ''; 

										}else if(!empty($this->session->userdata('session_group_id'))){

											$name = (!empty($chat[0]['group_name']))?ucfirst($chat[0]['group_name']):'';
											$class = '';
											$online_status = 'online';
											$receiver_profile_img = base_url().'assets/img/user.jpg';

											foreach($chat as $c){
												$receiver_id[]=$c['login_id'];
												$sinch_username[]=$c['sinch_username'];
											}
											if(!empty($receiver_id)){
												$receiver_id = implode(',',$receiver_id);	
												$receiver_sinchusername = implode(',',$sinch_username);
											}else{
												$receiver_id = '';
												$receiver_sinchusername ='';
											}


											$receiver_email = '';
											$phone_number ='';		
											$department_name = '';
											$dob = '';
											$mesage_type="group";		
											$group_id = $this->session->userdata('session_group_id');
											$task_class = 'hidden'; 

										}



										/*From User  Image*/
										if(!empty($profile['profile_img'])){
											$profile_img = $profile['profile_img'];
											$file_to_check = FCPATH . '/uploads/' . $profile_img;
											if (file_exists($file_to_check)) {
												$profile_img = base_url() . 'uploads/'.$profile_img;
											}
										}		
										$profile_img = (!empty($profile_img))?$profile_img : base_url().'assets/img/user.jpg';

										/*From User  Image*/

										if(!empty($this->session->userdata('session_chat_id'))){

											echo '<li '.$class.'  id="'.$chat['sinch_username'].'" onclick="set_nav_bar_chat_user('.$chat['login_id'].',this)" type="text_chat">
												<a href="#"><span class="status '.$online_status.'"></span>'.ucfirst($chat['first_name']).' '.ucfirst($chat['last_name']).'<span class="badge bg-danger pull-right" id="'.$chat['sinch_username'].'danger" ></span></a>
												</li>';
										}




										?>


									</div>	
									<!-- Newly Messaged user  -->
									<div id="new_message_user" class="new_message_user"></div>


									<div id="other_users">
										<?php
										if(!empty($chat_users)){

											foreach($chat_users as $u){
												$online_status = ($u['online_status'] == 1)?'online':'offline';
												$login_id = $this->session->userdata('login_id');
												$where = array('sender_id' => $u['login_id'],'receiver_id' =>$login_id,'read_status' =>0);
												$count = $this->db->get_where('chat_details',$where)->num_rows();
												$count = ($count!=0)?$count:'';
												if(!empty($this->session->userdata('session_chat_id'))){
													$class = ($this->session->userdata('session_chat_id') == $u['login_id'])?'class="active"':'';
												}else{
													$class = '';	
												}


												echo '<li '.$class.'  id="'.$u['sinch_username'].'" onclick="set_nav_bar_chat_user('.$u['login_id'].',this)" type="text_chat">
												<a href="#"><span class="status '.$online_status.'"></span>'.ucfirst($u['first_name']).' '.ucfirst($u['last_name']).'<span class="badge bg-danger pull-right" id="'.$u['sinch_username'].'danger">'.$count.'</span></a>
												</li>';
											}

										}

										?>

									</div>					

									<!-- Text Chat  ends -->					
									
								</div>

								<!-- Audio Call  -->
								<div class="audio <?php echo $audio_class; ?>">
									<ul>
										<li> 
											<a href="javascript:void(0)" page="profile" onclick="navigate(this)"><i class="fa fa-home"></i> Back to Home</a>
										</li>
										<li class="menu-title" onclick="set_group_type(2)">Voice Call Groups <a href="#" data-toggle="modal" data-target="#add_group"><i class="fa fa-plus"></i></a></li>
										<div id="session_group_audio"></div>
										<div id="other_audio_group">
											<?php if(!empty($audio_group)){ 
												foreach($audio_group['groups'] as $t){


													$login_id = $this->session->userdata('login_id');
													$where = array(
														'group_id' => $t['group_id']
														,'receiver_id' =>$login_id,
														'read_status' =>0
													);
													$count = $this->db->get_where('chat_details',$where)->num_rows();
													$count = ($count!=0)?$count:'';
													if(!empty($this->session->userdata('session_group_id'))){
														$class = ($this->session->userdata('session_group_id') == $t['group_id'])?'class="active"':'';
													}else{
														$class = '';	
													}


													echo '<li '.$class.' id="'.ucfirst($t['group_name']).'" onclick="set_nav_bar_group_user('.$t['group_id'].',this)" type="group_audio"><a href="javascript:void(0)" >#'.ucfirst($t['group_name']).'</a></li>';
												}
											} ?>
										</div>

										<li class="menu-title">Direct Voice Call <a href="javascript:void(0);" onclick="modal_open('audio')"><i class="fa fa-plus"></i></a></li>
										<!-- Session selected user  -->
										<div id="session_audio_user" class="session_chat_user">
											<?php 

											if(!empty($this->session->userdata('session_chat_id'))){

												$online_status = ($chat['online_status'] == 1)?'online':'offline';

											echo '<li '.$class.'  id="'.$chat['sinch_username'].'" onclick="set_nav_bar_chat_user('.$chat['login_id'].',this)" type="audio">
												<a href="#"><span class="status '.$online_status.'"></span>'.ucfirst($chat['first_name']).' '.ucfirst($chat['last_name']).'<span class="badge bg-danger pull-right"></span></a>
												</li>';
										}

										 ?>





										 <?php
										if(!empty($chat_users)){

											// echo '<pre>'; print_r($chat_users);
											// exit;

											foreach($chat_users as $u){
												$online_status = ($u['online_status'] == 1)?'online':'offline';
												$login_id = $this->session->userdata('login_id');
												$where = array('sender_id' => $u['login_id'],'receiver_id' =>$login_id,'read_status' =>0);
												$count = $this->db->get_where('chat_details',$where)->num_rows();
												$count = ($count!=0)?$count:'';
												if(!empty($this->session->userdata('session_chat_id'))){
													$class = ($this->session->userdata('session_chat_id') == $u['login_id'])?'class="active"':'';
												}else{
													$class = '';	
												}


												echo '<li '.$class.'  id="'.$u['sinch_username'].'" onclick="set_nav_bar_chat_user('.$u['login_id'].',this)" type="audio">
												<a href="#"><span class="status '.$online_status.'"></span>'.ucfirst($u['first_name']).' '.ucfirst($u['last_name']).'<span class="badge bg-danger pull-right">'.$count.'</span></a>
												</li>';
											}

										}
										?>


										</div>	
										<!-- Newly Messaged user  -->
										<div id="new_audio_user" class="new_message_user"></div>
										

										
									</ul>
								</div>
								<!-- Video Call  -->
								<ul class="video <?php echo $video_class; ?>">
									<li> 
										<a href="javascript:void(0)" page="profile" onclick="navigate(this)"><i class="fa fa-home"></i> Back to Home</a>
									</li>
									<li class="menu-title" onclick="set_group_type(3)">Video Call Groups <a href="#" data-toggle="modal" data-target="#add_group"><i class="fa fa-plus"></i></a></li>
									<div id="session_group_video"></div>
									<div id="other_video_group">
										<?php if(!empty($video_group)){ 
											foreach($video_group['groups'] as $t){


												$login_id = $this->session->userdata('login_id');
												$where = array(
													'group_id' => $t['group_id']
													,'receiver_id' =>$login_id,
													'read_status' =>0
												);
												$count = $this->db->get_where('chat_details',$where)->num_rows();
												$count = ($count!=0)?$count:'';
												if(!empty($this->session->userdata('session_group_id'))){
													$class = ($this->session->userdata('session_group_id') == $t['group_id'])?'class="active"':'';
												}else{
													$class = '';	
												}


												echo '<li '.$class.' id="'.ucfirst($t['group_name']).'" onclick="set_nav_bar_group_user('.$t['group_id'].',this)" type="group_video"><a href="javascript:void(0)" >#'.ucfirst($t['group_name']).'</a></li>';
											}
										} ?>
										<li class="menu-title">Direct Video Call <a href="javascript:void(0);" onclick="modal_open('video')"><i class="fa fa-plus"></i></a></li>

										<!-- Session selected user  -->
										<div id="session_video_user" class="session_chat_user">
											<?php 

											if(!empty($this->session->userdata('session_chat_id'))){
												$online_status = ($chat['online_status'] == 1)?'online':'offline';

											echo '<li '.$class.'  id="'.$chat['sinch_username'].'" onclick="set_nav_bar_chat_user('.$chat['login_id'].',this)" type="video">
												<a href="#"><span class="status '.$online_status.'"></span>'.ucfirst($chat['first_name']).' '.ucfirst($chat['last_name']).'<span class="badge bg-danger pull-right"></span></a>
												</li>';
										}

										 ?>

										 <?php
										if(!empty($chat_users)){

											foreach($chat_users as $u){
												$online_status = ($u['online_status'] == 1)?'online':'offline';
												$login_id = $this->session->userdata('login_id');
												$where = array('sender_id' => $u['login_id'],'receiver_id' =>$login_id,'read_status' =>0);
												$count = $this->db->get_where('chat_details',$where)->num_rows();
												$count = ($count!=0)?$count:'';
												if(!empty($this->session->userdata('session_chat_id'))){
													$class = ($this->session->userdata('session_chat_id') == $u['login_id'])?'class="active"':'';
												}else{
													$class = '';	
												}


												echo '<li '.$class.'  id="'.$u['sinch_username'].'" onclick="set_nav_bar_chat_user('.$u['login_id'].',this)" type="video">
												<a href="#"><span class="status '.$online_status.'"></span>'.ucfirst($u['first_name']).' '.ucfirst($u['last_name']).'<span class="badge bg-danger pull-right">'.$count.'</span></a>
												</li>';
											}

										}
										?>
										</div>	
										<!-- Newly Messaged user  -->
										<div id="new_video_user" class="new_message_user"></div>

										
									</ul>


									<div class="screen_share <?php echo $screen_share_class; ?>">
										<ul>
											<li> 
												<a href="javascript:void(0)" page="profile" onclick="navigate(this)"><i class="fa fa-home"></i> Back to Home</a>
											</li>
											<li class="menu-title" onclick="set_group_type(4)">Screen Share Groups <a href="#" data-toggle="modal" data-target="#screen_share"><i class="fa fa-plus"></i></a></li>
											<div id="session_screen_shrare_group"></div>
											<!-- Newly Messaged user  -->
											<div id="new_screen_user" class="new_screen_user"></div>
											<?php if(!empty($screen_share_group)){ 
												$class = '';
												foreach($screen_share_group as $t){
													if( $this->login_id == $t['from_id'] ) {
														echo '<li '.$class.' id="'.ucfirst($t['group_name']).'" onclick="set_nav_bar_share_group_user(this)" data-src="" data-id="'.$t['from_id'].'" data-name="'. $t['group_name'] .'" type="screen_share_group"><a href="javascript:void(0)" >#'.ucfirst($t['group_name']).'</a></li>';
													}
													else {

														echo '<li '.$class.' id="'.ucfirst($t['group_name']).'" onclick="set_nav_bar_share_group_user(this)" data-src="'.$t['url'].'" data-id="'.$t['from_id'].'" data-name="'. $t['group_name'] .'" type="screen_share_group"><a href="javascript:void(0)" >#'.ucfirst($t['group_name']).'</a></li>';													

													}
												}
											} ?>
										</div>
										


									</ul>
								<?php } ?>
								</div>
							</div>

							
						</ul>
					</div>
				</div>
			</div>