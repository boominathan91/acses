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
function set_nav_bar_audio_user(login_id,element){

	$('li').removeClass('active').removeClass('hidden');
	$(element).addClass('active');
	$(element).next('span').next('span').empty();
	var id = $(element).attr('id');
	$('#'+id).closest('bg-danger').empty();
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

		$('#user_list').html('');
		$('#add_chat_user').modal('hide');
		$('#search_user').val('');
		$('#audio_panel').removeClass('hidden');
		$('.to_name').text(obj.first_name+' '+obj.last_name);
		$('#receiver_sinchusername').val(obj.sinch_username);
		$('#receiver_id').val(obj.login_id);
		$('#receiver_image').val(receiver_image);
		$('.receiver_title_image').attr('src',receiver_image);
		$('.dob').text(obj.dob);
		$('.receiver_email').text(obj.email);
		$('.phone_number').text(obj.phone_number);		

		$('.load-more-btn').click(function(){
			$('.load-more-btn').html('<button class="btn btn-default">Please wait . . </button>');
			var total = parseInt($(this).attr('total'));
			if(total>0){                        
				load_more(total);   
				var total = total - 1;
				$(this).attr('total',total); 
				if(total == 0){
					$('.load-more-btn').html('<button class="btn btn-default">Thats all!</button>');
				}
			}else{
				$('.load-more-btn').html('<button class="btn btn-default">Thats all!</button>');
			}

		});




	});

}


function update_call_details(){
	var call_to_id = $('#call_to_id').val();
	var call_from_id = $('#call_from_id').val();
	var group_id = $('#group_id').val();
	var call_type = $('#call_type').val();
	var call_duration = $('#call_duration').val();
	var call_started_at = $('#call_started_at').val();
	var call_ended_at = $('#call_ended_at').val();
	var end_cause = $('#end_cause').val();



	$.post(base_url+'chat/update_call_details',
	{
		call_from_id :call_from_id,
		call_to_id :call_to_id,
		group_id :group_id,
		call_type :call_type,
		call_duration :call_duration,
		call_started_at :call_started_at,
		call_ended_at :call_ended_at,
		end_cause :end_cause
	},function(res){
		console.log(res);
	});
}








/*Set Current */
function set_nav_bar_chat_user(login_id,element){

	$('li').removeClass('active').removeClass('hidden');
	$(element).addClass('active');
	$(element).next('span').next('span').empty();
	var id = $(element).attr('id');
	$('#'+id).closest('bg-danger').empty();
	$('.chats').html('');
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

		$('#user_list').html('');
		$('#add_chat_user').modal('hide');
		$('#search_user').val('');
		$('.chat-main-row,#task_window').removeClass('hidden');
		$('.to_name').text(obj.first_name+' '+obj.last_name);
		$('#receiver_sinchusername').val(obj.sinch_username);
		$('#receiver_id').val(obj.login_id);
		$('#receiver_image').val(receiver_image);
		$('.receiver_title_image').attr('src',receiver_image);
		$('.dob').text(obj.dob);
		$('.receiver_email').text(obj.email);
		$('.phone_number').text(obj.phone_number);
		$('.chats').html(obj.messages);
		$('#type').val('text');
		$('#group_id').val('');


		$('.load-more-btn').click(function(){
			$('.load-more-btn').html('<button class="btn btn-default">Please wait . . </button>');
			var total = parseInt($(this).attr('total'));
			if(total>0){                        
				load_more(total);   
				var total = total - 1;
				$(this).attr('total',total); 
				if(total == 0){
					$('.load-more-btn').html('<button class="btn btn-default">Thats all!</button>');
				}
			}else{
				$('.load-more-btn').html('<button class="btn btn-default">Thats all!</button>');
			}

		});




	});

}


/*Set Current Active User in Chat */
function set_chat_user(login_id){

	$('li').removeClass('active');
	$('.chats').html('');

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
		
		$('.session_chat_user').prepend(data);
		$('#user_list').html('');
		$('#add_chat_user').modal('hide');
		$('#search_user').val('');
		$('.chat-main-row,#task_window').removeClass('hidden');
		$('.to_name').text(obj.first_name+' '+obj.last_name);
		$('.department').text(obj.department_name);
		$('#receiver_sinchusername').val(obj.sinch_username);
		$('#receiver_id').val(obj.login_id);
		$('#receiver_image').val(receiver_image);
		$('.receiver_title_image').attr('src',receiver_image);
		$('.dob').text(obj.dob);
		$('.receiver_email').text(obj.email);
		$('.phone_number').text(obj.phone_number);
		$('.chats').html(obj.messages);
		$('#type').val('text');
		$('#group_id').val('');



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




	});

}



