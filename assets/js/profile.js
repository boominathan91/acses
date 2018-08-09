$('#profile_img').change(function(){
	console.log('works');
});

$("#profile_img").on("change", function() {
    var file_data = $(this).prop("files")[0];   
    var form_data = new FormData();
    form_data.append("file", file_data);
    console.log(form_data);    
    $.ajax({
        url: base_url+"profile/upload_profile_img",
        dataType: 'script',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        beforeSend:function(){
        	$('.text_profile').text('Uploading..');
        },
        success: function(res){
        	$('.text_profile').text('Edit');
        	var obj = jQuery.parseJSON(res);
            $('#profile_image,.profile_img').attr('src',base_url+'uploads/'+obj.profile_img);
        }
    });
});

