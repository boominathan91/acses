   <div class="main-wrapper">
           <?php $this->load->view('nav_bar'); ?>
            <div class="page-wrapper">
                <div class="content container-fluid">
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<form>
								<h3 class="page-title"><?php lang('company_details'); ?></h3>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('company_name'); ?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" value="Focus Technologies">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('contact_person'); ?></label>
											<input class="form-control " value="Daniel Porter" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label><?php lang('address'); ?></label>
											<input class="form-control " value="3864 Quiet Valley Lane, Sherman Oaks, CA, 91403" type="text">
										</div>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-3">
										<div class="form-group">
											<label><?php lang('country'); ?></label>
											<select class="form-control select">
												<option>USA</option>
												<option>United Kingdom</option>
											</select>
										</div>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-3">
										<div class="form-group">
											<label><?php lang('city'); ?></label>
											<input class="form-control" value="Sherman Oaks" type="text">
										</div>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-3">
										<div class="form-group">
											<label><?php lang('state_province'); ?></label>
											<select class="form-control select">
												<option>California</option>
												<option>Alaska</option>
												<option>Alabama</option>
											</select>
										</div>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-3">
										<div class="form-group">
											<label><?php lang('postal_code'); ?></label>
											<input class="form-control" value="91403" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('email'); ?></label>
											<input class="form-control" value="danielporter@example.com" type="email">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('phone_number'); ?></label>
											<input class="form-control" value="818-978-7102" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('mobile_number'); ?></label>
											<input class="form-control" value="818-635-5579" type="text">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('fax'); ?></label>
											<input class="form-control" value="818-978-7102" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label><?php lang('website_url'); ?></label>
											<input class="form-control" value="https://www.example.com" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 text-center m-t-20">
										<button type="button" class="btn btn-primary"><?php lang('save_update') ?></button>
									</div>
								</div>
							</form>
						</div>
					</div>
                </div>
				
				<!-- Notifications -->
				<?php $this->load->view('notifications'); ?>
				<!-- Notifications -->
            </div>
        </div>
		