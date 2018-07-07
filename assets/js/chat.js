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
function set_chat_user(login_id){

	$('li').removeClass('active');
	$.post(base_url+'chat/set_chat_user',{login_id,login_id},function(res){
		var obj = jQuery.parseJSON(res);
		var data = '<li class="active" id="'+obj.sinch_username+'">'+
		'<a href="#"><span class="status '+obj.online_status+'"></span>'+obj.first_name+' '+obj.last_name+ '<span class="badge bg-danger pull-right"></span></a>'+
		'</li>';
		$('#'+obj.sinch_username).remove();
		$('#session_chat_user').html(data);
		$('#user_list').html('');
		$('#add_chat_user').modal('hide');
		$('#search_user').val('');
		$('.chat-main-row').removeClass('hidden');
		$('.to_name').text(obj.first_name+' '+obj.last_name);
		$('#recipients').val(obj.sinch_username);

	});

}
