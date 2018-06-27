<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('login_id')){
			$this->session->set_flashdata('msg','Please login to continue !');
			redirect('login');
		}
		$this->load->model('settings_model','settings');
		$this->load->model('employees_model','employees');
		// Load Pagination library
		$this->load->library('pagination');
	}


	public function loadRecord($rowno=0){

    // Row per page
		$rowperpage = 5;

    // Row position
		if($rowno != 0){
			$rowno = ($rowno-1) * $rowperpage;
		}
		
    // All records count
		$allcount = $this->employees->getrecordCount();

    // Get records
		$users_record = $this->employees->getData($rowno,$rowperpage);
		
    // Pagination Configuration
		$config['base_url'] = base_url().'employees/loadRecord';
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;

    // Initialize
		$this->pagination->initialize($config);

    // Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $users_record;
		$data['row'] = $rowno;

		echo json_encode($data);
		
	}

	public function index()
	{					
		$data['title'] = 'Employees';
		$data['department'] = $this->settings->get_departments();
		render_page('employees',$data);
	}
	public function  insert_employees(){
		$this->validate();
		if(!empty($_POST['joining_date'])){
			$joining_date = str_replace('/','-',$_POST['joining_date']);
			$joining_date = date('Y-m-d',strtotime($joining_date));
		}else{
			$joining_date = '0000-00-00';
		}
		$data = array(
			'first_name' => $_POST['first_name'],
			'last_name' => $_POST['last_name'],
			'user_name' => $_POST['user_name'],
			'email' => $_POST['email'],
			'password' => md5($_POST['password']),
			'decrypted' => $_POST['password'],
			'employee_id' => $_POST['employee_id'],
			'joining_date' => $joining_date,
			'phone_number' => $_POST['phone_number'],
			'company' => $_POST['company'],
			'department_id' => $_POST['department_id'],
			'designation_id' => $_POST['designation_id']
		);		
		if(empty($_POST['login_id'])){
			$result = $this->employees->insert_employees($data);
		}else{
			$result = $this->employees->update_employees($data);
		}
		
		echo json($result);

	}
	public function validate(){
		$response =  array();
		$where = array('email'=>$_POST['email']);
		if(!empty($_POST['login_id'])){
			$where +=array('login_id !=',$_POST['login_id']);
		}
		$count_email = $this->db->get_where('login_details',$where)->num_rows();
		if($count_email == 0){
			$where = array('user_name'=>$_POST['user_name']);
			if(!empty($_POST['login_id'])){
				$where +=array('login_id !=',$_POST['login_id']);
			}
			$count_username = $this->db->get_where('login_details',$where)->num_rows();
			if($count_username != 0){
				$response = array('error' => 'Username already taken!');
				echo json($response);
				exit;
			}			
		}else{
			$response = array('error' => 'Email already registered!');
			echo json($response);
			exit;
		}	
	}
	public function check_exist_email(){
		$result = $this->employees->check_exist_email();
		echo json(array('exist'=>$result));
	}


	public function get_all_employees(){
		$list = $this->employees->get_all_employees();
		foreach ($list as $g) {
			$row = array(); 
			$row[] = $g->first_name.' '.$g->last_name;
			$row[] = $g->employee_id;
			$row[] = $g->email;
			$row[] = $g->phone_number;
			$row[] = $g->joining_date;			
			$row[] = $g->company;
			$row[] = '<div class="dropdown">
			<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
			<ul class="dropdown-menu pull-right">
			<li><a href="#"  data-toggle="modal" data-target="#add_department" title="Edit" onclick="show_modal('.$g->login_id.')"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
			<li><a href="#"   data-toggle="modal" data-target="#delete_department"  title="Delete" onclick="show_delete_modal('.$g->login_id.')"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
			</ul>
			</div>';  
			$data[] = $row;
		}
		$output = array(
		//	"draw" => $_POST['draw'],
			"recordsTotal" => $this->employees->count_all(),
			"recordsFiltered" => $this->employees->count_filtered(),
			"data" => $data,
		);
                //output to json format
		echo '<pre>';
		print_r($output);
		//echo json($output);

	}


}

/* End of file Employees.php */
/* Location: ./application/controllers/Employees.php */
