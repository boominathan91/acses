	
$('input').attr('autocomplete','off');

	// 	/*Getting country details */
	// $.ajax({
	// 	type: 'GET',
	// 	url: base_url+'settings/get_company_settings',        
	// 	beforeSend :function(){
	// 		$('#country').find("option:eq(0)").html("Please wait..");			
	// 	},                         
	// 	success: function (data) {
	// 		$('#country').find("option:eq(0)").html("Select Country");
	// 		var obj=jQuery.parseJSON(data);
	// 		$(obj).each(function(){
	// 			var option = $('<option />');
	// 			option.attr('value', this.value).text(this.label);           
	// 			$('#country').append(option);
	// 		});            
	// 	}
	// });

	/*Getting company  details */
	$.ajax({
		type: 'GET',
		url: base_url+'settings/get_company_settings',  
		beforeSend :function(){
			$('#country').find("option:eq(0)").html("Please wait..");
			$("#state option:gt(0)").remove(); 
			$("#city option:gt(0)").remove(); 			
		},                         
		success: function (response) {
			var data = jQuery.parseJSON(response);			 
			if(data.country){
				$('#country').find("option:eq(0)").html("Select Country");
				/*Getting  country */
				var obj=jQuery.parseJSON(data.country);
				$(obj).each(function(){
					var option = $('<option />');
					option.attr('value', this.value).text(this.label);           
					$('#country').append(option);
				});  
			}
			if(data.state){
				/*Getting  State */
				var obj=jQuery.parseJSON(data.state);
				$(obj).each(function(){
					var option = $('<option />');
					option.attr('value', this.value).text(this.label);           
					$('#state').append(option);
				});  

			}
			if(data.city){
				/*Getting  City */
				var obj=jQuery.parseJSON(data.city);
				$(obj).each(function(){
					var option = $('<option />');
					option.attr('value', this.value).text(this.label);
					$('#city').append(option);
				}); 
			}			
			$('#company_name').val(data.company_name);
			$('#contact_person').val(data.contact_person);
			$('#address').val(data.address);
			$('#country').val(data.country_id);
			$('#state').val(data.state_id);
			$('#city').val(data.city_id);
			$('#postal_code').val(data.postal_code);
			$('#email').val(data.email);
			$('#phone_number').val(data.phone_number);
			$('#mobile_number').val(data.mobile_number);
			$('#fax').val(data.fax);
			$('#website_url').val(data.website_url);	






		}
	});

	$('#company_settings').submit(function(){
		var url = base_url+"settings/insert_company_settings";
		var formData = $('#company_settings').serialize(); 
		$.ajax({
			type:'POST',
			url:url,
			data:formData,
			success:function(response){
				updateNotification('Success   !', 'Company settings updated !', 'success');	
			}
		});		
		return false;
	});


	/*Get the state list */
	$('#country').change(function(){
		$.ajax({
			type: "POST",
			url: base_url+"settings/get_states",
			data:{country_id:$(this).val()}, 
			beforeSend :function(){
				$("#state option:gt(0)").remove(); 
				$("#city option:gt(0)").remove(); 
				$('#state').find("option:eq(0)").html("Please wait..");
			},                         
			success: function (data) {
				/*get response as json */
				$('#state').find("option:eq(0)").html("Select State");
				var obj=jQuery.parseJSON(data);
				$(obj).each(function()
				{
					var option = $('<option />');
					option.attr('value', this.value).text(this.label);           
					$('#state').append(option);
				});  
			}
		});
	});


	/*Get the state list */
	$('#state').change(function(){
		$.ajax({
			type: "POST",
			url: base_url+"settings/get_cities",
			data:{state_id:$(this).val()}, 
			beforeSend :function(){

				$("#city option:gt(0)").remove(); 
				$('#city').find("option:eq(0)").html("Please wait..");
			},  
			success: function (data) {
				$('#city').find("option:eq(0)").html("Select City");
				var obj=jQuery.parseJSON(data);
				$(obj).each(function()
				{
					var option = $('<option />');
					option.attr('value', this.value).text(this.label);
					$('#city').append(option);
				});            
			}
		});
	});