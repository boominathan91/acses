	<div class="main-wrapper">
		<?php $this->load->view('nav_bar'); ?>
		<div class="page-wrapper">
			<div class="content container-fluid">
				<div class="row">
					<div class="col-sm-8">
						<h4 class="page-title">Department</h4>
					</div>
					<div class="col-sm-4 text-right m-b-30">
						<a href="#" class="btn btn-primary rounded" data-toggle="modal" data-target="#add_department"><i class="fa fa-plus"></i> Add New Department</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div>
							<table class="table table-striped custom-table m-b-0 datatable">
								<thead>
									<tr>
										<th>#</th>
										<th>Department Name</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td>Web Development</td>
										<td class="text-right">
											<div class="dropdown">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<ul class="dropdown-menu pull-right">
													<li><a href="#" data-toggle="modal" data-target="#edit_department" title="Edit"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
													<li><a href="#" data-toggle="modal" data-target="#delete_department" title="Delete"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
												</ul>
											</div>
										</td>
									</tr>
									<tr>
										<td>2</td>
										<td>Application Development</td>
										<td class="text-right">
											<div class="dropdown">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<ul class="dropdown-menu pull-right">
													<li><a href="#" data-toggle="modal" data-target="#edit_department" title="Edit"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
													<li><a href="#" data-toggle="modal" data-target="#delete_department" title="Delete"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
												</ul>
											</div>
										</td>
									</tr>
									<tr>
										<td>3</td>
										<td>IT Management</td>
										<td class="text-right">
											<div class="dropdown">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<ul class="dropdown-menu pull-right">
													<li><a href="#" data-toggle="modal" data-target="#edit_department" title="Edit"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
													<li><a href="#" data-toggle="modal" data-target="#delete_department" title="Delete"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
												</ul>
											</div>
										</td>
									</tr>
									<tr>
										<td>4</td>
										<td>Accounts Management</td>
										<td class="text-right">
											<div class="dropdown">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<ul class="dropdown-menu pull-right">
													<li><a href="#" data-toggle="modal" data-target="#edit_department" title="Edit"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
													<li><a href="#" data-toggle="modal" data-target="#delete_department" title="Delete"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
												</ul>
											</div>
										</td>
									</tr>
									<tr>
										<td>5</td>
										<td>Support Management</td>
										<td class="text-right">
											<div class="dropdown">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<ul class="dropdown-menu pull-right">
													<li><a href="#" data-toggle="modal" data-target="#edit_department" title="Edit"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
													<li><a href="#" data-toggle="modal" data-target="#delete_department" title="Delete"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
												</ul>
											</div>
										</td>
									</tr>
									<tr>
										<td>6</td>
										<td>Marketing</td>
										<td class="text-right">
											<div class="dropdown">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<ul class="dropdown-menu pull-right">
													<li><a href="#" data-toggle="modal" data-target="#edit_department" title="Edit"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
													<li><a href="#" data-toggle="modal" data-target="#delete_department" title="Delete"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
												</ul>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<!-- Popup --> 
			<div id="add_department" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title">Add Department</h4>
						</div>
						<div class="modal-body">
							<form>
								<div class="form-group">
									<label>Department Name <span class="text-danger">*</span></label>
									<input class="form-control" required="" type="text">
								</div>
								<div class="m-t-20 text-center">
									<button class="btn btn-primary">Create Department</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div id="edit_department" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title">Edit Department</h4>
						</div>
						<div class="modal-body">
							<form>
								<div class="form-group">
									<label>Department Name <span class="text-danger">*</span></label>
									<input class="form-control" value="IT Management" type="text">
								</div>
								<div class="m-t-20 text-center">
									<button class="btn btn-primary">Save Changes</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
        </div>
        <!-- Popup --> 
				<!-- Notifications -->
				<?php $this->load->view('notifications'); ?>
				<!-- Notifications -->
		</div>
	</div>
