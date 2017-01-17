<?php
/*
 * File Name: Care_model.php
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Tracker_model extends CI_Model {
	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}
	

	function get_tracker_data($email,$pet_id,$strdate,$enddate) {
		$this->db->where('pet_id', $pet_id);
		$this->db->where('user_email', $email);
		$this->db->where('datetime >=', $strdate." 00:00:00");
		$this->db->where('datetime <=', $enddate." 23:59:00");
		$this -> db -> from('activity');
		$query = $this -> db -> get();
		return  $query->result();
	}
	
	
	function check_tracker_data($email,$pet_id,$datetime,$deviceid) {
		$query = array("pet_id"=>$pet_id,'user_email'=>$email,"deviceid"=>$deviceid,'datetime'=>$datetime);	
		$this -> db -> where($query);
		$this -> db -> from('activity');
		$query = $this -> db -> get();
		return  $query->num_rows();
	}

	
	//insert tracker data
	function insert_tracker($data) {
		$data['id'] = $this -> getNewid();
		//insert the form data into database
		$this -> db -> insert('activity', $data);
	}

	function getNewid() {
		$sql = "select max(id) as mid from activity";
		$query = $this -> db -> query($sql);
		if($query -> num_rows() > 0){
			$result = $query -> result();
			$maxid = $result[0] -> mid;
			return $maxid + 1;	
		}else{
			return 1;	
		}		
		
	}
	/*
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
	*/
}