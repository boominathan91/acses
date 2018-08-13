var global_username = '';
/*Intialize the sinch */
var sinchClient = new SinchClient({
	applicationKey: 'f06ae4f2-4980-40aa-89ca-9b98d80d70c4',
	capabilities: {messaging: true,calling: true,video: true, multiCall: true},
	supportActiveConnection: true,
  startActiveConnection: true,
  onLogMessage: function(message) {
    console.log(message.message);   
    if(message.message == 'Was disconnected!'){
      window.location.href=base_url+"login";
    } 
    if(message.message == 'Call DENIED Received' || message.message == 'Call HANGUP Received' || message.message == 'Call CANCEL Received' ){
          $('.loading').hide();
      $('.video_call_status').html('Call Rejected!');
      setTimeout(function() {
        $('.video_call_status').html('');
      }, 2000);
    }
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

  $('.loading').show();	
  updateNotification('', 'Please wait  redirecting...', 'success');
  var credential = {};
  credential.username = data.sinch_username;
  credential.password = data.sinch_username;		
  var sessionObj = JSON.parse(localStorage[sessionName] || '{}');	
  global_username = sessionObj.userId;	
  sinchClient.start(credential).then(function() {
    localStorage[sessionName] = JSON.stringify(sinchClient.getSession());

    $('.loading').hide();
    window.location.href=base_url+"chat";			
  }).fail(function(error){			
    console.log(error);
    return false;					
  });
}




var sessionObj = JSON.parse(localStorage[sessionName] || '{}');
if(sessionObj.userId) { 
  $('.loading').show();
  sinchClient.start(sessionObj)
  .then(function() {
    $('.loading').hide();
    localStorage[sessionName] = JSON.stringify(sinchClient.getSession());

    // var groupCall = callClient.callGroup("general");
    // groupCall.addEventListener({
    //     onGroupRemoteCallAdded: function(call) { // Called when a remote participant stream is ready
    //         $("#incoming_group_video").append("<video autoplay class="+ call.toId +" class='img-responsive' src='" + call.incomingStreamURL + "'muted></video>");
    //     },
    //     onGroupLocalMediaAdded: function(stream) { // Called when the local media stream is ready (optional)
    //         $('video#outgoing').attr('src', window.URL.createObjectURL(stream));
    //     },
    //     onGroupRemoteCallRemoved: function(call) { // Called when a remote participant has left and the stream needs to be removed from the HTML element
    //       console.log('--------------------remove call--------------');
    //         $('video#incoming').attr('src', (remoteCalls[index] || {}).incomingStreamURL || '');
    //     },
    // });
  })
  .fail(function() {
    $('.loading').hide();

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

  console.log(message);

       var receiver_sinchusername = $('#receiver_sinchusername').val();  // receiver username     
	     var sender_sinchusername = $('#sender_sinchusername').val();  // sender username     
        var receiver_img = $('#receiver_image').val();     // receiver image 
        var message_type = $('#type').val();     // message type 

        if(message.direction==false){
          if(message.textBody == 'ENABLE_STREAM'){
            $('#incoming_caller_image').addClass('hidden');
            $('#incoming').removeClass('hidden');
            return false;
          }else if(message.textBody == 'DISABLE_STREAM'){
            $('#incoming_caller_image').removeClass('hidden');
            $('#incoming').addClass('hidden');
            return false;
          }
          /*Notify members for creating new group */
          if(message.textBody == 'NEW_GROUP_ADDED' && sender_sinchusername != message.senderId){
            $.post(base_url+'chat/get_notification',{created_by:message.senderId},function(res){      
              if(res){
               var result = jQuery.parseJSON(res);
               updateNotification('Group :'+result.group_name,'New '+result.group_type+' group created by '+result.first_name+' '+result.last_name+'!','success');
             }
            // return false;
          });      
          }


          


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
                  '<li><i class="fa fa-file"></i><a href="'+file_name+'" target="_blank">'+up_file_name+'</a></li>'+
                  '</ul>'+
                  '<span class="chat-time">'+time+'</span>'+
                  '</div>'+                  
                  '</div>'+
                  '</div>'+
                  '</div>'+
                  '</div>';
                }else{ /* Text message */

                 var content = '<div class="chat chat-left">'+
                 '<div class="chat-avatar">'+
                 '<a href="#" class="avatar">'+
                 '<img alt="'+receiver_name+'" title="'+receiver_name+'" src="'+receiver_img+'" class="img-responsive img-circle">'+
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
               $('.ajax').append(content);
             }else{ /*Hidden group and receiving msg group are different*/


              $('#'+obj.msg_data.new_group_name).remove();         
              var data = '<li  id="'+obj.msg_data.new_group_name+'" onclick="set_nav_bar_group_user('+obj.msg_data.group_id+',this)">'+
              '<a href="#">#'+obj.msg_data.group_name+ '<span class="badge bg-danger pull-right"  id="'+obj.msg_data.new_group_name+'danger">'+obj.count+'</span></a>'+
              '</li>';
              $('#new_group_user').prepend(data);
              updateNotification('Message From the Group : '+obj.msg_data.new_group_name+' ',message.textBody,'success');

            }




    }else{ // One to One text chat with receiver name same in hidden box 




      if(msg == 'file' && type == 'image'){

        var content ='<div class="chat chat-left">'+
        '<div class="chat-avatar">'+
        '<a href="#" class="avatar">'+
        '<img alt="'+receiver_name+'" title="'+receiver_name+'" src="'+receiver_img+'" class="img-responsive img-circle">'+
        '</a>'+
        '</div>'+
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

        var content ='<div class="chat chat-left">'+
        '<div class="chat-avatar">'+
        '<a href="#" class="avatar">'+
        '<img alt="'+receiver_name+'" title="'+receiver_name+'" src="'+receiver_img+'" class="img-responsive img-circle">'+
        '</a>'+
        '</div>'+
        '<div class="chat-body">'+
        '<div class="chat-bubble">'+
        '<div class="chat-content "><ul class="attach-list">'+
        '<li><i class="fa fa-file"></i><a href="'+file_name+'" target="_blank">'+up_file_name+'</a></li>'+
        '</ul>'+
        '<span class="chat-time">'+time+'</span>'+
        '</div>'+                  
        '</div>'+
        '</div>'+
        '</div>'+
        '</div>';
      }else{

       var content = '<div class="chat chat-left">'+
       '<div class="chat-avatar">'+
       '<a href="#" class="avatar">'+
       '<img alt="'+receiver_name+'" title="'+receiver_name+'" src="'+receiver_img+'" class="img-responsive img-circle">'+
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
     $('.ajax').append(content);



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

      $('#user_list').attr('data-type','text_chat');
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
          '<li><i class="fa fa-file"></i><a href="'+file_name+'" target="_blank">'+up_file_name+'</a></li>'+
          '</ul>'+
          '<span class="chat-time">'+time+'</span>'+
          '</div>'+                  
          '</div>'+
          '</div>'+
          '</div>'+
          '</div>';
        }else{
          var receiver_img = datas.profile_img;
          var content = '<div class="chat chat-left">'+
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
        $('.ajax').append(content);

      }else{ // Different group 

       if(datas.message){

        $(datas.message).each(function(){
          $('#'+this.new_group_name).remove();         

          // TEXT NEW GROUP 
          if(this.type == 'text'){

           var data = '<li  id="'+this.new_group_name+'" onclick="set_nav_bar_group_user('+this.group_id+',this)" type="group_text_chat">'+
           '<a href="javascript:void(0)">#'+this.group_name+ '<span class="badge bg-danger pull-right" id="'+this.new_group_name+'danger">'+datas.count+'</span></a>'+
           '</li>';
           $('#new_group_user').prepend(data);  
         }else if(this.type == 'audio'){ /*New Audio Group */

           var data = '<li  id="'+this.new_group_name+'" onclick="set_nav_bar_group_user('+this.group_id+',this)" type="group_audio">'+
           '<a href="javascript:void(0)">#'+this.group_name+ '<span class="badge bg-danger pull-right" id="'+this.new_group_name+'danger">'+datas.count+'</span></a>'+
           '</li>';
           $('#session_group_audio').prepend(data);  

            }else if(this.type == 'video'){ // New Video Group 

             var data = '<li  id="'+this.new_group_name+'" onclick="set_nav_bar_group_user('+this.group_id+',this)" type="group_video">'+
             '<a href="javascript:void(0)">#'+this.group_name+ '<span class="badge bg-danger pull-right" id="'+this.new_group_name+'danger">'+datas.count+'</span></a>'+
             '</li>';
             $('#session_group_video').prepend(data);  
            }else if(this.type == 'screenshare'){ // New Screenshare group 

             var data = '<li  id="'+this.new_group_name+'" onclick="set_nav_bar_group_user('+this.group_id+',this)" type="screen_share_group">'+
             '<a href="javascript:void(0)">#'+this.group_name+ '<span class="badge bg-danger pull-right" id="'+this.new_group_name+'danger">'+datas.count+'</span></a>'+
             '</li>';
             $('#new_screen_user').prepend(data);  
           }


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
    '<a href="#"><span class="status '+online_status+'"></span>'+receiver_name+ '<span class="badge bg-danger pull-right" id="'+datas.sinch_username+'danger">'+count+'</span></a>'+
    '</li>';       
    $('#new_message_user').prepend(content);
    updateNotification(receiver_name+':',message.textBody,'success');

  }


});


}


}
$(".msg-list-scroll").slimscroll({ scrollBy: '400px' });
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
  var video_timer = document.getElementById('video_timer'),seconds = 0, minutes = 0, hours = 0,t;
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
    
    // h1.textContent = (hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds);
    video_timer.textContent = (hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds);
    $('#call_duration').val((hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds));

    timer();
  }

 // group_audio_members_status = setInterval(get_group_audio_member_status, 5000);

 function get_group_audio_member_status() {
  if( $("#for_group_audio").is(":visible") && $("#group_id").val() ) {
    $.post(base_url+'chat/get_group_members_status',{ group_id : $("#group_id").val() },function(res) {
      if(res) {
        var obj=jQuery.parseJSON(res);

        jQuery.each(obj, function(key, value) {
          if( value.is_active == "0") {
            $("#" + value.members_id).addClass('grayscale');
          }
          else {
            $("#" + value.members_id).removeClass('grayscale'); 
          }
        });
      }
    });       
  }
}

function timer() {
  t = setTimeout(add, 1000);
}

/* Clear button */
var clear = function() {
  $('#call_duration').val('00:00:00');
  seconds = 0; minutes = 0; hours = 0;
}

/*** Define listener for managing calls ***/

var callListeners = {
  onCallProgressing: function(call) {
    // console.log('progressing');

    var call_type = $('#call_type').val();
    if(call_type == 'video'){        
      $('audio#ringback').prop("currentTime", 0);
      $('audio#ringback').trigger("play");    
      $('.video_call_status').html('Ringing...');   
    }
  },
  onCallEstablished: function(call) {

      $('#call_duration').val('00:00:00');
      $('.vccontainer').removeClass('hidden');
      $('.profile,.group_vccontainer').addClass('hidden');
      $('.text_chat').removeClass('hidden');
        $('#text_chat').addClass('active');      
      $('#'+call.fromId).click();
       // console.log(call);
      // console.log(call.getDetails());
      $('.video_call_status').html('');
      $('.loading').hide();

      var call_type = $('#call_type').val();
      if(call_type == 'video'){
        //call.outgoingStream.getVideoTracks()[0].enabled = true;
        $('.video_call_status').html('');  
        $('video#outgoing').attr('src', call.outgoingStreamURL);
        $('video#incoming').attr('src', call.incomingStreamURL);
        $('#incoming_caller_image,#outgoing_caller_image').addClass('hidden');
        $('#outgoing,#incoming,.vcmike,.vcend,.vccam,.vc_receiver_name').removeClass('hidden');
        $('.outgoing_image,.incoming_image').hide();
        $('.camera').css('color','#55ce63');        
      }else{
       // call.outgoingStream.getVideoTracks()[0].enabled = false;
        $('.video_call_status').html('');          
         $('video#outgoing').attr('src', call.outgoingStreamURL);
        $('video#incoming').attr('src', call.incomingStreamURL);      
        $('.vcmike,.vcend,.vccam,.vc_receiver_name').removeClass('hidden');        
        $('.phone').css('color','#55ce63');  
        $('.vccam').addClass('active');
      }         

      /*Mute the mike */
      $('a.vcmike').click(function(){        
        if($(this).hasClass('active')){
          $(this).removeClass('active')
          call.unmute();          
          
        }else{
          $(this).addClass('active')
          call.mute();          
        }
      }); 

      /*Mute the camera */
      $('a.vccam').click(function(){
        if($(this).hasClass('active')){
          $(this).removeClass('active');          
          call.outgoingStream.getVideoTracks()[0].enabled = true;          
          $('#outgoing_caller_image').addClass('hidden');        
          $('#outgoing').removeClass('hidden');
          message('ENABLE_STREAM');
          
        }else{
          $(this).addClass('active');          
          call.outgoingStream.getVideoTracks()[0].enabled = false;
          $('#outgoing_caller_image').removeClass('hidden');
          $('#outgoing').addClass('hidden');            
          message('DISABLE_STREAM');
        }
      });
      $('audio#ringback').trigger("pause");
      $('audio#ringtone').trigger("pause");    
      $('.start-call').addClass('hidden');
      //Report call stats
      var callDetails = call.getDetails();
      timer();    
      $('#call_started_at').val(callDetails.establishedTime);


      $.post(base_url+'chat/set_call_status',{call_status:1},function(res){
            //console.log(res);
          }); 

    },
    onCallEnded: function(call) {
      $('.vcmike,.vccam').removeClass('active');  
      $('.camera,.phone').css('color','#667eea'); 
      $('#incoming_call').modal('hide');             
      var call_type = $('#call_type').val();      
      $('#incoming_caller_image,#outgoing_caller_image').removeClass('hidden');
      $('#outgoing,#incoming,.hangup,.vc_receiver_name').addClass('hidden');  
      $('.vcmike,.vccam').removeClass('active');  

      $('audio#ringback').trigger("pause");
      $('audio#ringtone').trigger("pause");      
      $('video#outgoing').attr('src', '');
      $('video#incoming').attr('src', '');
      //Report call stats
      var callDetails = call.getDetails();    
      $('#call_ended_at').val(callDetails.endedTime);    
      $('#end_cause').val(call.getEndCause());

      if(call.getEndCause() == 'CANCELED'){
        $('span.call-timing-count').html('Call Canceled.');    
      }else if(call.getEndCause() == 'HUNG_UP'){
        $('span.call-timing-count').html('Call Ended.'); 
      }
      $('.start-call').removeClass('hidden').show(); 
      
      $('.vcend,.vcmike,.vccam,#audio-footer,#video-footer').addClass('hidden');   
      update_call_details();
      clear();
      clearTimeout(t);
      setTimeout(function() {        
        clear();
        $('#timer').html('');
        $('.video_call_status').html(''); 
      }, 2000);
      if(call.error) {
        $('span.call-timing-count').append('<div id="stats">Failure message: '+call.error.message+'</div>');
      }
    }
  }


  /*** Set up callClient and define how to handle incoming calls ***/

  var callClient = sinchClient.getCallClient();
  var call;
  var groupCall;
  callClient.addEventListener({

  onIncomingCall: function(incomingCall) {
    

    // group_vccontainer to be hide here 
     // if(incomingCall.callState == 3){
     //   return false;
     // }

    console.log(incomingCall.callState);
    console.log(incomingCall);
    console.log('-----------------------incomingCall----------------------------');
  //Play some groovy tunes 


  //Print statistics
  $('small text-muted').append('<div id="title">Incoming call from ' + incomingCall.fromId + '</div>');  
  $.post(base_url+'chat/get_caller_details',{sinch_username:incomingCall.fromId },function(res){

    var obj=jQuery.parseJSON(res);
      if(obj.type == 'audio' || obj.type == 'video'){

        $('audio#ringtone').prop("currentTime", 0);
    $('audio#ringtone').trigger("play");
    $('.caller_image').attr('src',obj.profile_img);
    $('.caller_name').text(obj.name);
    $('#call_from_id').val(obj.call_from_id);      
    $('#call_to_id').val(obj.call_to_id);
    $('.caller_sinchusername').val(obj.sinch_username);      
    $('.caller_full_name').val(obj.name);      
    $('.caller_profile_img').val(obj.profile_img);      
    $('#call_type').val(obj.type);    
    $('#incoming_call').modal('show');
  //Manage the call object
  call = incomingCall;
  call.addEventListener(callListeners);
      }
    
  
});


}


});

$('.mute_icon').click(function(){

  event.preventDefault();
  // console.info('Will request hangup..');
  var communicating_obj;


  var type = $('#call_type').val();
  switch(type){
    case 'video':      
    if(call){
      communicating_obj = call;
      if($(this).hasClass('active')){
        $(this).removeClass('active');
        communicating_obj.unmute();
      }else{
        $(this).addClass('active');
        communicating_obj.mute();
      }
    }
    break;
    case 'audio':  
    if(call){
      communicating_obj = call;
      if($(this).hasClass('active')){
        $(this).removeClass('active');
        communicating_obj.unmute();
      }else{
        $(this).addClass('active');
        communicating_obj.mute();
      }
    }
    break;
    case 'group_video':
    if(group_video_members[callId]){
      communicating_obj = group_video_members[callId];
      if($(this).hasClass('active')){
        $(this).removeClass('active');
        communicating_obj.unmute();
      }else{
        $(this).addClass('active');
        communicating_obj.mute();
      }
    } 
    break;
    case 'group_audio':
    if(group_audio_members[audioCallId]){
      communicating_obj = group_audio_members[audioCallId];
      if($(this).hasClass('active')){
        $(this).removeClass('active');
        communicating_obj.unmute();
      }else{
        $(this).addClass('active');
        communicating_obj.mute();
      }
    } 
    break;
  }

  console.log(communicating_obj);
  
});



$('a#answer').click(function(event) {
  event.preventDefault();
  try {    
    call.answer();    
    var caller_login_id = $('.caller_login_id').val();
    var caller_sinchusername = $('.caller_sinchusername').val();
    var caller_full_name = $('.caller_full_name').val();
    var caller_profile_img = $('.caller_profile_img').val();
    $('.to_name').text(caller_full_name);
    $('.receiver_title_image').attr('src',caller_profile_img);
    $('#'+caller_sinchusername).click();
    $('audio#ringback').trigger("pause");
    $('audio#ringtone').trigger("pause");
    $('#incoming_call').modal('hide');
    $('.loading').show();
  }
  catch(error) {
    handleFail(error);
  }
  
});



var group_video_members = {};
var group_audio_members = {};
var callId;
var audioCallId;
var my_stream_url;


/*** Make a new data call ***/

$('.start-call').click(function(event) {
  event.preventDefault();    
  var type = $('.start-call').attr('type');
  $('#call_type').val(type);
  var sinch_username = $('input#receiver_sinchusername').val();
  var video_type = $('#video_type').val();
  if(video_type == 'one'){ /*One to One */

    $.post(base_url+'chat/get_call_status',{sinch_username:sinch_username,type:type},function(res){
    if(res!='[]'){
      var obj = jQuery.parseJSON(res);
      updateNotification('',obj.name,'error');
      return false;
    }else{            
      var call_status = 'calling..';
      call = callClient.callUser(sinch_username); 
      $('.start-call').addClass('hidden');
      $('.vcend').removeClass('hidden');
      $('.video_call_status').html('Calling...');
      call.addEventListener(callListeners);  
      $('.start-call').hide();
    }
  });

  }else{ /*Group Call*/




        call_status = 'Joining in a group..';
   var  groupName = $('.to_group_video').text();
   // console.log(groupName);
    groupName = groupName.replace(" ","_");
    var groupCall = callClient.callGroup( groupName );

       // console.log(groupCall);
      groupCall.addEventListener({
      onGroupLocalMediaAdded: function(stream) { // Called when the local media stream is ready (optional)
        console.log('------------------My stream----------------------'); 

        $('.start-call').addClass('hidden');
        $('.vcend').removeClass('hidden');
        $('.vccam').removeClass('hidden');
        $('.vcmike').removeClass('hidden');
        $('#group_outgoing_caller_image').addClass('hidden');        
         var my_stream_url = window.URL.createObjectURL(stream);
        $('#group_outgoing').attr('src',my_stream_url);
        $('#group_outgoing').removeClass('hidden');    
        console.log(stream);       
        call_status = 'Joined in a group';
        $('.video_call_status').html(call_status);

        /*Muting options */

        $('#group_audio_mute').click(function(){         
          if($(this).hasClass('active')){
            $(this).removeClass('active');                
            stream.getAudioTracks()[0].enabled = true; 
          }else{
            $(this).addClass('active');        
            stream.getAudioTracks()[0].enabled = false;             
          }
        //console.log(stream);
      });    

  $('#group_video_mute').click(function(){         
          if($(this).hasClass('active')){
            $(this).removeClass('active');                
            stream.getVideoTracks()[0].enabled = true; 
            $('#group_outgoing').addClass('hidden');
            $('#group_outgoing_caller_image').removeClass('hidden');
            message('ENABLE_STREAM');
          }else{
            $(this).addClass('active');        
            stream.getVideoTracks()[0].enabled = false; 
            $('#group_outgoing').removeClass('hidden');
            $('#group_outgoing_caller_image').addClass('hidden');
            message('DISABLE_STREAM');
          }
        //console.log(stream);
      });      



        $.post(base_url+'chat/set_call_status',{call_status:1,type:'group_video'},function(res){
            //console.log(res);
          }); 


     




      },
    onGroupRemoteCallAdded: function(call) { // Called when a remote participant stream is ready
      console.log('------------------remote stream----------------------');
      console.log(call);  
      console.log(call.outgoingStream.getVideoTracks());  



      callId = call.callId;
      group_video_members[call.callId] = call;
      
        $.post(base_url+'chat/get_username',{sinch_username:call.toId},function(res){
          var obj = jQuery.parseJSON(res);
          call_status = obj.first_name +' '+obj.last_name+ ' joined in a group';       
        });
        if(call.toId === global_username){          
          call_status = 'You have joined in a group';
        }        
        $('.video_call_status').html(call_status);    

       // console.log(call);
        if(currentSinchUserName == call.fromId){
          var Id = call.toId;
        }else{
          var Id = call.fromId;
        }
       // console.log(Id);
        $('#image_'+Id).addClass('hidden');
        $('video#video_'+Id).attr('src',call.incomingStreamURL);
        $('video#video_'+Id).removeClass('hidden');


        $('video#video_'+Id).click(function(){
          var video_url = $(this).attr('src');
          if($('#inner_image').hasClass('hidden')){
            $('#inner_image').removeClass('hidden');
            $('#inner_video').attr('src','');
            $('#inner_video').addClass('hidden');
          }else{
            $('#inner_image').addClass('hidden');
            $('#inner_video').attr('src',video_url);
            $('#inner_video').removeClass('hidden');
          }

        });
      
        call.addEventListener({
            onGroupRemoteCallRemoved: function(call) { // Called when a remote participant has left and the stream needs to be removed from the HTML element
              $('video#other').attr('src', (remoteCalls[index] || {}).incomingStreamURL || '');
              console.log('---------------------Remove Call------------------------');
              console.log(call);

              if(currentSinchUserName == call.fromId){
                var Id = call.toId;
                }else{
                var Id = call.fromId;
                }
                // console.log(Id);
                $('#image_'+Id).removeClass('hidden');
                $('video#video_'+Id).attr('src','');
                $('video#video_'+Id).addClass('hidden');




            },
            onCallEnded: function(call) {
              console.log('---------------------Call Hangup-----------------');
              console.log(call);

                if(currentSinchUserName == call.fromId){
                var Id = call.toId;
                }else{
                var Id = call.fromId;
                }
                // console.log(Id);
                $('#image_'+Id).removeClass('hidden');
                $('video#video_'+Id).attr('src','');
                $('video#video_'+Id).addClass('hidden');


              delete group_video_members[call.callId];             

             }
           });



      }
    });



  } 
  


  return false;

  






});

/*** Hang up a call ***/

$('.vcend,#hangup').click(function(event) {
  event.preventDefault();
  var communicating_obj;

  var type = $('#call_type').val();
  var call_status = 'calling..';
  $('.vccall').removeClass('hidden').show();
  $('.vcend,.vcmike,.vccam').addClass('hidden');
   communicating_obj = call;
    communicating_obj && communicating_obj.hangup(); 
  // switch(type){
  //   case 'video':      
  //   communicating_obj = call;
  //   communicating_obj && communicating_obj.hangup();   
  //   break; 
  //   case 'audio':      
  //   communicating_obj = call;
  //   communicating_obj && communicating_obj.hangup();       
  //   break;   
  //   case 'group_video':
  //   group_video_members[callId] && group_video_members[callId].hangup();
  //   $('#for_video').hide();
  //   $('#for_audio').hide();
  //   $('#for_group_audio').hide();
  //   $('#for_group_video').show();
  //   location.reload();
  //   break;   
  // }



});





var handleFail = function (error){
 console.log(error);
}




