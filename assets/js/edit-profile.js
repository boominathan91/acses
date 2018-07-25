$('#country').change(function(){
	$.ajax({
		type: "GET",
		url: base_url+"settings/get_country_states/"+$(this).val(),
		beforeSend :function(){
			$("#state option:gt(0)").remove(); 
			$('#state').find("option:eq(0)").html("Please wait..");
		},                         
		success: function (data) {
			/*get response as json */
			$('#state').find("option:eq(0)").html("Select State");
			var obj=jQuery.parseJSON(data);
			$(obj).each(function()
			{
				var option = $('<option />');
				option.attr('value', this.value).text(this.label);           
				$('#state').append(option);
			});  
		}
	});
});


$('#state').change(function(){
	$.ajax({
		type: "GET",
		url: base_url+"settings/get_state_cities/"+$(this).val(),
		beforeSend :function(){
			$("#city option:gt(0)").remove(); 
			$('#city').find("option:eq(0)").html("Please wait..");
		},                         
		success: function (data) {
			/*get response as json */
			$('#city').find("option:eq(0)").html("Select City");
			var obj=jQuery.parseJSON(data);
			$(obj).each(function()
			{
				var option = $('<option />');
				option.attr('value', this.value).text(this.label);           
				$('#city').append(option);
			});  
		}
	});
});

var date = new Date();
var today = dob;//new Date(date.getFullYear(), date.getMonth(), date.getDate());

$('#dob').datetimepicker({ 
	 format: 'DD-MM-YYYY',
	 maxDate: today
});


function addInstitute(e) {
	var id = $(e).attr('data-row');
	id = parseInt(id)+1;
	var htmldata = $('.institute_html').html();
	htmldata = htmldata.replace(/{#}/g,id);
	$('.institute_additional').append(htmldata);
}

function addExperience(e) {
	var id = $(e).attr('data-row');
	id = parseInt(id)+1;
	var htmldata = $('.experience_html').html();
	htmldata = htmldata.replace(/{#}/g,id);
	$('.experience_additional').append(htmldata);
}

$(document).ready(function(){

	$image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:200,
      height:200,
      type:'square' //circle
    },
    boundary:{
      width:300,
      height:300
    }
  });

  $('#upload_image').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
  });

  $('.crop_image').click(function(event){
  	var url = base_url+'profile_image';
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:url,
        type: "POST",
        data:{"image": response},
        success:function(data)
        {
        	data = JSON.parse(data);
        	var img = data.img;
        	var name = data.name;
          $('#uploadimageModal').modal('hide');
          $('#profile_img').val(name);
          $('#uploaded_image').html(img);

        }
      });
    })
  });

});  