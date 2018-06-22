	/*Getting country details */
	$.ajax({
		type: 'GET',
		url: base_url+'settings/get_localization_settings',        
		beforeSend :function(){
			$('#country').find("option:eq(0)").html("Please wait..");			
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
			$('#country').val(data.country_id);
			$('#date_format').val(data.date_format);
			$('#time_zone').val(data.time_zone);
			$('#default_language').val(data.default_language);

			
			

		}
	});

	

	$('#localization_form').submit(function(){
		var url = base_url+"settings/insert_localization_settings";
		var formData = $('#localization_form').serialize(); 
		$.ajax({
			type:'POST',
			url:url,
			data:formData,
			success:function(response){
				updateNotification('Success   !', 'Localization settings updated !', 'success');	
			}
		});		
		return false;
	});