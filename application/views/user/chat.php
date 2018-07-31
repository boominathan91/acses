<!-- Loader -->
<div class="loading style-2"><div class="loading-wheel"></div></div>

<div class="main-wrapper">
	<?php $this->load->view('user/includes/nav_bar'); 
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
	?>


	<!-- Profile Page  -->


	<div class="page-wrapper profile <?php echo $profile_class; ?>">
                <div class="content container-fluid">
					<div class="row">
						<div class="col-sm-8">
							<h4 class="page-title"><?php lang('my_profile'); ?></h4>
						</div>
						
						<div class="col-sm-4 text-right m-b-30">
							<a href="<?php echo base_url(); ?>edit-profile" class="btn btn-primary rounded"><i class="fa fa-plus"></i> Edit Profile</a>
						</div>
					</div>
					<div class="card-box">
						<div class="row">
							<div class="col-md-12">
								<div class="profile-view">
									<div class="profile-img-wrap">
										<div class="profile-img">
											<?php 
												if(empty($user_profile['profile_img'])){
													$profile_img = base_url().'assets/img/user.jpg';
												}else{
													$profile_img = base_url().'uploads/'.$user_profile['profile_img'];
												}
											 ?>
											<a href="Javascript:void(0)"><img class="avatar" src="<?php echo $profile_img; ?>" alt=""></a>
										</div>
									</div>
									<div class="profile-basic">
										<div class="row">
											<div class="col-md-5">
												<div class="profile-info-left">
													<h3 class="user-name m-t-0 m-b-0"><?php echo ucfirst($this->session->userdata('first_name')).' '.ucfirst($this->session->userdata('last_name')) ?></h3>
													<small class="text-muted">Web Designer</small>
													<div class="staff-id">Employee ID : FT-000<?php echo $this->session->userdata('login_id'); ?></div>
													<!-- <div class="staff-msg"><a href="chat.html" class="btn btn-primary">Send Message</a></div> -->
												</div>
											</div>
											<div class="col-md-7">
												<ul class="personal-info">
													<li>
														<span class="title">Phone:</span>
														<span class="text"><a href=""><?php echo (!empty($user_profile['phone_number']))?$user_profile['phone_number']:'N/A'; ?></a></span>
													</li>
													<li>
														<span class="title">Email:</span>
														<span class="text"><a href=""><?php echo (!empty($user_profile['email']))?$user_profile['email']:'N/A'; ?></a></span>
													</li>
													<li>
														<span class="title">Birthday:</span>
														<span class="text"><?php echo (!empty($user_profile['dob']))?date('d-m-Y',strtotime($user_profile['dob'])):'N/A'; ?></span>
													</li>
													<li>
														<span class="title">Address:</span>
														<span class="text"><?php echo (!empty($user_profile['address']))?$user_profile['address'].','.$user_profile['cityname'].','.$user_profile['statename'].','.$user_profile['countryname']:'N/A'; ?></span>
													</li>
													<li>
														<span class="title">Gender:</span>
														<span class="text"><?php echo (!empty($user_profile['gender']))?ucfirst($user_profile['gender']):'N/A'; ?></span>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
					<!-- 	<div class="col-md-3">
							<div class="card-box m-b-0">
								<h3 class="card-title">Skills</h3>
								<div class="skills">
									<span>IOS</span>
									<span>Android</span> 
									<span>Html</span>
									<span>CSS</span>
									<span>Codignitor</span>
									<span>Php</span>
									<span>Javascript</span>
									<span>Wordpress</span>
									<span>Jquery</span>
								</div>
							</div>
						</div> -->
						<div class="col-md-12">
							<div class="card-box">
								<h3 class="card-title">Education Informations</h3>
								<div class="experience-box">
									<ul class="experience-list">
										<?php if(!empty($education_details)){ 
											 
											foreach ($education_details as $education) {  ?>
										<li>
											<div class="experience-user">
												<div class="before-circle"></div>
											</div>
											<div class="experience-content">
												<div class="timeline-content">
													<a href="Javascript:void(0)" class="name"><?php echo $education['institution']; ?></a>
													<div><?php echo $education['subject']; ?></div>
													<span class="time"><?php echo $education['start_year']; ?> - <?php echo $education['complete_year']; ?></span>
												</div>
											</div>
										</li>
										<?php } }else{ ?>
										<li class="text-danger">No details</li>
										<?php } ?>
										 
									</ul>
								</div>
							</div>
							<div class="card-box m-b-0">
								<h3 class="card-title">Experience</h3>
								<div class="experience-box">
									<ul class="experience-list">
									 
										<?php if(!empty($experience_informations)){ 
											 
											foreach ($experience_informations as $experience) {  ?>
											<li>
											<div class="experience-user">
												<div class="before-circle"></div>
											</div>
											<div class="experience-content">
												<div class="timeline-content">
													<a href="Javascript:void(0)" class="name"><?php echo $experience['company'].'-'.$experience['location']; ?></a>
													<span class="time"><?php echo $experience['jop_position']; ?> - <?php echo $experience['period_from'].'-'.$experience['period_to']; ?></span>
												</div>
											</div>
										</li>
										<?php } }else{ ?>
										<li class="text-danger">No details</li>
										<?php } ?>

										
									 
									</ul>
								</div>
							</div>
						</div>
					</div>
                </div>
				<div class="notification-box">
					<div class="msg-sidebar notifications msg-noti">
						<div class="topnav-dropdown-header">
							<span>Messages</span>
						</div>
						<div class="drop-scroll msg-list-scroll">
							<ul class="list-box">
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">R</span>
											</div>
											<div class="list-body">
												<span class="message-author">Richard Miles </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item new-message">
											<div class="list-left">
												<span class="avatar">J</span>
											</div>
											<div class="list-body">
												<span class="message-author">John Doe</span>
												<span class="message-time">1 Aug</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">T</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Tarah Shropshire </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">M</span>
											</div>
											<div class="list-body">
												<span class="message-author">Mike Litorus</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">C</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Catherine Manseau </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">D</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Domenic Houston </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">B</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Buster Wigton </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">R</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Rolland Webber </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">C</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Claire Mapes </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">M</span>
											</div>
											<div class="list-body">
												<span class="message-author">Melita Faucher</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">J</span>
											</div>
											<div class="list-body">
												<span class="message-author">Jeffery Lalor</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">L</span>
											</div>
											<div class="list-body">
												<span class="message-author">Loren Gatlin</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">T</span>
											</div>
											<div class="list-body">
												<span class="message-author">Tarah Shropshire</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
							</ul>
						</div>
						<div class="topnav-dropdown-footer">
							<a href="chat.html">See all messages</a>
						</div>
					</div>
				</div>
            </div>

	<!-- Profile Page ends  -->
	

	<!-- Text Chat Page Content  -->
	<div class="page-wrapper text_chat <?php echo $text_chat_class; ?>" id="text_chat_panel">
		<div class="chat-main-row <?php echo $class; ?>">
			<div class="chat-main-wrapper">
				<div class="col-xs-9 message-view task-view">
					<div class="chat-window">
						<div class="chat-header">
							<div class="navbar">
								<div class="user-details">
									<div class="pull-left user-img m-r-10">
										<a href="#" title="<?php echo $name; ?>">
											<img src="<?php echo $receiver_profile_img; ?>" alt="" class="w-40 img-circle receiver_title_image"><span class="status <?php echo $online_status; ?> title_status"></span></a>
										</div>
										<div class="user-info pull-left">
											<a href="#" title="<?php $name; ?>"><span class="font-bold to_name"><?php echo $name; ?></span></a>
											<!-- <span class="last-seen"><?php echo ucfirst($online_status); ?></span> -->
										</div>
									</div>		
									
									<ul class="nav navbar-nav pull-right chat-menu <?php echo $task_class; ?>">											
										<li class="dropdown">
											<a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog"></i></a>
											<ul class="dropdown-menu">
												<li><a href="javascript:void(0)" onclick="delete_conversation();">Delete Conversations</a></li>													
											</ul>
										</li>
									</ul>
									<a href="#task_window" class="task-chat profile-rightbar pull-right"><i class="fa fa-user" aria-hidden="true"></i></a>
								</div>
							</div>
							<div class="progress upload-progress hidden">
								<div class="progress-bar progress-bar-success active progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100" style="width: 100%;">
									Uploading...  
								</div>
							</div>
							<div class="chat-contents">
								<div class="chat-content-wrap">
									<div class="chat-wrap-inner">
										<div class="chat-box msg-list-scroll">
											<div class="chats chat_messages">
												<?php 
												if(!empty($latest_chats)){

													if(count($latest_chats)>4){

														echo '<div class="load-more-btn text-center" total="'.$page.'">
														<button class="btn btn-default" data-page="2"><i class="fa fa-refresh"></i> Load More</button>
														</div><div class="ajax_old"></div>';      
													}


													foreach($latest_chats as $l){


														$login_id = $this->session->userdata('login_id');

														$sender_name = $l['sender_name'];
														$sender_profile_img = (!empty($l['sender_profile_image']))?base_url().'uploads/'.$l['sender_profile_image'] : base_url().'assets/img/user.jpg';
														$msg = $l['message'];
														$type = $l['type'];
														$file_name = base_url().$l['file_path'].'/'.$l['file_name'];
														$time = date('h:i A',strtotime($l['created_at']));
														$up_file_name =$l['file_name'];

														if($l['sender_id'] == $login_id){
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

															echo '<div class="chat '.$class_name.'">'.$img_avatar.'
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

															echo '<div class="chat '.$class_name.'">'.$img_avatar.'
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

															echo '<div class="chat '.$class_name.'">'.$img_avatar.'
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

												} ?>
												<div class="ajax"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<form method="post" id="chat_form" enctype="multipart/formdata">
								<div class="chat-footer">
									<div class="message-bar">
										<div class="message-inner">
											<a class="link attach-icon" href="javascript:void(0)" ><img src="assets/img/attachment.png" alt=""></a>
											<div class="message-area">
												<div class="input-group">

													<input class="form-control" placeholder="Type message..." id="input_message" type="text">
													<input type="file" name="userfile" id="user_file" class="hidden">
													<input type="hidden" name="sender_sinchusername" id="sender_sinchusername" value="<?php echo $this->session->userdata('sinch_username'); ?>">
													<!-- sender sinch username  -->
													<input type="text" name="receiver_sinchusername" id="receiver_sinchusername" value="<?php echo $receiver_sinchusername; ?>">
													<!--  receiver sinch username  -->
													<input type="hidden" name="receiver_id" id="receiver_id" value="<?php echo $receiver_id; ?>">
													<!--  receiver id  -->

													<input type="hidden" name="time" id="time" > 
													<!-- Current Time  --> 
													<input type="hidden" name="img" id="sender_img" value="<?php echo $profile_img; ?>">
													<!-- Sender Image  -->
													<input type="hidden" name="img" id="receiver_image" value="<?php echo $receiver_profile_img; ?>">
													<!-- Receiver Image  -->

													<input type="hidden" name="message_type" id="type" value="<?php echo $mesage_type ?>" >
													<input type="hidden" name="group_id" id="group_id" value="<?php echo $group_id; ?>">

													<span class="input-group-btn">
														<button class="btn btn-primary chat-send-btn" type="submit" ><i class="fa fa-send"></i></button>
													</span>

												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="col-xs-3 profile-right fixed-sidebar-right chat-profile-view <?php echo $task_class; ?>" id="task_window" >
						<div class="display-table profile-right-inner">
							<div class="table-row">
								<div class="table-body">
									<div class="table-content">
										<div class="chat-profile-img">
											<div class="edit-profile-img">
												<img class="avatar receiver_title_image" src="<?php echo $receiver_profile_img; ?>" alt="">
											</div>
											<h3 class="user-name m-t-10 m-b-0 to_name"><?php echo $name; ?></h3>
											<small class="text-muted department"><?php echo $department_name; ?></small>

										</div>
										<div class="chat-profile-info">
											<ul class="user-det-list">													
												<li>
													<span>DOB:</span>
													<span class="pull-right text-muted dob"><?php echo $dob; ?></span>
												</li>
												<li>
													<span>Email:</span>
													<span class="pull-right text-muted receiver_email"><?php echo $receiver_email; ?></span>
												</li>
												<li>
													<span>Phone:</span>
													<span class="pull-right text-muted phone_number"><?php echo $phone_number; ?></span>
												</li>
											</ul>
										</div>										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Text Chat Page Content ends  -->

		<!-- Audio Call Page Content starts -->	

		<div id="for_audio" >

		<div class="page-wrapper audio <?php echo $audio_class; ?>">
			<div class="chat-main-row <?php echo $class; ?>" id="audio_panel">
				<div class="chat-main-wrapper">
					<div class="col-xs-9 message-view task-view">
						<div class="chat-window">
							<div class="chat-header">
								<div class="navbar">
									<div class="user-details">
										<div class="pull-left user-img m-r-10">
											<a href="#" title="<?php echo $name; ?>"><img src="<?php echo $receiver_profile_img; ?>" alt="" class="w-40 img-circle receiver_title_image"><span class="status online"></span></a>
										</div>
										<div class="user-info pull-left">
											<a href="javascript:void()" title="<?php echo $name; ?>"><span class="font-bold to_name"><?php echo $name; ?></span></a>
											<!-- <span class="last-seen">Online</span> -->
										</div>
									</div>
									<ul class="nav navbar-nav pull-right chat-menu">
										<li>
											<a href="#chat_sidebar" class="task-chat profile-rightbar pull-right"><i class="fa fa-comments" aria-hidden="true"></i></a>
										</li>										
									</ul>
								</div>
							</div>
							<div class="chat-contents">
								<div class="chat-content-wrap">
									
									<div class="voice-call-avatar">
										<img src="<?php echo $receiver_profile_img; ?>" alt="" class="call-avatar receiver_title_image">
										<span class="username to_name"><?php echo $name; ?></span>
										<span class="call-timing-count" id="timer"></span>
										<button class="start-call" type="audio">Call</button>
										<audio id="incoming_audio" autoplay></audio>
										<audio id="ringback" src="<?php echo base_url().'assets/audio/ringback.wav'; ?>" loop></audio>
										<audio id="ringtone" src="<?php echo base_url().'assets/audio/phone_ring.wav'; ?>" loop></audio>
									</div>
									
										<input type="hidden"  id="call_to_id" value="<?php echo $receiver_id ?>" >	
										<input type="hidden"  id="call_from_id" >	
										<input type="hidden" id="call_type" value="audio">
										<input type="hidden" id="call_duration" value="call_duration" >
										<input type="hidden" id="call_started_at" value="call_started_at" >
										<input type="hidden" id="call_ended_at" value="call_ended_at">
										<input type="hidden" id="end_cause" value="end_cause" >								
                                   <!--  <div class="call-users">
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <img src="assets/img/user-04.jpg" class="img-responsive" alt="">
                                                    <span class="call-mute"><i class="fa fa-microphone-slash" aria-hidden="true"></i></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="assets/img/user-05.jpg" class="img-responsive" alt="">
                                                    <span class="call-mute"><i class="fa fa-microphone-slash" aria-hidden="true"></i></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="assets/img/user-06.jpg" class="img-responsive" alt="">
                                                    <span class="call-mute"><i class="fa fa-microphone-slash" aria-hidden="true"></i></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div> -->
                                </div>
                            </div>
                            <div class="chat-footer hidden" id="audio-footer">
                            	<div class="call-icons">
                            		<ul class="call-items">                                    
                            			<li class="call-item mute_icon">
                            				<a href="#" title="Mute" data-placement="top" data-toggle="tooltip">
                            					<i class="fa fa-microphone microphone" aria-hidden="true"></i>
                            				</a>
                            			</li>
                                      <!--   <li class="call-item">
                                            <a href="#" title="Add User" data-placement="top" data-toggle="tooltip">
                                                <i class="fa fa-user-plus" aria-hidden="true"></i>
                                            </a>
                                        </li> -->
                                    </ul>
                                    <div class="end-call">
                                    	<a href="javascript:void(0);" class="hangup hidden">End Call</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3 message-view chat-profile-view chat-sidebar" id="chat_sidebar">
                    	<div class="chat-window video-window">
                    		<!-- <div class="chat-header">
                    			<ul class="nav nav-tabs nav-tabs-bottom">
                    				<li class="active"><a href="#calls_tab" data-toggle="tab">Calls</a></li>
                    				<li><a href="#chats_tab" data-toggle="tab">Chats</a></li>
                    				<li><a href="#profile_tab" data-toggle="tab">Profile</a></li>
                    			</ul>
                    		</div> -->
                    		
                    		</div>
                    	</div>
                    </div>
                </div>
            </div>       
        </div>
        </div>


        <!-- Audio Call Page Content ends  -->

<!-- Audio Call Page Content starts -->	

		<div id="for_group_audio">

		<div class="page-wrapper audio <?php echo $audio_class; ?>">
			<div class="chat-main-row <?php echo $class; ?>" id="audio_panel">
				<div class="chat-main-wrapper">
					<div class="col-xs-9 message-view task-view">
						<div class="chat-window">
							<div class="chat-header">
								<div class="navbar">
									<div class="user-details">
										<div class="pull-left user-img m-r-10">
											<a href="#" title="<?php echo $name; ?>"><img src="<?php echo $receiver_profile_img; ?>" alt="" class="w-40 img-circle receiver_title_image"><span class="status online"></span></a>
										</div>
										<div class="user-info pull-left">
											<a href="javascript:void()" title="<?php echo $name; ?>"><span class="font-bold to_group_audio_name"><?php echo $name; ?></span></a>
											<!-- <span class="last-seen">Online</span> -->
											<span class="font-bold to_group_audio hidden"><?php echo $name; ?></span>
										</div>
									</div>
									<ul class="nav navbar-nav pull-right chat-menu">
										<li>
											<a href="#chat_sidebar" class="task-chat profile-rightbar pull-right"><i class="fa fa-comments" aria-hidden="true"></i></a>
										</li>										
									</ul>
								</div>
							</div>
							<div class="chat-contents">
								<div class="chat-content-wrap">
									
									<div class="voice-call-avatar">
										<img src="<?php echo $receiver_profile_img; ?>" alt="" class="call-avatar receiver_title_image">
										<span class="username to_group_audio_name"><?php echo $name; ?></span>
										<span class="group-audio-call-timing-count" id="timer"></span>
										<button class="start-call" type="group_audio">Join</button>
										<audio id="incoming_audio" autoplay></audio>
										<audio id="ringback" src="<?php echo base_url().'assets/audio/ringback.wav'; ?>" loop></audio>
										<audio id="ringtone" src="<?php echo base_url().'assets/audio/phone_ring.wav'; ?>" loop></audio>
									</div>
									
										<input type="hidden"  id="call_to_id" value="<?php echo $receiver_id ?>" >	
										<input type="hidden"  id="call_from_id" >	
										<input type="hidden" id="call_type" value="audio">
										<input type="hidden" id="call_duration" value="call_duration" >
										<input type="hidden" id="call_started_at" value="call_started_at" >
										<input type="hidden" id="call_ended_at" value="call_ended_at">
										<input type="hidden" id="end_cause" value="end_cause" >								
                                   
                                   <div class="for-group-video my-audio">
                                        <ul>
                                            <div class="group_members">
                                            	<li id="outgoing_audio_initial">
                                            	</li>
                                            </div>
                                        </ul>
                                    </div>


                                </div>
                            </div>
                            <div class="chat-footer hidden" id="audio-footer">
                            	<div class="call-icons">
                            		<ul class="call-items">                                    
                            			<li class="call-item mute_icon">
                            				<a href="#" title="Mute" data-placement="top" data-toggle="tooltip">
                            					<i class="fa fa-microphone microphone" aria-hidden="true"></i>
                            				</a>
                            			</li>
                                      <!--   <li class="call-item">
                                            <a href="#" title="Add User" data-placement="top" data-toggle="tooltip">
                                                <i class="fa fa-user-plus" aria-hidden="true"></i>
                                            </a>
                                        </li> -->
                                    </ul>
                                    <div class="end-call">
                                    	<a href="javascript:void(0);" class="hangup hidden">End Call</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
            </div>       
        </div>
        </div>
        </div>


        <!-- Audio Call Page Content ends  -->
        <!-- Video Call Page Content Starts  -->
	<div id="for_video">
         <div class="page-wrapper video <?php echo $video_class; ?>">
            <div class="chat-main-row <?php echo $class; ?>">
                <div class="chat-main-wrapper">
                    <div class="col-xs-9 message-view task-view">
                        <div class="chat-window">
                            <div class="chat-header">
								<div class="navbar">
									<div class="user-details">
										<div class="pull-left user-img m-r-10">
											<a href="#" title="<?php echo $name; ?>"><img src="<?php echo $receiver_profile_img; ?>" alt="" class="w-40 img-circle receiver_title_image"><span class="status online"></span></a>
										</div>
										<div class="user-info pull-left">
											<a href="javascript:void()" title="<?php echo $name; ?>"><span class="font-bold to_name"><?php echo $name; ?></span></a>
										</div>
									</div>
									<ul class="nav navbar-nav pull-right chat-menu">
										<li>
											<a href="#chat_sidebars" class="task-chat profile-rightbar pull-right"><i class="fa fa-comments" aria-hidden="true"></i></a>
										</li>										
									</ul>
								</div>
							</div>
                            <div class="chat-contents">
                                <div class="chat-content-wrap">
                                    <div class="user-video voice-call-avatar">
                                        <img src="<?php echo $receiver_profile_img; ?>" class="call-avatar incoming_image receiver_title_image">
                                        <button class="start-call" type="video">Call</button>
                                        <div class="video_call_status"></div>                                        
											<video id="incoming" autoplay class="img-responsive" ></video>
                                    </div>
                                    <div class="my-video">
                                        <ul>
                                            <li>
                                            	<video id="outgoing" autoplay class="img-responsive" muted></video>
                                                <img src="<?php echo $profile_img; ?>" class="img-responsive outgoing_image" alt="">
                                            </li>
                                            <div class="group_members"></div>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-footer hidden" id="video-footer">
                                <div class="call-icons">
                                    <span class="call-duration" id="video_timer"></span>
                                    <ul class="call-items">
                                        <!-- <li class="call-item enable_video">
                                            <a href="javascript:void(0)" title="Enable Video" data-placement="top" data-toggle="tooltip">
                                                <i class="fa fa-video-camera camera" aria-hidden="true"></i>
                                            </a>
                                        </li> -->
                                        <li class="call-item mute_icon">
                                            <a href="javascript:void(0)" title="Mute Audio" data-placement="top" data-toggle="tooltip">
                                                <i class="fa fa-microphone microphone" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                       <!--  <li class="call-item">
                                            <a href="javascript:void(0)" title="Add User" data-placement="top" data-toggle="tooltip">
                                                <i class="fa fa-user-plus" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="call-item">
                                            <a href="javascript:void(0)" title="Full Screen" data-placement="top" data-toggle="tooltip">
                                                <i class="fa fa-arrows-v full-screen" aria-hidden="true"></i>
                                            </a>
                                        </li>
										<li class="call-item">
                                            <a href="javascript:void(0)" title="Screen Share" data-placement="top" data-toggle="tooltip">
                                                <i class="fa fa-desktop full-screen" aria-hidden="true"></i>
                                            </a>
                                        </li> -->
                                    </ul>
                                    <div class="end-call">
                                        <a href="javascript:void(0)" class="hangup">
												End Call
											</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3 message-view chat-profile-view chat-sidebar" id="chat_sidebar">
                    	<div class="chat-window video-window">
                    		<div class="chat-header">
                    			<ul class="nav nav-tabs nav-tabs-bottom">
                    				<li class="active"><a href="#call_tab" data-toggle="tab">Calls</a></li>
                    				<li><a href="#chats_tab" data-toggle="tab">Chats</a></li>
                    				<li><a href="#profile_tab" data-toggle="tab">Profile</a></li>
                    			</ul>
                    		</div>
                    		<div class="tab-content chat-contents">
                    			<div class="content-full tab-pane active" id="call_tab">
                    				<div class="chat-wrap-inner">
                    					<div class="chat-box">
                    						<div class="chats">
                    						<div  id="call_history">
                    						<!-- Call History  -->
                    						<?php

                    						// echo '<pre>'; print_r($call_history);
                    						 if(!empty($call_history)){
                    						 	$login_id = $this->session->userdata('login_id');								

                    						 	foreach($call_history as $c){
                    						 		$end_cause = $c['end_cause'];
                    						 		$caller_img = (!empty($c['profile_img']))?base_url().'uploads/'.$c['profile_img'] : base_url().'assets/img/user.jpg';
                    						 		if($c['login_id'] != $login_id){
                    						 			$caller_name = ucfirst($c['first_name']).' '.ucfirst($c['last_name']);	
                    						 			$receiver_name = 'You';
                    						 		}else{
                    						 			$receiver_name =  ucfirst($c['first_name']).' '.ucfirst($c['last_name']);
                    						 			$caller_name = 'You';                    						 		}
                    						 			$call_duration = $c['call_duration'];                    						 			
                    						 			if(date('Y-m-d') == date('Y-m-d',strtotime($c['call_ended_at']))){
                    						 				$call_ended_at = date('H:i a',strtotime($c['call_ended_at']));
                    						 			}else{
                    						 				$call_ended_at = date('H:i a d-m-Y',strtotime($c['call_ended_at']));
                    						 			}

                    						 		if($end_cause == 'HUNG_UP'){ 
                    						 		// Call from others and answered 

                    						 			

                    						 			echo '<div class="chat chat-left">
                    								<div class="chat-avatar">
                    									<a href="profile.html" class="avatar">
                    										<img alt="'.$caller_name.'" src="'.$caller_img.'" class="img-responsive img-circle">
                    									</a>
                    								</div>
                    								<div class="chat-body">
                    									<div class="chat-bubble">
                    										<div class="chat-content">
                    											<span class="task-chat-user">'.$caller_name.'</span> <span class="chat-time">'.$call_ended_at .'</span>
                    											<div class="call-details">
                    												<i class="material-icons">call_end</i>
                    												<div class="call-info">
                    													<div class="call-user-details">
                    														<span class="call-description">This call has ended</span>
                    													</div>
                    													<div class="call-timing">Duration: <strong>'.$call_duration.'</strong></div>
                    												</div>
                    											</div>
                    										</div>
                    									</div>
                    								</div>
                    							</div>';
                    						 		}elseif($end_cause == 'DENIED'){                 						 		




                    						 			echo '<div class="chat chat-left">
                    								<div class="chat-avatar">
                    									<a href="profile.html" class="avatar">
                    										<img alt="'.$caller_name.'" src="'.$caller_img.'" class="img-responsive img-circle">
                    									</a>
                    								</div>
                    								<div class="chat-body">
                    									<div class="chat-bubble">
                    										<div class="chat-content">
                    											<span class="task-chat-user">'.$caller_name.'</span> <span class="chat-time">'.$call_ended_at .'</span>
                    											<div class="call-details">
                    												<i class="material-icons">phone_missed</i>
                    												<div class="call-info">
                    													<div class="call-user-details">
                    														<span class="call-description">'.$receiver_name.' rejected call</span>
                    													</div>
                    													
                    												</div>
                    											</div>
                    										</div>
                    									</div>
                    								</div>
                    							</div>';
                    						 		}else{

                    						 			echo '<div class="chat chat-left">
                    								<div class="chat-avatar">
                    									<a href="profile.html" class="avatar">
                    										<img alt="'.$caller_name.'" src="'.$caller_img.'" class="img-responsive img-circle">
                    									</a>
                    								</div>
                    								<div class="chat-body">
                    									<div class="chat-bubble">
                    										<div class="chat-content">
                    											<span class="task-chat-user">'.$caller_name.'</span> <span class="chat-time">'.$call_ended_at .'</span>
                    											<div class="call-details">
                    												<i class="material-icons">phone_missed</i>
                    												<div class="call-info">
                    													<div class="call-user-details">
                    														<span class="call-description">'.$receiver_name.'missed the call</span>
                    													</div>
                    													
                    												</div>
                    											</div>
                    										</div>
                    									</div>
                    								</div>
                    							</div>';
                    						 		}
                    						 	}
                    						 }else{
                    						 	echo 'No call records';
                    						 }
                    						 ?>
                    						</div>
                    					</div>
                    					</div>
                    				</div>
                    			</div>

                    			<div class="content-full tab-pane"  id="chats_tab" >
                    				<div class="progress upload-progress hidden">
								<div class="progress-bar progress-bar-success active progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100" style="width: 100%;">
									Uploading...  
								</div>
							</div>
                    				<div class="chat-window">
                    					<div class="chat-contents">
                    						<div class="chat-content-wrap">
                    							<div class="chat-wrap-inner">
                    								<div class="chat-box">
                    									<div class="chats chat_messages">	
                    										<?php 
												if(!empty($latest_chats)){

													if(count($latest_chats)>4){

														echo '<div class="load-more-btn text-center" total="'.$page.'">
														<button class="btn btn-default" data-page="2"><i class="fa fa-refresh"></i> Load More</button>
														</div><div class="ajax_old"></div>';      
													}


													foreach($latest_chats as $l){


														$login_id = $this->session->userdata('login_id');

														$sender_name = $l['sender_name'];
														$sender_profile_img = (!empty($l['sender_profile_image']))?base_url().'uploads/'.$l['sender_profile_image'] : base_url().'assets/img/user.jpg';
														$msg = $l['message'];
														$type = $l['type'];
														$file_name = base_url().$l['file_path'].'/'.$l['file_name'];
														$time = date('h:i A',strtotime($l['created_at']));
														$up_file_name =$l['file_name'];

														if($l['sender_id'] == $login_id){
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

															echo '<div class="chat '.$class_name.'">'.$img_avatar.'
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

															echo '<div class="chat '.$class_name.'">'.$img_avatar.'
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

															echo '<div class="chat '.$class_name.'">'.$img_avatar.'
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

												} ?>
												<div class="ajax"></div>
                    								</div>
                    								</div>
                    							</div>
                    						</div>
                    					</div>
                    					<form method="post" id="audio_chat_form" enctype="multipart/formdata">
                    					<div class="chat-footer">
                    						<div class="message-bar">
                    							<div class="message-inner">
                    								<a class="link attach-icon" href="#" data-toggle="modal" data-target="#drag_files"><img src="assets/img/attachment.png" alt=""></a>
                    								<div class="message-area">
                    									<div class="input-group">
                    										<input id="input_messages" class="form-control" placeholder="Type message...">
                    										<span class="input-group-btn">
                    											<button class="btn btn-primary" type="button"><i class="fa fa-send"></i></button>
                    										</span>
                    									</div>
                    								</div>
                    							</div>
                    						</div>
                    					</div>
                    				</form>
                    				</div>
                    			</div>
                    			<div class="content-full tab-pane" id="profile_tab">
                    				<div class="display-table">
                    					<div class="table-row">
                    						<div class="table-body">
                    							<div class="table-content">
                    								<div class="chat-profile-img">
                    									<div class="edit-profile-img">
                    										<img src="<?php echo $receiver_profile_img; ?>" alt="" class="receiver_title_image">
                    										
                    									</div>
                    									<h3 class="user-name m-t-10 m-b-0 to_name"><?php echo $name; ?></h3>
                    									<small class="text-muted department"><?php echo $department_name; ?></small>
                    									
                    								</div>
                    								<div class="chat-profile-info">
                    									<ul class="user-det-list">													
                    										<li>
                    											<span>DOB:</span>
                    											<span class="pull-right text-muted dob"><?php echo $dob; ?></span>
                    										</li>
                    										<li>
                    											<span>Email:</span>
                    											<span class="pull-right text-muted receiver_email"><?php echo $receiver_email; ?></span>
                    										</li>
                    										<li>
                    											<span>Phone:</span>
                    											<span class="pull-right text-muted phone_number"><?php echo $phone_number; ?></span>
                    										</li>
                    									</ul>
                    								</div>
                    							<!-- 	<div>
                    									<ul class="nav nav-tabs nav-tabs-solid nav-justified m-b-0">
                    										<li class="active"><a href="#all_files" data-toggle="tab">All Files</a></li>
                    										<li><a href="#my_files" data-toggle="tab">My Files</a></li>
                    									</ul>
                    									<div class="tab-content">
                    										<div class="tab-pane active" id="all_files">
                    											<ul class="files-list">
                    												<li>
                    													<div class="files-cont">
                    														<div class="file-type">
                    															<span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                    														</div>
                    														<div class="files-info">
                    															<span class="file-name text-ellipsis">AHA Selfcare Mobile Application Test-Cases.xls</span>
                    															<span class="file-author"><a href="#">Loren Gatlin</a></span> <span class="file-date">May 31st at 6:53 PM</span>
                    														</div>
                    														<ul class="files-action">
                    															<li class="dropdown">
                    																<a href="" class="dropdown-toggle btn btn-default btn-xs" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                    																<ul class="dropdown-menu">
                    																	<li><a href="javascript:void(0)">Download</a></li>
                    																	<li><a href="#" data-toggle="modal" data-target="#share_files">Share</a></li>
                    																</ul>
                    															</li>
                    														</ul>
                    													</div>
                    												</li>
                    											</ul>
                    										</div>
                    										<div class="tab-pane" id="my_files">
                    											<ul class="files-list">
                    												<li>
                    													<div class="files-cont">
                    														<div class="file-type">
                    															<span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                    														</div>
                    														<div class="files-info">
                    															<span class="file-name text-ellipsis">AHA Selfcare Mobile Application Test-Cases.xls</span>
                    															<span class="file-author"><a href="#">John Doe</a></span> <span class="file-date">May 31st at 6:53 PM</span>
                    														</div>
                    														<ul class="files-action">
                    															<li class="dropdown">
                    																<a href="" class="dropdown-toggle btn btn-default btn-xs" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                    																<ul class="dropdown-menu">
                    																	<li><a href="javascript:void(0)">Download</a></li>
                    																	<li><a href="#" data-toggle="modal" data-target="#share_files">Share</a></li>
                    																</ul>
                    															</li>
                    														</ul>
                    													</div>
                    												</li>
                    											</ul>
                    										</div>
                    									</div> -->
                    								</div>
                    							</div>
                    						</div>
                    					</div>
                    				</div>
                    			</div>
                    </div>
                </div>
                    </div>
                </div>
            </div>
            </div>
        <!-- Video Call Starts ends  -->


        <!-- Video Call Page Content Starts  -->
	<div id="for_group_video">
         <div class="page-wrapper video <?php echo $video_class; ?>">
            <div class="chat-main-row <?php echo $class; ?>">
                <div class="chat-main-wrapper">
                    <div class="col-xs-9 message-view task-view">
                        <div class="chat-window">
							<div class="chat-header">
                                <div class="navbar">
                                    <div class="user-details">
                                        <div class="pull-left user-img m-r-10">
                                            <a href="#" title="<?php echo $name; ?>"><img src="<?php echo $receiver_profile_img; ?>" alt="" class="w-40 img-circle receiver_title_image"><span class="status online"></span></a>
                                        </div>
                                        <div class="user-info pull-left">
                                            <a href="javascript:void()" title="<?php echo $name; ?>"><span class="font-bold to_group_video_name"><?php echo $name; ?></span></a>
                                            <span class="font-bold to_group_video hidden"><?php echo $name; ?></span>
                                        </div>
                                    </div>
                                    <ul class="nav navbar-nav pull-right chat-menu">
                                        <li>
											<a href="#chat_sidebar" class="task-chat profile-rightbar pull-right"><i class="fa fa-comments" aria-hidden="true"></i></a>
										</li>	
                                    </ul>
                                </div>
                            </div>

                            <div class="chat-contents">
                                <div class="chat-content-wrap">
                                	<div class="user-video voice-call-avatar">
                                        <img src="<?php echo $receiver_profile_img; ?>" class="call-avatar incoming_image receiver_title_image group_video_image">
                                        <button class="start-call" type="group_video">Join</button>
                                        <div class="group_video_call_status"></div>
                                        <div id="incoming_group_video_div">
											<!-- <video id='incoming_group_video' autoplay class='img-responsive' ></video> -->
										</div>

                                    </div>

                                    <div class="my-video for-group-video">
                                        <ul>
                                            <li id="outgoing_video_initial">
                                            	 <img src="<?php echo $profile_img; ?>" class="call-avatar img-responsive outgoing_image ">
                                            	<!-- <video id="outgoing" autoplay class="img-responsive" muted></video> -->
                                            </li>
                                            <div class="group_members"></div>
                                        </ul>
                                    </div>
                                </div>
                            </div>




                            <div class="chat-footer hidden" id="group-video-footer">
                                <div class="call-icons">
                                    <ul class="call-items">
                                        <li class="call-item enable_video" id="group_video_mute">
                                            <a href="javascript:void(0)" title="Disable Video" data-placement="top" data-toggle="tooltip">
                                                <i class="fa fa-video-camera camera" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="call-item mute_icon">
                                            <a href="javascript:void(0)" title="Mute Audio" data-placement="top" data-toggle="tooltip">
                                                <i class="fa fa-microphone microphone" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="end-call">
                                        <a href="javascript:void(0)" class="hangup">
												End Call
											</a>
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>
                    <div class="col-xs-3 message-view chat-profile-view chat-sidebar" id="chat_sidebar">
                        <div class="chat-window video-window">
                            <div class="chat-header">
                                <ul class="nav nav-tabs nav-tabs-bottom">
                                    <li class="active"><a href="#calls_tab" data-toggle="tab">Calls</a></li>
                                </ul>
                            </div>
                            <div class="tab-content chat-contents">
                                <div class="content-full tab-pane active hidden" id="calls_tab">                                
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            </div>
        <!-- Video Call Starts ends  -->



        <!-- Screen Share Page Content Starts  -->
	<div id="for_screen_share_group">
         <div class="page-wrapper screen-share-window <?php echo $screen_share_class; ?>">
            <div class="chat-main-row <?php echo $class; ?>">
                <div class="chat-main-wrapper">
                    <div class="col-xs-9 message-view task-view">
                        <div class="chat-window">
							

                            <div class="chat-contents">
                                <div class="chat-content-wrap">
                                	<div class="user-video voice-call-avatar">
                                        <button id="group_screen_btn" data-name="" data-id="" class="start-call" type="group_screen">Screen Share</button>
                                    </div>
                                </div>
                                <a id="shareIframe" href="" target="_blank" style="display: none;">view</a>
                            </div>




                            




                        </div>
                    </div>
                    </div>
                </div>
            </div>
            </div>
        <!-- Video Call Starts ends  -->




        <!-- POPUPS  -->
        <?php $this->load->view('user/popups'); ?>


        <?php $this->load->view('notifications');  ?>