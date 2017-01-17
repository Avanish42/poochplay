<?php
/* 
 * File Name: Registration.php
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('form_validation');
        //load the employee model
        $this->load->model('user_model');
    }

    //index function
    function index()
    {
	$code = $this -> input -> get('code', TRUE);

        $postdata = array('code' => $code);
	//set data for validation
	$this -> form_validation -> set_data($postdata);
	//set validations
	$this -> form_validation -> set_rules('code', 'code', 'trim|required');
	
	if ($this -> form_validation -> run() == FALSE) {
	    //echo "Validation Failed";
	   echo $this -> form_validation -> error_string();	
	} else {
	   $this->user_model->activate_user($code);	
	   echo "<p>Your account has been activated successfully...</p>"; 	
        }
    }
    
}
?>
