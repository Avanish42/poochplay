<?php
/*
 * File Name: Notificationandroid_model.php
 */
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

class Notificationandroid_model extends CI_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct ();
    }
   
    function sendShareNotification($acceptUrl, $denyUrl, $deviceToken) {
        $GOOGLE_API_KEY='AIzaSyAAkDkrUQMMgvjvA7ozixWgzFblVAgHDB4';
	$title = "Pet Share Request";
	$message = "Please Accept share request";
//$deviceToken="APA91bEkGGU04nngUauVWOdTF4fmUSB781PZNRvkJxV6DiqKO3jtQBngGMRDEQSgF0FSfWMINNmItdMQVC4OpTbBU8bo5dwkWUdbMcoHok5qDlsJKbZiRrd3dlbgtEwocIEzgynPzqoW";
         $desc =array(
	        "title"=>$title,
                "message"=>$message,
		"acceptUrl"=>$acceptUrl,
		"denyUrl"=>$denyUrl
         );
         $message =array("message"=>$desc);
         $deviceToken= array($deviceToken);
			 
	// Set POST variables
	$url = 'https://android.googleapis.com/gcm/send';

	$fields = array(
            'registration_ids' =>$deviceToken,
            'data'=>$message,
	);
	$headers = array(
            'Authorization: key='.$GOOGLE_API_KEY,
            'Content-Type: application/json'
	);
			
	 // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);

	//echo "Result: ".$result;
	if($result){
		//echo true;
	}
	else{
		//echo false;
        }
    }       
}
?>
