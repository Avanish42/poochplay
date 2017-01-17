<?php
/*
 * File Name: Mc_model.php
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Mc_model extends CI_Model {
	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}
	

	function get_mc_by_petid($pet_id) {
		$this -> db -> where('pet_id', $pet_id);
		$this -> db -> from('pet_mc');
		$query = $this -> db -> get();
		return $query -> result();
	}

	/*function get_care_record_by_timerid($timer_id) {
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
	}*/

	
	//insert mc
	function insert_mc($data) {
		$data['id'] = $this -> getNewid();
		//insert the form data into database
		$this -> db -> insert('pet_mc', $data);
	}

	function getNewid() {
		$sql = "select max(id) as mid from pet_mc";
		$query = $this -> db -> query($sql);
		if($query -> num_rows() > 0){
			$result = $query -> result();
			$maxid = $result[0] -> mid;
			return $maxid + 1;	
		}else{
			return 1;	
		}		
		
	}
	//update mc
	function update_mc($pet_id,$data) {
		$this -> db -> where('pet_id', $pet_id);
		$this -> db -> update('pet_mc', $data);
	}
	
	//delete mc
	function delete_mc($pet_id) {
		$this -> db -> where('pet_id', $pet_id);
		$this -> db -> delete('pet_mc');
	}
}
