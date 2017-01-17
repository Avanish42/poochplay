<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Login extends CI_Controller
{

     public function __construct()
     {
          parent::__construct();
          $this->load->library('session');
          $this->load->helper('form');
          $this->load->helper('url');
          $this->load->helper('html');
          $this->load->database();
          $this->load->library('form_validation');
          //load the login model
          $this->load->model('login_model');
     }

     public function index(){
	if (!empty($this -> session -> userdata) && $this -> session -> userdata!=null && !empty($this -> session -> userdata['username']) && $this -> session -> userdata['username'] == 'admin') {
		$this->load->view('dashboard');
        }else{
          $data['role'] = $this->login_model->get_role('all'); 
	  //get the posted values
          $username = $this->input->post("txt_username");
          $password = $this->input->post("txt_password");

          //set validations
          
	  $this->form_validation->set_rules("txt_username", "Username", "trim|required");
          $this->form_validation->set_rules("txt_password", "Password", "trim|required");
	  //$this->form_validation->set_rules('role', 'Role', 'callback_combo_check');
          if ($this->form_validation->run() == FALSE)
          {
               //validation fails
               $this->load->view('login_view', $data);
          }
          else
          {
		$role = $this->input->post("role");               
		//validation succeeds
               if ($this->input->post('btn_login') == "Login")
               {
                    //check if username and password is correct
                    $usr_result = $this->login_model->get_user($username, $password,$role);
                    if ($usr_result > 0) //active user record is present
                    {
                         //set the session variables
                         $sessiondata = array(
                              'username' => $username,
                              'loginuser' => TRUE
                         );
                         $this->session->set_userdata($sessiondata);
                        //redirect('user/view');
			$this->load->view('dashboard');
			//$this->load->view('plain_page');
                    }
                    else
                    {
                         $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username or password!</div>');
                         redirect('login/index');
                    }
               }
               else
               {
                   redirect('login/index');
               }
          }
        }
     }

     //custom validation function for dropdown input
    function combo_check($str)
    {
        if ($str == '-SELECT-')
        {
            $this->form_validation->set_message('combo_check', 'Valid %s Name is required');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
}?>
