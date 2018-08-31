isMobile = {
	Android: function() {
		return navigator.userAgent.match(/Android/i);
	},
	BlackBerry: function() {
		return navigator.userAgent.match(/BlackBerry/i);
	},
	iOS: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	},
	Opera: function() {
		return navigator.userAgent.match(/Opera Mini/i);
	},
	Windows: function() {
		return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
	},
	any: function() {
		return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	}
};

var screenShareData = null;

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
		case 4:
		$('#group_type').val('screen_share');
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


$('#group_user_form').submit(function(){

	var members = $('#members1').val();
	var group_id = $('#group_id').val();
	if(members == ''){
		updateNotification('Warning !','Select members!','error');
		return false
	}

	$.post(base_url+'chat/add_group_user',{group_id:group_id,members:members},function(res){
		var obj = jQuery.parseJSON(res);		
		$('#add_group_user').modal('hide');	
		$('#group_user_form')[0].reset();
		updateNotification('Success  !','New user added','success');	

		var data ='';
		var group_name = obj.group_name;
		var group_id = obj.group_id;
		if(group_name!=''){
		$('.to_name').text(group_name);
		$('#group_id').val(group_id);
		$('li').removeClass('active');
		var content =  '<li class="active" id="'+group_name+'" onclick="set_nav_bar_group_user('+group_id+',this)" type="group_text_chat"><a href="javascript:void(0)" >#'+group_name+'<span class="badge bg-danger pull-right" id="'+group_name+'danger"></span></a></li>';
		$('#session_group_text').prepend(content);
		}
		


		var receivers =[];
		receivers.push($('#receiver_sinchusername').val());

		$(obj.users).each(function(){
			receivers.push(this.sinch_username);
			send_new_msg('NEW_GROUP_ADDED',this.sinch_username);

			if(this.profile_img != ''){
				var image = base_url+'uploads/'+this.profile_img;
			}else{
				var image = base_url+'assets/img/user.jpg';
			}

			data +='<div class="test" >'+
			'<img src="'+image+'" title ="'+this.first_name+' '+this.last_name+'" class="img-responsive outgoing_image" alt="" id="image_'+this.sinch_username+'" >'+
			'<video id="video_'+this.sinch_username+'" autoplay unmute class="hidden"></video>'+
			'<span class="thumb-title">'+this.first_name+' '+this.last_name+'</span>'+
			'</div>';

		});

		$('#receiver_sinchusername').val(receivers);


		$('.group_members').prepend(data);
		message('NEW_USER_ADDED');

	});
	return false;





});

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



	if(group_type == 'text'){
		$('#type').val('group');
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
				$('.chat_messages').html('');
				// $('#task_window,#chat_sidebar').addClass('hidden');
				$('#add_group').modal('hide');	
				if(obj.group_type == 'text'){
					var gtype = obj.group_type;

				}else if(obj.group_type == 'audio'){
					var gtype = 'group_audio';

				}else if(obj.group_type == 'video'){
					var gtype = 'group_video';
				}
				var data = '<li class="active" id="'+obj.group_name+'" onclick="set_nav_bar_group_user('+obj.group_id+',this)" type="'+gtype+'">'+
				'<a href="#">#'+obj.group_name+ '<span class="badge bg-danger pull-right"></span></a>'+
				'</li>';
				
				if(obj.group_type == 'text'){
					$('#session_group_text').prepend(data);

				}else if(obj.group_type == 'audio'){
					$('#session_group_audio').prepend(data);

				}else if(obj.group_type == 'video'){
					$('#session_group_video').prepend(data);
				}
				var data ='';
				var receivers =[];		
				$(obj.group_members).each(function(){
					receivers.push(this.sinch_username);

					if(this.profile_img != ''){
						var image = base_url+'uploads/'+this.profile_img;
					}else{
						var image = base_url+'assets/img/user.jpg';
					}

					data +='<div class="test" >'+
					'<img src="'+image+'" title ="'+this.first_name+' '+this.last_name+'" class="img-responsive outgoing_image" alt="" id="image_'+this.sinch_username+'" >'+
					'<video id="video_'+this.sinch_username+'" autoplay unmute class="hidden"></video>'+
					'<span class="thumb-title">'+this.first_name+' '+this.last_name+'</span>'+
					'</div>';

				});		
				$('#receiver_sinchusername').val(receivers);
				$('#group_members').prepend(data);
				$('.gr_tab,.add_user').removeClass('hidden');
				$('.add_user').show();
				$('.single_video,.vc_tab').addClass('hidden');
				$('.chat-main-row').removeClass('hidden');				
				$('.to_name').text(obj.group_name);
				$('.to_group_video').text(obj.group_name);
				$('.receiver_title_image').attr('src',base_url+'assets/img/user.jpg');
				$('#channel').val(channel);
				$('.chat_messages').html('<div class="ajax"></div>');
				$('input[data-role=tagsinput]').tagsinput('removeAll');
				$('.single_video').addClass('hidden');
				message('NEW_GROUP_ADDED');
			}
		}
	})
	return false;
});	



