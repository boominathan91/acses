<div class="main-wrapper">
			<div class="account-page">
				<div class="container">
					<h3 class="account-title"><?php lang('management_login'); ?></h3>
					<div class="account-box">
						<div class="account-wrapper">
							<div class="account-logo">
								<a href="#"><img src="<?php echo base_url(); ?>assets/img/logo2.png" alt="Focus Technologies"></a>
							</div>
							<form id="login_form" method="post">
								<div class="form-group form-focus">
									<label class="control-label"><?php lang('user_name_or_email'); ?></label>
									<input class="form-control floating" type="text" name="user_name" id="user_name">
								</div>
								<div class="form-group form-focus">
									<label class="control-label"><?php lang('password'); ?></label>
									<input class="form-control floating" type="password" name="password" id="password">
								</div>
								<div class="form-group text-center">
									<button class="btn btn-primary btn-block account-btn" type="submit"><?php lang('login'); ?></button>
								</div>
								<div class="text-center">
									<a href="<?php echo base_url(); ?>forgot_password"><?php lang('forgot_your_password'); ?>?</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
        </div>
		<div class="sidebar-overlay" data-reff="#sidebar"></div>		