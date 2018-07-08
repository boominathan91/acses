var global_username = '';
/*Intialize the sinch */
var sinchClient = new SinchClient({
	applicationKey: 'f06ae4f2-4980-40aa-89ca-9b98d80d70c4',
	capabilities: {messaging: true,calling: true, video: true},
	supportActiveConnection: true,
	onLogMessage: function(message) {
		//console.log(message.message);
	}
});
sinchClient.startActiveConnection();
// Get the messageClient
var messageClient = sinchClient.getMessageClient();


var sessionName = 'session_data'+sinchClient.applicationKey;


/*Register New User in Sinch */
var register = function(data){
	var credential = {};
	credential.username = data.sinch_username;
	credential.password = data.sinch_username;
	sinchClient.newUser(credential).then(function(ticket) {		
	}).fail(handleFail);
}


/*** Name of session, can be anything. ***/


/*Login  User in Sinch */
var login = function(data){		
	var credential = {};
	credential.username = data.sinch_username;
	credential.password = data.sinch_username;		
	var sessionObj = JSON.parse(localStorage[sessionName] || '{}');	
	global_username = sessionObj.userId;	
	sinchClient.start(credential).then(function() {
		localStorage[sessionName] = JSON.stringify(sinchClient.getSession());
		window.location.href=base_url+"chat";			
	}).fail(function(error){			
		console.log(error);
		return false;					
	});
}




var sessionObj = JSON.parse(localStorage[sessionName] || '{}');
if(sessionObj.userId) { 
	sinchClient.start(sessionObj)
	.then(function() {
		localStorage[sessionName] = JSON.stringify(sinchClient.getSession());
	})
	.fail(function() {

	});
}



/*Text Message*/
function message(txt){	
	var receiver_sinchusername = $('#receiver_sinchusername').val();
	// Create a new Message
	var message = messageClient.newMessage(receiver_sinchusername,txt);
	// Send it
	messageClient.send(message);
}


var myListenerObj = {
	onMessageDelivered: function(messageDeliveryInfo) {

	},
	onIncomingMessage: function(message) {
		receive_message(message);

	}
};
messageClient.addEventListener(myListenerObj);





function receive_message(message){
//	console.log(message);

	     var receiver_sinchusername = $('#receiver_sinchusername').val();  // sender username     
        var receiver_img = $('#receiver_image').val();     // receiver image 

        if(message.direction==true){

         //    if( message.textBody =='ENABLE_STREAM'){              
         //      $('#muted_image_me').show();
         //      return false; 
         //  }
         //  if(message.textBody =='DISABLE_STREAM'){
         //     $('#muted_image_me').hide();               
         //     return false;
         // }
     }else if(message.direction==false){

   //    if( message.textBody =='ENABLE_STREAM'){
   //      $('#other0').hide();
   //      $('#muted_image').show();
   //      return false; 
   //  }
   //  if(message.textBody =='DISABLE_STREAM'){
   //     $('#muted_image').hide();
   //     $('#other0').show();
   //     return false;
   // }
   


   /*Message From highlighting User */
   if(receiver_sinchusername == message.recipientIds[0] || receiver_sinchusername == message.recipientIds[1]){
   	$.post(base_url+'chat/get_message_details',{receiver_sinchusername:message.senderId},function(res){ 
   		var obj = jQuery.parseJSON(res);
   		var receiver_name = obj.reciever_data.first_name+' '+obj.reciever_data.last_name;
   		var msg = obj.msg_data.msg;
   		var type = obj.msg_data.type;
   		var file_name = base_url+obj.msg_data.file_path+'/'+obj.msg_data.file_name;
   		var time = message.timestamp.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: true });

   		var content = '<div class="chat chat-left">'+
   		'<div class="chat-avatar">'+
   		'<a href="#" class="avatar">'+
   		'<img alt="'+receiver_name+'" src="'+receiver_img+'" class="img-responsive img-circle">'+
   		'</a>'+
   		'</div>'+
   		'<div class="chat-body">'+
   		'<div class="chat-bubble">'+
   		'<div class="chat-content">'+
   		'<p>'+message.textBody+'</p>'+				
   		'<span class="chat-time">'+time+'</span>'+
   		'</div>'+
   		'</div>'+
   		'</div>'+
   		'</div>';

   		$('#ajax').append(content);
   	});
   }else{  /*Message From other user */

   	$('#'+message.senderId).addClass('hidden');
   	$.post(base_url+'chat/get_user_details',{receiver_sinchusername:message.senderId},function(res){ 
   		// console.log(res);
   		var datas = jQuery.parseJSON(res);
   		var count = datas.count;

   		if( datas.online_status == 1){
			var online_status = 'online';
		
		}else{
			var online_status = 'offline';			
		}
   		var receiver_name = datas.first_name+' '+datas.last_name; 
   		var content = '<li class="active" id="'+datas.sinch_username+'" onclick="set_chat_user('+datas.login_id+')">'+
   		'<a href="#"><span class="status '+online_status+'"></span>'+receiver_name+ '<span class="badge bg-danger pull-right">'+count+'</span></a>'+
   		'</li>';    		
   		$('#new_message_user').prepend(content);
   	});


   }


}
}

var handleFail = function (error){
	console.log(error);
}




