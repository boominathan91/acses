function show_modal(designation_id){
	$('#designation_form')[0].reset();
	$('#department_id').val('');
	$('#designation_id').val('');
	if(designation_id == 0){
		$('.modal-title').text('Add Designation');
		
	}else if(designation_id != ''){
		$('#designation_id').val(designation_id);
		$('.modal-title').text('Edit Designation');
		$.post(base_url+'settings/get_designation_settings_by_id',{designation_id:designation_id},function(res){
			var obj = jQuery.parseJSON(res);
			$('#department_id').val(obj.department_id);
			$('#designation_id').val(obj.designation_id);
			$('#designation_name').val(obj.designation_name);
		});
	}
}
function show_delete_modal(designation_id){
	$('#designation_form')[0].reset();
	$('#designation_hidden_id').val('');
	$('#designation_hidden_id').val(designation_id);	
}

function delete_designation (){
	var designation_id = 	$('#designation_hidden_id').val();
	$.post(base_url+'settings/delete_designation',{designation_id:designation_id},function(res){
		$('#delete_designation').modal('hide');
		updateNotification('Success   !', 'Designation settings deleted !', 'success');	
		reload_table();
	});	
}

var  table = $('#designation_table').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
        	"url": base_url+"settings/get_all_designations",
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



$('#designation_form').submit(function(){
	var department_id = $('#department_id').val();
	var designation_name = $('#designation_name').val();
	if(department_id == ''){
		updateNotification('Warning  !','Select any department', 'error');	
		return false;
	}
	if(designation_name == ''){
		updateNotification('Warning  !','Enter designation name', 'error');	
		return false;
	}	
	var url = base_url+"settings/insert_designation_settings";
	var formData = $('#designation_form').serialize(); 
	$.ajax({
		type:'POST',
		url:url,
		data:formData,
		success:function(response){
			
			var obj = jQuery.parseJSON(response);
			if(obj.designation_id){
				$('#designation_form')[0].reset();
				$('#add_designation').modal('hide');
				updateNotification('Success   !', 'Designation settings updated !', 'success');	
				reload_table();
			}else if(obj.error){					
				updateNotification('Warning  !', obj.error , 'error');	
				return false;
			}

		}
	});		
	return false;
});