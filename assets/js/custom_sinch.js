var global_username = '';
/*Intialize the sinch */
var sinchClient = new SinchClient({
	applicationKey: 'f06ae4f2-4980-40aa-89ca-9b98d80d70c4',
	capabilities: {messaging: true,calling: true},
	supportActiveConnection: true,
  startActiveConnection: true,
  onLogMessage: function(message) {
    console.log(message.message);
  }
});
//sinchClient.startActiveConnection();
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




  /*Audio Call Starts */



  var h1 = document.getElementById('timer'),seconds = 0, minutes = 0, hours = 0,t;
  function add() {
    seconds++;
    if (seconds >= 60) {
      seconds = 0;
      minutes++;
      if (minutes >= 60) {
        minutes = 0;
        hours++;
      }
    }
    
    h1.textContent = (hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds);
    $('#call_duration').val((hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds));

    timer();
  }

  function timer() {
    t = setTimeout(add, 1000);
  }

/* Clear button */
var clear = function() {
  h1.textContent = "00:00:00";
  seconds = 0; minutes = 0; hours = 0;
}

/*** Define listener for managing calls ***/

var callListeners = {
  onCallProgressing: function(call) {
    $('audio#ringback').prop("currentTime", 0);
    $('audio#ringback').trigger("play");

    //Report call stats
    $('span.call-timing-count').html('<div id="stats">Ringing...</div>');
  },
  onCallEstablished: function(call) {
    $('audio#incoming').attr('src', call.incomingStreamURL);
    $('audio#ringback').trigger("pause");
    $('audio#ringtone').trigger("pause");
    $('#incoming_call').modal('hide');
    $('.start-call').hide();
    $('.hangup,#audio-footer').removeClass('hidden');  
    //Report call stats
    var callDetails = call.getDetails();
    timer();    
    $('#call_started_at').val(callDetails.establishedTime);
  },
  onCallEnded: function(call) {
    clearTimeout(t);
    $('audio#ringback').trigger("pause");
    $('audio#ringtone').trigger("pause");
    $('audio#incoming').attr('src', '');     

    //Report call stats
    var callDetails = call.getDetails();    
    $('#call_ended_at').val(callDetails.endedTime);    
    $('#end_cause').val(call.getEndCause());

    if(call.getEndCause() == 'CANCELED'){
      $('span.call-timing-count').html('Call Canceled.');    
    }else if(call.getEndCause == 'HUNG_UP'){
      $('span.call-timing-count').html('Call Ended.'); 
    }
      $('.start-call').show();  
      $('.hangup,#audio-footer').addClass('hidden');    
    update_call_details();
    setTimeout(function() {        
      clear();
      $('#timer').html('');
      }, 2000);
    if(call.error) {
      $('span.call-timing-count').append('<div id="stats">Failure message: '+call.error.message+'</div>');
    }
  }
}


/*** Set up callClient and define how to handle incoming calls ***/

var callClient = sinchClient.getCallClient();
// callClient.initStream().then(function() { // Directly init streams, in order to force user to accept use of media sources at a time we choose
//   $('div.frame').not('#chromeFileWarning').show();
// }); 

var call;
callClient.addEventListener({
  onIncomingCall: function(incomingCall) {
    console.log(incomingCall);
  //Play some groovy tunes 
  $('audio#ringtone').prop("currentTime", 0);
  $('audio#ringtone').trigger("play");

  $('#incoming_call').modal('show');

  //Print statistics
  $('small text-muted').append('<div id="title">Incoming call from ' + incomingCall.fromId + '</div>');  
  $.post(base_url+'chat/get_caller_details',{sinch_username:incomingCall.fromId },function(res){
    var obj=jQuery.parseJSON(res);
    
    $('.caller_image').attr('src',obj.profile_img);
    $('.caller_name').text(obj.name);
    $('#call_from_id').val(obj.call_from_id);      
    $('#call_to_id').val(obj.call_to_id);
    $('.caller_sinchusername').val(obj.sinch_username);      
    $('.caller_full_name').val(obj.name);      
    $('.caller_profile_img').val(obj.profile_img);      
  });

  

  //Manage the call object
  call = incomingCall;
  call.addEventListener(callListeners);

}
});

$('.call-item').click(function(){
  if(call){
    if($(this).hasClass('active')){
      $(this).removeClass('active');
      call.unmute();
    }else{
      $(this).addClass('active');
      call.mute();
    }

  }
  
});

$('a#answer').click(function(event) {
  event.preventDefault();
  try {
    var caller_login_id = $('.caller_login_id').val();
    var caller_sinchusername = $('.caller_sinchusername').val();
    var caller_full_name = $('.caller_full_name').val();
    var caller_profile_img = $('.caller_profile_img').val();
    $('.to_name').text(caller_full_name);
    $('.receiver_title_image').attr('src',caller_profile_img);
    call.answer();
  }
  catch(error) {
    handleFail(error);
  }
  
});





/*** Make a new data call ***/

$('button.start-call').click(function(event) {
  event.preventDefault();    
  $('span.call-timing-count').html('<div id="title">Calling...</div>');
  //console.log('Placing call to: ' + $('input#receiver_sinchusername').val());
  call = callClient.callUser($('input#receiver_sinchusername').val());
  call.addEventListener(callListeners);  
  $('.start-call').hide();
});

/*** Hang up a call ***/

$('a#hangup,.hangup').click(function(event) {
  event.preventDefault();
  // console.info('Will request hangup..');
  call && call.hangup();  
});





var handleFail = function (error){
 console.log(error);
}




