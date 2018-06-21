        <div class="main-wrapper">
				<?php $this->load->view('nav_bar'); ?>            
            <div class="page-wrapper">
                <div class="content container-fluid">
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<form>
								<h3 class="page-title"><?php lang('basic_settings'); ?></h3>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('default_country'); ?></label>
											<select class="select">
												<option selected="selected">USA</option>
												<option>United Kingdom</option>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('date_format'); ?></label>
											<select class="select">
												<option value="d/m/Y">15/05/2016</option>
												<option value="d.m.Y">15.05.2016</option>
												<option value="d-m-Y">15-05-2016</option>
												<option value="m/d/Y">05/15/2016</option>
												<option value="Y/m/d">2016/05/15</option>
												<option value="Y-m-d">2016-05-15</option>
												<option value="M d Y">May 15 2016</option>
												<option selected="selected" value="d M Y">15 May 2016</option>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('time_zone') ?></label>
											<select class="select">
												<option>(UTC +5:30) Antarctica/Palmer</option>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('default_language') ?></label>
											<select class="select">
												<option selected="selected">English</option>
												<option>French</option>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('currency_code') ?></label>
											<select class="select">
												<option selected="selected">USD</option>
												<option>Pound</option>
												<option>EURO</option>
												<option>Ringgit</option>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('currency_symbol') ?></label>
											<input class="form-control" readonly value="$" type="text">
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12 text-center m-t-20">
											<button type="button" class="btn btn-primary"><?php lang('save_update') ?></button>
										</div>
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
		