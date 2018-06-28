function show_modal(login_id){
	if(login_id == 0){
		$('.modal-title').text('Add Employee');
	}else{
		$('#login_id').val(login_id);
		$('.modal-title').text('Edit Employee');
		$("#designation_id option:gt(0)").remove(); 
		$.post(base_url+'employees/get_employee_by_id',{login_id:login_id},function(res){
			var data = jQuery.parseJSON(res);
			$(data.designation).each(function(){
				var option = $('<option />');
				option.attr('value', this.designation_id).text(this.designation_name);           
				$('#designation_id').append(option);
			}); 


			var obj = data.result;
			$('#designation_id').val(obj.designation_id);
			$('#department_id').val(obj.department_id);
			$('#login_id').val(obj.login_id);
			$('#first_name').val(obj.first_name);
			$('#last_name').val(obj.last_name);
			$('#user_name').val(obj.user_name);
			$('#email').val(obj.email);
			$('#employee_id').val(obj.employee_id);
			$('#joining_date').val(obj.joining_date);
			$('#phone_number').val(obj.phone_number);
			$('#company').val(obj.company);


			



		});
	}
}
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
function check_email(){
	var email = $('#email').val();
	var login_id = $('#login_id').val();
	$.post(base_url+'employees/check_exist_email',{email:email,login_id:login_id},function(res){
		var obj = jQuery.parseJSON(res);			
		if(obj.exist == '1'){
			$('#btn').attr('disabled',true);
			updateNotification('','Email id already registered','error');
			return false;
		}else{
			$('#btn').attr('disabled',false);
		}

	});
}
function check_username(){
	var user_name = $('#user_name').val();
	$.post(base_url+'employees/check_exist_username',{user_name:user_name},function(res){
		var obj = jQuery.parseJSON(res);			
		if(obj.exist == '1'){
			$('#btn').attr('disabled',true);
			updateNotification('','Username already exist','error');
			return false;
		}else{
			$('#btn').attr('disabled',false);
		}

	});
}


function check_old_pwd(){
	var password = $('#old_password').val();
	if(password == ''){
		updateNotification('', 'Enter old password !', 'error');	
	}else{
		
		$.post(base_url+'settings/check_old_pwd',{password:password},function(res){
			var obj = jQuery.parseJSON(res);
			if(obj.match === 0){
				updateNotification('Warning   !', 'Old Password does not matches !', 'error');	
				$('#btn').attr('disabled',true);
			}else{
				updateNotification('Success   !', 'Password matched !', 'success');	
				$('#btn').attr('disabled',false);
			}
		});

	}
}




$('#employee_form').submit(function(){
	var first_name = $('#first_name').val();
	var user_name = $('#user_name').val();
	var email = $('#email').val();
	var employee_id = $('#employee_id').val();
	var joining_date = $('#joining_date').val();
	if(first_name == ''){
		$('#first_name').focus();
		updateNotification('','Enter First name','error');
		$('#btn').attr('disabled',true);
		return false;
	}
	if(user_name == ''){
		$('#user_name').focus();
		updateNotification('','Enter Last name','error');
		$('#btn').attr('disabled',true);
		return false;
	}if(email == ''){
		$('#email').focus();
		updateNotification('','Enter Email','error');
		$('#btn').attr('disabled',true);
		return false;
	}
	if(employee_id == ''){
		$('#employee_id').focus();
		updateNotification('','Enter Employee id','error');
		$('#btn').attr('disabled',true);
		return false;
	}
	if(joining_date == ''){
		$('#joining_date').focus();
		updateNotification('','Select Joining date','error');
		return false;
	}		
	check_email();	
	var url = base_url+"employees/insert_employees";
	var formData = $('#employee_form').serialize(); 
	$.ajax({
		type:'POST',
		url:url,
		data:formData,
		success:function(response){
			var obj = jQuery.parseJSON(response);
			if(obj.error){
				updateNotification('', obj.error, 'error');						
				return false;
			}else{
				updateNotification('Success   !', 'Employee details saved successfully!', 'success');
				$('#add_employee').modal('hide');
				loadPagination(0);						
			}
		}
	});		
	return false;
});

// $('input').keyup(function(){
// 	$('#btn').attr('disabled',false);
// });

$('#password').blur(function(){
	if($(this).val()!=''){
		var confirm_password = $('#confirm_password').val();
		var confirm = $(this).val();
		if(confirm_password == ''){
			updateNotification('', 'Enter confirm password!', 'error');
		}
	}
});



$('#confirm_password').keyup(function(){
	var new_pwd = $('#password').val();
	var confirm = $(this).val();
	if(new_pwd !=''){
		if(new_pwd == confirm){
			updateNotification('Success   !', 'Confirm Password matched !', 'success');	
			$('.updateBtn').attr('disabled',false);
			check_old_pwd();
		}else{
			updateNotification('', 'Confirm password doesnot match!', 'error');	
			$('.updateBtn').attr('disabled',true);
		}
	}
});

$('.btn-block').click(function(){
	filter_next_page(0);
});

filter_next_page(0);

function filter_next_page(page=1){

	var employee_id = $('#employee_ids').val();
	var employee_name = $('#employee_names').val();
	var designation = $('#designations').val();

	inital_loading_employee(page,employee_id,employee_name,designation);   
}

