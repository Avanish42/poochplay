<?php
/*
 * File Name: Ins_model.php
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Ins_model extends CI_Model {
	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}
	

	function get_pet_by_petid($pet_id) {
		$this -> db -> where('id', $pet_id);
		$this -> db -> from('pet');
		$query = $this -> db -> get();
		return $query -> result();
	}

	//update mc
	function update_ins($pet_id,$data) {
		$this -> db -> where('id', $pet_id);
		$this -> db -> update('pet', $data);
		return $this -> get_pet_by_petid($pet_id);
	}
	
	//delete mc
	function delete_ins($pet_id) {
		$this -> update_ins($pet_id,array('ins_user_email' => null,'ins_provider'=>null,'ins_policy_no'=>null,'ins_renewal_date'=>null,'pet_ins_path'=>null));
	}
}
