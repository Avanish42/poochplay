<?php
/*
 * File Name: Appointment_model.php
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Appointment_model extends CI_Model {
	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_appointment_record($appointment_id) {
		if ($appointment_id != 'all')
			$this -> db -> where('appointment_id', $appointment_id);
		$this -> db -> from('pet_appointments');
		$this -> db -> order_by("appointment_id", "asc");
		$query = $this -> db -> get();
		return $query -> result();
	}
	
	function get_appointment_record_by_petid($pet_id) {
		$this -> db -> where('pet_id', $pet_id);
		$this -> db -> from('pet_appointments');
		$this -> db -> order_by("appointment_id", "asc");
		$query = $this -> db -> get();
		return $query -> result();
	}

	//insert appointment
	function insert_appointment($data) {
		$data['id'] = $this -> getNewid();
		//insert the form data into database
		$this -> db -> insert('pet_appointments', $data);
	}

	function getNewid() {
		$sql = "select max(id) as mid from pet_appointments";
		$query = $this -> db -> query($sql);
		if($query -> num_rows() > 0){
			$result = $query -> result();
			$maxid = $result[0] -> mid;
			return $maxid + 1;	
		}else{
			return 1;	
		}		
		
	}
	//update appointment
	function update_appointment($appointment_id,$data) {
		$this -> db -> where('appointment_id', $appointment_id);
		$this -> db -> update('pet_appointments', $data);
	}
	
	//delete appointment
	function delete_appointment($appointment_id) {
		$this -> db -> where('appointment_id', $appointment_id);
		$this -> db -> delete('pet_appointments');
	}
}
