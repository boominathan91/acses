<div class="main-wrapper">
	<?php $this->load->view('user/includes/nav_bar'); 
	
	if(!empty($chat)){
		$name = ucfirst($chat['first_name']).' '.ucfirst($chat['last_name']);
		$class = 'hidden';
		$online_status = $chat['online_status'];
	}else{
		$name = '';
		$class = 'hidden';
		$online_status = 'offline';
	} 

	?>


	<!-- From USER  -->

	<input type="hidden" name="sender_id" id="sender_id" value="<?php echo $this->session->userdata('sinch_username'); ?>">
	 <div class="page-wrapper">
				<div class="chat-main-row <?php echo $class; ?>">
					<div class="chat-main-wrapper">
						<div class="col-xs-9 message-view task-view">
							<div class="chat-window">
								<div class="chat-header">
									<div class="navbar">
										<div class="user-details">
											<div class="pull-left user-img m-r-10">
												<a href="#" title="Mike Litorus"><img src="assets/img/user.jpg" alt="" class="w-40 img-circle"><span class="status <?php echo $online_status; ?>"></span></a>
											</div>
											<div class="user-info pull-left">
												<a href="#" title="<?php $name; ?>"><span class="font-bold to_name"><?php echo $name; ?></span></a>
												<input type="text" name="recipients" id="recipients">
												<!-- 
												<span class="last-seen">Last seen today at 7:50 AM</span> -->
											</div>
										</div>										
										<a href="#task_window" class="task-chat profile-rightbar pull-right"><i class="fa fa-user" aria-hidden="true"></i></a>
									</div>
								</div>
								<div class="chat-contents">
									<div class="chat-content-wrap">
										<div class="chat-wrap-inner">
											<div class="chat-box">
												<div class="chats"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="chat-footer">
									<div class="message-bar">
										<div class="message-inner">
											<a class="link attach-icon" href="#" data-toggle="modal" data-target="#drag_files"><img src="assets/img/attachment.png" alt=""></a>
											<div class="message-area"><div class="input-group">
												<textarea class="form-control" placeholder="Type message..." id="input_message"></textarea>
												<span class="input-group-btn">
													<button class="btn btn-primary" type="button" onclick="message()"><i class="fa fa-send"></i></button>
												</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-3 profile-right fixed-sidebar-right chat-profile-view" id="task_window">
							<div class="display-table profile-right-inner">
								<div class="table-row">
									<div class="table-body">
										<div class="table-content">
											<div class="chat-profile-img">
												<div class="edit-profile-img">
													<img class="avatar" src="assets/img/user.jpg" alt="">
													<span class="change-img">Change Image</span>
												</div>
												<h3 class="user-name m-t-10 m-b-0">John Doe</h3>
												<small class="text-muted">Web Designer</small>
												<a href="edit-profile.html" class="btn btn-primary edit-btn"><i class="fa fa-pencil"></i></a>
											</div>
											<div class="chat-profile-info">
												<ul class="user-det-list">
													<li>
														<span>Username:</span>
														<span class="pull-right text-muted">johndoe</span>
													</li>
													<li>
														<span>DOB:</span>
														<span class="pull-right text-muted">24 July</span>
													</li>
													<li>
														<span>Email:</span>
														<span class="pull-right text-muted">johndoe@example.com</span>
													</li>
													<li>
														<span>Phone:</span>
														<span class="pull-right text-muted">9876543210</span>
													</li>
												</ul>
											</div>
											<div class="tabbable">
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
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="drag_files" class="modal custom-modal fade center-modal" role="dialog">
					<div class="modal-dialog">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<div class="modal-content">
							<div class="modal-header">
								<h3 class="modal-title">Drag and drop files upload</h3>
							</div>
							<div class="modal-body p-t-0">
                                <form id="js-upload-form">
									<div class="upload-drop-zone" id="drop-zone">
										<i class="fa fa-cloud-upload fa-2x"></i> <span class="upload-text">Just drag and drop files here</span>
									</div>
                                    <h4>Uploading</h4>
                                    <ul class="upload-list">
                                        <li class="file-list">
                                            <div class="upload-wrap">
                                                <div class="file-name">
                                                    <i class="fa fa-photo"></i>
                                                    photo.png
                                                </div>
                                                <div class="file-size">1.07 gb</div>
                                                <button type="button" class="file-close">
                                                    <i class="fa fa-close"></i>
                                                </button>
                                            </div>
                                            <div class="progress progress-xs progress-striped">
												<div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
											</div>
                                            <div class="upload-process">37% done</div>
                                        </li>
                                        <li class="file-list">
                                            <div class="upload-wrap">
                                                <div class="file-name">
                                                    <i class="fa fa-file"></i>
                                                    task.doc
                                                </div>
                                                <div class="file-size">5.8 kb</div>
                                                <button type="button" class="file-close">
                                                    <i class="fa fa-close"></i>
                                                </button>
                                            </div>
                                            <div class="progress progress-xs progress-striped">
												<div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
											</div>
                                            <div class="upload-process">37% done</div>
                                        </li>
                                        <li class="file-list">
                                            <div class="upload-wrap">
                                                <div class="file-name">
                                                    <i class="fa fa-photo"></i>
                                                    dashboard.png
                                                </div>
                                                <div class="file-size">2.1 mb</div>
                                                <button type="button" class="file-close">
                                                    <i class="fa fa-close"></i>
                                                </button>
                                            </div>
                                            <div class="progress progress-xs progress-striped">
												<div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
											</div>
                                            <div class="upload-process">Completed</div>
                                        </li>
                                    </ul>
                                </form>
								<div class="m-t-30 text-center">
								<button class="btn btn-primary btn-lg">Add to upload</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="add_group" class="modal custom-modal fade center-modal" role="dialog">
					<div class="modal-dialog">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<div class="modal-content">
							<div class="modal-header">
								<h3 class="modal-title">Create a group</h3>
							</div>
							<div class="modal-body">
								<p>Groups are where your team communicates. They’re best when organized around a topic — #leads, for example.</p>
								<form>
								<div class="form-group">
									<label>Group Name <span class="text-danger">*</span></label>
									<input class="form-control" required="" type="text">
								</div>
								<div class="form-group">
									<label>Send invites to: <span class="text-muted-light">(optional)</span></label>
									<input class="form-control" required="" type="text">
								</div>
								<div class="m-t-50 text-center">
								<button class="btn btn-primary btn-lg">Create Group</button>
								</div>
							</form>
							</div>
						</div>
					</div>
				</div>
				<div id="add_chat_user" class="modal custom-modal fade center-modal" role="dialog">
					<div class="modal-dialog">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<div class="modal-content">
							<div class="modal-header">
								<h3 class="modal-title">Direct Chat</h3>
							</div>
							<div class="modal-body">
								<div class="input-group m-b-30">
									<input placeholder="Search to start a chat" class="form-control search-input input-lg" id="search_user" type="text">
									<span class="input-group-btn">
										<button class="btn btn-primary btn-lg" onclick="search_user()">Search</button>
									</span>
								</div>
								<div>
									<h5>Recent Conversations</h5>
									<div id="user_list"></div>									
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="share_files" class="modal custom-modal fade center-modal" role="dialog">
					<div class="modal-dialog">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<div class="modal-content">
							<div class="modal-header">
								<h3 class="modal-title">Share File</h3>
							</div>
							<div class="modal-body">
								<div class="files-share-list">
									<div class="files-cont">
										<div class="file-type">
											<span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
										</div>
										<div class="files-info">
											<span class="file-name text-ellipsis">AHA Selfcare Mobile Application Test-Cases.xls</span>
											<span class="file-author"><a href="#">Bernardo Galaviz</a></span> <span class="file-date">May 31st at 6:53 PM</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Share With</label>
									<input class="form-control" type="text">
								</div>
								<div class="m-t-50 text-center">
									<button class="btn btn-primary btn-lg">Share</button>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>