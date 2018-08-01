localStorage.clear();
$('.loading').hide();
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
	
	$.ajax({
		type: "POST",
		url:base_url+'login/check_login',
		data:$('#login_form').serialize(),
		beforeSend :function(){
			$('.loading').hide();
			updateNotification('', 'Please wait..', 'success');
		},                         
		success: function (res) {
			var obj = jQuery.parseJSON(res);

				if(obj.invalid_username){
					updateNotification('', 'Invalid username!', 'error');	
					return false;
				}else if(obj.invalid_password){
					updateNotification('', 'Invalid password!', 'error');	
					return false;
				}else if(obj.type == 'admin'){
					updateNotification('Success !', 'Logged in successfully!', 'success');	
					setTimeout(function() {window.location.href=base_url+"employees";}, 1000);
				}else if(obj.type == 'user'){
					updateNotification('Success !', 'Logged in successfully!', 'success');				
					login(obj);				

				}
		},error:function(){
			$('.loading').hide();
			updateNotification('', 'Check your internet & try again !', 'error');	

		}	
	});

return false;
	
	
});