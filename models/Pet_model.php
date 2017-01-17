<?php
/*
 * File Name: Pets_model.php
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Pet_model extends CI_Model {
	function __construct() {
		// Call the Model constructor
		parent::__construct ();
	}
	
	// get bread table to populate the bread name dropdown
	function get_bread() {
		$this->db->select ( 'id' );
		$this->db->select ( 'bread_name' );
		$this->db->from ( 'BREAD' );
		$query = $this->db->get ();
		$result = $query->result ();
		
		// array to store bread id & bread name
		$bread_id = array (
				'-SELECT-' 
		);
		$b_name = array (
				'-SELECT-' 
		);
		
		for($i = 0; $i < count ( $result ); $i ++) {
			array_push ( $bread_id, $result [$i]->id );
			array_push ( $b_name, $result [$i]->bread_name );
		}
		return $bread_result = array_combine ( $bread_id, $b_name );
	}
	// get user table to populate the user name dropdown
	function get_user() {
		$this->db->select ( 'id' );
		$this->db->select ( 'first_name' );
		$this->db->select ( 'last_name' );
		$this->db->from ( 'users' );
		$query = $this->db->get ();
		$result = $query->result ();
		
		// array to store bread id & bread name
		$user_id = array (
				'-SELECT-' 
		);
		$u_name = array (
				'-SELECT-' 
		);
		
		for($i = 0; $i < count ( $result ); $i ++) {
			array_push ( $user_id, $result [$i]->id );
			$userFullName = $result [$i]->first_name . " " . $result [$i]->last_name;
			array_push ( $u_name, $userFullName );
		}
		return $user_result = array_combine ( $user_id, $u_name );
	}
	function getNewid() {
		$sql = "select max(id) as mid from pet";
		$query = $this -> db -> query($sql);
		if($query -> num_rows() > 0){
			$result = $query -> result();
			$maxid = $result[0] -> mid;
			return $maxid + 1;	
		}else{
			return 1;	
		}	
	}
	
	// add pet
	function addPet($data) {
		$data['created_stamp'] = date("Y-m-d H:i:s");
		$data['active_status'] = true;//true - means pet active, false - pet deleted
		$pet_id = $this -> getNewid();
		$data['id'] = $pet_id;
		
		//insert the form data into database
		$this -> db -> insert('pet', $data);
		return $pet_id;
	}
	
	//update pet
	function updatePet($petid,$data) {
		$this -> db -> where('id', $petid);
		$this -> db -> update('pet', $data);
	}

	//get pet by id
	function getPet($petid) {
		$this -> db -> where('id', $petid);
		$this -> db -> from('pet');
		$query = $this -> db -> get();
		return $query -> result();
	}

	//function to get maxid of pet user mapping
	
	function getNewidPetUserMapping() {
		$sql = "select max(id) as mid from pet_user_mapping";
		$query = $this -> db -> query($sql);
		if($query -> num_rows() > 0){
			$result = $query -> result();
			$maxid = $result[0] -> mid;
			return $maxid + 1;	
		}else{
			return 1;	
		}		
	}
	
	// add pet and user mapping
	function addPetUserMapping($pet_id,$user_email) {
		$data['created_stamp'] = date("Y-m-d H:i:s");
		$id = $this -> getNewidPetUserMapping();
		$data['id'] = $id;
		$data['pet_id'] = $pet_id;
		$data['type'] = 'owner';
		//get user
		$this->load->model('user_model');
		$user_obj = $this->user_model->get_user_record_by_email($user_email);
		$data['user_id'] = $user_obj[0]->id;
		//insert the form data into database
		$this -> db -> insert('pet_user_mapping', $data);
	}

	// get all petid by user id
	function getAllPetByUserId($userid) {
		$this -> db -> where('user_id', $userid);
		$this -> db -> from('pet_user_mapping');
		$query = $this -> db -> get();
		return $query -> result();
	}
	
	// get pet's owner userid
	function getPetsOwnerUserId($petid) {
		$query = array("pet_id"=>$petid,'type'=>'owner');			
		$this -> db -> where($query);
		$this -> db -> from('pet_user_mapping');
		$query = $this -> db -> get();
		$result = $query -> result();	
		if(!empty($result)){
		   return $result[0]->user_id;	
		}else{
		   return null;	
		}		
	}

	//check if pet shared
	function isPetShared($petid){
		$query = array("pet_id"=>$petid,'type'=>'shared');			
		$this -> db -> where($query);
		$this -> db -> from('pet_user_mapping');
		$query = $this -> db -> get();
		$result = $query -> result();	
		if(empty($result)){
		   return false;	
		}else{
		   return true;	
		}			
	}

	//share pet
	function share_pet($pet_id,$shared_id,$owner_email){
		//get user
		$this->load->model('user_model');
		$user_obj = $this->user_model->get_user_record_by_email($owner_email);
		$owner_id = $user_obj[0]->id;
	
		//insert pet share record
		$data = array();
		$data['created_stamp'] = date("Y-m-d H:i:s");
		$share_id = $this -> getNewidPetShare();
		$data['id'] = $share_id;
		$data['pet_id'] = $pet_id;
		$data['owner_id'] = $owner_id;
		$data['shared_user_id'] = $shared_id;
		$data['status'] = 0;//0-pending,1-accepted,2-denyed

		//generate random code
		$code = $this->user_model->generate_verification_code(7);
		$data['activation_code'] = $code;
		//insert the form data into database
		$this -> db -> insert('pet_share', $data);

		//send mail to shared_user_id, send link accept and deny

		return $code;
	}

	//check if is valid code of shared pet
	function isValidPetShared($petid){
		$query = array("pet_id"=>$petid,'type'=>'shared');			
		$this -> db -> where($query);
		$this -> db -> from('pet_user_mapping');
		$query = $this -> db -> get();
		$result = $query -> result();	
		if(!empty($result)){
		   return true;	
		}else{
		   return false;	
		}			
	}

	//function to get maxid of pet share	
	function getNewidPetShare() {
		$sql = "select max(id) as mid from pet_share";
		$query = $this -> db -> query($sql);
		if($query -> num_rows() > 0){
			$result = $query -> result();
			$maxid = $result[0] -> mid;
			return $maxid + 1;	
		}else{
			return 1;	
		}		
	}
	
	//share pet
	function insert_share_pet($code,$action){
		$message = '';		
		//first check action
		if($action == 'accept' && $this->isValidCodePetShared($code)){
                  $petShare = $this->getPetShare($code);
		  if(!$this->isPetShared($petShare[0]->pet_id)){	
		    //set status to 1 
		     $this->update_pet_share($code,array('status'=>1)); 
		    //insert in to pet mapping		    
		    $data['created_stamp'] = date("Y-m-d H:i:s");
		    $id = $this -> getNewidPetUserMapping();
		    $data['id'] = $id;
		    $data['pet_id'] = $petShare[0]->pet_id;
		    $data['type'] = 'shared';
		    $data['user_id'] = $petShare[0]->shared_user_id;
		    //insert the form data into database
		    $this -> db -> insert('pet_user_mapping', $data);	
		    $message = 'Pet accepted';	
                  }else{
		    $message = 'Pet already shared with someone else.';		 
		  }
		}else if($action == 'deny' && $this->isValidCodePetShared($code)){
		  //set status to 2
		  $this->update_pet_share($code,array('status'=>2)); 	
		  $message = 'Pet denyed';
		}else{
		   $message = 'Please provide valid action or code';
		}

		//send mail to shared_user_id, send link accept and deny

		return $message;
	}
	
	//check if is valid code of shared pet
	function isValidCodePetShared($code){
		$query = array("activation_code"=>$code);			
		$this -> db -> where($query);
		$this -> db -> from('pet_share');
		$query = $this -> db -> get();
		$result = $query -> result();	
		if(!empty($result)){
		   return true;	
		}else{
		   return false;	
		}			
	}

	//check if is valid code of shared pet
	function getPetShare($code){
		$query = array("activation_code"=>$code);			
		$this -> db -> where($query);
		$this -> db -> from('pet_share');
		$query = $this -> db -> get();
		$result = $query -> result();	
		if(!empty($result)){
		   return $result;	
		}else{
		   return null;	
		}			
	}

	function update_pet_share($code,$data){
		$this -> db -> where('activation_code', $code);
		$this -> db -> update('pet_share', $data);
	}
}
?>
