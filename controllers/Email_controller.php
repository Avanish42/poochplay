<?php 
   class Email_controller extends CI_Controller { 
 
      function __construct() { 
         parent::__construct(); 
         $this->load->library('session'); 
         $this->load->helper('form'); 
      } 
		
      public function index() { 
	
         $this->load->helper('form'); 
         $this->load->view('email_form'); 
      } 
  
      public function send_mail() { 
	$this->load->library('email');

	$this->email->initialize(array(
	  'useragent' => 'CodeIgniter',	
	  'mailpath' => '/usr/sbin/sendmail',
	  'protocol' => 'smtp',
	  'smtp_host' => 'localhost',	
	'smtp_user' => 'poochplayapp@gmail.com',
  	'smtp_pass' => 'poochplayapp123',  
	  'smtp_port' => '25',
	  'crlf' => "\r\n",
	  'newline' => "\r\n",
	  'wordwrap' => 'TRUE'
	));

	$this->email->from('poochplayapp@gmail.com', 'poochplay');
	$this->email->to('pankaj.sharma0901@gmail.com');
	$this->email->set_mailtype("html");
//	$this->email->cc('another@another-example.com');
	//$this->email->bcc('them@their-example.com');
	$this->email->subject('Email Test');
	$mass = '<b>Pankaj</b><br/>sharma';
	$this->email->message($mass);
	$this->email->send();

	echo $this->email->print_debugger();      
      } 
   } 
?>
