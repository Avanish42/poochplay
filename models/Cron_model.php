<?php
/*
 * File Name: Care_model.php
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Cron_model extends CI_Model {
	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}

	function get_care_record_by_isComp() {
		$where = "is_comp='Yes' OR is_comp='No'";
		$this->db->where($where);
		$this -> db -> from('care');
		$query = $this -> db -> get();
		return $query -> result();
	}
	
/*
	function get_care_record_by_isComp() {
		$where = "user_email='nsc@gmail.com'";
		$this->db->where($where);
		$this -> db -> from('care');
		$query = $this -> db -> get();
		return $query -> result();
	}	
	*/

	//update care
	function update_care($id,$is_comp) {
		$this -> db -> where('id', $id);
		$this -> db -> update('care', $is_comp);
	}

}
