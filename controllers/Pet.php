<?php
/* 
 * File Name: User.php
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pet extends CI_Controller
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
        //fetch data from role table
        $data['bread'] = $this->pet_model->get_bread();
	$data['user'] = $this->pet_model->get_user();
	$maxid = $this->user_model->getNewid();
        //$data['designation'] = $this->employee_model->get_designation();

        //set validation rules
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('ownername', 'ownerName', 'trim|required');
        $this->form_validation->set_rules('bread', 'Bread', 'callback_combo_check');
	$this->form_validation->set_rules('user', 'User', 'callback_combo_check');
        //$this->form_validation->set_rules('designation', 'Designation', 'callback_combo_check');
        $this->form_validation->set_rules('age', 'Age', 'numeric|required');
	$this->form_validation->set_rules('allergies', 'Allergies', 'required');        
	$this->form_validation->set_rules('country', 'Country', 'callback_combo_check');
	$data['state'] = $this->user_model->get_state($this->input->post('country'));
	$this->form_validation->set_rules('state', 'State', 'callback_combo_check');
	$this->form_validation->set_rules('city', 'City', 'required');
	$this->form_validation->set_rules('postcode', 'postcode', 'required');
	$this->form_validation->set_rules('sex', 'Sex', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            //fail validation
	    $this->load->view('commons/header');
	    $this->load->view('commons/topnav');
	    $this->load->view('commons/sidebar');
            $this->load->view('user_view', $data);
	    $this->load->view('commons/footer.php');
        }
        else
        {    
            //pass validation
            $data = array(
                'id' => $maxid,
                'name' => $this->input->post('firstname'),
		'owner_name' => $this->input->post('ownername'),
                'bread_id' => $this->input->post('bread'),
		'age' => $this->input->post('age'),
		'sex' => $this->input->post('sex'),
		'allergies' => $this->input->post('allergies'),
		'country' => $this->input->post('country'),
		'state' => $this->input->post('state'),
		'city' => $this->input->post('city'),
		'postcode' => $this->input->post('postcode'),
                'email' => $this->input->post('email'),
		'birthdate' => @date('Y-m-d', @strtotime($this->input->post('hireddate'))),
		'created_stamp' => "2016-03-27"/*@date('Y-m-d', @strtotime("2016-03-27"))*/,
		'active_status' => TRUE
            );

            //insert the form data into database
            $this->db->insert('users', $data);

            //display success message
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">User details added to Database!!!</div>');
            redirect('User/index');
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

    //custom validation function to accept only alpha and space input
    function alpha_only_space($str)
    {
        if (!preg_match("/^([-a-z ])+$/i", $str))
        {
            $this->form_validation->set_message('alpha_only_space', 'The %s field must contain only alphabets or spaces');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
}
?>