function inital_loading_employee(pageno,employee_id,employee_name,designation) {
	$.post(base_url+'employees/loadRecord',{
		pageno:pageno,
		employee_id:employee_id,
		employee_name:employee_name,
		designation:designation
	},function(response){
		var obj = jQuery.parseJSON(response);
		var current_page = obj.current_page;
		var total_page = obj.total_page;   
		var pagination_html = '';
		total_page = parseInt(total_page);

		if (total_page >1) {
			pagination_html ='<div class="row"><div class="col-sm-5"></div>'+
			'<div class="col-sm-7">'+
			'<div class="dataTables_paginate paging_simple_numbers" id="table-projects_paginate">'+
			'<ul class="pagination">';
			total_page = parseInt(total_page);
			for (var k = 1;k<=total_page;k++) { 

				if(current_page == k){
					class_name = 'active';
				}else{class_name = '';}
				pagination_html +='<li class="paginate_button '+class_name+'"><a href="javascript:void(0)" onclick="filter_next_page('+k+')">'+k+'</a></li>'; 
			}
			pagination_html += '</ul></div></div></div>';
		}
		$('#pagination').html(pagination_html);
		createTable(obj.result,obj.row,obj.header,obj.designations);

	});
}


    //   // Create table list
    function createTable(result,sno,header,designations){

    	$("#designations option:gt(0)").remove();
    	$('.div-table').html('');

    	/*Table Header */
    	var data ='<div class="div-heading">'+
    	'<div class="div-cell">'+
    	'<p>'+header.employee_name+'</p>'+
    	'</div>'+
    	'<div class="div-cell">'+
    	'<p>'+header.employee_id+'</p>'+
    	'<p></p>'+
    	'</div>'+
    	'<div class="div-cell">'+
    	'<p>'+header.email+'</p>'+
    	'</div>'+
    	'<div class="div-cell">'+
    	'<p>'+header.phone_number+'</p>'+
    	'</div>'+
    	'<div class="div-cell">'+
    	'<p>'+header.joining_date+'</p>'+
    	'</div>'+
    	'<div class="div-cell">'+
    	'<p>'+header.role+'</p>'+      	
    	'</div>'+
    	'<div class="div-cell">'+
    	'<p>'+header.action+'</p>'+      	      	
    	'</div>'+
    	'</div>';



    //   	console.log(result);
    //   	/*Table Body */
    for(index in result){

    	var login_id = result[index].login_id;
    	var first_name = result[index].first_name;
    	var employee_name = result[index].first_name+' '+result[index].last_name;
    	var employee_id = result[index].employee_id;
    	var email = result[index].email;   
    	var phone_number = result[index].phone_number;   
    	var joining_date = result[index].joining_date;   
    	var first_letter = result[index].first_letter;   
    	var designation_name = result[index].designation_name;  
    	var department_name  = result[index].department_name;  
    	var drop_down  = result[index].drop_down;  


    	data += '<div class="div-row">'+
    	'<div class="div-cell user-cell">'+
    	'<div class="user_det_list">'+
    	'<a href="#" class="avatar">'+first_letter+'</a>'+
    	'<h2><a href="#"><span class="username-info">'+employee_name+'</span>'+
    	'<span class="userrole-info">'+department_name+'</span></a></h2>'+
    	'</div>'+
    	'</div>'+
    	'<div class="div-cell user-identity">'+
    	'<p>'+employee_id+'</p>'+
    	'</div>'+
    	'<div class="div-cell user-mail-info">'+
    	'<p>'+email+'</p>'+
    	'</div>'+
    	'<div class="div-cell number-info">'+
    	'<p>'+phone_number+'</p>'+
    	'</div>'+
    	'<div class="div-cell create-date-info">'+
    	'<p>'+joining_date+'</p></div>'+
    	'<div class="div-cell user-role-info">'+
    	'<div class="dropdown">'+
    	'<a class="btn btn-white btn-sm rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'+designation_name+'<i class="caret"></i></a>';
    	
				data +='<ul class="dropdown-menu">';
			$(drop_down).each(function(){
				data +='<li><a href="javascript:void(0);" onclick="change_role('+this.designation_id+','+login_id+')">'+this.designation_name+'</a></li>';
    		});    
    			data +='</ul>';		
    	

    	data +='</div>'+
    	'</div>'+
    	'<div class="div-cell user-action-info">'+
    	'<div class="text-right">'+
    	'<div class="dropdown">'+
    	'<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>'+
    	'<ul class="dropdown-menu pull-right">'+
    	'<li><a href="#" data-toggle="modal" data-target="#add_employee" onclick="show_modal('+result[index].login_id+')"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>'+
    	'<li><a href="#" data-toggle="modal" data-target="#delete_employee" onclick="show_delete_modal('+result[index].login_id+')"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>'+
    	'</ul>'+
    	'</div>'+
    	'</div>'+
    	'</div>'+
    	'</div><div class="clear-fix"></div>';
    }

    $('.div-table').append(data);

    for(index in designations){
    	var option = $('<option />');
    	option.attr('value', designations[index].designation_id).text(designations[index].designation_name);           
    	$('#designations').append(option);
    }




}

function show_delete_modal(id){
	$('#employee_form')[0].reset();
	$('#employee_hidden_id').val('');
	$('#employee_hidden_id').val(id);	
}

function delete_employee(){
	var login_id = 	$('#employee_hidden_id').val();
	$.post(base_url+'employees/delete_employee',{login_id:login_id},function(res){
		$('#delete_employee').modal('hide');
		updateNotification('Success   !', 'Employee details deleted !', 'success');	
		filter_next_page(0);
	});	
}



function change_role(designation_id,login_id){
	$.post(base_url+'employees/change_role',{designation_id:designation_id,login_id:login_id},function(res){
		updateNotification('Success   !', 'Role changed successfully !', 'success');	
		filter_next_page(0);
	})

}
