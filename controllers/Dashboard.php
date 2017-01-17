<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Dashboard extends CI_Controller
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
          //$this->load->model('login_model');
     }
     public function index()
     {
	

	$this->load->view('commons/header');
	$this->load->view('commons/topnav');	
	$this->load->view('dashboard');
	$this->load->view('commons/footer');
    }

}
     
