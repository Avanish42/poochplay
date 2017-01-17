<?php
/* 
 * File Name: Share.php
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Share extends CI_Controller
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
        $this->load->model('pet_model');
    }

    //index function
    function index()
    {

	$code = $this -> input -> get('code', TRUE);
	$action = $this -> input -> get('action', TRUE);
	//$pet_id = $this -> input -> post('pet_id', TRUE);

        $postdata = array('code' => $code, 'action' => $action);
	//set data for validation
	$this -> form_validation -> set_data($postdata);
	//set validations
	$this -> form_validation -> set_rules('code', 'code', 'trim|required');
	$this -> form_validation -> set_rules('action', 'action', 'trim|required');
	
	if ($this -> form_validation -> run() == FALSE) {
	    //echo "Validation Failed";
	   echo $this -> form_validation -> error_string();	
	} else {
	   echo $this->pet_model->insert_share_pet($code,$action);	
        }
    }
    
}
?>
