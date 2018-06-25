function show_modal(id){
	$('#department_form')[0].reset();
	$('#department_id').val('');
	if(id == 0){
		$('.modal-title').text('Add Department');
		
	}else if(id != ''){
		$('#department_id').val(id);
		$('.modal-title').text('Edit Department');
		$.post(base_url+'settings/get_department_settings_by_id',{department_id:id},function(res){
			$('#department_name').val(res);
		});
	}
}
function show_delete_modal(id){
	$('#department_form')[0].reset();
	$('#department_hidden_id').val('');
	$('#department_hidden_id').val(id);	
}

function delete_department(){
	var department_id = 	$('#department_hidden_id').val();
	$.post(base_url+'settings/delete_department',{department_id:department_id},function(res){
		$('#delete_department').modal('hide');
		updateNotification('Success   !', 'Department settings deleted !', 'success');	
		reload_table();
	});	
}

var  table = $('#department_table').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
        	"url": base_url+"settings/get_all_departments",
        	"type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
        	'className': "text-right",
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable            
        },
        ],

    });

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}



$('#department_form').submit(function(){
	var department_name = $('#department_name').val();
	if(department_name == ''){
		updateNotification('Warning   !', 'Enter department name!', 'error');
		return false;
	}
	var url = base_url+"settings/insert_department_settings";
	var formData = $('#department_form').serialize(); 
	$.ajax({
		type:'POST',
		url:url,
		data:formData,
		success:function(response){
			
			var obj = jQuery.parseJSON(response);
			if(obj.department_id){
			$('#department_form')[0].reset();
			$('#add_department').modal('hide');
			updateNotification('Success   !', 'Department settings updated !', 'success');	
			reload_table();
			}else if(obj.error){					
				updateNotification('Warning  !', obj.error , 'error');	
			}

		}
	});		
	return false;
});