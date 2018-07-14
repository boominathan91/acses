function set_group_type(type){
	switch(type){
		case 1:
		$('#group_type').val('text');
		break;
		case 2:
		$('#group_type').val('audio');
		break;
		case 3:
		$('#group_type').val('video');
		break;
	}
}


//Support functions
var getUuid = function() {
	return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
	    var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
	    return v.toString(16);
	});
};

var channel= getUuid();//random channel name

$('#group_form').submit(function(){
	var group_name = $('#group_name').val();
	var members = $('#members').val();
	var group_type = $('#group_type').val();
	if(group_name == ''){
		updateNotification('Warning !','Enter group name to create!','error');
		return false
	}else if(members == ''){
		updateNotification('Warning !','Select members to create group!','error');
		return false
	}

	$.post(base_url+'chat/create_group',{group_name:group_name,members:members,group_type:group_type,channel:channel},function(res){
		if(res){
			var obj = jQuery.parseJSON(res);
			if(obj.error){
				updateNotification('Warning !',obj.error,'error');			
			}else{
				$('#group_form')[0].reset();
				updateNotification('Success  !',obj.success,'success');		
				
				$('li').removeClass('active');
				$('.chats').html('');
				$('#task_window').addClass('hidden');
				$('#add_group').modal('hide');	
				var data = '<li class="active" id="'+obj.group_name+'" onclick="set_nav_bar_group_user('+obj.group_id+',this)">'+
				'<a href="#">#'+obj.group_name+ '<span class="badge bg-danger pull-right"></span></a>'+
				'</li>';
				
				if(obj.group_type == 'text'){
					$('#session_group_text').prepend(data);
						
				}else if(obj.group_type == 'audio'){
					$('#session_group_audio').prepend(data);

				}else if(obj.group_type == 'video'){
					$('#session_group_video').prepend(data);
				}
				$('.chat-main-row').removeClass('hidden');				
				$('.to_name').text(obj.group_name);
				$('.receiver_title_image').attr('src',base_url+'assets/img/user.jpg');
				$('#channel').val(channel);
			}
		}
	})
	return false;
});	








function set_nav_bar_group_user(group_id,element){


	$('li').removeClass('active').removeClass('hidden');
	$(element).addClass('active');
	$(element).next('span').next('span').empty();
	var id = $(element).attr('id');	
	var type = $(element).attr('type');	

	$('#'+id).closest('bg-danger').empty();

	$('.chats').html('');
	$('.chat-main-row').removeClass('hidden');

	$('#group_id').val(group_id);
	$('.receiver_title_image').attr('src',base_url+'assets/img/user.jpg');	
	$('.group_members').html('');
	$.post(base_url+'chat/get_group_datas',{group_id:group_id,type:type},function(res){
		if(res){
			var obj = jQuery.parseJSON(res);
			if(obj.group){
				var group = obj.group;
				$('.to_name').text(group.group_name);
				$('#task_window').addClass('hidden');
				var receivers = [];
				var receiver_id = [];
				var group_members_thumbnail = '';;
				var i=0;
				if(obj.group_members){
					i++;
					$(obj.group_members).each(function(){
						receivers.push(this.sinch_username);
						receiver_id.push(this.login_id);

						if(this.profile_img != ''){
						var receiver_image = this.profile_img;
						}else{
						var receiver_image = base_url+'assets/img/user.jpg';
						}

						group_members_thumbnail +='<li>'+
                                            	'<video id="outgoing'+i+'" autoplay class="img-responsive"></video>'+
                                                '<img src="'+receiver_image+'" class="img-responsive outgoing_image" alt="">'+
                                            	'</li>';
					});
					// $('.group_members').html(group_members_thumbnail);



				}
				$('#receiver_sinchusername').val(receivers);
				$('#receiver_id').val(receiver_id);
				$('#type').val('group');
				$('.no_message').html('');
				$('.chats').html(obj.messages);

				$('.load-more-btn').click(function(){
					$('.load-more-btn').html('<button class="btn btn-default">Please wait . . </button>');
					var total = $(this).attr('total');
					if(total>0 || total == 0 ){                        
						load_more(total);   
						var total = total - 1;
						$(this).attr('total',total); 
					}else{
						$('.load-more-btn').html('<button class="btn btn-default">Thats all!</button>');
					}

				});






				

			}		

			
		}
	});


}