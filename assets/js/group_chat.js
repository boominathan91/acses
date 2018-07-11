$('#text_group_form').submit(function(){
	var group_name = $('#group_name').val();
	var members = $('#members').val();
	if(group_name == ''){
		updateNotification('Warning !','Enter group name to create!','error');
		return false
	}else if(members == ''){
		updateNotification('Warning !','Select members to create group!','error');
		return false
	}

	$.post(base_url+'chat/create_group',{group_name:group_name,members:members,type:'text'},function(res){
		if(res){
			var obj = jQuery.parseJSON(res);
			if(obj.error){
				updateNotification('Warning !',obj.error,'error');			
			}else{
				$('#text_group_form')[0].reset();
				updateNotification('Success  !',obj.success,'success');		
				
				$('li').removeClass('active');
				$('.chats').html('');
				$('#task_window').addClass('hidden');
				$('#add_group').modal('hide');	
				var data = '<li class="active" id="'+obj.group_name+'" onclick="set_nav_bar_group_user('+obj.group_id+',this)">'+
				'<a href="#">#'+obj.group_name+ '<span class="badge bg-danger pull-right"></span></a>'+
				'</li>';
				$('#session_group_user').prepend(data);
				$('.chat-main-row').removeClass('hidden');
				$('.to_name').text(obj.group_name);
				$('.receiver_title_image').attr('src',base_url+'assets/img/user.jpg');



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
	 $('#'+id).closest('bg-danger').empty();

	$('.chats').html('');


	$('#group_id').val(group_id);
	$('.receiver_title_image').attr('src',base_url+'assets/img/user.jpg');	

	$.post(base_url+'chat/get_group_datas',{group_id:group_id},function(res){
		if(res){
			var obj = jQuery.parseJSON(res);
			if(obj.group){
				var group = obj.group;
				$('.to_name').text(group.group_name);
				$('#task_window').addClass('hidden');
				var receivers = [];
				var receiver_id = [];
				if(obj.group_members){
					$(obj.group_members).each(function(){
						receivers.push(this.sinch_username);
						receiver_id.push(this.login_id);
					});
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