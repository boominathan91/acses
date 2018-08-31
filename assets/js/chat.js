




$('a#answer').click(function(event) {
	event.preventDefault();
	var group_id = $('#group_id').val();
	var caller_login_id = $('.caller_login_id').val();
	var caller_sinchusername = $('.caller_sinchusername').val();
	var caller_full_name = $('.caller_full_name').val();
	var caller_profile_img = $('.caller_profile_img').val();
	$('.to_name').text(caller_full_name);
	$('.receiver_title_image').attr('src',caller_profile_img);
	$('#'+caller_sinchusername).click();
	$('#receiver_sinchusername').val(caller_sinchusername);
	$('audio#ringback').trigger("pause");
	$('audio#ringtone').trigger("pause");
	$('#incoming_call').modal('hide');
	$('.loading').hide();      
	$('.gr_tab').addClass('hidden');
	$('.vc_tab,.audio_call_icon').removeClass('hidden'); 


	$.post(base_url+'chat/get_dummy_datas',{group_id,group_id},function(res){



		/* New Incoming  Call  */
		var token;
		var subscribers = {};
		var obj = jQuery.parseJSON(res);
		var apiKey = obj.apiKey;    
		var sessionId = obj.sessionId;   
		var token = obj.token;
		var group_id = obj.dummy_group_id;
		var session = OT.initSession(apiKey, sessionId);
		/*Initialize the publisher*/
		var publisherOptions = {
			showControls: true,
			insertMode: 'append',
			width: '100%',
			height: '100%',
			// showControls: true,
			name: currentUserName,
			style: { nameDisplayMode: "on" }
		};
		var publisher = OT.initPublisher('outgoing', publisherOptions, handleError);
		$('.single_video,.vcend').removeClass('hidden');
		$('#outgoing_caller_image').addClass('hidden');
		$('.camera').css('color','#55ce63');  
    	clearInterval(notify);

    // Connect to the session
    session.connect(token, function callback(error) {
    	if (error) {
    		handleError(error);
    	} else {
    // If the connection is successful, publish the publisher to the session
    session.publish(publisher, handleError);
}
});

     // Subscribe to a newly created stream
     session.on('streamCreated', function streamCreated(event) {
     	var subscriberOptions = {
     		insertMode: 'append',
     		width: '30%',
     		height: '50%'	
     	};

     	console.log('--event--');
     	console.log(event);
     	console.log('--stream--');
     	console.log(event.stream);
     	console.log('--streams--');
     	console.log(event.streams);

     	$('.test').addClass('hidden');


     	var subscriber_id = 'subscriber_' + event.stream.connection.connectionId;
     	subscriberHtmlBlock = '<div class="subscriber" id="' + subscriber_id + '" style="width: 500px;height: 282px;"></div>';
     	$('#receiver_video_tab').append(subscriberHtmlBlock);
     	var subscriber = session.subscribe(event.stream, subscriber_id, subscriberOptions, handleError);
     	subscribers[subscriber_id] = subscriber;
     	console.log(subscribers);
     });

     session.on('sessionDisconnected', function sessionDisconnected(event) {
     	console.log('You were disconnected from the session.', event.reason);
     });

     $('.vcend').click(function(event) {
     	event.preventDefault();  
     	session.unpublish(publisher);
     	$('#incoming_call').modal('hide');  
     	var group_id  = $('#group_id').val();
     	$.post(base_url+'chat/discard_notify',{group_id:group_id},function(res){
     		$('#group_id').val('');
     		$('.vcend').removeClass('hidden');    
     	})
     });





 });  

});




$('#hangup').click(function(event) {
	event.preventDefault();  	
	$('audio#ringback').trigger("pause");
	$('audio#ringtone').trigger("pause");
	$('#incoming_call').modal('hide');
	var group_id  = $('#group_id').val();
	$.post(base_url+'chat/discard_notify',{group_id:group_id},function(res){
		$('#group_id').val('');
	});
});




