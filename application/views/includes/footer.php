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
		if($uri == 'department-settings' || $uri == 'designation-settings' || $uri ='employees'){ ?>
		<!-- 	CSS   -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap.min.css">

		<!-- JS -->
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>

		<?php } ?>

		<!-- Employees  -->
		<?php if($uri = 'employees'){ ?>
			<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
			<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>
			<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/employees.js"></script>
		<?php } ?>

		<!-- Company Settings  -->
		<?php if($uri = 'company-settings'){ ?>
		<script src="<?php echo base_url(); ?>assets/js/company.js"></script>
		<?php } ?>
    </body>
</html>