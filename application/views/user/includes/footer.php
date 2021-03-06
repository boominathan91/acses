<div class="sidebar-overlay" data-reff="#sidebar"></div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/app.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/notify.js"></script>

<!-- Tok Box  -->
<script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
<!-- Polyfill for fetch API so that we can fetch the sessionId and token in IE11 -->
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@7/dist/polyfill.min.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fetch/2.0.3/fetch.min.js" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tok_box.js"></script>

<!-- Tok Box ends  -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/notify.js"></script>

<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';	
	var currentUserId = '<?php echo $this->session->userdata("login_id"); ?>';
	var defaultImageBasePath = base_url + 'assets/img/';
	var imageBasePath = base_url + '/uploads/';
	var currentUserProfileImage = '<?php echo $this->session->userdata("profile_img"); ?>';
	var currentUserName = '<?php echo ucfirst($this->session->userdata("first_name")).' '.ucfirst($this->session->userdata("last_name")); ?>';
	var currentSinchUserName = '<?php echo $this->session->userdata('sinch_username'); ?>';

	if(currentUserProfileImage != ''){
		currentUserProfileImage = imageBasePath + currentUserProfileImage;
	}
	else{
		currentUserProfileImage = defaultImageBasePath +'user.jpg';
	}
</script>
<?php 
$uri = $this->uri->segment(1);
if($uri == 'profile' && $this->uri->segment(2) == 'edit'){ ?>
	<!-- JS -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/profile.js"></script>


<?php } ?>	
<?php if (strtolower($uri) == 'edit-profile') { ?>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/edit-profile.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/croppie.js"></script>
<?php } ?>

<?php if($uri == 'chat' ){ ?>

	<!-- CSS  -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/typehead.css" rel="stylesheet">
	<!-- JS -->
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.form.min.js"></script>
	<script src='<?php echo base_url()."assets/" ?>js/jquery.slimscroll.js'></script>
	<script src="<?php echo base_url(); ?>assets/js/sinch.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/custom_sinch.js"></script>


<!-- Group chat  -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/group_chat.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/typehead.bundle.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-tagsinput.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/chat.js"></script>
<!-- Nav Bar chat  -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/nav_bar.js"></script>
<script type="text/javascript" src="https://api.screenleap.com/js/screenleap.js"></script>

<?php } ?>	

</body>
</html>