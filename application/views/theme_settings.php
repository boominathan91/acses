       <div class="main-wrapper" id="wrapper">
           <?php $this->load->view('nav_bar'); ?>
            <div class="page-wrapper">
                <div class="content container-fluid">
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
                            <form class="form-horizontal">
								<h4 class="page-title">Theme Settings</h4>
								<div class="form-group">
									<label class="col-lg-3 control-label">Website Name</label>
									<div class="col-lg-9">
										<input name="website_name" class="form-control" value="Focus Technologies" type="text">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Light Logo</label>
									<div class="col-lg-5">
										<input class="form-control" type="file">
										<span class="help-block">Recommended image size is 40px x 40px</span>
									</div>
									<div class="col-lg-4">
										<div class="img-thumbnail pull-right"><img src="assets/img/logo2.png" alt="" width="40" height="40"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Dark Logo</label>
									<div class="col-lg-5">
										<input class="form-control" type="file">
										<span class="help-block">Recommended image size is 140px x 40px</span>
									</div>
									<div class="col-lg-4">
										<div class="img-thumbnail pull-right"><img src="assets/img/logo3.png" class="img-responsive" alt="" width="140" height="40"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Favicon</label>
									<div class="col-lg-5">
										<input class="form-control" type="file">
										<span class="help-block">Recommended image size is 16px x 16px</span>
									</div>
									<div class="col-lg-4">
										<div class="settings-image img-thumbnail pull-right"><img src="assets/img/favicon.png" class="img-responsive" width="16" height="16" alt=""></div>
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
		