function delete_conversation()
{

	if(confirm('Are you sure to delete this conversation?')){
		var sender_id = $('#receiver_id').val();
		$.post(base_url+'chat/delete_conversation',{sender_id:sender_id},function(response){
			if(response == 1){
				$('.chats').html('<div class="no_message">No Record Found</div><div id="ajax"></div><input type="hidden"  id="hidden_id">');
			}
		});
	}
}

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

/*Append message onclick send button */

$('#chat_form').submit(function(){
	$('.no_message').html('');
	var time = $('#time').val();
	var img = $('#img').val();
	var receiver_id = $('#receiver_id').val();

	var input_message = $.trim($('#input_message').val());
	if(input_message == ''){
		updateNotification('','Please enter message to send!','error');
		return false;
	}
	if(input_message!=''){
		var content ='<div class="chat chat-right slimscrollleft">'+
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
		var message_type = $('#type').val();

		var group_id = $('#group_id').val();
		message(input_message);
		$.post(base_url+'chat/insert_chat',{message:input_message,receiver_id:receiver_id,message_type:message_type,group_id:group_id},function(res){

		});                 
		

	}
	return false;
});

$('.attach-icon').click(function(){
	$('#user_file').click();
});


$('#user_file').change(function(e) {   
	e.preventDefault();   
   var oFile = document.getElementById("user_file").files[0]; // <input type="file" id="fileUpload" accept=".jpg,.png,.gif,.jpeg"/>
            if (oFile.size > 25097152){ // 25 mb for bytes.
            	updateNotification('Warning!','File size must under 25MB!','error');
            	return false;
            }
            var formData = new FormData($('#chat_form')[0]);
            $.ajax({
            	url: base_url+'chat/upload_files',
            	type: 'POST',
            	data: formData,    
            	beforeSend :function(){
            		$('.progress').removeClass('hidden');
            		$('.progress').css('display','block');
            	},    
            	success: function(res) { 
            		$('.progress').addClass('hidden');               
            		var obj = jQuery.parseJSON(res);
            		if(obj.error){
            			updateNotification('Warning!',obj.error,'error');            			
            			$('#user_file').val('');
            			return false;
            		}      
            		var to_username = $('#receiver_sinchusername').val();
            		var img = $('#img').val();
            		var time = $('#time').val();
            		var up_file_name =obj.file_name;

            		if(obj.type == 'image'){
            			var file_src = '<div class="chat-img-group clearfix">'+
            			'<a class="chat-img-attach" href="'+base_url+'/'+obj.img+'" target="_blank">'+
            			'<img width="182" height="137" alt="" src="'+base_url+'/'+obj.img+'">'+
            			'<div class="chat-placeholder">'+
            			'<div class="chat-img-name">'+up_file_name+'</div>'+
            			'</div>'+
            			'</a>'+
            			'</div>';
            			
            			var img_content = 'img-content';

            		}else{
            			var file_src = '<ul class="attach-list">'+
            			'<li><i class="fa fa-file"></i><a href="'+base_url+'/'+obj.img+'">'+up_file_name+'</a></li>'+
            			'</ul>';    	
            			var img_content = '';
            		}           		

            		var content ='<div class="chat chat-right">'+
            		'<div class="chat-body">'+
            		'<div class="chat-bubble">'+
            		'<div class="chat-content '+img_content+'">'+file_src+
            		'<span class="chat-time">'+time+'</span>'+
            		'</div>'+            		
            		'</div>'+
            		'</div>'+
            		'</div>'+
            		'</div>';            		
            		$('#ajax').append(content); 
            		$('#user_file').val('');
            		$(".slimscrollleft.chats").mCustomScrollbar("update");
            		$(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom"); 
            		message('file');
            	},
            	error: function(error){
            		updateNotification('Warning!','Please try again','error'); 
            	},        
            	cache: false,
            	contentType: false,
            	processData: false

            }); 
            return false; 

        });



function load_more(total){   

	if(total==0){
		$('.load-more-btn').html('<button class="btn btn-default">Thats all!</button>');
		return false;
	}   

	var receiver_id = $('#receiver_id').val();                  

	$.post(base_url+'chat/get_old_messages',{total:total},function(res){  
		if(res){        
			$('.load-more-btn').html('<button class="btn btn-default" data-page="2"><i class="fa fa-refresh"></i> Load More</button>');               
			$('#ajax_old').prepend(res);
		}else{
			$('.load-more-btn').html('<button class="btn btn-default">Thats all!</button>');
		}
	}); 
}



(function($){
	$(window).on("load",function(){
		$(".chat-right,.chat-box.slimscrollleft,.chat-left").mCustomScrollbar({
			theme:"minimal"
		});			
	});
})(jQuery);


/*setting Current time */
function clock() {
	var time = new Date();
	time = time.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: true });
	$('#time').val(time);
	setTimeout('clock()',1000);
}
clock();


