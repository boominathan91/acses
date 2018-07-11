<?php   

$light_logo = $this->session->userdata('light_logo');
if(!empty($light_logo)){
	$light_logo = 'uploads/'.$light_logo;
}else{
	$light_logo = 'assets/img/logo.png';
}

$website_name = $this->session->userdata('website_name');
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
	<li class="dropdown hidden-xs">
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
	</li>	
	<li class="dropdown">
		<a href="#" class="dropdown-toggle user-link" data-toggle="dropdown" title="<?php echo ucfirst($this->session->userdata('first_name')); ?>">
			<span class="user-img"><img class="img-circle" src="<?php echo base_url(); ?>assets/img/user.jpg" width="40" alt="<?php echo ucfirst($this->session->userdata('first_name')); ?>">
				<span class="status online"></span></span>
				<span><?php echo ucfirst($this->session->userdata('first_name')); ?></span>
				<i class="caret"></i>
			</a>
			<ul class="dropdown-menu">
							<!-- <li><a href="#">My Profile</a></li>
								<li><a href="#">Edit Profile</a></li> -->
								<li><a href="<?php echo base_url(); ?>company-settings">Settings</a></li>
								<li><a href="<?php echo base_url(); ?>logout">Logout</a></li>
							</ul>
						</li>
					</ul>
					<div class="dropdown mobile-user-menu pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
						<ul class="dropdown-menu pull-right">
						<!-- <li><a href="#">My Profile</a></li>
							<li><a href="#">Edit Profile</a></li> -->
							<li><a href="<?php echo base_url(); ?>company-settings">Settings</a></li>
							<li><a href="<?php echo base_url(); ?>login">Logout</a></li>
						</ul>
					</div>
				</div>

				<div class="sidebar" id="sidebar">
					<div class="sidebar-inner slimscroll">
						<div class="sidebar-menu">
							<?php $uri = $this->uri->segment(1); ?>
							<ul>							
								<?php if($uri == 'profile'){ ?>	
									<li> 
										<a href="<?php echo base_url(); ?>chat">Chat</a>
									</li>
								<?php } ?>
								<?php if($uri == 'chat'){ ?>
									<!-- Text Chat  -->	
									<li> 
										<a href="<?php echo base_url(); ?>profile"><i class="fa fa-home"></i> Back to Home</a>
									</li>

									<li class="menu-title">Chat Groups <a href="#" data-toggle="modal" data-target="#add_group"><i class="fa fa-plus"></i></a></li>
									<!-- Session selected user  -->
									<div id="session_group_user"></div>	
									<!-- Newly Messaged user  -->
									<div id="new_group_user"></div>

									<div id="other_groups">

									<?php if(!empty($text_group)){ 
												foreach($text_group['groups'] as $t){
												

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


													echo '<li '.$class.' id="'.$t['group_name'].'" onclick="set_nav_bar_group_user('.$t['group_id'].',this)"><a href="javascript:void(0)" >#'.ucfirst($t['group_name']).'</a></li>';
												}
										 } ?>
										</div>

									<li class="menu-title">Direct Chats <a href="#" data-toggle="modal" data-target="#add_chat_user"><i class="fa fa-plus"></i></a></li>
									<!-- Session selected user  -->
									<div id="session_chat_user"></div>	
									<!-- Newly Messaged user  -->
									<div id="new_message_user"></div>


									<div id="other_users">
										<?php
//echo '<pre>';print_r($chat_users);exit;	
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
												

											echo '<li '.$class.'  id="'.$u['sinch_username'].'" onclick="set_nav_bar_chat_user('.$u['login_id'].',this)">
												<a href="#"><span class="status '.$online_status.'"></span>'.ucfirst($u['first_name']).' '.ucfirst($u['last_name']).'<span class="badge bg-danger pull-right">'.$count.'</span></a>
												</li>';
											}
											
										}
										 ?>
																				
									</div>					

									<!-- Text Chat  ends -->					
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>