$('#screen_share_form').submit(function(){
	var members = $('#share_members').val();
	var group_name = $('#share_group_name').val();
	if(group_name == ''){
		updateNotification('Warning !','Enter group name to create!','error');
		return false
	}else if(members == ''){
		updateNotification('Warning !','Select members to create group!','error');
		return false
	}

	$.post(base_url+'chat/create_share',{group_name:group_name,members:members},function(res){
		if(res){
			console.log(res);
			var obj = jQuery.parseJSON(res);

			if(obj.error){
				updateNotification('Warning !',obj.error,'error');			
			}else{
				$('#group_form')[0].reset();
				updateNotification('Success  !',obj.success,'success');	

				var data = '<li class="active" data-id="'+obj.fromId+'" data-src="'+obj.url+'" data-name="'+obj.group_name+'" id="'+obj.group_name+'" onclick="set_nav_bar_share_group_user(this)">'+
				'<a href="#">#'+obj.group_name+ '<span class="badge bg-danger pull-right"></span></a>'+
				'</li>';	
				
				$('#session_screen_shrare_group').prepend(data);
				message('NEW_GROUP_ADDED');
				location.reload();

			}
			
		}
	});
	return false;
});	



function add_user(){
	var group_name = $('.to_group_video').text();
	var group_id = $('#group_id').val();
	$('#add_group_user').modal('show');
	$('#group_name1').val(group_name);
	$('#group_id1').val(group_id);

}




