<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(empty($this->session->userdata('login_id')) || $this->session->userdata('type') !='admin'){
			$this->session->set_flashdata('msg','Please login as admin to continue !');
			redirect('login');
		}
		$this->load->model('settings_model','settings');
		$this->load->model('employees_model','employees');
		// Load Pagination library
		$this->load->library('pagination');
	}	

	public function index()
	{				

        $data['title'] = 'Employees';
		$data['department'] = $this->settings->get_departments();
		$data['designations'] = $this->employees->get_designation_names();
        render_page('employees',$data);
	}

	 //generate a username from Full name
	function generate_username($string_name="", $rand_no = 200){
        $username_parts = array_filter(explode(" ", strtolower($string_name))); //explode and lowercase name
        $username_parts = array_slice($username_parts, 0, 2); //return only first two arry part

        $part1 = (!empty($username_parts[0]))?substr($username_parts[0], 0,8):""; //cut first name to 8 letters
        $part2 = (!empty($username_parts[1]))?substr($username_parts[1], 0,5):""; //cut second name to 5 letters
        $part3 = ($rand_no)?rand(0, $rand_no):"";
        
        $username = $part1. str_shuffle($part2). $part3; //str_shuffle to randomly shuffle all characters 
        return $username;
    }


    public function  insert_employees(){
    	$this->validate();
    	if(!empty($_POST['joining_date'])){
    		$joining_date = str_replace('/','-',$_POST['joining_date']);
    		$joining_date = date('Y-m-d',strtotime($joining_date));
    	}else{
    		$joining_date = '0000-00-00';
    	}
    	$password = (!empty($_POST['password']))?md5($_POST['password']):'adminadmin';
    	$name = $_POST['first_name'].' '.$_POST['last_name'];
    	$sinch_username = $this->generate_username($name,10);
    	$data = array(
    		'first_name' => $_POST['first_name'],
    		'last_name' => $_POST['last_name'],
    		'user_name' => $_POST['user_name'],
    		'email' => $_POST['email'],
    		'password' => $password,
    		'decrypted' => $_POST['password'],
    		'employee_id' => $_POST['employee_id'],
    		'joining_date' => $joining_date,
    		'phone_number' => $_POST['phone_number'],
    		'company' => $_POST['company'],
    		'department_id' => $_POST['department_id'],
    		'designation_id' => $_POST['designation_id']    		
    	);		
    	if(empty($_POST['login_id'])){
    		$data += array('sinch_username' => $sinch_username);
    		$this->employees->insert_employees($data);
    		$result = array('sinch_username' => $sinch_username);
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


    public function loadRecord(){

    	$total_page = 1;
    	$inputs  = $this->input->post();
    	$limit   = 5;
    	$inputs['limit']  = $limit;
    	$records = $this->employees->getData(1,$limit);
    	$count   = $this->employees->getData(2,$limit);
    	if($count > $limit){
    		$total_page = ceil($count /$limit);
    	}
    	$array = array();
    	$users_record = array();
    	foreach($records as $u){
    		$datas['first_letter'] = substr($u['first_name'], 0, 1);
    		$datas['first_name'] = $u['first_name'];
    		$datas['last_name'] = $u['last_name'];
    		$datas['employee_id'] = $u['employee_id'];
    		$datas['email'] = $u['email'];
    		$datas['phone_number'] = $u['phone_number'];
    		$datas['joining_date'] = date('d-m-Y',strtotime($u['joining_date']));
    		$datas['company'] = $u['company'];
    		$datas['login_id'] = $u['login_id'];
    		$datas['designation_id'] = $u['designation_id'];
    		$datas['designation_name'] = $u['designation_name'];
    		$datas['department_name'] = $u['department_name'];
    		$datas['department_id'] = $u['department_id'];
    		$datas['drop_down'] = $this->employees->get_department_by_id($u['department_id']);
    		$users_record[] = $datas;
    	}
    	$array['result'] = $users_record;
		// $array['designations'] = $this->employees->get_designation_names();
    	$array['header']=array('employee_name' =>lang_new('employee_name'),
    		'employee_id' =>lang_new('employee_id'),
    		'email' =>lang_new('email'),
    		'phone_number' =>lang_new('phone_number'),
    		'joining_date' =>lang_new('joining_date'),
    		'role' =>lang_new('role'),
    		'action' =>lang_new('action')
    	);
    	$array['current_page'] = $_POST['pageno'];
    	$array['total_page']   = $total_page;
    	echo json($array);

    }
    public function get_employee_by_id(){
    	$data['result'] =  $this->employees->get_employee_by_id();
    	$data['result']['joining_date'] = date('d-m-Y',strtotime($data['result']['joining_date']));
    	$data['designation'] = $this->employees->get_designation_by_id($data['result']['department_id']);
    	echo json($data);
    }

    public function change_role(){
    	$result  = $this->employees->change_role();
    	echo json(array('status'=>$result));
    }
    public function delete_employee(){
    	$result  = $this->employees->delete_employee();
    	echo json(array('status'=>$result));
    }

}

/* End of file Employees.php */
/* Location: ./application/controllers/Employees.php */
