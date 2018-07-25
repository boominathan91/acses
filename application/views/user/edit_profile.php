<div class="main-wrapper">
	<?php $this->load->view('user/includes/nav_bar'); ?>
	 <div class="page-wrapper">
                <div class="content container-fluid">
					<div class="row">
						<div class="col-sm-8">
							<h4 class="page-title">Edit Profile</h4>
						</div>
					</div>
					<?php 
					/*echo "<pre>";
					print_r($profile);
					exit;*/
						if(empty($profile['profile_img'])){
							$profile_img = base_url().'assets/img/user.jpg';
						}else{
							$profile_img = base_url().'uploads/'.$profile['profile_img'];
						}

					 ?>
					<form id="profile_form" action="" enctype="multipart/form-data" method="post">
						<div class="card-box">
							<h3 class="card-title">Basic Informations</h3>
							<div class="row">
								<div class="col-md-12">
									<div class="profile-img-wrap">
										<div id="uploaded_image">
											<img class="inline-block" src="<?php echo $profile_img; ?>" alt="user" id="profile_image">	
										</div>
										<div class="fileupload btn btn-default">
											<span class="btn-text text_profile">Edit</span>
											<input class="upload" type="file" id="upload_image"  >
											<input  type="hidden" name="profile_img" id="profile_img"  value="<?php echo $profile['profile_img'] ?>">
										</div>
									</div>
									<div class="profile-basic">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group form-focus">
													<label class="control-label">First Name</label>
													<input type="text" class="form-control floating" name="first_name" id="first_name" value="<?php echo $profile['first_name']; ?>"  />
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group form-focus">
													<label class="control-label">Last Name</label>
													<input type="text" class="form-control floating" id="last_name" name="last_name" value="<?php echo $profile['last_name']; ?>"/>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group form-focus">
													<label class="control-label">Birth Date</label>
													<script type="text/javascript">var dob = "<?php echo !(empty($profile['dob']))?$profile['dob']:date('d-m-Y'); ?>";</script>
													<div class="cal-icon"><input class="form-control floating" id="dob" name="dob"  type="text" value="<?php echo $profile['dob']; ?>"></div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group form-focus select-focus">
													<label class="control-label">Gendar</label>
													<select class="select form-control floating" id="gender" name="gender">
														<option value="">Select Gendar</option>
														<option value="male" <?php if($profile['gender'] == 'male'){ echo 'selected="selected"'; } ?>>Male</option>
														<option value="female" <?php if($profile['gender'] == 'female'){ echo 'selected="selected"'; } ?>>Female</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-box">
							<h3 class="card-title">Contact Informations</h3>
							<div class="row">

									<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Country</label>
										<select  class="form-control floating" name="country" id="country">
											<option value="">--Country--</option>
											<?php 
												if (!empty($countries)) {
													foreach ($countries as $country) {
														$country_id = $profile['country'];
														$selected = ($country['country_id'] == $country_id)?'selected':'';
													 ?>
													<option <?php echo $selected; ?> value="<?php echo $country['country_id']; ?>"><?php echo $country['country']; ?></option>			
													<?php }
												}
											 ?>
										</select>
										<!-- <input type="text" class="form-control floating" value="<?php echo $profile['country']; ?>"/> -->
									</div>
									</div>

									<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">State</label>
										<select  class="form-control floating" name="state" id="state">
											<option value="">--State--</option>
												<?php 
												if (!empty($states)) {
													foreach ($states as $state) {
														$state_id = $profile['state'];
														$selected = ($state['state_id'] == $state_id)?'selected':'';
													 ?>
													<option <?php echo $selected; ?> value="<?php echo $state['state_id']; ?>"><?php echo $state['statename']; ?></option>			
													<?php }
												}
											 ?>
										</select>
										<!-- <input type="text" class="form-control floating" value="<?php echo $profile['state']; ?>"/> -->
									</div>
								</div>
							
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">City</label>
										<select  class="form-control floating" name="city" id="city">
											<option value="">--City--</option>
												<?php 
												if (!empty($cities)) {
													foreach ($cities as $city) {
														$city_id = $profile['city'];
														$selected = ($city['city_id'] == $city_id)?'selected':'';
													 ?>
													<option <?php echo $selected; ?> value="<?php echo $city['city_id']; ?>"><?php echo $city['city']; ?></option>			
													<?php }
												}
											 ?>
										</select>
										<!-- <input type="text" class="form-control floating" value="<?php echo $profile['address']; ?>"/> -->
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Address</label>
										<input type="text" class="form-control floating" id="address" name="address" value="<?php echo $profile['address']; ?>"/>
									</div>
								</div>
							
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Pin Code</label>
										<input type="text" class="form-control floating" name="pincode" id="pincode" value="<?php echo $profile['pincode']; ?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Phone Number</label>
										<input type="text" class="form-control floating" id="phone_number" name="phone_number" value="<?php echo $profile['phone_number']; ?>"/>
									</div>
								</div>
							</div>
						</div>
						<div class="card-box">
							<h3 class="card-title">Education Informations</h3>
							<div class="row">
								<?php if(!empty($education_details)){
										$education = $education_details[0];
										unset($education_details[0]);
									} ?>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Institution</label>
										<input type="text" class="form-control floating" name="institution[]" id="institution1" value="<?php echo !(empty($education['institution']))?$education['institution']:''; ?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Subject</label>
										<input type="text" class="form-control floating" name="subject[]" id="subject1" value="<?php echo !(empty($education['subject']))?$education['subject']:''; ?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Starting Date</label>
										<input type="text" class="form-control floating" name="start_year[]" id="start_year1" placeholder="2016" value="<?php echo !(empty($education['start_year']))?$education['start_year']:''; ?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Complete Date</label>
										<input type="text" class="form-control floating" name="complete_year[]" id="complete_year1" placeholder="2018" value="<?php echo !(empty($education['complete_year']))?$education['complete_year']:''; ?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Degree</label>
										<input type="text" class="form-control floating" name="degree[]" id="degree1" value="<?php echo !(empty($education['degree']))?$education['degree']:''; ?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Grade</label>
										<input type="text" class="form-control floating" name="grade[]" id="grade1" value="<?php echo !(empty($education['grade']))?$education['grade']:''; ?>" />
									</div>
								</div>
							</div>

							<div class="institute_additional">
								<?php if(!empty($education_details)){ 
											 
											foreach ($education_details as $education) {  ?>
											<hr>
								<div class="row">
									<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Institution</label>
										<input type="text" class="form-control floating" name="institution[]" id="institution1" value="<?php echo !(empty($education['institution']))?$education['institution']:''; ?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Subject</label>
										<input type="text" class="form-control floating" name="subject[]" id="subject1" value="<?php echo !(empty($education['subject']))?$education['subject']:''; ?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Starting Date</label>
										<input type="text" class="form-control floating" name="start_year[]" id="start_year1" placeholder="2016" value="<?php echo !(empty($education['start_year']))?$education['start_year']:''; ?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Complete Date</label>
										<input type="text" class="form-control floating" name="complete_year[]" id="complete_year1" placeholder="2018" value="<?php echo !(empty($education['complete_year']))?$education['complete_year']:''; ?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Degree</label>
										<input type="text" class="form-control floating" name="degree[]" id="degree1" value="<?php echo !(empty($education['degree']))?$education['degree']:''; ?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Grade</label>
										<input type="text" class="form-control floating" name="grade[]" id="grade1" value="<?php echo !(empty($education['grade']))?$education['grade']:''; ?>" />
									</div>
								</div>
							</div>
								<?php } ?>
							<?php } ?>
							</div>
							

							<div class="add-more">
								<a href="javascript:void(0)" class="btn btn-primary" onclick="addInstitute(this)" data-row="1" ><i class="fa fa-plus"></i> Add More Institute</a>
							</div>
						</div>
						<div class="card-box">
							<h3 class="card-title">Experience Informations</h3>
							<div class="row">
								<?php if(!empty($experience_informations)){
										$experience = $experience_informations[0];
										unset($experience_informations[0]);
									} ?>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Company Name</label>
										<input type="text" class="form-control floating" name="company[]" id="company1"  value="<?php echo (!empty($experience['company']))?$experience['company']:''; ?>"/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Location</label>
										<input type="text" class="form-control floating" name="location[]" id="location1"  value="<?php echo (!empty($experience['location']))?$experience['location']:''; ?>"/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Job Position</label>
										<input type="text" class="form-control floating" name="jop_position[]" id="jop_position1" value="<?php echo (!empty($experience['jop_position']))?$experience['jop_position']:''; ?>"/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Period From</label>
										<input type="text" class="form-control floating" name="period_from[]" id="period_from1" value="<?php echo (!empty($experience['period_from']))?$experience['period_from']:''; ?>"/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Period To</label>
										<input type="text" class="form-control floating" name="period_to[]" id="period_to1"  value="<?php echo (!empty($experience['period_to']))?$experience['period_to']:''; ?>"/>
									</div>
								</div>
							</div>

							<div class="experience_additional">
								<?php if(!empty($experience_informations)){ 
											 
											foreach ($experience_informations as $experience) {  ?>
											<hr>
												<div class="row">
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Company Name</label>
										<input type="text" class="form-control floating" name="company[]" id="company1" value="<?php echo $experience['company']; ?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Location</label>
										<input type="text" class="form-control floating" name="location[]" id="location1" value="<?php echo $experience['location']; ?>"/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Job Position</label>
										<input type="text" class="form-control floating" name="jop_position[]" id="jop_position1" value="<?php echo $experience['jop_position']; ?>"/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Period From</label>
										<input type="text" class="form-control floating" name="period_from[]" id="period_from1" value="<?php echo $experience['period_from']; ?>"/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Period To</label>
										<input type="text" class="form-control floating" name="period_to[]" id="period_to1" value="<?php echo $experience['period_to']; ?>"/>
									</div>
								</div>
							</div>

										<?php } ?>			
								<?php } ?>			
							</div>


							<div class="add-more">
								<a href="javascript:void(0)" onclick="addExperience(this)" data-row="1" class="btn btn-primary"><i class="fa fa-plus"></i> Add More Experience</a>
							</div>
						</div>
						<div class="text-center m-t-20">
							<button class="btn btn-primary btn-lg" type="submit">Save &amp; update</button>
						</div>
					</form>
				</div>
				<div class="notification-box">
					<div class="msg-sidebar notifications msg-noti">
						<div class="topnav-dropdown-header">
							<span>Messages</span>
						</div>
						<div class="drop-scroll msg-list-scroll">
							<ul class="list-box">
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">R</span>
											</div>
											<div class="list-body">
												<span class="message-author">Richard Miles </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item new-message">
											<div class="list-left">
												<span class="avatar">J</span>
											</div>
											<div class="list-body">
												<span class="message-author">John Doe</span>
												<span class="message-time">1 Aug</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">T</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Tarah Shropshire </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">M</span>
											</div>
											<div class="list-body">
												<span class="message-author">Mike Litorus</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">C</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Catherine Manseau </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">D</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Domenic Houston </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">B</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Buster Wigton </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">R</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Rolland Webber </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">C</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Claire Mapes </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">M</span>
											</div>
											<div class="list-body">
												<span class="message-author">Melita Faucher</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">J</span>
											</div>
											<div class="list-body">
												<span class="message-author">Jeffery Lalor</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">L</span>
											</div>
											<div class="list-body">
												<span class="message-author">Loren Gatlin</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">T</span>
											</div>
											<div class="list-body">
												<span class="message-author">Tarah Shropshire</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
							</ul>
						</div>
						<div class="topnav-dropdown-footer">
							<a href="chat.html">See all messages</a>
						</div>
					</div>
				</div>
			</div>


