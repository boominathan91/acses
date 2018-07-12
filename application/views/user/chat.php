<div class="main-wrapper">
	<?php $this->load->view('user/includes/nav_bar'); 
		$name = '';
		$class = 'hidden';
		$online_status = '';
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
		
		$name = ucfirst($chat[0]['group_name']);
		$class = '';
		$online_status = 'online';
		$receiver_profile_img = base_url().'assets/img/user.jpg';
		foreach($chat as $c){
			$receiver_id[]=$c['login_id'];
			$sinch_username[]=$c['sinch_username'];
		}
		$receiver_id = implode(',',$receiver_id);
		$receiver_sinchusername = implode(',',$sinch_username);
		$receiver_email = '';
		$phone_number ='';		
		$department_name = '';
		$dob = '';
		$mesage_type="group";
		$group_id = $chat[0]['group_id'];
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
	


	<div class="page-wrapper">
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
									<button data-target="#incoming_call" data-toggle="modal">Call</button>
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
										<div class="chat-box slimscrollleft">
											<div class="chats">
												<?php 
												if(!empty($latest_chats)){

													if(count($latest_chats)>4){

														echo '<div class="load-more-btn text-center" total="'.$page.'">
														<button class="btn btn-default" data-page="2"><i class="fa fa-refresh"></i> Load More</button>
														</div><div id="ajax_old"></div>';      
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
															<img alt="'.$sender_name.'" src="'.$sender_profile_img.'" class="img-responsive img-circle">
															</a>
															</div>';
															$class_name = 'chat-left';
														}
														if($msg == 'file' && $type == 'image'){

															echo '<div class="chat '.$class_name.' slimscrollleft">'.$img_avatar.'
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

															echo '<div class="chat '.$class_name.' slimscrollleft">'.$img_avatar.'
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

															echo '<div class="chat '.$class_name.' slimscrollleft">'.$img_avatar.'
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
												<div id="ajax"></div>
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
			<!-- POPUPS  -->
			<?php $this->load->view('user/popups'); ?>
		</div>

		<?php $this->load->view('notifications');  ?>