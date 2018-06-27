function show_modal(login_id){
	if(id == 0){
		$('.modal-title').text('Add Employee');
	}else{
		$('#login_id').val(login_id);
		$('.modal-title').text('Edit Employee');
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
	$.post(base_url+'employees/check_exist_email',{email:email},function(res){
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
			}
		}
	});		
	return false;
});

$('input').keyup(function(){
	$('#btn').attr('disabled',false);
});

$('#password').blur(function(){
	var confirm_password = $('#confirm_password').val();
	var confirm = $(this).val();
	if(confirm_password == ''){
		updateNotification('', 'Enter confirm password!', 'error');
	}
});



$('#confirm_password').keyup(function(){
	var new_pwd = $('#password').val();
	var confirm = $(this).val();
	if(new_pwd == confirm){
		updateNotification('Success   !', 'Confirm Password matched !', 'success');	
		$('.updateBtn').attr('disabled',false);
		check_old_pwd();
	}else{
		updateNotification('', 'Confirm password doesnot match!', 'error');	
		$('.updateBtn').attr('disabled',true);
	}
});



  // Detect pagination click
     $('#pagination').on('click','a',function(e){
       e.preventDefault(); 
       var pageno = $(this).attr('data-ci-pagination-page');
       loadPagination(pageno);
     });

     loadPagination(0);

     // Load pagination
     function loadPagination(pagno){
       $.ajax({
         url: base_url+'employees/loadRecord/'+pagno,
         type: 'get',
         dataType: 'json',
         success: function(response){
            $('#pagination').html(response.pagination);
            createTable(response.result,response.row);
         }
       });
     }



      // Create table list
     function createTable(result,sno){
     	console.log(result);
     	console.log(sno);

     	var data ='<div class="div-heading">'+
					'<div class="div-cell" style="width: 30%;">'+
						'<p>employee_name</p>'+
					'</div>'+
					'<div class="div-cell">'+
						'<p>employee_id</p>'+
					'</div>'+
					'<div class="div-cell">'+
						'<p>email</p>'+
					'</div>'+
					'<div class="div-cell">'+
						'<p>mobile</p>'+
					'</div>'+
					'<div class="div-cell">'+
						'<p>join_date</p>'+
					'</div>'+
					'<div class="div-cell">'+
						'<p>role</p>'+
					'</div>'+
					'<div class="div-cell">'+
						'<p>action</p>'+
					'</div>'+
				'</div>';
     // 	var data ='<div class="div-cell"><div class="div-table"><div class="div-row">'+
     // 			'<div class="div-cell user-cell">'+
					// 	'<div class="user_det_list">'+
					// 		'<a href="profile.html" class="avatar">J</a>'+
					// 		'<h2><a href="profile.html"><span class="username-info">John Doe</span>'+
					// 		'<span class="userrole-info">Web Designer</span></a></h2>'+
					// 	'</div>'+
					// '</div>'+
					// '<div class="div-cell user-identity">'+
					// 	'<p>FT-0001</p>'+
					// '</div>'+
					// '<div class="div-cell user-mail-info">'+
					// 	'<p>johndoe@example.com</p>'+
					// '</div>'+
					// '<div class="div-cell number-info">'+
					// 	'<p>9876543210</p>'+
					// '</div>'+
					// '<div class="div-cell create-date-info">'+
					// 	'<p>1 Jan 2013</p>'+
					// '</div>'+
					// '<div class="div-cell user-role-info">'+
					// 	'<div class="dropdown">'+
					// 		'<a class="btn btn-white btn-sm rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Web Developer <i class="caret"></i></a>'+
					// 		'<ul class="dropdown-menu">'+
					// 			'<li><a href="#">Software Engineer</a></li>'+
					// 			'<li><a href="#">Software Tester</a></li>'+
					// 			'<li><a href="#">Frontend Developer</a></li>'+
					// 			'<li><a href="#">UI/UX Developer</a></li>'+
					// 		'</ul>'+
					// 	'</div>'+
					// '</div>'+
					// '<div class="div-cell user-action-info">'+
					// 	'<div class="text-right">'+
					// 		'<div class="dropdown">'+
					// 			'<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>'+
					// 			'<ul class="dropdown-menu pull-right">'+
					// 				'<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>'+
					// 				'<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>'+
					// 			'</ul>'+
					// 		'</div>'+
					// 		'</div>'+
					// 		'</div>'+
					// 		'</div>'+
					// 	'</div>'+
					// 	'<div class="div-table"><div class="div-row">'+
     // 			'<div class="div-cell user-cell">'+
					// 	'<div class="user_det_list">'+
					// 		'<a href="profile.html" class="avatar">J</a>'+
					// 		'<h2><a href="profile.html"><span class="username-info">John Doe</span>'+
					// 		'<span class="userrole-info">Web Designer</span></a></h2>'+
					// 	'</div>'+
					// '</div>'+
					// '<div class="div-cell user-identity">'+
					// 	'<p>FT-0001</p>'+
					// '</div>'+
					// '<div class="div-cell user-mail-info">'+
					// 	'<p>johndoe@example.com</p>'+
					// '</div>'+
					// '<div class="div-cell number-info">'+
					// 	'<p>9876543210</p>'+
					// '</div>'+
					// '<div class="div-cell create-date-info">'+
					// 	'<p>1 Jan 2013</p>'+
					// '</div>'+
					// '<div class="div-cell user-role-info">'+
					// 	'<div class="dropdown">'+
					// 		'<a class="btn btn-white btn-sm rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Web Developer <i class="caret"></i></a>'+
					// 		'<ul class="dropdown-menu">'+
					// 			'<li><a href="#">Software Engineer</a></li>'+
					// 			'<li><a href="#">Software Tester</a></li>'+
					// 			'<li><a href="#">Frontend Developer</a></li>'+
					// 			'<li><a href="#">UI/UX Developer</a></li>'+
					// 		'</ul>'+
					// 	'</div>'+
					// '</div>'+
					// '<div class="div-cell user-action-info">'+
					// 	'<div class="text-right">'+
					// 		'<div class="dropdown">'+
					// 			'<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>'+
					// 			'<ul class="dropdown-menu pull-right">'+
					// 				'<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>'+
					// 				'<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>'+
					// 			'</ul>'+
					// 		'</div>'+
					// 		'</div>'+
					// 		'</div>'+
					// 		'</div>';
						
					//var data ='';
     	
     	for(index in result){

			var first_name = result[index].first_name;
			var employee_name = result[index].first_name+' '+result[index].last_name;
			var employee_id = result[index].employee_id;
			var email = result[index].email;   
			var phone_number = result[index].phone_number;   
			var joining_date = result[index].joining_date;   


     	 data += '<div class="div-row">'+
					'<div class="div-cell user-cell">'+
						'<div class="user_det_list">'+
							'<a href="profile.html" class="avatar">J</a>'+
							'<h2><a href="profile.html"><span class="username-info">'+employee_name+'</span> <span class="userrole-info">Web Designer</span></a></h2>'+
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
							'<a class="btn btn-white btn-sm rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Web Developer <i class="caret"></i></a>'+
							'<ul class="dropdown-menu">'+
								'<li><a href="#">Software Engineer</a></li>'+
								'<li><a href="#">Software Tester</a></li>'+
								'<li><a href="#">Frontend Developer</a></li>'+
								'<li><a href="#">UI/UX Developer</a></li>'+
							'</ul>'+
						'</div>'+
					'</div>'+
					'<div class="div-cell user-action-info">'+
						'<div class="text-right">'+
							'<div class="dropdown">'+
								'<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>'+
								'<ul class="dropdown-menu pull-right">'+
									'<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>'+
									'<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>'+
								'</ul>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div><div class="clear-fix"></div>';

// 				data += '<div class="div-row" style="width:100%" >'+
// '<div class="div-cell user-cell">'+
// '<div class="user_det_list">'+
// '<a href="profile.html" class="avatar">J</a>'+
// '<h2><a href="profile.html"><span class="username-info">John Doe</span>'+
// '<span class="userrole-info">Web Designer</span></a></h2>'+
// '</div>'+
// '</div>'+
// '<div class="div-cell user-identity">'+
// '<p>FT-0001</p>'+
// '</div>'+
// '<div class="div-cell user-mail-info">'+
// '<p>johndoe@example.com</p>'+
// '</div>'+
// '<div class="div-cell number-info">'+
// '<p>9876543210</p>'+
// '</div>'+
// '<div class="div-cell create-date-info">'+
// '<p>1 Jan 2013</p>'+
// '</div>'+
// '<div class="div-cell user-role-info">'+
// '<div class="dropdown">'+
// '<a class="btn btn-white btn-sm rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Web Developer <i class="caret"></i></a>'+
// '<ul class="dropdown-menu">'+
// '<li><a href="#">Software Engineer</a></li>'+
// '<li><a href="#">Software Tester</a></li>'+
// '<li><a href="#">Frontend Developer</a></li>'+
// '<li><a href="#">UI/UX Developer</a></li>'+
// '</ul>'+
// '</div>'+
// '</div>'+
// '<div class="div-cell user-action-info">'+
// '<div class="text-right">'+
// '<div class="dropdown">'+
// '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>'+
// '<ul class="dropdown-menu pull-right">'+
// '<li><a href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>'+
// '<li><a href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>'+
// '</ul>'+
// '</div>'+
// '</div>'+
// '</div>'+
// '</div>';
			}
			console.log(data);

			     	$('.div-table').append(data);

       // sno = Number(sno);
       // $('#postsList tbody').empty();
       // for(index in result){
       //    var first_name = result[index].first_name;
       //    var employee_name = result[index].first_name+' '+result[index].last_name;
       //    var employee_id = result[index].employee_id;
       //    var email = result[index].email;      

       //    var tr = "<tr>";
       //    tr += "<td>"+ sno +"</td>";
       //    tr += "<td><a href='"+ link +"' target='_blank' >"+ title +"</a></td>";
       //    tr += "<td>"+ content +"</td>";
       //    tr += "</tr>";
       //    $('#postsList tbody').append(tr);
 
       //  }
      }
