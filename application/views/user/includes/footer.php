<div class="sidebar-overlay" data-reff="#sidebar"></div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/app.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/notify.js"></script>

<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';	
</script>
<?php 
$uri = $this->uri->segment(1);
if($uri == 'profile' && $this->uri->segment(2) == 'edit'){ ?>
	<!-- JS -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/profile.js"></script>


<?php } ?>	

<?php if($uri == 'chat' ){ ?>

	<!-- CSS  -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.mCustomScrollbar.min.css" type="text/css">
	<!-- JS -->
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.form.min.js"></script>
	<script src='<?php echo base_url()."assets/" ?>js/jquery.mCustomScrollbar.concat.min.js'></script>
	<script src="<?php echo base_url(); ?>assets/js/sinch.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/custom_sinch.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/chat.js"></script>

<!-- Group chat  -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/group_chat.js"></script>
<!-- Nav Bar chat  -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/nav_bar.js"></script>


<?php } ?>	

</body>
</html>