<div class="institute_html" style="display: none;">
	<div class="row" id="institute{#}">
		<hr/>
	<div class="col-md-6">
		<div class="form-group form-focus">
			<label class="control-label">Institution</label>
			<input type="text" class="form-control floating" name="institution[]" id="institution{#}" />
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group form-focus">
			<label class="control-label">Subject</label>
			<input type="text" class="form-control floating" name="subject[]" id="subject{#}" />
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group form-focus">
			<label class="control-label">Starting Date</label>
			<input type="text" class="form-control floating" name="start_year[]" id="start_year{#}" placeholder="2016" />
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group form-focus">
			<label class="control-label">Complete Date</label>
			<input type="text" class="form-control floating" name="complete_year[]" id="complete_year{#}" placeholder="2018" />
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group form-focus">
			<label class="control-label">Degree</label>
			<input type="text" class="form-control floating" name="degree[]" id="degree{#}" />
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group form-focus">
			<label class="control-label">Grade</label>
			<input type="text" class="form-control floating" name="grade[]" id="grade{#}" />
		</div>
	</div>
	</div>
</div>

<div class="experience_html" style="display: none;">
					<div class="row" id="experience{#}">
						<hr/>
					<div class="col-md-6">
						<div class="form-group form-focus">
							<label class="control-label">Company Name</label>
							<input type="text" class="form-control floating" name="company[]" id="company{#}" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group form-focus">
							<label class="control-label">Location</label>
							<input type="text" class="form-control floating" name="location[]" id="location{#}" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group form-focus">
							<label class="control-label">Job Position</label>
							<input type="text" class="form-control floating" name="jop_position[]" id="jop_position{#}"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group form-focus">
							<label class="control-label">Period From</label>
							<input type="text" class="form-control floating" name="period_from[]" id="period_from{#}"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group form-focus">
							<label class="control-label">Period To</label>
							<input type="text" class="form-control floating" name="period_to[]" id="period_to{#}"/>
						</div>
					</div>
				</div>
			</div>



<div id="uploadimageModal" class="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title">Upload & Crop Image</h4>
      		</div>
      		<div class="modal-body">
        		<div class="row">
  					<div class="col-md-8 text-center">
						  <div id="image_demo" style="width:350px; margin-top:30px"></div>
  					</div>
  					<div class="col-md-4" style="padding-top:30px;">
  						<br />
  						<br />
  						<br/>
						  <button class="btn btn-success crop_image">Crop & Upload Image</button>
					</div>
				</div>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      		</div>
    	</div>
    </div>
</div>