function set_nav_bar_group_user(group_id,element){

	$('.gr_tab').removeClass('hidden');
	$('.single_video,.vc_tab').addClass('hidden');
	$('li').removeClass('active').removeClass('hidden');
	$(element).addClass('active');
	var id = $(element).attr('id');	
	$('#'+id+'danger').empty();	
	var type = $(element).attr('type');	
	$('.add_user').show();
	$('#video_type').val('many');

	$("div[id^='for_']").hide();	
	$('#for_' + type).show();
	$('.chat_messages').html('');
	$('.chat-main-row').removeClass('hidden');
	$('#group_id').val(group_id);
	$('.receiver_title_image').attr('src',base_url+'assets/img/user.jpg');	
	$('.group_members').html('');
	$.post(base_url+'chat/get_group_datas',{group_id:group_id,type:type},function(res){
		if(res){
			var obj = jQuery.parseJSON(res);
			if(obj.group){
				var group = obj.group;
				var type = obj.group.type;
				var group_type_name =type.replace(/_/g, ' ');
				var extra_add = 'Call';
				var receivers = [];
				var receiver_id = [];					


				if(type == 'text'){
					extra_add = '';
					$('.to_name').text(group.group_name);
				}
				$('.to_' + type).text(group.group_name);
					// $('#task_window,#chat_sidebar').addClass('hidden');
					
					var group_members_thumbnail = '';;
					var i=0;			
					if( obj.group_members){
						$(obj.group_members).each(function(){
							receivers.push(this.sinch_username);
							receiver_id.push(this.login_id);					
							if(this.profile_img != ''){
								var receiver_image = imageBasePath + this.profile_img;
							}else{
								var receiver_image = defaultImageBasePath +'user.jpg';
							}
							group_members_thumbnail +='<div class="test" >'+
							'<img src="'+receiver_image+'" title ="'+this.first_name+' '+this.last_name+'" class="img-responsive outgoing_image" alt="" id="image_' + this.sinch_username +'" >'+
							'<video id="video_'+this.sinch_username+'" autoplay unmute class="hidden"></video>'+
							'<span class="thumb-title">'+this.first_name+' '+this.last_name+'</span>'+
							'</div>';
						});
						$('.group_members').html(group_members_thumbnail);
					}
				// console.log(receivers);
				$('.to_group_video_name').text(group.group_name);
				$('.to_group_video').text(group.group_name);
				$('#receiver_sinchusername').val(receivers);
				$('#receiver_id').val(receiver_id);
				$('#type').val('group');
				$('.no_message').html('');
				$('.chat_messages').html(obj.messages);

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



function set_nav_bar_share_group_user(element){
	$("#group_screen_btn").attr("data-id", $(element).attr("data-id"));
	$("#group_screen_btn").attr("data-name", $(element).attr("data-name"));
	if( currentUserId != $(element).attr("data-id") ) {
		$("#group_screen_btn").attr("data-src", $(element).attr("data-src"));
		$("#group_screen_btn").html("Click to view the shared screen");
	}
	$(".screen-share-window").removeClass("hidden");
	$(".audio_call_icon").hide();
	$("#for_audio").hide();
	$("#for_group_audio").hide();
	$("#for_video").hide();
	$("#for_group_video").hide();
	$("#for_screen_share_group").show();

	$("#for_screen_share_group .chat-main-row").removeClass("hidden");
	
}


function set_screen_share_url(){
	$('.loading').show();
	var group_id = $('#group_id').val();
	var receiver_id = $('#receiver_id').val();
	$.post(base_url+'chat/request_share', function(res){
		if(res){
				// console.log(res);
				var obj = jQuery.parseJSON(res);

				screenShareData = jQuery.parseJSON(obj);

				if( screenleap.isBrowserSupportedForExtension() ) {
					console.log("Browser supported");

					screenleap.checkIsExtensionEnabled(function(){ // If Extension installed 						 
						updateNotification('','Extension enabled.', 'success');
						console.log(screenShareData);
						screenleap.startSharing('IN_BROWSER', screenShareData);

						screenleap.checkIsExtensionInstalled(
							function() {									
								$('.loading').hide();
								console.log("Extension already installed but not enabled.");
								updateNotification('',"Extension already installed but not enabled.", 'error');
							},
							function() {
								$('.loading').hide();
								console.log("Extension not installed");
								screenleap.installExtension(
									function(){
										$('.loading').hide();
										console.log('Extension installation success.');
										updateNotification('','Extension installation success.', 'success');
									}, 
									function(){
										$('.loading').hide();
										console.log('Extension installation failed.');
										updateNotification('','Extension installation failed.', 'error');
									}
									);
							}
							);



					},function(){ // If Extension not installed 	
						$('.loading').hide();									
						updateNotification('',"Screen leap Extension should be  installed to screenshare.", 'error');
					}					
					);
				}
				else {
					console.log('Browser not supported for screen leap extension.');
					updateNotification('','Browser not supported for screen leap extension.', 'error');

				}



				screenleap.onScreenShareStart = function() { 
					var code = screenleap.getScreenShareCode();
					var viewerUrl = screenleap.getViewerUrl();
					console.log('Screen is now shared using the code ' + code);
					console.log('Screen is now shared with the url ' + viewerUrl); 


					$.post(base_url+'chat/update_share',{'group_id': group_id,'receiver_id': receiver_id,'url':viewerUrl }, function(res){
						$('.loading').hide();
						updateNotification('','Screen Share started successfully!', 'success');
						var receiver_sinchusername = $('#receiver_sinchusername').val();
						var viewerUrl = screenleap.getViewerUrl();
						viewerUrl = viewerUrl.replace(/'/g, "\\'")
						var txt  = 'Click the link to see the Screen share <br> <a href="'+viewerUrl+'" data-src="'+viewerUrl+'"  target="blank">'+viewerUrl+'</a>';					
						txt = txt.link(viewerUrl);
						var time = $('#time').val();
						var content ='<div class="chat chat-right">'+
						'<div class="chat-body">'+
						'<div class="chat-bubble">'+
						'<div class="chat-content">'+
						'<p>'+txt+'</p>'+
						'<span class="chat-time">'+time+'</span>'+
						'</div>'+		
						'</div>'+
						'</div>'+
						'</div>';
						$('.ajax').append(content);
							// Create a new Message
							var receiver_sinchusername = $('#receiver_sinchusername').val();
							var receiver_sinchusername = receiver_sinchusername.split(",");
							var receiver_sinchusername = receiver_sinchusername;
							var message = messageClient.newMessage(receiver_sinchusername,txt);
						// Send it
						messageClient.send(message);
						return false;


					});


				} 

				screenleap.onScreenShareEnd = function() { 
					updateNotification('','Screen sharing has ended!', 'success');
					
				}

				screenleap.error = function(action, errorMessage, xhr) { 
					var msg = action + ': ' + errorMessage; 
					if (xhr) { 
						msg += ' (' + xhr.status + ')'; 
					} 
					console.log('Error in ' + msg); 
					updateNotification('','Error in ' + msg, 'error');

				}

				screenleap.onViewerConnect = function( screenShareData ) { 
					console.log('viewer ' + screenShareData.participantId + ' connected'); 
					updateNotification('','viewer ' + screenShareData.participantId + ' connected', 'success');
				}

				screenleap.onViewerDisconnect = function( screenShareData ) { 
					console.log('viewer ' + screenShareData.participantId + ' disconnected'); 
					updateNotification('','viewer ' + screenShareData.participantId + ' disconnected', 'success');
				} 

				screenleap.onPause = function() { 
					updateNotification('','Screen sharing paused', 'success');
					console.log('Screen sharing paused'); 
				}

				screenleap.onResume = function() { 
					updateNotification('','Screen sharing resumed', 'success');
					console.log('Screen sharing resumed'); 
				}

			}
		});
}

function redirect_url(element){
	console.log(element);
}

