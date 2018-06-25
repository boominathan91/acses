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
			<div class="div-table">
				<div class="div-heading">
					<div class="div-cell" style="width: 30%;">
						<p><?php echo lang('employee_name'); ?></p>
					</div>
					<div class="div-cell">
						<p><?php echo lang('employee_id'); ?></p>
					</div>
					<div class="div-cell">
						<p><?php echo lang('email'); ?></p>
					</div>
					<div class="div-cell">
						<p><?php echo lang('mobile'); ?></p>
					</div>
					<div class="div-cell">
						<p><?php echo lang('join_date'); ?></p>
					</div>
					<div class="div-cell">
						<p><?php echo lang('role'); ?></p>
					</div>
					<div class="div-cell">
						<p><?php echo lang('action'); ?></p>
					</div>
				</div>
				<div class="div-row">
					<div class="div-cell user-cell">
						<div class="user_det_list">
							<a href="profile.html" class="avatar">J</a>
							<h2><a href="profile.html"><span class="username-info">John Doe</span> <span class="userrole-info">Web Designer</span></a></h2>
						</div>
					</div>
					<div class="div-cell user-identity">
						<p>FT-0001</p>
					</div>
					<div class="div-cell user-mail-info">
						<p>johndoe@example.com</p>
					</div>
					<div class="div-cell number-info">
						<p>9876543210</p>
					</div>
					<div class="div-cell create-date-info">
						<p>1 Jan 2013</p>
					</div>
					<div class="div-cell user-role-info">
						<div class="dropdown">
							<a class="btn btn-white btn-sm rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Web Developer <i class="caret"></i></a>
							<ul class="dropdown-menu">
								<li><a href="#">Software Engineer</a></li>
								<li><a href="#">Software Tester</a></li>
								<li><a href="#">Frontend Developer</a></li>
								<li><a href="#">UI/UX Developer</a></li>
							</ul>
						</div>
					</div>
					<div class="div-cell user-action-info">
						<div class="text-right">
							<div class="dropdown">
								<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
								<ul class="dropdown-menu pull-right">
									<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
									<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="div-row">
					<div class="div-cell user-cell">
						<div class="user_det_list">
							<a href="profile.html" class="avatar">J</a>
							<h2><a href="profile.html"><span class="username-info">John Doe</span> <span class="userrole-info">Web Designer</span></a></h2>
						</div>
					</div>
					<div class="div-cell user-identity">
						<p>FT-0001</p>
					</div>
					<div class="div-cell user-mail-info">
						<p>johndoe@example.com</p>
					</div>
					<div class="div-cell number-info">
						<p>9876543210</p>
					</div>
					<div class="div-cell create-date-info">
						<p>1 Jan 2013</p>
					</div>
					<div class="div-cell user-role-info">
						<div class="dropdown">
							<a class="btn btn-white btn-sm rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Web Developer <i class="caret"></i></a>
							<ul class="dropdown-menu">
								<li><a href="#">Software Engineer</a></li>
								<li><a href="#">Software Tester</a></li>
								<li><a href="#">Frontend Developer</a></li>
								<li><a href="#">UI/UX Developer</a></li>
							</ul>
						</div>
					</div>
					<div class="div-cell user-action-info">
						<div class="text-right">
							<div class="dropdown">
								<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
								<ul class="dropdown-menu pull-right">
									<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
									<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
								</ul>
							</div>
						</div>
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
								<input type="text" name="company" class="form-control" value="<?php echo $this->session->userdata('company_name'); ?>">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Department</label>
								<select class="form-control" id="department_id" name="department_id">
										<option value="">Select Department</option>	
										<?php if(!empty($department)){
											foreach ($department as $d) {
											echo '<option value="'.$d->department_id.'">'.$d->department_name.'</option>';
											}
										} ?>									
									</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Designation</label>
								<select id="designation_id" name="designation_id" class="form-control">
									<option value="">Select Designation</option>
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