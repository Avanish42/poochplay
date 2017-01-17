<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class login_model extends CI_Model {
	function __construct() {
		// Call the Model constructor
		$this -> load -> library('session');
		parent::__construct();
	}

	//get the username & password from users
	function get_user($usr, $pwd, $role) {
		$sql = "select * from users where email = '" . $usr . "' and password = '" . md5($pwd) . "' and role_id = " . $role;
		$query = $this -> db -> query($sql);
		return $query -> num_rows();
	}

	//get the role from role table
	function get_role($role) {
		if ($role == 'all') {
			$sql = "select * from role";
			$query = $this -> db -> query($sql);
			$result = $query -> result();
			//array to store bread id & bread name
			$role_id = array('-SELECT-');
			$role_name = array('-SELECT-');
			for ($i = 0; $i < count($result); $i++) {
				array_push($role_id, $result[$i] -> id);
				array_push($role_name, $result[$i] -> role_name);
			}
			return $role_result = array_combine($role_id, $role_name);

		} else {
			$sql = "select * from role where role_name = '" . $role . "'";
			$query = $this -> db -> query($sql);
			return $query -> num_rows();

		}
	}

}
?>