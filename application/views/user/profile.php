<div class="main-wrapper">
	<?php $this->load->view('user/includes/nav_bar'); ?>
	<div class="page-wrapper">
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
												if(empty($profile['profile_img'])){
													$profile_img = base_url().'assets/img/user.jpg';
												}else{
													$profile_img = base_url().'uploads/'.$profile['profile_img'];
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
														<span class="text"><a href=""><?php echo (!empty($profile['phone_number']))?$profile['phone_number']:'N/A'; ?></a></span>
													</li>
													<li>
														<span class="title">Email:</span>
														<span class="text"><a href=""><?php echo (!empty($profile['email']))?$profile['email']:'N/A'; ?></a></span>
													</li>
													<li>
														<span class="title">Birthday:</span>
														<span class="text"><?php echo (!empty($profile['dob']))?$profile['dob']:'N/A'; ?></span>
													</li>
													<li>
														<span class="title">Address:</span>
														<span class="text"><?php echo (!empty($profile['address']))?$profile['address'].','.$profile['cityname'].','.$profile['statename'].','.$profile['countryname']:'N/A'; ?></span>
													</li>
													<li>
														<span class="title">Gender:</span>
														<span class="text"><?php echo (!empty($profile['gender']))?ucfirst($profile['gender']):'N/A'; ?></span>
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