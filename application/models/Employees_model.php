<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees_model extends CI_Model {

	public function insert_employees($data){
		return insert('login_details',$data);
	}
	public function update_employees($data){
		$where = array('login_id' => $_POST['login_id']);
		$this->db->update('login_details',$data,$where);
		return $where;
	}
	public function check_exist_email(){
			$where = array('status' => 1 ,'email' => $_POST['email']);
		if(!empty($_POST['login_id'])){
			$where +=array('login_id !=',$_POST['login_id']);
		}
		return $this->db->get_where('login_details',$where)->num_rows();
	}

	 // Fetch records
  public function getData($rowno,$rowperpage) {     
    return $this->db
    ->select('first_name,last_name,employee_id,email,phone_number,joining_date,company,login_id')
    ->limit($rowperpage, $rowno)
    ->order_by('login_id','desc')
    ->get_where('login_details',array('status'=>1))
    ->result_array(); 
  }

  // Select total records
  public function getrecordCount() {
    $this->db->select('count(*) as allcount');
    $this->db->from('login_details');
    $query = $this->db->get();
    $result = $query->result_array(); 
    return $result[0]['allcount'];
  }


	private function _get_datatables_query()
	{
		$columns = array(
					'first_name',
					'last_name',
					'user_name',
					'email',
					'employee_id',
					'joining_date',
					'phone_number',
					'company'
					);
		$search_value = (!empty($_POST['search']['value']))?trim($_POST['search']['value']):'';
		$login_id = $this->session->userdata('login_id');
		$sql ="SELECT * FROM login_details  WHERE login_id !=  $login_id ";
		if(!empty($search_value)){ 
			$sql .=" AND ( 
				first_name LIKE '%$search_value%',
				last_name LIKE '%$search_value%',
				user_name LIKE '%$search_value%',
				email LIKE '%$search_value%',
				employee_id LIKE '%$search_value%',
				joining_date LIKE '%$search_value%',
				phone_number LIKE '%$search_value%',
				company LIKE '%$search_value%'
			) ";		
		} 				
		$sql .=" ORDER BY login_id DESC";
		return $sql;
	}
	public function get_all_employees()
	{
		$sql = $this->_get_datatables_query();			
		// if($_POST['length'] != -1)
		// 	$limits = $_POST['start'].','.$_POST['length'];
		// $sql .=" LIMIT $limits"; 		
		$sql .=" LIMIT 10"; 		
		return $this->db->query($sql)->result();	
	}	
	public function count_filtered()
	{
		$sql = $this->_get_datatables_query();	
		return $this->db->query($sql)->num_rows();		
	}
	public function count_all()
	{
		$sql = $this->_get_datatables_query();			
		return $this->db->query($sql)->num_rows();
	}

}

/* End of file Employees_model.php */
/* Location: ./application/models/Employees_model.php */