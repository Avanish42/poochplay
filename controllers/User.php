<?php
/*
 * File Name: User.php
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this -> load -> library('session');
		$this -> load -> helper('form');
		$this -> load -> helper('url');
		$this -> load -> database();
		$this -> load -> library('form_validation');
		//load the user model
		$this -> load -> model('user_model');
	}

	function index() {
		if (empty($this -> session -> userdata) || $this -> session -> userdata==null ||  $this -> session -> userdata['loginuser'] == FALSE) {
			redirect('login/index');
		}
	}

	function view() {
		if (empty($this -> session -> userdata) || $this -> session -> userdata==null ||  $this -> session -> userdata['loginuser'] == FALSE) {
			redirect('login/index');
		}
		$data['userrecord'] = $this -> user_model -> get_user_record('all');
		$this -> load -> view('commons/header');
		$this -> load -> view('commons/topnav');
		$this -> load -> view('commons/sidebar');
		$this -> load -> view('user_list_view', $data);
		$this -> load -> view('commons/footer.php');
	}

	function add($user_id = 0) {
		//fetch data from role table
		$data['role'] = $this -> user_model -> get_role('all');
		//$data['country'] = $this->user_model->get_country();
		$data['user_id'] = 0;
		//$data['designation'] = $this->employee_model->get_designation();
		$data['userrecord'] = $this -> user_model -> get_user_record('all');
		//set validation rules
		$this -> form_validation -> set_rules('firstname', 'First Name', 'trim|required');
		$this -> form_validation -> set_rules('lastname', 'Last Name', 'trim|required');
		$this -> form_validation -> set_rules('role', 'Role', 'callback_combo_check');
		//$this->form_validation->set_rules('designation', 'Designation', 'callback_combo_check');
		$this -> form_validation -> set_rules('email', 'Email', 'trim|required|is_unique[users.email]');
		//$this->form_validation->set_rules('username', 'User Name', 'required');
		$this -> form_validation -> set_rules('password', 'Password', 'required');
		$this -> form_validation -> set_rules('country', 'Country', 'callback_combo_check');
		//$data['state'] = $this->user_model->get_state($this->input->post('country'));
		$this -> form_validation -> set_rules('state', 'State', 'callback_combo_check');
		$this -> form_validation -> set_rules('city', 'City', 'required');
		$this -> form_validation -> set_rules('postcode', 'postcode', 'required');
		if ($this -> form_validation -> run() == FALSE) {
			//fail validation
			$this -> load -> view('commons/header');
			$this -> load -> view('commons/topnav');
			$this -> load -> view('commons/sidebar');
			$this -> load -> view('user_view', $data);
			$this -> load -> view('commons/footer.php');
		} else {
			//pass validation
			$data = array('first_name' => $this -> input -> post('firstname'), 'last_name' => $this -> input -> post('lastname'), 'role_id' => $this -> input -> post('role'), 'password' => $this -> input -> post('password'), 'country' => $this -> input -> post('country'), 'state' => $this -> input -> post('state'), 'city' => $this -> input -> post('city'), 'postcode' => $this -> input -> post('postcode'), 'email' => $this -> input -> post('email'));

			//create user
			$this -> user_model -> create_user($data);

			//display success message
			$this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">User details added to Database!!!</div>');
			redirect('User/add');
		}

	}

	function changepassword() {
		if (empty($this -> session -> userdata) || $this -> session -> userdata==null ||  $this -> session -> userdata['loginuser'] == FALSE) {
			redirect('login/index');
		} else {
			$username = $this -> session -> userdata['username'];
			$data['username'] = $username;
			//set validation rules
			$this -> form_validation -> set_rules('password', 'Password', 'required|matches[retypepassword]');
			$this -> form_validation -> set_rules('retypepassword', 'Retype Password', 'required');
			if ($this -> form_validation -> run() == FALSE) {
				//fail validation
				$this -> load -> view('commons/header');
				$this -> load -> view('commons/topnav');
				$this -> load -> view('commons/sidebar');
				$this -> load -> view('change_password', $data);
				$this -> load -> view('commons/footer.php');
			} else {
				//pass validation
				$password = $this -> input -> post('password');

				//update password field for this user
				$this -> user_model -> update_password($password,$username);

				//display success message
				$this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">Password Updated!!!</div>');
				redirect('user/changepassword');
			}
		}
	}

	//index function
	function update($user_id) {
		//fetch data from role table
		$data['role'] = $this -> user_model -> get_role('all');
		//$data['country'] = $this -> user_model -> get_country();
		$data['user_id'] = $user_id;
		//fetch user record for the given id
		$data['userrecord'] = $this -> user_model -> get_user_record($user_id);
		//set validation rules

		$this -> form_validation -> set_rules('firstname', 'First Name', 'trim|required');
		$this -> form_validation -> set_rules('lastname', 'Last Name', 'trim|required');
		$this -> form_validation -> set_rules('role', 'Role', 'callback_combo_check');
		//$this->form_validation->set_rules('designation', 'Designation', 'callback_combo_check');
		//$this -> form_validation -> set_rules('email', 'Email', 'trim|required|is_unique[users.email]');
		$this -> form_validation -> set_rules('password', 'Password', 'required');
		$this -> form_validation -> set_rules('country', 'Country', 'callback_combo_check');
		//$data['state'] = $this -> user_model -> get_state($this -> input -> post('country'));
		$this -> form_validation -> set_rules('state', 'State', 'callback_combo_check');
		$this -> form_validation -> set_rules('city', 'City', 'required');
		$this -> form_validation -> set_rules('postcode', 'postcode', 'required');
		if ($this -> form_validation -> run() == FALSE) {
			//fail validation
			$this -> load -> view('commons/header');
			$this -> load -> view('commons/topnav');
			$this -> load -> view('commons/sidebar');
			$this -> load -> view('user_view', $data);
			$this -> load -> view('commons/footer.php');
		} else {
			//pass validation
			$data = array('first_name' => $this -> input -> post('firstname'), 'last_name' => $this -> input -> post('lastname'), 'role_id' => $this -> input -> post('role'), 'password' => md5($this -> input -> post('password')), 'country' => $this -> input -> post('country'), 'state' => $this -> input -> post('state'), 'city' => $this -> input -> post('city'), 'postcode' => $this -> input -> post('postcode'));

			//insert the form data into database
			$this -> db -> where('id', $user_id);
			$this -> db -> update('users', $data);

			//display success message
			$this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">User details updated !!!</div>');
			redirect("User/update/" . $user_id);
		}

	}

	//delete user record from db
	function delete($user_id) {
		$data = array('active_status' => 2);
		//delete user record
		$this -> db -> where('id', $user_id);
		$this -> db -> update('users', $data);
		redirect('User/view');
	}

	function logout(){
		$this->session->userdata = array();
		$this->session->sess_destroy();
		redirect('login/index');
	}
	
	function verify(){
		$code = $this -> input -> get('c', TRUE);
		$data = array('active_status' => 1);
		//set user status to verified
		$this -> db -> where('verification_code', $code);
		$this -> db -> update('users', $data);
		$this -> load -> view('user_verify', $data);
	}
	
	
	//custom validation function for dropdown input
	function combo_check($str) {
		if ($str == '-SELECT-') {
			$this -> form_validation -> set_message('combo_check', 'Valid %s Name is required');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	//custom validation function to accept only alpha and space input
	function alpha_only_space($str) {
		if (!preg_match("/^([-a-z ])+$/i", $str)) {
			$this -> form_validation -> set_message('alpha_only_space', 'The %s field must contain only alphabets or spaces');
			return FALSE;
		} else {
			return TRUE;
		}
	}

}
?>
