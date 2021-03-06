<!-- Loader -->
<div class="loading style-2"><div class="loading-wheel"></div></div>
<div class="download hidden" >
	Click to Install Extension <a href='https://chrome.google.com/webstore/detail/screenleap/hpcipbhehomfgjbgnajdhiahhdeeffbg?utm_source=chrome-ntp-icon' target='_blank' onclick="hide_message()">Download</a>
</div>
<script>
	function hide_message(){
		$('.download').addClass('hidden');
	}
</script>
<style type="text/css">

.download{
    position: fixed;
    right: 11px;
    top: 11px;
    background: aliceblue;
    z-index: 999999;
    font-size: 23px;
    padding: 25px 12px 27px 19px;
    border-radius: 6px 5px 5px 5px;

}

.disabled {
    pointer-events:none; //This makes it not clickable
    opacity:0.6;         //This grays it out to look disabled
}

	.subscriber {
    display: block !important;
    width: 100% !important;
    float: left;
}

.subscriber > div {
    width: 100% !important;
    height: 200px !important;
    margin-bottom: 10px !important;
}
</style>
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




			<?php 

									$group_name ='';
									$group_id = $this->session->userdata('session_group_id');
									if(!empty($group_id)){

										$group_name = $this->db
										->select('group_name')
										->get_where('chat_group_details',array('group_id'=>$group_id))
										->row_array();

										$group_name =$group_name['group_name'];


										$group_class = "";
										$one_class="hidden";
									}else{
										$group_class = "hidden";
										$one_class="";
										$group_name ='';
									} 
									?>



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
											<span class="group_members_list last-seen"></span>
												</div>			
												
											</div>		
											<div class="video_call_status" id="video_timer"></div>

											<input type="hidden"  id="new_call_type">

											<ul class="nav navbar-nav pull-right chat-menu ">	
												
												<li class="call-item audio_call_icon">
													<a href="javascript:void(0)" title="Audio" data-placement="top" data-toggle="tooltip" onclick="handle_video_panel(0)">
														<i class="fa fa-phone phone" aria-hidden="true"></i>
													</a>
												</li>	
												<li class="call-item enable_video" onclick="handle_video_panel(1)">
													<a href="javascript:void(0)" title="Video" data-placement="top" data-toggle="tooltip">
														<i class="fa fa-video-camera camera" aria-hidden="true"></i>
													</a>
												</li>                                        
												<li class="call-item add_user ">
													<a href="javascript:void(0)" title="Add User" data-placement="top" data-toggle="tooltip" onclick="add_user()">
														<i class="fa fa-user-plus" aria-hidden="true"></i>
													</a>
												</li>                                        
												<li class="call-item">
													<a href="javascript:void(0)" title="Screen Share" data-placement="top" data-toggle="tooltip" onclick="set_screen_share_url()">
														<i class="fa fa-desktop full-screen" aria-hidden="true"></i>
													</a>
												</li>
												<li class="call-item edit_group_name" data-groupname>
													<a href="javascript:void(0)" title="Edit Group name" data-placement="top" data-toggle="tooltip" onclick="edit_group()">
														<i class="fa fa-pencil pencil" aria-hidden="true"></i>
													</a>
												</li>
												<li class="call-item delete_group_name">
													<a href="javascript:void(0)" title="Delete Group" data-placement="top" data-toggle="tooltip" onclick="delete_group()">
														<i class="fa fa-trash trash" aria-hidden="true"></i>
													</a>
												</li>
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

									

									<!-- Group call Contents starts  -->
									<div class="container-fluid vccontainer group_vccontainer hidden">
										<div class="vcrow">
											<div class="vccol vccollarge">
												<div class="vcvideo">
													<div class="videoinner">
														<div class="to_group_video hidden"><?php echo $group_name; ?></div>
														<img src="<?php echo base_url().'assets/img/user.jpg'; ?>" class="img-circle img-responsive center-block" id="inner_image">

														<div id="sample" style="width: 54%;height: 100%;margin: 0 0 0 250px;"></div>
														
													</div>
													<div class="vcopponentvideo">
														<img src="<?php echo  $profile_img ?>" class="img-responsive" id="group_outgoing_caller_image">
														<div  id="outgoing"  style="width: 282px;height: 209px;"></div>
													</div>
													<div class="vcactions">
														<a class="vccam hidden" href="javascript:void(0)" id="group_video_mute">Video</a>  
														<a href="javascript:void(0)" class="vcend hidden" ">Call End</a>
													</div>	


												</div>
											</div>
										</div>
									</div>

									<!-- Group call Contents ends  -->


									<!-- Video call Contents here  -->
								<!-- 	<div class="container-fluid vccontainer single_video hidden">
										<div class="vcfullscreen">1</div>    
										<div class="vcrow">
											<div class="vccol vccollarge">
												<div class="vcvideo">
													<div class="videoinner">
														<video autoplay id="incoming" class="hidden" style="display: inline;height: 98%;margin: auto;width: 100%;"></video>
														<img src="<?php echo base_url().'assets/img/user.jpg'; ?>" class="img-circle img-responsive center-block" id="incoming_caller_image">
														
													</div>
													<div class="vcopponentvideo">
														<img src="<?php echo  $profile_img ?>" class="img-responsive" id="outgoing_caller_image">
														<div  id="outgoing"  style="width: 282px;height: 209px;"></div>
														<div class="video_call_status" id="video_timer"></div>

													</div>	
													<div class="vcactions">
														<a href="javascript:void(0)" class="vcend hidden" ">Call End</a>
													</div>											
												</div>
											</div>
										</div>
									</div> -->
									
									<!-- Video call Contents ends here  -->
									<!-- <input type="text" id="connectionCountField" value="0"></input> -->

									<!-- Chat contents starts  -->
									
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
																$time = date('h:i A',strtotime($l['chatdate']));
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
																	<li><i class="fa fa-file"></i><a href="'.$file_name.'" target="_blank">'.$up_file_name.'</a></li>
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
															<input type="hidden" name="" value="<?php echo ucfirst($group_name); ?>" id="hidden_group_name">
															<input type="hidden" name="sender_sinchusername" id="sender_sinchusername" value="<?php echo $this->session->userdata('sinch_username'); ?>">
															<!-- sender sinch username  -->
															<input type="hidden" name="receiver_sinchusername" id="receiver_sinchusername" value="<?php echo $receiver_sinchusername; ?>">
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


															<audio id="ringback" src="<?php echo base_url().'assets/audio/ringback.wav'; ?>" loop></audio>
															<audio id="ringtone" src="<?php echo base_url().'assets/audio/phone_ring.wav'; ?>" loop></audio>
															<input type="hidden"  id="call_to_id" value="<?php echo $receiver_id ?>" >	
															<input type="hidden"  id="call_from_id" >	
															<input type="hidden" id="call_type" value="audio">
															<input type="hidden" id="call_duration" value="call_duration" >
															<input type="hidden" id="call_started_at" value="call_started_at" >
															<input type="hidden" id="call_ended_at" value="call_ended_at">
															<input type="hidden" id="end_cause" value="end_cause" >	


															<?php if(!empty($this->session->userdata('session_group_id'))){ 
																
																echo '<input type="hidden" id="video_type" value="many" >';
															}else{
																echo '<input type="hidden" id="video_type" value="one" >';

															} ?>

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

							<div class="col-xs-3 message-view chat-profile-view chat-sidebar" id="chat_sidebar">
								<div class="chat-window video-window  gr_tab">
									<div class="chat-header">
										<ul class="nav nav-tabs nav-tabs-bottom">
											<li class="active"><a href="#member_tab" data-toggle="tab">Members</a></li>
										</ul>
									</div>
									<div class="tab-content chat-contents">
										<div class="content-full tab-pane active" id="member_tab">
											<div class="chat-wrap-inner">
												<div class="chat-box">
													<div class="chats group_members">
														<div id="temp"></div>
														<?php 
														$group_name='';
														$group_id = $this->session->userdata('session_group_id');
														if(!empty($group_id)){

															$group_name = $this->db
															->select('group_name')
															->get_where('chat_group_details',array('group_id'=>$group_id))
															->row_array();

															$this->db->select('l.sinch_username,l.login_id,l.profile_img,l.first_name,l.last_name, cg.members_id');
															$this->db->where('cg.group_id',$group_id);
															$this->db->where('cg.login_id !=',$this->login_id);
															$this->db->join('login_details l','l.login_id = cg.login_id');
															$group_members= $this->db->get('chat_group_members cg')->result_array();	


															if(!empty($group_members)){


																foreach ($group_members as  $g) {

																	if(!empty($g['profile_img'])){
																		$receivers_image = $g['profile_img'];
																		$file_to_check = FCPATH . '/uploads/' . $receivers_image;
																		if (file_exists($file_to_check)) {
																			$receivers_image = base_url() . 'uploads/'.$receivers_image;
																		}
																	}
																	$receivers_image = (!empty($g['profile_img']))?$receivers_image : base_url().'assets/img/user.jpg';

																	echo '<div class="test" >
																	<img src="'.$receivers_image.'" title ="'.$g['first_name'].' '.$g['last_name'].'" class="img-responsive outgoing_image" alt="" id="image_'.$g['sinch_username'].'" >
																	<video id="video_'.$g['sinch_username'].'" autoplay unmute class="hidden"></video>
																	<span class="thumb-title">'.$g['first_name'].' '.$g['last_name'].'</span>
																	</div>';
																}
															}
														}else{
															echo '<div class="test" >
																	<img src="'.$receiver_profile_img.'" title ="'.$name.'" class="img-responsive outgoing_image" alt="" id="image_'.$receiver_sinchusername.'" >
																	<video id="video_'.$receiver_sinchusername.'" autoplay unmute class="hidden"></video>
																	<span class="thumb-title">'.$name.'</span>
																	</div>';
														}
														
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- <div class="chat-window video-window vc_tab <?php echo $one_class; ?>">
									<div class="chat-header">
										<ul class="nav nav-tabs nav-tabs-bottom">
											<li class="active"><a href="#call_tab" data-toggle="tab">Member</a></li>
										</ul>
									</div>
									<div class="tab-content chat-contents">
										<div class="content-full tab-pane active" id="call_tab">
											<div class="chat-wrap-inner">
												<div class="chat-box">
													<div class="chats group_members" id="receiver_video_tab">
														<?php 

															echo '<div class="test" >
																	<img src="'.$receiver_profile_img.'" title ="'.$name.'" class="img-responsive outgoing_image" alt="" id="image_'.$receiver_sinchusername.'" >
																	<video id="video_'.$receiver_sinchusername.'" autoplay unmute class="hidden"></video>
																	<span class="thumb-title">'.$name.'</span>
																	</div>';

														?>
														</div>
													</div>
												</div>
											</div>                    														
										</div>
									</div>  --><!-- video window ends  -->
								</div>
							</div>
						</div>
					</div>
					<!-- Text Chat Page Content ends  -->


					<!-- POPUPS  -->
					<?php $this->load->view('user/popups'); ?>


					<?php $this->load->view('notifications');  ?>