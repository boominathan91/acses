<div class="main-wrapper">
	<?php $this->load->view('nav_bar'); ?>
		<div class="page-wrapper">
			<div class="content container-fluid">
				<div class="row">
					<div class="col-xs-4">
						<h4 class="page-title"><?php lang('employees'); ?></h4>
					</div>
					<div class="col-xs-8 text-right m-b-30">
						<a href="#" class="btn btn-primary pull-right rounded" data-toggle="modal" data-target="#add_employee"><i class="fa fa-plus"></i> <?php lang('add_employee'); ?></a>
						<div class="view-icons">
							<a href="javascript:void(0);" class="grid-view btn btn-link" id="staff-grid-view"><i class="fa fa-th"></i></a>
							<a href="javascript:void(0);" class="list-view btn btn-link active" id="staff-table-view"><i class="fa fa-bars"></i></a>
						</div>
					</div>
				</div>
				<div class="row filter-row">
					<div class="col-sm-3 col-xs-6">  
						<div class="form-group form-focus">
							<label class="control-label"><?php lang('employee_id'); ?></label>
							<input type="text" class="form-control floating" />
						</div>
					</div>
					<div class="col-sm-3 col-xs-6">  
						<div class="form-group form-focus">
							<label class="control-label"><?php lang('employee_name'); ?></label>
							<input type="text" class="form-control floating" />
						</div>
					</div>
					<div class="col-sm-3 col-xs-6"> 
						<div class="form-group form-focus select-focus">
							<label class="control-label"><?php lang('designation'); ?></label>
							<select class="select floating"> 
								<option value=""><?php lang('select_designation'); ?></option>
								<option value="">Web Developer</option>
								<option value="1">Web Designer</option>
								<option value="1">Android Developer</option>
								<option value="1">Ios Developer</option>
							</select>
						</div>
					</div>
					<div class="col-sm-3 col-xs-6">  
						<a href="#" class="btn btn-success btn-block"><?php lang('search') ?></a>  
					</div>     
				</div>
				<div class="row staff-table-view">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-striped custom-table datatable">
								<thead>
									<tr>
										<th style="width:30%;"><?php lang('employee_name') ?></th>
										<th><?php lang('employee_id'); ?></th>
										<th><?php lang('email'); ?></th>
										<th><?php lang('mobile'); ?></th>
										<th><?php lang('join_date'); ?></th>
										<th class="text-right"><?php lang('action'); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<a href="profile.html" class="avatar">J</a>
											<h2><a href="profile.html">John Doe <span>Web Designer</span></a></h2>
										</td>
										<td>FT-0001</td>
										<td>johndoe@example.com</td>
										<td>9876543210</td>
										<td>1 Jan 2013</td>
										<td class="text-right">
											<div class="dropdown">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<ul class="dropdown-menu pull-right">
													<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
													<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
												</ul>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<a href="profile.html" class="avatar">R</a>
											<h2><a href="profile.html">Richard Miles <span>Web Developer</span></a></h2>
										</td>
										<td>FT-0002</td>
										<td>richardmiles@example.com</td>
										<td>9876543210</td>
										<td>18 Mar 2014</td>
										<td class="text-right">
											<div class="dropdown">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<ul class="dropdown-menu pull-right">
													<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
													<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
												</ul>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<a href="profile.html" class="avatar">J</a>
											<h2><a href="profile.html">John Smith <span>Android Developer</span></a></h2>
										</td>
										<td>FT-0003</td>
										<td>johnsmith@example.com</td>
										<td>9876543210</td>
										<td>1 Apr 2014</td>
										<td class="text-right">
											<div class="dropdown">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<ul class="dropdown-menu pull-right">
													<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
													<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
												</ul>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<a href="profile.html" class="avatar">M</a>
											<h2><a href="profile.html">Mike Litorus <span>IOS Developer</span></a></h2>
										</td>
										<td>FT-0004</td>
										<td>mikelitorus@example.com</td>
										<td>9876543210</td>
										<td>1 Apr 2014</td>
										<td class="text-right">
											<div class="dropdown">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<ul class="dropdown-menu pull-right">
													<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
													<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
												</ul>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<a href="profile.html" class="avatar">W</a>
											<h2><a href="profile.html">Wilmer Deluna <span>Team Leader</span></a></h2>
										</td>
										<td>FT-0005</td>
										<td>wilmerdeluna@example.com</td>
										<td>9876543210</td>
										<td>22 May 2014</td>
										<td class="text-right">
											<div class="dropdown">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<ul class="dropdown-menu pull-right">
													<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
													<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
												</ul>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<a href="profile.html" class="avatar">J</a>
											<h2><a href="profile.html">Jeffrey Warden <span>Web Developer</span></a></h2>
										</td>
										<td>FT-0006</td>
										<td>jeffreywarden@example.com</td>
										<td>9876543210</td>
										<td>16 Jun 2013</td>
										<td class="text-right">
											<div class="dropdown">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<ul class="dropdown-menu pull-right">
													<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
													<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
												</ul>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<a href="profile.html" class="avatar">B</a>
											<h2><a href="profile.html">Bernardo Galaviz <span>Web Developer</span></a></h2>
										</td>
										<td>FT-0007</td>
										<td>bernardogalaviz@example.com</td>
										<td>9876543210</td>
										<td>1 Jan 2013</td>
										<td class="text-right">
											<div class="dropdown">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<ul class="dropdown-menu pull-right">
													<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
													<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
												</ul>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row staff-grid-view">
						<div class="col-md-4 col-sm-4 col-xs-6 col-lg-3">
							<div class="profile-widget">
								<div class="profile-img">
									<a href="profile.html"><img class="avatar" src="assets/img/user.jpg" alt=""></a>
								</div>
								<div class="dropdown profile-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
									<ul class="dropdown-menu pull-right">
										<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
										<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
									</ul>
								</div>
								<h4 class="user-name m-t-10 m-b-0 text-ellipsis"><a href="profile.html">John Doe</a></h4>
								<div class="small text-muted">Web Designer</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-6 col-lg-3">
							<div class="profile-widget">
								<div class="profile-img">
									<a href="profile.html" class="avatar">R</a>
								</div>
								<div class="dropdown profile-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
									<ul class="dropdown-menu pull-right">
										<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
										<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
									</ul>
								</div>
								<h4 class="user-name m-t-10 m-b-0 text-ellipsis"><a href="profile.html">Richard Miles</a></h4>
								<div class="small text-muted">Web Developer</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-6 col-lg-3">
							<div class="profile-widget">
								<div class="profile-img">
									<a href="profile.html" class="avatar">J</a>
								</div>
								<div class="dropdown profile-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
									<ul class="dropdown-menu pull-right">
										<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
										<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
									</ul>
								</div>
								<h4 class="user-name m-t-10 m-b-0 text-ellipsis"><a href="profile.html">John Smith</a></h4>
								<div class="small text-muted">Android Developer</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-6 col-lg-3">
							<div class="profile-widget">
								<div class="profile-img">
									<a href="profile.html" class="avatar">M</a>
								</div>
								<div class="dropdown profile-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
									<ul class="dropdown-menu pull-right">
										<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
										<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
									</ul>
								</div>
								<h4 class="user-name m-t-10 m-b-0 text-ellipsis"><a href="profile.html">Mike Litorus</a></h4>
								<div class="small text-muted">IOS Developer</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-6 col-lg-3">
							<div class="profile-widget">
								<div class="profile-img">
									<a href="profile.html" class="avatar">W</a>
								</div>
								<div class="dropdown profile-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
									<ul class="dropdown-menu pull-right">
										<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
										<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
									</ul>
								</div>
								<h4 class="user-name m-t-10 m-b-0 text-ellipsis"><a href="profile.html">Wilmer Deluna</a></h4>
								<div class="small text-muted">Team Leader</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-6 col-lg-3">
							<div class="profile-widget">
								<div class="profile-img">
									<a href="profile.html" class="avatar">J</a>
								</div>
								<div class="dropdown profile-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
									<ul class="dropdown-menu pull-right">
										<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
										<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
									</ul>
								</div>
								<h4 class="user-name m-t-10 m-b-0 text-ellipsis"><a href="profile.html">Jeffrey Warden</a></h4>
								<div class="small text-muted">Web Developer</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-6 col-lg-3">
							<div class="profile-widget">
								<div class="profile-img">
									<a href="profile.html" class="avatar">B</a>
								</div>
								<div class="dropdown profile-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
									<ul class="dropdown-menu pull-right">
										<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
										<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
									</ul>
								</div>
								<h4 class="user-name m-t-10 m-b-0 text-ellipsis"><a href="profile.html">Bernardo Galaviz</a></h4>
								<div class="small text-muted">Web Developer</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-6 col-lg-3">
							<div class="profile-widget">
								<div class="profile-img">
									<a href="profile.html" class="avatar">L</a>
								</div>
								<div class="dropdown profile-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
									<ul class="dropdown-menu pull-right">
										<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
										<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
									</ul>
								</div>
								<h4 class="user-name m-t-10 m-b-0 text-ellipsis"><a href="profile.html">Lesley Grauer</a></h4>
								<div class="small text-muted">Team Leader</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-6 col-lg-3">
							<div class="profile-widget">
								<div class="profile-img">
									<a href="profile.html" class="avatar">J</a>
								</div>
								<div class="dropdown profile-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
									<ul class="dropdown-menu pull-right">
										<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
										<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
									</ul>
								</div>
								<h4 class="user-name m-t-10 m-b-0 text-ellipsis"><a href="profile.html">Jeffery Lalor</a></h4>
								<div class="small text-muted">Team Leader</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-6 col-lg-3">
							<div class="profile-widget">
								<div class="profile-img">
									<a href="profile.html" class="avatar">L</a>
								</div>
								<div class="dropdown profile-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
									<ul class="dropdown-menu pull-right">
										<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
										<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
									</ul>
								</div>
								<h4 class="user-name m-t-10 m-b-0 text-ellipsis"><a href="profile.html">Loren Gatlin</a></h4>
								<div class="small text-muted">Android Developer</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-6 col-lg-3">
							<div class="profile-widget">
								<div class="profile-img">
									<a href="profile.html" class="avatar">T</a>
								</div>
								<div class="dropdown profile-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
									<ul class="dropdown-menu pull-right">
										<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
										<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
									</ul>
								</div>
								<h4 class="user-name m-t-10 m-b-0 text-ellipsis"><a href="profile.html">Tarah Shropshire</a></h4>
								<div class="small text-muted">Android Developer</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-6 col-lg-3">
							<div class="profile-widget">
								<div class="profile-img">
									<a href="profile.html" class="avatar">C</a>
								</div>
								<div class="dropdown profile-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
									<ul class="dropdown-menu pull-right">
										<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
										<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
									</ul>
								</div>
								<h4 class="user-name m-t-10 m-b-0 text-ellipsis"><a href="profile.html">Catherine Manseau</a></h4>
								<div class="small text-muted">Android Developer</div>
							</div>
						</div>
					</div>
			</div>
			<?php $this->load->view('notifications'); ?>
		</div>
	</div>
	<div id="add_employee" class="modal custom-modal fade" role="dialog">
		<div class="modal-dialog">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<div class="modal-content modal-lg">
				<div class="modal-header">
					<h4 class="modal-title">Add Employee</h4>
				</div>
				<div class="modal-body">
					<form class="m-b-30">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">First Name <span class="text-danger">*</span></label>
									<input class="form-control" type="text">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Last Name</label>
									<input class="form-control" type="text">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Username <span class="text-danger">*</span></label>
									<input class="form-control" type="text">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Email <span class="text-danger">*</span></label>
									<input class="form-control" type="email">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Password</label>
									<input class="form-control" type="password">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Confirm Password</label>
									<input class="form-control" type="password">
								</div>
							</div>
							<div class="col-sm-6">  
								<div class="form-group">
									<label class="control-label">Employee ID <span class="text-danger">*</span></label>
									<input type="text" class="form-control">
								</div>
							</div>
							<div class="col-sm-6">  
								<div class="form-group">
									<label class="control-label">Joining Date <span class="text-danger">*</span></label>
									<div class="cal-icon"><input class="form-control datetimepicker" type="text"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Phone </label>
									<input class="form-control" type="text">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Company</label>
									<select class="select">
										<option value="">Global Technologies</option>
										<option value="1">Delta Infotech</option>
									</select>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Department</label>
									<select class="select">
										<option>Web Development</option>
										<option>Application Development</option>
										<option>IT Management</option>
									</select>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Designation</label>
									<select class="select">
										<option>Web Developer</option>
										<option>Web Designer</option>
										<option>SEO Analyst</option>
									</select>
								</div>
							</div>
						</div>
						<div class="m-t-20 text-center">
							<button class="btn btn-primary">Create Employee</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="edit_employee" class="modal custom-modal fade" role="dialog">
		<div class="modal-dialog">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<div class="modal-content modal-lg">
				<div class="modal-header">
					<h4 class="modal-title">Edit Employee</h4>
				</div>
				<div class="modal-body">
					<form class="m-b-30">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">First Name <span class="text-danger">*</span></label>
									<input class="form-control" value="John" type="text">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Last Name</label>
									<input class="form-control" value="Doe" type="text">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Username <span class="text-danger">*</span></label>
									<input class="form-control" value="johndoe" type="text">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Email <span class="text-danger">*</span></label>
									<input class="form-control" value="johndoe@example.com" type="email">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Password</label>
									<input class="form-control" value="johndoe" type="password">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Confirm Password</label>
									<input class="form-control" value="johndoe" type="password">
								</div>
							</div>
							<div class="col-sm-6">  
								<div class="form-group">
									<label class="control-label">Employee ID <span class="text-danger">*</span></label>
									<input type="text" value="FT-0001" readonly="" class="form-control floating">
								</div>
							</div>
							<div class="col-sm-6">  
								<div class="form-group">
									<label class="control-label">Joining Date <span class="text-danger">*</span></label>
									<div class="cal-icon"><input class="form-control datetimepicker" type="text"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Phone </label>
									<input class="form-control" value="9843014641" type="text">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Company</label>
									<select class="select">
										<option value="">Global Technologies</option>
										<option value="1">Delta Infotech</option>
									</select>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Department</label>
									<select class="select">
										<option>Web Development</option>
										<option>Application Development</option>
										<option>IT Management</option>
									</select>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Designation</label>
									<select class="select">
										<option>Web Developer</option>
										<option>Web Designer</option>
										<option>SEO Analyst</option>
									</select>
								</div>
							</div>
						</div>
						<div class="m-t-20 text-center">
							<button class="btn btn-primary">Save Changes</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="delete_employee" class="modal custom-modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content modal-md">
				<div class="modal-header">
					<h4 class="modal-title">Delete Employee</h4>
				</div>
				<form>
					<div class="modal-body card-box">
						<p>Are you sure want to delete this?</p>
						<div class="m-t-20"> <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
							<button type="submit" class="btn btn-danger">Delete</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>		