function handle_video_panel(status){
	var video_type = $('#video_type').val();
						if(video_type == 'one'){ // One -to -one video 

							if(status == 0){ /* Clicking Audio icon */
								$('.vc_video').addClass('active');
								$('.start-call').attr('type','audio');

							}else{ /*Clicking Video icon */
								$('.start-call').attr('type','video');
							}	

							if($('.single_video').hasClass('hidden')){
								$('.single_video').removeClass('hidden');
								initializeSession();
							}else{
								$('.single_video').addClass('hidden');
							}


						}else{ /*Group video */

							$('.single_video').addClass('hidden');
							if(status == 0){ /* Clicking Audio icon */
								$('.vc_video').addClass('active');
								$('.start-call').attr('type','audio');

							}else{ /*Clicking Video icon */
								$('.start-call').attr('type','video');
							}	

							if($('.group_vccontainer').hasClass('hidden')){
								$('.group_vccontainer').removeClass('hidden');								
							}else{
								$('.group_vccontainer').addClass('hidden');								
							}

						}
						
					}

					function search_user(){
						var user_name = $('#search_user').val();
						$.post(base_url+'chat/get_users_by_name',{user_name:user_name},function(res){
							$('#user_list').html('');
							var data = '<ul class="media-list media-list-linked chat-user-list">';
							if(res){
								var obj = jQuery.parseJSON(res);
								$(obj).each(function(){

									data +='<li class="media">'+
									'<a href="#" class="media-link" type="text" onclick="set_chat_user('+this.login_id+', this)">'+
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


					$(document).ready(function(){



						$(".vcfullscreen").click(function(){
							$(".vcheader, .vcmsg, .vccolsmall, .message-bar").toggle();
							$(".vccollarge").toggleClass("vccollargefull");
							$(this).toggleClass("vcfullscreenalt");
							if($(".vccollarge").hasClass("vccollargefull")){
								$(".vccollarge").css('height',$(window).height());
							} else{
								$(".vccollarge").css('height','auto');
							}
						});

						$(".videoinner").click(function(){
							$(this).toggleClass("videoinneralt");
						});




					// $("#for_audio").hide();
					// $("#for_group_audio").hide();
					// $("#for_video").hide();
					// $("#for_group_video").hide();
					// $("#for_screen_share_group").hide();
					/* To make active group enable */
					$("#other_video_group li.active").click();
					$("#other_audio_group li.active").click();
					$("#session_video_user li.active").click();
					$("#session_audio_user li.active").click();
				});

					


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
							end_cause :end_cause,
							call_status:0
						},function(res){
							console.log(res);

							var obj = jQuery.parseJSON(res);
							/*Call History */

							var history ='';
							/*Call History for Audio */
							if(obj.call_history.length!=0){
								$(obj.call_history).each(function(){				

									var end_cause = this.end_cause;
									if(this.profile_img!=''){
										var caller_img = base_url+'uploads/'+this.profile_img;		
									}else{
										var caller_img = base_url+'assets/img/user.jpg';	
									}                     
									if(this.login_id != currentUserId){
										var caller_name = this.first_name+' '+this.last_name;	
										var receiver_name = 'You';
									}else{
										var receiver_name =  this.first_name+' '+this.last_name;
										var caller_name = 'You';                    						 		
									}
									var call_duration = this.call_duration;                    						 							 			
									var call_ended_at = this.call_ended_at;
									if(end_cause == 'HUNG_UP'){ 
					// Call from others and answered 

					history +='<div class="chat chat-left">'+
					'<div class="chat-avatar">'+
					'<a href="javascript.void(0);" class="avatar">'+
					'<img alt="'+caller_name+'" src="'+caller_img+'" class="img-responsive img-circle">'+
					'</a>'+
					'</div>'+
					'<div class="chat-body">'+
					'<div class="chat-bubble">'+
					'<div class="chat-content">'+
					'<span class="task-chat-user">'+caller_name+'</span>'+
					'<span class="chat-time">'+call_ended_at+'</span>'+
					'<div class="call-details">'+
					'<i class="material-icons">call_end</i>'+
					'<div class="call-info">'+
					'<div class="call-user-details">'+
					'<span class="call-description">This call has ended</span>'+
					'</div>'+
					'<div class="call-timing">Duration: <strong>'+call_duration+'</strong></div>'+
					'</div>'+
					'</div>'+
					'</div>'+
					'</div>'+
					'</div>'+
					'</div>';
				}else if(end_cause == 'DENIED'){

					history +='<div class="chat chat-left">'+
					'<div class="chat-avatar">'+
					'<a href="javascript:void(0);" class="avatar">'+
					'<img alt="'+caller_name+'" src="'+caller_img+'" class="img-responsive img-circle">'+
					'</a>'+
					'</div>'+
					'<div class="chat-body">'+
					'<div class="chat-bubble">'+
					'<div class="chat-content">'+
					'<span class="task-chat-user">'+caller_name+'</span>'+
					'<span class="chat-time">'+call_ended_at+'</span>'+
					'<div class="call-details">'+
					'<i class="material-icons">phone_missed</i>'+
					'<div class="call-info">'+
					'<div class="call-user-details">'+
					'<span class="call-description">'+receiver_name+' rejected call</span>'+
					'</div>'+						
					'</div>'+
					'</div>'+
					'</div>'+
					'</div>'+
					'</div>'+
					'</div>';
				}else{

					history +='<div class="chat chat-left">'+
					'<div class="chat-avatar">'+
					'<a href="javascript:void(0)" class="avatar">'+
					'<img alt="'+caller_name+'" src="'+caller_img+'" class="img-responsive img-circle">'+
					'</a>'+
					'</div>'+
					'<div class="chat-body">'+
					'<div class="chat-bubble">'+
					'<div class="chat-content">'+
					'<span class="task-chat-user">'+caller_name+'</span> <span class="chat-time">'+call_ended_at+'</span>'+
					'<div class="call-details">'+
					'<i class="material-icons">phone_missed</i>'+
					'<div class="call-info">'+
					'<div class="call-user-details">'+
					'<span class="call-description">'+receiver_name+'&nbsp;missed the call</span>'+
					'</div>'+						
					'</div>'+
					'</div>'+
					'</div>'+
					'</div>'+
					'</div>'+
					'</div>';
				}






			});				
								$('#call_history').prepend(history);
							}
							/*Call History */
						});
}
/*Set Current */
function set_nav_bar_chat_user(login_id,element){

	$('.gr_tab').addClass('hidden');
	$('.vc_tab').removeClass('hidden');
	$('li').removeClass('active').removeClass('hidden');
	$(element).addClass('active');
	$(element).next('span').next('span').empty();
	var id = $(element).attr('id');
	$('#'+id).closest('bg-danger').empty();
	$('#'+id+'danger').empty();

	
	$('.audio_call_icon').show();
	$('#video_type').val('one');
	$('.chat_messages').html('');
	var type = $(element).attr('type');	
	$('.group_vccontainer').addClass('hidden');

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
		$('.chat-main-row,#task_window,#chat_sidebar').removeClass('hidden');

		$('#user_list').html('');
		$('#add_chat_user').modal('hide');
		$('#search_user').val('');
		var session_type = $(element).parent().attr('id');

		$('.chat-main-row,#task_window,#chat_sidebar').removeClass('hidden');
		$("#for_screen_share_group").hide();				

		var group_type_name = type.replace(/_/g, ' ');
		var extra_add = 'Call';
		if(type == 'text_chat'){
			extra_add = '';					
			$('.to_name').text(obj.first_name+' '+obj.last_name);
		}

		$('.to_name').text(obj.first_name+' '+obj.last_name);
		$('#receiver_sinchusername').val(obj.sinch_username);
		$('#receiver_id').val(obj.login_id);
		$('#receiver_image').val(receiver_image);
		$('.receiver_title_image').attr('src',receiver_image);						
		$('.chat_messages').html(obj.messages);
		$('#type').val('text');
		$('#group_id').val('');

		var contents = '<div class="test" >'+
		'<img src="'+receiver_image+'" title ="'+obj.first_name+' '+obj.last_name+'" class="img-responsive outgoing_image" alt="" id="image_'+obj.sinch_username+'" >'+
		'<video id="video_'+obj.sinch_username+'" autoplay unmute class="hidden"></video>'+
		'<span class="thumb-title">'+obj.first_name+' '+obj.last_name+'</span>'+
		'</div>';
		$('#receiver_video_tab').html(contents);


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
function set_chat_user(login_id, element){
	var chat_user_type = $('#user_list').attr('data-type');	
	$('li').removeClass('active');
	$('.chat_messages').html('');
	$('#video_type').val('one');
	$('.group_vccontainer,.gr_tab').addClass('hidden');


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
		var data = '<li class="active" id="'+obj.sinch_username+'" onclick="set_nav_bar_chat_user('+obj.login_id+',this)" type=' + chat_user_type +'>'+
		'<a href="#"><span class="status '+online_status+'"></span>'+obj.first_name+' '+obj.last_name+ '<span class="badge bg-danger pull-right" id="'+obj.sinch_username+'danger"></span></a>'+
		'</li>';
		var group_type_name = chat_user_type.replace(/_/g, ' ');
		var extra_add = 'Call';
		if(chat_user_type == 'text_chat'){
			$('#session_chat_user').prepend(data);
			$('.chat-main-row,#task_window,#chat_sidebar').removeClass('hidden');
			extra_add = '';							
		}		


		$('.to_name').text(obj.first_name+' '+obj.last_name);

		$('#user_list').html('');
		$('#add_chat_user').modal('hide');
		$('#search_user').val('');		
		$('.department').text(obj.department_name);
		$('#receiver_sinchusername').val(obj.sinch_username);
		$('#receiver_id').val(obj.login_id);
		$('#receiver_image').val(receiver_image);
		$('.receiver_title_image').attr('src',receiver_image);						
		$('.chat_messages').html(obj.messages);
		$('#type').val('text');
		$('#group_id').val('');

		var contents = '<div class="test" >'+
		'<img src="'+receiver_image+'" title ="'+obj.first_name+' '+obj.last_name+'" class="img-responsive outgoing_image" alt="" id="image_'+obj.sinch_username+'" >'+
		'<video id="video_'+obj.sinch_username+'" autoplay unmute class="hidden"></video>'+
		'<span class="thumb-title">'+obj.first_name+' '+obj.last_name+'</span>'+
		'</div>';
		$('#receiver_video_tab').html(contents);



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
		var group_id = $('#group_id').val();
		$.post(base_url+'chat/delete_conversation',{sender_id:sender_id,group_id:group_id},function(response){
			if(response == 1){
				$('.chat_messages').html('<div class="no_message"></div><div class="ajax"></div><input type="hidden"  id="hidden_id">');
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
		$('.ajax').append(content);     
		$('#input_message').val('');  
		var message_type = $('#type').val();

		var group_id = $('#group_id').val();
		message(input_message);
		$.post(base_url+'chat/insert_chat',{message:input_message,receiver_id:receiver_id,message_type:message_type,group_id:group_id},function(res){

		});                 


	}
	return false;
});




$('#audio_chat_form').submit(function(){
	$('.no_message').html('');
	var time = $('#time').val();
	var img = $('#img').val();
	var receiver_id = $('#receiver_id').val();

	var input_message = $.trim($('#input_messages').val());
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
		$('.ajax').append(content);     
		$('#input_messages').val('');  
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
							$('.ajax').append(content); 
							$('#user_file').val('');

							$(".msg-list-scroll").slimscroll({ scrollBy: '400px' });

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
			$('.ajax_old').prepend(res);
		}else{
			$('.load-more-btn').html('<button class="btn btn-default">Thats all!</button>');
		}
	}); 
}





/*setting Current time */
function clock() {
	var time = new Date();
	time = time.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: true });
	$('#time').val(time);
	setTimeout('clock()',1000);
}
clock();

function modal_open(modal_type){
	$('#user_list').attr('data-type', modal_type);
	$('#add_chat_user').modal('show');
}

