function check_old_pwd(){
	var password = $('#old_password').val();
	if(password == ''){
		updateNotification('', 'Enter old password !', 'error');	
	}else{
		
		$.post(base_url+'settings/check_old_pwd',{password:password},function(res){
	var obj = jQuery.parseJSON(res);
	if(obj.match === 0){
		updateNotification('Warning   !', 'Old Password does not matches !', 'error');	
		$('.updateBtn').attr('disabled',true);
	}else{
		updateNotification('Success   !', 'Password matched !', 'success');	
		$('.updateBtn').attr('disabled',false);
	}
});

	}
}


$('#new_password').blur(function(){
	var confirm_password = $('#confirm_password').val();
	var confirm = $(this).val();
	if(confirm_password == ''){
		updateNotification('Success   !', 'Enter confirm password!', 'error');
	}
});



$('#confirm_password').keyup(function(){
	var new_pwd = $('#new_password').val();
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

$('#password_form').submit(function(){
	var password = $('#new_password').val();
	$.post(base_url+'settings/update_password',{password:password},function(res){
		updateNotification('Success   !', 'Password changed successfully!', 'success');	
		return false;
	});
	
});