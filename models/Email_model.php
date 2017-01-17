<?php
/*
 * File Name: Email_model.php
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_model extends CI_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    //mail function to reset password	
    function send_password_email($email,$password) {
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
        $this->email->to($email);
	$this->email->set_mailtype("html");
 	$this->email->subject('PoochPlay Password Reset');
        //$body = '<p>Your password has been updated to <b>'.$password.'</b></p>';
	$data = array('password'=>$password);
	$body = $this->load->view('emailtemplates/resetpassword.php',$data,TRUE);
        $this->email->message($body);   
        $this->email->send();
    }

    //mail function to send registration email
    function send_registraion_email($email,$code) {
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
        $this->email->to($email);
	$this->email->set_mailtype("html");
 	$this->email->subject('PoochPlay Registration');
	$activationUrl = $this->config->base_url()."registration?code=".$code;
        //$body = '<p>Please confirm your account by click on below link, <b>'.$activationUrl.'</b></p>';
	$data = array('activation'=>$activationUrl);
	$body = $this->load->view('emailtemplates/useractivation.php',$data,TRUE);
        $this->email->message($body);   
        $this->email->send();
    }

    //share mail

    //unshare mail		
}
