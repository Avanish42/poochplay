<?php
/*
 * File Name: Breed_model.php
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Breed_model extends CI_Model {
	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_breed_record($breed_id) {
		if ($breed_id != 'all')
			$this -> db -> where('id', $breed_id);
		$this -> db -> from('breed');
		$this -> db -> order_by("id", "asc");
		$query = $this -> db -> get();
		
		return $query -> result();
	}
	
	//insert breed
	function insert_breed($data) {
		$data['id'] = $this -> getNewid();
		//insert the form data into database

		// foreach ($data as $key => $value) {
		// 	# code...
		// 	echo $key." :: " .$value."<br>";
		// }

		$this -> db -> insert('breed', $data);
	}

	//update breed
	function update_breed($breed_id,$data) {
		//insert the form data into database
		$this -> db -> where('id', $breed_id);
		$this -> db -> update('breed', $data);
	}
			

	function getNewid() {
		$sql = "select max(id) as mid from breed";
		$query = $this -> db -> query($sql);
		if($query -> num_rows() > 0){
			$result = $query -> result();
			$maxid = $result[0] -> mid;
			return $maxid + 1;	
		}else{
			return 1;	
		}		
		
	}
}
