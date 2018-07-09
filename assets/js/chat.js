function search_user(){
	var user_name = $('#search_user').val();
	$.post(base_url+'chat/get_users_by_name',{user_name:user_name},function(res){
		$('#user_list').html('');
		var data = '<ul class="media-list media-list-linked chat-user-list">';
		if(res){
			var obj = jQuery.parseJSON(res);
			$(obj).each(function(){

				data +='<li class="media">'+
				'<a href="#" class="media-link" onclick="set_chat_user('+this.login_id+')">'+
				'<div class="media-left"><span class="avatar">'+this.first_letter+'</span></div>'+
				'<div class="media-body media-middle text-nowrap">'+
				'<div class="user-name">'+this.first_name+' '+this.last_name+'</div>'+
				'<span class="designation">'+this.department_name+'</span>'+
				'</div>'+
				'<div class="media-right media-middle text-nowrap">'+			
				'</div>'+
				'</a>'+
				'</li>';
			});
			data +='</ul>';
			$('#user_list').append(data);

		}


	});
}

/*Set Current Active User in Chat */
function set_nav_bar_chat_user(login_id,element){

	$('li').removeClass('active').removeClass('hidden');
	$(element).addClass('active');
	$(element).next('span').next('span').empty();
	//var sinch_username = $(element).attr('id');
	//$('#'+sinch_username).addClass('hidden');
	$.post(base_url+'chat/set_chat_user',{login_id,login_id},function(res){
		var obj = jQuery.parseJSON(res);
		
		if(obj.online_status == 1){
			var online_status = 'online';
			$('.title_status').removeClass('offline');
			$('.title_status').addClass('online');
		}else{
			var online_status = 'offline';
			$('.title_status').removeClass('online');
			$('.title_status').addClass('offline');
		}
		if(obj.profile_img != ''){
				var receiver_image = obj.profile_img;
		}else{
			var receiver_image = base_url+'assets/img/user.jpg';
		}
			
		// var data = '<li class="active" id="'+obj.sinch_username+'" onclick="set_chat_user('+obj.login_id+')">'+
		// '<a href="#"><span class="status '+online_status+'"></span>'+obj.first_name+' '+obj.last_name+ '<span class="badge bg-danger pull-right"></span></a>'+
		// '</li>';
		//$('#session_chat_user').html(data);
		$('#user_list').html('');
		$('#add_chat_user').modal('hide');
		$('#search_user').val('');
		$('.chat-main-row').removeClass('hidden');
		$('.to_name').text(obj.first_name+' '+obj.last_name);
		$('#receiver_sinchusername').val(obj.sinch_username);
		$('#receiver_id').val(obj.login_id);
		$('#receiver_image').val(receiver_image);
		$('.receiver_title_image').attr('src',receiver_image);

	});

}


/*Set Current Active User in Chat */
function set_chat_user(login_id){

	$('li').removeClass('active');

	$.post(base_url+'chat/set_chat_user',{login_id,login_id},function(res){
		var obj = jQuery.parseJSON(res);
		if(obj.online_status == 1){
			var online_status = 'online';
		}else{
			var online_status = 'offline';
		}
		if(obj.profile_img != ''){
				var receiver_image = obj.profile_img;
		}else{
			var receiver_image = base_url+'assets/img/user.jpg';
		}
		$('#'+obj.sinch_username).remove();
		var data = '<li class="active" id="'+obj.sinch_username+'" onclick="set_nav_bar_chat_user('+obj.login_id+',this)">'+
		'<a href="#"><span class="status '+online_status+'"></span>'+obj.first_name+' '+obj.last_name+ '<span class="badge bg-danger pull-right"></span></a>'+
		'</li>';
		
		$('#session_chat_user').prepend(data);
		$('#user_list').html('');
		$('#add_chat_user').modal('hide');
		$('#search_user').val('');
		$('.chat-main-row').removeClass('hidden');
		$('.to_name').text(obj.first_name+' '+obj.last_name);
		$('#receiver_sinchusername').val(obj.sinch_username);
		$('#receiver_id').val(obj.login_id);
		$('#receiver_image').val(receiver_image);
		$('.receiver_title_image').attr('src',receiver_image);

	});

}

/*Append message onclick send button */

$('#chat_form').submit(function(){
	// $('.no_message').html('');
	var time = $('#time').val();
	var img = $('#img').val();
	var receiver_id = $('#receiver_id').val();

	var input_message = $.trim($('#input_message').val());
	if(input_message == ''){
		updateNotification('','Please enter message to send!','error');
		return false;
	}
	if(input_message!=''){
		var content ='<div class="chat chat-right">'+
		'<div class="chat-body">'+
		'<div class="chat-bubble">'+
		'<div class="chat-content">'+
		'<p>'+input_message+'</p>'+
		'<span class="chat-time">'+time+'</span>'+
		'</div>'+		
		'</div>'+
		'</div>'+
		'</div>';
		$('#ajax').append(content);     
		$('#input_message').val('');  
		message(input_message);
		$.post(base_url+'chat/insert_chat',{message:input_message,receiver_id:receiver_id},function(res){

		});                 
		

	}
	return false;
});




/*setting Current time */
function clock() {
	var time = new Date();
	time = time.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: true });
	$('#time').val(time);
	setTimeout('clock()',1000);
}
clock();


