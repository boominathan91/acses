var token;
var subscribers = {};

  

function get_call_notification(){
  $.get(base_url+'chat/get_call_notification',function(res){
    var obj = jQuery.parseJSON(res);
    var data = obj.data;
    if(obj.status == true){

      if(data.profile_img!=''){
        var caller_img = base_url+'uploads/'+data.profile_img;    
      }else{
        var caller_img = base_url+'assets/img/user.jpg';  
      } 

      $('audio#ringtone').prop("currentTime", 0);
      $('audio#ringtone').trigger("play");
      $('.caller_image').attr('src',caller_img);
      $('.caller_name').text(data.first_name+' '+data.last_name);
      $('.caller_login_id').val(data.login_id);      
      $('#call_from_id').val(data.login_id);      
      $('#call_to_id').val(data.call_to_id);
      $('.caller_sinchusername').val(data.sinch_username);      
      $('.caller_full_name').val(data.first_name+' '+data.last_name);      
      $('.caller_profile_img').val(caller_img);      
      $('#call_type').val(data.call_type);    
      $('#group_id').val(data.group_id);    
      $('#incoming_call').modal('show');        

    }else{
      $('audio#ringback').trigger("pause");
      $('audio#ringtone').trigger("pause");
      $('#incoming_call').modal('hide');

    }

  });
} 


var notify = setInterval(get_call_notification, 2000);

function handleError(error) {
  if (error) {
    console.error(error);
  }
}


function initializeSession() {

  $.post(base_url+'chat/get_chat_token',function(res){
    // console.log(res);
  var obj = jQuery.parseJSON(res);
  if(obj.error){
    updateNotification('',obj.error,'error');
    $('.vcend').addClass('hidden');
    return false;
  }


  /* New Outgoing  Call Initiated */
  var apiKey = obj.apiKey;    
  var sessionId = obj.sessionId;   
  var token = obj.token;
  var group_id = obj.dummy_group_id;
  $('#group_id').val(obj.dummy_group_id);

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
    $('#outgoing_caller_image').addClass('hidden');
    $('.vcend').removeClass('hidden');
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
    // console.log(subscribers);
  });


  session.on('sessionDisconnected', function sessionDisconnected(event) {
    console.log('You were disconnected from the session.', event.reason);
  });


  $('.vcend').click(function(event) {
  event.preventDefault();  
    session.unpublish(publisher);
  // $('#incoming_call').modal('hide');  
  // $(this).addClass('hidden');
  var group_id  = $('#group_id').val();
  $.post(base_url+'chat/discard_notify',{group_id:group_id},function(res){
    $('#group_id').val('');
    // window.location.reload();
   
  })
});



  return false;




  
});
}

