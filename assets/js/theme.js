$('#website_name').keyup(function(){
	var name = $(this).val();
	$('.website_name').text(name);
});

$('#theme_form').submit(function(){
		$.post(base_url+'settings/insert_theme_settings',{'website_name' : $('#website_name').val()},function(res){
			 updateNotification('Success   !', 'Theme settings updated !', 'success');
		});
		return false;
	});


/*Image upload function */
var _URL = window.URL || window.webkitURL;
function upload_image(element){

	var id = $(element).attr('id');
var maxwidth = $(element).attr('maxwidth'); // Width of the element 
var maxheight = $(element).attr('maxheight'); // Height of the element 
var id = $(element).attr('id');
var file = $('#'+id)[0].files[0]; // Id of the element 

img = new Image();
img.src = _URL.createObjectURL(file);
img.onload = function(){
	imgwidth = this.width;
	imgheight = this.height;
	if(imgwidth <= maxwidth && imgheight <= maxheight){
		var formData = new FormData();
		formData.append(id, $('#'+id)[0].files[0]);
		$.ajax({
			url: base_url+'settings/upload_image',
			type: 'POST',
			data: formData,
			cache: false,
			dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function(res, textStatus, jqXHR){
        	$('.'+res.field_name).attr('src','uploads/'+res.file_name);
        	// updateNotification('Success   !', 'Light logo updated !', 'success');
        }        
    });							
	}else{
			 updateNotification('Warning  !', 'Image size shoulbe '+maxwidth+'px x '+maxheight+'px !', 'danger');	
		}
	}
}

/*Image upload function */
