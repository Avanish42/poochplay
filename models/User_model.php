<?php
/*
 * File Name: User_model.php
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class User_model extends CI_Model {
	function __construct() {
		// Call the Model constructor
		parent::__construct();
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

	/*fetch user record

	 */
	function get_user_record($user_id) {
		if ($user_id != 'all')
			$this -> db -> where('id', $user_id);
		//else
			//$this->db->where('active_status', TRUE);
			$this -> db -> from('users');
		$query = $this -> db -> get();
		return $query -> result();
	}

	function get_user_record_by_email($user_email) {
		$this -> db -> where('email', $user_email);
		$this -> db -> from('users');
		$query = $this -> db -> get();
		return $query -> result();
	}	
	//Generate Random number
	function generate_verification_code($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	//create user
	function create_user($data) {
		//before insert data need to perform other operation like create verification_code, password_encryption, set date, set active_status to 0
		//create unique verification code
		$verification_code = $this -> generate_verification_code(10);
		//check if code is already exists then create a new one.
		$sql = "select * from users where verification_code = '" . $verification_code . "'";
		$query = $this -> db -> query($sql);
		if ($query -> num_rows() == 0) {
			$data['verification_code'] = $verification_code;
		} else {
			$verification_code = $this -> generate_verification_code(10);
			$data['verification_code'] = $verification_code;
		}
		//set date and active_status=0 (0-register,1-verified,2-blocked)
		$data['created_stamp'] = date("Y-m-d H:i:s");
		$data['active_status'] = 0;
		$data['id'] = $this -> getNewid();
		//set password encryption
		$data['password'] = md5($data['password']);

		$CI =& get_instance();
         	$CI->load->model('email_model');
		$this -> email_model ->send_registraion_email($data['email'],$data['verification_code']);

		//insert the form data into database
		$this -> db -> insert('users', $data);
	}

	function activate_user($code) {
	 	$this -> db -> where('verification_code', $code);
		$this -> db -> update('users', $data = array('active_status' => 1));
	}


	function update_password($password,$username){
		$this -> db -> where('email', $username);
		$this -> db -> update('users', $data = array('password' => md5($password)));
	}
	
	//update user
	function update_user($username,$data){
		$this -> db -> where('email', $username);
		$this -> db -> update('users', $data);
	}
	
	function reset_password($username){
		$password = $this -> generate_verification_code(7);
		$this -> db -> where('email', $username);
		$this -> db -> update('users', $data = array('password' => md5($password),'verification_code' => $password));
		$CI =& get_instance();
         	$CI->load->model('email_model');
		$this -> email_model ->send_password_email($username,$password);
		return $password;
	}
	
	//get the county from country table
	function get_country() {
		$sql = "select * from country";
		$query = $this -> db -> query($sql);
		$result = $query -> result();
		//array to store bread id & bread name
		$country_id = array('-SELECT-');
		$country_name = array('-SELECT-');
		for ($i = 0; $i < count($result); $i++) {
			array_push($country_id, $result[$i] -> id);
			array_push($country_name, $result[$i] -> country_name);
		}
		return $country_result = array_combine($country_id, $country_name);

	}

	function get_state($country1) {
		$country1 = 2;
		$sql = "select * from state where country = " . $country1;
		$query = $this -> db -> query($sql);
		$result = $query -> result();
		//array to store bread id & bread name
		$state_id = array('-SELECT-');
		$state_name = array('-SELECT-');
		for ($i = 0; $i < count($result); $i++) {
			array_push($state_id, $result[$i] -> id);
			array_push($state_name, $result[$i] -> state_name);
		}
		return $state_result = array_combine($state_id, $state_name);

	}

	function getNewid() {
		$sql = "select max(id) as mid from users";
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
?>
