<?php
/*
 * File Name: Care_model.php
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Care_model extends CI_Model {
	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}
	

	function get_care_record_by_petid($pet_id) {
		$this -> db -> where('pet_id', $pet_id);
		$this -> db -> from('care');
		$query = $this -> db -> get();
		return $query -> result();
	}

	function get_care_record_by_timerid($timer_id) {
		$this -> db -> where('timer_id', $timer_id);
		$this -> db -> from('care');
		$query = $this -> db -> get();
		return $query -> result();
	}

	function get_care_record_by_category_petid($category,$pet_id) {
		$query = array("pet_id"=>$pet_id,'category'=>$category);	
		$this -> db -> where($query);
		$this -> db -> from('care');
		$query = $this -> db -> get();
		return $query -> result();
	}

	
	//insert care
	function insert_care($data) {
		$data['id'] = $this -> getNewid();
		//insert the form data into database
		$this -> db -> insert('care', $data);
	}

	function getNewid() {
		$sql = "select max(id) as mid from care";
		$query = $this -> db -> query($sql);
		if($query -> num_rows() > 0){
			$result = $query -> result();
			$maxid = $result[0] -> mid;
			return $maxid + 1;	
		}else{
			return 1;	
		}		
		
	}
	//update care
	function update_care($timer_id,$data) {
		$this -> db -> where('timer_id', $timer_id);
		$this -> db -> update('care', $data);
	}
	
	//delete care
	function delete_care($timer_id) {
		$this -> db -> where('timer_id', $timer_id);
		$this -> db -> delete('care');
	}
}
