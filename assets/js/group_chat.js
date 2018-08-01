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
				$('#task_window,#chat_sidebar').addClass('hidden');
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
				$('#receiver_sinchusername').val(obj.sinch_username);
				$('.chat-main-row').removeClass('hidden');				
				$('.to_name').text(obj.group_name);
				$('.receiver_title_image').attr('src',base_url+'assets/img/user.jpg');
				$('#channel').val(channel);
				$('.chat_messages').html('<div class="ajax"></div>');
				$('input[data-role=tagsinput]').tagsinput('removeAll');
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








function set_nav_bar_group_user(group_id,element){

	$('li').removeClass('active').removeClass('hidden');
	$(element).addClass('active');
	var id = $(element).attr('id');	
	$('#'+id+'danger').empty();	
	var type = $(element).attr('type');		
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
					$('#task_window,#chat_sidebar').addClass('hidden');
					
					var group_members_thumbnail = '';;
					var i=0;
					//if( obj.group_members && (type == 'audio' || type == 'video') ){
					if( obj.group_members && type == 'audio'){
						i++;
						$('.to_group_audio_name').text(group.group_name);
						$('.to_group_audio').text(group.group_name);
						group_members_thumbnail +='<li>'+
						'<img src="'+ currentUserProfileImage +'" id="'+currentUserId+'" class="img-responsive outgoing_image" alt="" title="'+currentUserName+'">'+						
						'</li>';

						$(obj.group_members).each(function(){
							receivers.push(this.sinch_username);
							receiver_id.push(this.login_id);
							if(this.profile_img != ''){
								var receiver_image = imageBasePath + this.profile_img;
							}else{
								var receiver_image = defaultImageBasePath +'user.jpg';
							}
							group_members_thumbnail +='<li id="' + this.members_id +'">'+
							'<img src="'+receiver_image+'" title ="'+this.first_name+' '+this.last_name+'"class="img-responsive outgoing_image" alt="">'+
							'<span class="thumb-title">'+this.first_name+' '+this.last_name+'</span>'+
							'</li>';
						});
						$('.group_members').append(group_members_thumbnail);

					}else if( obj.group_members && (type == 'text' || type =='video')){

						$(obj.group_members).each(function(){
							receivers.push(this.sinch_username);
							receiver_id.push(this.login_id);
						});


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
	$("#for_audio").hide();
	$("#for_group_audio").hide();
	$("#for_video").hide();
	$("#for_group_video").hide();
	$("#for_screen_share_group").show();

	$("#for_screen_share_group .chat-main-row").removeClass("hidden");
	
}


$("#group_screen_btn").click(function(){
	var url = $(this).attr("data-src");
	if(url) {
		$("#shareIframe").attr("href", url);
		$("#shareIframe")[0].click();
	}
	else {
		var group_name = $(this).attr("data-name");
		var from_id = $(this).attr("data-id");
		$.post(base_url+'chat/request_share', function(res){
			if(res){
				console.log(res);
				var obj = jQuery.parseJSON(res);

				screenShareData = jQuery.parseJSON(obj);

				if( screenleap.isBrowserSupportedForExtension() ) {
					console.log("Browser supported");
					screenleap.checkIsExtensionEnabled(
						function() {
							console.log("Extension enabled");
							console.log(screenShareData);
							screenleap.startSharing('IN_BROWSER', screenShareData);
						}, 
						function() {
							screenleap.checkIsExtensionInstalled(
								function() {
									console.log("Extension already installed but not enabled.");
								},
								function() {
									console.log("Extension not installed");
									screenleap.installExtension(
										function(){
											console.log('Extension installation success.');
										}, 
										function(){
											console.log('Extension installation failed.');
										}
										);
								}
								);
						}
						);
				}
				else {
					console.log('Browser not supported for screen leap extension.');
				}

				screenleap.onScreenShareStart = function() { 
					var code = screenleap.getScreenShareCode();
					var viewerUrl = screenleap.getViewerUrl();
					console.log('Screen is now shared using the code ' + code);
					console.log('Screen is now shared with the url ' + viewerUrl); 
					$.post(base_url+'chat/update_share',{'group_name': group_name,'from_id': from_id,'url':viewerUrl }, function(res){
						updateNotification('Members are invited successfully!', 'success');
					});


				} 

				screenleap.onScreenShareEnd = function() { 
					console.log('Screen sharing has ended'); 
				}

				screenleap.error = function(action, errorMessage, xhr) { 
					var msg = action + ': ' + errorMessage; 
					if (xhr) { 
						msg += ' (' + xhr.status + ')'; 
					} 
					console.log('Error in ' + msg); 
				}

				screenleap.onViewerConnect = function( screenShareData ) { 
					console.log('viewer ' + screenShareData.participantId + ' connected'); 
				}

				screenleap.onViewerDisconnect = function( screenShareData ) { 
					console.log('viewer ' + screenShareData.participantId + ' disconnected'); 
				} 

				screenleap.onPause = function() { 
					console.log('Screen sharing paused'); 
				}

				screenleap.onResume = function() { 
					console.log('Screen sharing resumed'); 
				}

			}
		});
	}

});
