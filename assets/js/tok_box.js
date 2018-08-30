var token;
var subscribers = {};

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
    height: '100%'
    };
    var publisher = OT.initPublisher('outgoing', publisherOptions, handleError);
    $('#outgoing_caller_image,.audio_call_icon,.enable_video').addClass('hidden');
    $('.vcend').removeClass('hidden');
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

//   var connectionCount = 0;
//   session.on("connectionCreated", function(event) {
//    connectionCount++;
//    displayConnectionCount();
// });
// session.on("connectionDestroyed", function(event) {
//    connectionCount--;
//    displayConnectionCount();
// });


function displayConnectionCount() {
    document.getElementById("connectionCountField").value = connectionCount.toString();
    // if(connectionCount == 1){
    //   session.disconnect();
    // }
}


  session.on('sessionDisconnected', function sessionDisconnected(event) {
    console.log('You were disconnected from the session.', event.reason);
  });


  $('.vcend').click(function(event) {
  event.preventDefault();  
   session.disconnect();
  // $('#incoming_call').modal('hide');  
  $(this).addClass('hidden');
  var group_id  = $('#group_id').val();
  $.post(base_url+'chat/discard_notify',{group_id:group_id},function(res){
    $('#group_id').val('');
    window.location.reload();
   
  })
});



  return false;




  
});
}

