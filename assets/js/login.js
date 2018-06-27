$('#login_form').submit(function(e){
	e.preventDefault();
	var user_name = $('#user_name').val();
	var password = $('#password').val();
	if(user_name == ''){
		updateNotification('', 'Enter username or email !', 'error');	
		return false;
	}
	if(password == ''){
		updateNotification('', 'Enter password !', 'error');	
		return false;
	}
	$.post(base_url+'login/check_login',{user_name:user_name,password:password},function(res){
		var obj = jQuery.parseJSON(res);
		if(obj.invalid_username){
			updateNotification('', 'Invalid username!', 'error');	
			return false;
		}else if(obj.invalid_password){
			updateNotification('', 'Invalid password!', 'error');	
			return false;
		}else if(obj.login_id){
			updateNotification('Success !', 'Logged in successfully!', 'success');	
			setTimeout(function() {window.location.href=base_url+"employees";}, 1000);
			
		}		
	});	
	return false;
});