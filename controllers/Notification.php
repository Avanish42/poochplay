<?php
/*
 * File Name: Foster.php
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this -> load -> library('session');
        $this -> load -> helper('form');
        $this -> load -> helper('url');
        $this -> load -> database();
        $this -> load -> library('form_validation');
        //load the foster model
        $this -> load -> model('foster_model');
    }

    function index() {
        if (empty($this -> session -> userdata) || $this -> session ->
userdata==null ||  $this -> session -> userdata['loginuser'] == FALSE) {
            redirect('login/index');
        }else{
            $data['foster'] = $this -> foster_model ->
get_foster_record('all');
            $this -> load -> view('commons/header');
            $this -> load -> view('commons/topnav');
            $this -> load -> view('commons/sidebar');
            $this -> load -> view('send_notification', $data);
            $this -> load -> view('commons/footer.php');
        }
    }
	

		function sendfcm($mess,$id) {
		$url = 'https://fcm.googleapis.com/fcm/send';
		$fields = array (
				'to' => $id,
				'notification' => array (
						"body" => $mess,
						"title" => "Niranjan First Push",
						"icon" => "app_icon"
				)
		);
		$fields = json_encode ( $fields );
		$headers = array (
				'Authorization: key=' . "AIzaSyAaniRlpAAjxnEdoPeTqAImGr-1T76RKnw",
				'Content-Type: application/json'
		);

		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

		$result = curl_exec ( $ch );
		curl_close ( $ch );
		}

}

?>