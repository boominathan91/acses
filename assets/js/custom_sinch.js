var global_username = '';
/*Intialize the sinch */
var sinchClient = new SinchClient({
	applicationKey: 'f06ae4f2-4980-40aa-89ca-9b98d80d70c4',
	capabilities: {messaging: true,calling: true, video: true},
	supportActiveConnection: true,
	onLogMessage: function(message) {
		console.log(message.message);
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

  var type = $('#type').val();
  if(type == 'text'){
    var receiver_sinchusername = $('#receiver_sinchusername').val();
  }else if(type == 'group'){
    var receiver_sinchusername = $('#receiver_sinchusername').val();
    var receiver_sinchusername = receiver_sinchusername.split(",");
    var receiver_sinchusername = receiver_sinchusername;
  }



	 // console.log(receiver_sinchusername);
  //  return false;
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

       var receiver_sinchusername = $('#receiver_sinchusername').val();  // receiver username     
	     var sender_sinchusername = $('#sender_sinchusername').val();  // sender username     
        var receiver_img = $('#receiver_image').val();     // receiver image 
        var message_type = $('#type').val();     // message type 

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


   var receiver = message.recipientIds;

   /*If selected receiver and incoming recivers are equal */
   if(sender_sinchusername != message.senderId &&  contains.call(receiver, receiver_sinchusername)){ /* Chat  with Receiver name same in hidden box  */

   	$.post(base_url+'chat/get_message_details',{receiver_sinchusername:message.senderId},function(res){ 
   		var obj = jQuery.parseJSON(res);
   		var receiver_name = obj.reciever_data.first_name+' '+obj.reciever_data.last_name;
   		var msg = obj.msg_data.message;
   		var type = obj.msg_data.type;
   		var file_name = base_url+obj.msg_data.file_path+'/'+obj.msg_data.file_name;
   		var time = message.timestamp.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: true });
       var up_file_name =obj.msg_data.file_name;


       if(obj.msg_data.message_type == 'group'){  /* Group chat  with Receiver name same in hidden box  */
        var group_id = $('#group_id').val();


        if(obj.msg_data.group_id == group_id){ /*Hidden group id and receiving group id are same */

          if(msg == 'file' && type == 'image'){ /*Message is a image file */

            var content ='<div class="chat chat-right">'+
            '<div class="chat-body">'+
            '<div class="chat-bubble">'+
            '<div class="chat-content img-content">'+
            '<div class="chat-img-group clearfix">'+
            '<a class="chat-img-attach" href="'+file_name+'" target="_blank">'+
            '<img width="182" height="137" alt="" src="'+file_name+'">'+
            '<div class="chat-placeholder">'+
            '<div class="chat-img-name">'+up_file_name+'</div>'+
            '</div>'+
            '</a>'+
            '</div>'+
            '<span class="chat-time">'+time+'</span>'+
            '</div>'+                  
            '</div>'+
            '</div>'+
            '</div>'+
            '</div>';

          }else if(msg == 'file' && type == 'others'){ /*Message is other file */

            var content ='<div class="chat chat-right">'+
            '<div class="chat-body">'+
            '<div class="chat-bubble">'+
            '<div class="chat-content "><ul class="attach-list">'+
            '<li><i class="fa fa-file"></i><a href="'+file_name+'">'+up_file_name+'</a></li>'+
            '</ul>'+
            '<span class="chat-time">'+time+'</span>'+
            '</div>'+                  
            '</div>'+
            '</div>'+
            '</div>'+
            '</div>';
          }else{ /* Text message */

           var content = '<div class="chat chat-left slimscrollleft">'+
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

         }
         $('.no_message').html('');
         $('#ajax').append(content);
       }else{ /*Hidden group and receiving msg group are different*/


        $('#'+obj.msg_data.group_name).remove();         
        var data = '<li  id="'+obj.msg_data.group_name+'" onclick="set_nav_bar_group_user('+obj.msg_data.group_id+',this)">'+
        '<a href="#">#'+obj.msg_data.group_name+ '<span class="badge bg-danger pull-right">1</span></a>'+
        '</li>';
        $('#new_group_user').prepend(data);

      }




    }else{ // One to One text chat with receiver name same in hidden box 


      if(msg == 'file' && type == 'image'){

        var content ='<div class="chat chat-right">'+
        '<div class="chat-body">'+
        '<div class="chat-bubble">'+
        '<div class="chat-content img-content">'+
        '<div class="chat-img-group clearfix">'+
        '<a class="chat-img-attach" href="'+file_name+'" target="_blank">'+
        '<img width="182" height="137" alt="" src="'+file_name+'">'+
        '<div class="chat-placeholder">'+
        '<div class="chat-img-name">'+up_file_name+'</div>'+
        '</div>'+
        '</a>'+
        '</div>'+
        '<span class="chat-time">'+time+'</span>'+
        '</div>'+                  
        '</div>'+
        '</div>'+
        '</div>'+
        '</div>';

      }else if(msg == 'file' && type == 'others'){

        var content ='<div class="chat chat-right">'+
        '<div class="chat-body">'+
        '<div class="chat-bubble">'+
        '<div class="chat-content "><ul class="attach-list">'+
        '<li><i class="fa fa-file"></i><a href="'+file_name+'">'+up_file_name+'</a></li>'+
        '</ul>'+
        '<span class="chat-time">'+time+'</span>'+
        '</div>'+                  
        '</div>'+
        '</div>'+
        '</div>'+
        '</div>';
      }else{

       var content = '<div class="chat chat-left slimscrollleft">'+
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

     }
     $('.no_message').html('');
     $('#ajax').append(content);



   }



 });
}else{  /*Message From other user */

  if(message.recipientIds.length >2){
    var message_type = 'group';
  } else{
    var message_type = 'text';
  }

    // $('#'+message.senderId).addClass('hidden');
    $.post(base_url+'chat/get_user_details',{receiver_sinchusername:message.senderId,message_type:message_type},function(res){ 
     var datas = jQuery.parseJSON(res);      
     var count = datas.count;

     if(message_type == 'group'){

      var group_id = $('#group_id').val();
      if(datas.message.group_id == group_id){



        // var receiver_name = obj.reciever_data.first_name+' '+obj.reciever_data.last_name;
      var msg = datas.message.message;
      var type = datas.message.type;
      var file_name = base_url+datas.message.file_path+'/'+datas.message.file_name;
      var time = message.timestamp.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: true });
       var up_file_name =datas.message.file_name;



          
          if(msg == 'file' && type == 'image'){

            var content ='<div class="chat chat-right">'+
            '<div class="chat-body">'+
            '<div class="chat-bubble">'+
            '<div class="chat-content img-content">'+
            '<div class="chat-img-group clearfix">'+
            '<a class="chat-img-attach" href="'+file_name+'" target="_blank">'+
            '<img width="182" height="137" alt="" src="'+file_name+'">'+
            '<div class="chat-placeholder">'+
            '<div class="chat-img-name">'+up_file_name+'</div>'+
            '</div>'+
            '</a>'+
            '</div>'+
            '<span class="chat-time">'+time+'</span>'+
            '</div>'+                  
            '</div>'+
            '</div>'+
            '</div>'+
            '</div>';

          }else if(msg == 'file' && type == 'others'){

            var content ='<div class="chat chat-right">'+
            '<div class="chat-body">'+
            '<div class="chat-bubble">'+
            '<div class="chat-content "><ul class="attach-list">'+
            '<li><i class="fa fa-file"></i><a href="'+file_name+'">'+up_file_name+'</a></li>'+
            '</ul>'+
            '<span class="chat-time">'+time+'</span>'+
            '</div>'+                  
            '</div>'+
            '</div>'+
            '</div>'+
            '</div>';
          }else{
              var receiver_img = datas.profile_img;
           var content = '<div class="chat chat-left slimscrollleft">'+
           '<div class="chat-avatar">'+
           '<a href="#" class="avatar">'+
           '<img src="'+receiver_img+'" class="img-responsive img-circle">'+
           '</a>'+
           '</div>'+
           '<div class="chat-body">'+
           '<div class="chat-bubble">'+
           '<div class="chat-content">'+
           '<p>'+msg+'</p>'+            
           '<span class="chat-time">'+time+'</span>'+
           '</div>'+
           '</div>'+
           '</div>'+
           '</div>';

         }
         $('.no_message').html('');
         $('#ajax').append(content);

      }else{ // Different group 

         if(datas.message){
        $(datas.message).each(function(){
          $('#'+this.group_name).remove();         
          var data = '<li  id="'+this.group_name+'" onclick="set_nav_bar_group_user('+this.group_id+',this)">'+
          '<a href="#">#'+this.group_name+ '<span class="badge bg-danger pull-right">'+count+'</span></a>'+
          '</li>';
          $('#new_group_user').prepend(data);

        });
      }   


      }
     


    }else{

      if( datas.online_status == 1){
        var online_status = 'online';
      }else{
        var online_status = 'offline';      
      }
      $('#'+datas.sinch_username).remove();
      var receiver_name = datas.first_name+' '+datas.last_name; 
      var content = '<li  id="'+datas.sinch_username+'" onclick="set_chat_user('+datas.login_id+')">'+
      '<a href="#"><span class="status '+online_status+'"></span>'+receiver_name+ '<span class="badge bg-danger pull-right">'+count+'</span></a>'+
      '</li>';       
      $('#new_message_user').prepend(content);

    }


  });


  }


}
}


var contains = function(needle) {
    // Per spec, the way to identify NaN is that it is not equal to itself
    var findNaN = needle !== needle;
    var indexOf;

    if(!findNaN && typeof Array.prototype.indexOf === 'function') {
      indexOf = Array.prototype.indexOf;
    } else {
      indexOf = function(needle) {
        var i = -1, index = -1;

        for(i = 0; i < this.length; i++) {
          var item = this[i];

          if((findNaN && item !== item) || item === needle) {
            index = i;
            break;
          }
        }

        return index;
      };
    }

    return indexOf.call(this, needle) > -1;
  };




  var handleFail = function (error){
   console.log(error);
 }




