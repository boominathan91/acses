F <?php   

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
							<li> 
								<a href="chat.html">#General</a>
							</li>
							<li> 
								<a href="chat.html">#Video Responsive Survey</a>
							</li>
							<li> 
								<a href="chat.html">#500rs</a>
							</li>
							<li> 
								<a href="chat.html">#warehouse</a>
							</li>
							<li class="menu-title">Direct Chats <a href="#" data-toggle="modal" data-target="#add_chat_user"><i class="fa fa-plus"></i></a></li>
							<div id="session_chat_user"></div>
							

							<li id="testestt2"> 
								<a href="chat.html"><span class="status offline"></span> Test Test <span class="badge bg-danger pull-right">18</span></a>
							</li>
							<li> 
								<a href="chat.html"><span class="status away"></span> John Smith</a>
							</li>
							<li class="active"> 
								<a href="chat.html"><span class="status online"></span> Mike Litorus <span class="badge bg-danger pull-right">108</span></a>
							</li>
							<!-- Text Chat  ends -->					
						<?php } ?>
						</ul>
					</div>
                </div>
            </div>