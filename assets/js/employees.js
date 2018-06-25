$('.btn-link').click(function(){
	var id = $(this).attr('id');
	$(this).addClass('active');	
	if(id == 'staff-grid-view'){
		$('.div-table').addClass('grid-view');
		$('#staff-table-view').removeClass('active');
	}else{		
		$('.div-table').removeClass('grid-view');
		$('#staff-grid-view').removeClass('active');
	}
});

/*Get the state list */
	$('#department_id').change(function(){
		$.ajax({
			type: "POST",
			url: base_url+"settings/get_designation_by_id",
			data:{department_id:$(this).val()}, 
			beforeSend :function(){
				$("#designation_id option:gt(0)").remove(); 
				$('#designation_id').find("option:eq(0)").html("Please wait..");
			},                         
			success: function (data) {
				/*get response as json */
				$('#designation_id').find("option:eq(0)").html("Select Designation");
				var obj=jQuery.parseJSON(data);
				$(obj).each(function()
				{
					var option = $('<option />');
					option.attr('value', this.value).text(this.label);           
					$('#designation_id').append(option);
				});  
			}
		});
	});
