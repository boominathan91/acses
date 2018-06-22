<?php 

if(!function_exists('get_where')){
	/*  get with where condition */
	function get_where($table_name,$where){
		$CI = &get_instance();
		return $CI->db->get_where($table_name,$where)->result_array();
	}
}
if(!function_exists('get_all')){
	/*  get all */
	function get_all($table_name){
		$CI = &get_instance();
		return $CI->db->get($table_name)->result_array();
	}
}
if(!function_exists('insert')){
	/*  insert */
	function insert($table_name,$data){
		$CI = &get_instance();
		$CI->db->insert($table_name,$data);
		return $CI->db->insert_id();
	}
}

?>